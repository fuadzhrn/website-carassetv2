<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductBydAtto1ContentSeeder extends Seeder
{
    /**
     * Fill the 5 Produk BYD ATTO 1 sections' content from
     * config/product-byd-atto-1-content.php — ONLY for sections whose
     * content is still empty. Never overwrites a section an admin has
     * already edited, never touches is_active, updated_by, section_name,
     * sort_order, draft_content, or workflow_status. Never invents
     * colors/variants/specifications/features/prices.
     *
     * Also provisions the real BYD ATTO 1 photo(s) declared in
     * config('product-byd-atto-1-content.placeholder_media') as real
     * Media Library rows (idempotent — matched by a fixed file_path,
     * never recreated once present), so the Gallery section is never
     * empty out of the box and every reference is a real,
     * admin-replaceable Media entry rather than a hand-typed path. See
     * PRODUCT-ASSET-SOURCES-BYD-ATTO-1.md for the photo's source/license.
     *
     * Safe to run repeatedly.
     */
    public function run(): void
    {
        $page = Page::where('slug', 'product-byd-atto-1')->first();

        if (! $page) {
            $this->command?->error('ProductBydAtto1ContentSeeder dibatalkan: page dengan slug "product-byd-atto-1" tidak ditemukan. Jalankan CmsStructureSeeder terlebih dahulu.');

            return;
        }

        $placeholderMediaByKey = $this->seedPlaceholderMedia();

        $sectionsContent = config('product-byd-atto-1-content.sections', []);
        $sections = $page->sections()->get()->keyBy('section_key');

        foreach ($sectionsContent as $sectionKey => $content) {
            $section = $sections->get($sectionKey);

            if (! $section) {
                continue;
            }

            $isEmpty = $section->content === null || $section->content === [];

            if (! $isEmpty) {
                continue;
            }

            $content = $this->applyPlaceholderMedia($sectionKey, $content, $placeholderMediaByKey);

            $section->content = $content;
            $section->save();
        }
    }

    /**
     * Copies the real BYD ATTO 1 photo(s)
     * (public/assets/images/products/byd-atto-1/gallery/) into the Media
     * Library disk under a fixed, deterministic path and creates their
     * Media rows if not already present. Never overwrites an existing
     * Media row, never re-copies the file once it exists.
     *
     * @return array<string, Media> keyed by config's placeholder 'key'
     */
    private function seedPlaceholderMedia(): array
    {
        $disk = config('media.disk', 'public');
        $definitions = config('product-byd-atto-1-content.placeholder_media', []);
        $sourceDir = public_path('assets/images/products/byd-atto-1/gallery');
        $targetDir = config('media.directory', 'media').'/product-byd-atto-1-gallery';

        $mediaByKey = [];

        foreach ($definitions as $definition) {
            $targetPath = $targetDir.'/'.$definition['file'];

            $media = Media::where('file_path', $targetPath)->first();

            if (! $media) {
                $sourcePath = $sourceDir.'/'.$definition['file'];

                if (! is_file($sourcePath)) {
                    $this->command?->warn("ProductBydAtto1ContentSeeder: file placeholder tidak ditemukan, dilewati: {$sourcePath}");

                    continue;
                }

                if (! Storage::disk($disk)->exists($targetPath)) {
                    Storage::disk($disk)->put($targetPath, file_get_contents($sourcePath));
                }

                [$width, $height] = $this->imageDimensions($sourcePath);

                $media = new Media();
                $media->original_name = $definition['file'];
                $media->file_name = $definition['file'];
                $media->file_path = $targetPath;
                $media->mime_type = 'image/webp';
                $media->file_size = filesize($sourcePath) ?: 0;
                $media->width = $width;
                $media->height = $height;
                $media->alt_text = $definition['alt'];
                $media->caption = $definition['caption'];
                $media->uploaded_by = null;
                $media->save();
            }

            $mediaByKey[$definition['key']] = $media;
        }

        return $mediaByKey;
    }

    /**
     * Wires the seeded placeholder Media into the fallback content for
     * product-hero (hero_media_id) and product-colors (gallery[]) — the
     * only 2 places non-empty visuals are needed out of the box. Colors,
     * variants, and specifications remain untouched (still empty/draft)
     * since no confirmed client data exists.
     *
     * @param array<string, mixed> $content
     * @param array<string, Media> $placeholderMediaByKey
     * @return array<string, mixed>
     */
    private function applyPlaceholderMedia(string $sectionKey, array $content, array $placeholderMediaByKey): array
    {
        if ($sectionKey === 'product-hero' && isset($placeholderMediaByKey['front'])) {
            $content['hero_media_id'] = $placeholderMediaByKey['front']->id;
        }

        if ($sectionKey === 'product-colors') {
            $definitions = config('product-byd-atto-1-content.placeholder_media', []);
            $gallery = [];

            foreach ($definitions as $index => $definition) {
                $media = $placeholderMediaByKey[$definition['key']] ?? null;

                if (! $media) {
                    continue;
                }

                $gallery[] = [
                    'item_key' => 'gallery-'.$definition['key'],
                    'media_id' => $media->id,
                    'alt' => $definition['alt'],
                    'caption' => $definition['caption'],
                    'view_label' => $definition['view_label'],
                    'is_temporary' => true,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ];
            }

            $content['gallery'] = $gallery;
        }

        return $content;
    }

    /**
     * @return array{0: ?int, 1: ?int}
     */
    private function imageDimensions(string $path): array
    {
        $size = @getimagesize($path);

        if (! $size) {
            return [null, null];
        }

        return [$size[0], $size[1]];
    }
}
