<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Page;
use App\Services\CmsLinkService;
use App\Services\ContentService;
use App\Services\PageSeoService;
use Illuminate\View\View;

/**
 * Public Produk BYD ATTO 1 page. Mirrors Website\PageController's
 * read-only, present*()-per-section pattern — no Blade-level queries, no
 * reading Draft, no invented colors/variants/specifications/prices, no
 * requests to any BYD website. $version is always decided server-side by
 * the caller (the public route always passes 'published'; only
 * ContentPreviewController ever passes 'preview').
 */
class ProductBydAtto1Controller extends Controller
{
    public function index(ContentService $contentService, CmsLinkService $linkService, PageSeoService $seoService): View
    {
        return view('pages.product-byd-atto-1.index', [
            'product' => $this->productData($contentService, $linkService, 'published'),
            'seo' => $this->seoFor($seoService, 'published'),
        ]);
    }

    /**
     * @return array{title: string, description: ?string, robots: string, canonical: string, source: array<string, string>}
     */
    public function seoFor(PageSeoService $seoService, string $version): array
    {
        $page = Page::where('slug', 'product-byd-atto-1')->first();

        if (! $page) {
            return [
                'title' => $seoService->staticFallback('product-byd-atto-1')['title'] ?? '',
                'description' => null,
                'robots' => 'index,follow',
                'canonical' => url()->current(),
                'source' => ['title' => 'static', 'description' => 'static', 'robots' => 'default', 'canonical' => 'route'],
            ];
        }

        return $seoService->getForPage($page, $seoService->staticFallback('product-byd-atto-1'), $version);
    }

    /**
     * @return array<string, mixed>
     */
    public function productData(ContentService $contentService, CmsLinkService $linkService, string $version): array
    {
        $fallbacks = config('product-byd-atto-1-content.sections', []);
        $sections = $contentService->getPageSectionsContent('product-byd-atto-1', $fallbacks, $version);
        $fallbackImages = config('product-byd-atto-1-content.fallback_images', []);
        $limits = config('product-byd-atto-1-content.limits', []);

        return [
            'product-hero' => $this->presentHero($sections['product-hero'], $linkService, $fallbackImages, $limits),
            'product-colors' => $this->presentGallery($sections['product-colors'], $limits),
            'product-variants' => $this->presentVariants($sections['product-variants'], $limits),
            'product-specifications' => $this->presentSpecifications($sections['product-specifications'], $limits),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fallbackImages
     * @param array<string, int> $limits
     * @return array<string, mixed>
     */
    private function presentHero(array $section, CmsLinkService $linkService, array $fallbackImages, array $limits): array
    {
        $content = $section['content'];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'model_name' => $content['model_name'] ?? null,
            'title' => $content['title'] ?? null,
            'tagline' => $content['tagline'] ?? null,
            'description' => $content['description'] ?? null,
            'image' => $this->resolveImage(
                $content['hero_media_id'] ?? null,
                $content['hero_alt'] ?? null,
                $fallbackImages['product-hero'] ?? null,
                'Ilustrasi generik kendaraan listrik (visual sementara)',
            ),
            'badges' => $this->filterItems($content['badges'] ?? [], 'label', $limits['hero_badges'] ?? 4),
            'primary_cta' => $linkService->resolve($content['primary_cta'] ?? null),
            'secondary_cta' => $linkService->resolve($content['secondary_cta'] ?? null),
            'microcopy' => $content['microcopy'] ?? null,
        ];
    }

    /**
     * Gallery is a temporary-visual concern — an item only needs is_active
     * + a resolvable media to show. The section stays active as long as
     * the gallery has at least one item.
     *
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, int> $limits
     * @return array<string, mixed>
     */
    private function presentGallery(array $section, array $limits): array
    {
        $content = $section['content'];

        $gallery = [];

        foreach (array_slice($content['gallery'] ?? [], 0, $limits['gallery'] ?? 8) as $item) {
            if (($item['is_active'] ?? true) === false) {
                continue;
            }

            $image = $this->resolveImage($item['media_id'] ?? null, $item['alt'] ?? null, null, $item['view_label'] ?? '');

            if ($image['url'] === null) {
                continue;
            }

            $gallery[] = [
                'item_key' => $item['item_key'] ?? null,
                'image' => $image,
                'caption' => $item['caption'] ?? null,
                'view_label' => $item['view_label'] ?? null,
                'is_temporary' => ($item['is_temporary'] ?? true) !== false,
            ];
        }

        return [
            'is_active' => $section['is_active'] && $gallery !== [],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'gallery' => $gallery,
            'gallery_note' => $content['gallery_note'] ?? null,
        ];
    }

    /**
     * Variants only ever surface once each variant's own
     * information_status is 'confirmed' — section-level data_status must
     * also be 'confirmed'. Layout must work with just 1 confirmed variant
     * (handled in the Blade, not here) — this method only filters/shapes
     * data, never forces a fixed grid count.
     *
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, int> $limits
     * @return array<string, mixed>
     */
    private function presentVariants(array $section, array $limits): array
    {
        $content = $section['content'];
        $dataStatus = $content['data_status'] ?? 'draft';

        $variants = [];

        if ($dataStatus === 'confirmed') {
            foreach (array_slice($content['variants'] ?? [], 0, $limits['variants'] ?? 5) as $variant) {
                if (($variant['is_active'] ?? true) === false) {
                    continue;
                }

                if (($variant['information_status'] ?? 'draft') !== 'confirmed') {
                    continue;
                }

                $name = $variant['name'] ?? null;

                if ($name === null) {
                    continue;
                }

                $variants[] = [
                    'item_key' => $variant['item_key'] ?? null,
                    'name' => $name,
                    'subtitle' => $variant['subtitle'] ?? null,
                    'description' => $variant['description'] ?? null,
                    'image' => $this->resolveImage($variant['image_media_id'] ?? null, $variant['image_alt'] ?? null, null, $name),
                    'badge' => $variant['badge'] ?? null,
                    'is_featured' => ($variant['is_featured'] ?? false) === true,
                    'highlights' => $this->filterItems($variant['highlights'] ?? [], 'label', $limits['variant_highlights'] ?? 8),
                    'specifications' => $this->filterItems($variant['specifications'] ?? [], 'label', $limits['variant_specs'] ?? 12),
                ];
            }
        }

        return [
            'is_active' => $section['is_active'] && $dataStatus === 'confirmed' && $variants !== [],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'variants' => $variants,
        ];
    }

    /**
     * Specification categories and features only ever surface once
     * data_status is 'confirmed'.
     *
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, int> $limits
     * @return array<string, mixed>
     */
    private function presentSpecifications(array $section, array $limits): array
    {
        $content = $section['content'];
        $dataStatus = $content['data_status'] ?? 'draft';

        $categories = [];
        $features = [];

        if ($dataStatus === 'confirmed') {
            foreach (array_slice($content['specification_categories'] ?? [], 0, $limits['spec_categories'] ?? 6) as $category) {
                if (($category['is_active'] ?? true) === false || ($category['title'] ?? null) === null) {
                    continue;
                }

                $items = $this->filterItems($category['items'] ?? [], 'label', $limits['spec_items_per_category'] ?? 10);

                if ($items === []) {
                    continue;
                }

                $categories[] = [
                    'item_key' => $category['item_key'] ?? null,
                    'title' => $category['title'],
                    'description' => $category['description'] ?? null,
                    'items' => $items,
                ];
            }

            foreach (array_slice($content['features'] ?? [], 0, $limits['feature_items'] ?? 12) as $feature) {
                if (($feature['is_active'] ?? true) === false || ($feature['title'] ?? null) === null) {
                    continue;
                }

                $features[] = [
                    'item_key' => $feature['item_key'] ?? null,
                    'title' => $feature['title'],
                    'description' => $feature['description'] ?? null,
                    'image' => $this->resolveImage($feature['media_id'] ?? null, $feature['media_alt'] ?? null, null, $feature['title']),
                ];
            }
        }

        return [
            'is_active' => $section['is_active'] && $dataStatus === 'confirmed' && ($categories !== [] || $features !== []),
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'specification_categories' => $categories,
            'features' => $features,
        ];
    }

    /**
     * @return array{url: ?string, alt: string}
     */
    private function resolveImage(?int $mediaId, ?string $overrideAlt, ?string $fallbackPath, string $fallbackAlt): array
    {
        if ($mediaId) {
            $media = Media::find($mediaId);
            $url = $media?->url();

            if ($url) {
                return [
                    'url' => $url,
                    'alt' => $overrideAlt ?: ($media->alt_text ?: $fallbackAlt),
                ];
            }
        }

        return [
            'url' => $fallbackPath ? asset($fallbackPath) : null,
            'alt' => $overrideAlt ?: $fallbackAlt,
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $items
     * @return array<int, array<string, mixed>>
     */
    private function filterItems(array $items, string $textField, int $max): array
    {
        $filtered = array_filter($items, function ($item) use ($textField) {
            return ($item[$textField] ?? '') !== '' && ($item['is_active'] ?? true) !== false;
        });

        return array_values(array_slice($filtered, 0, $max));
    }

    /**
     * @return array<int, string>
     */
    private function splitLines(?string $value, string $separator): array
    {
        if (! $value) {
            return [];
        }

        $parts = explode($separator, str_replace("\r\n", "\n", $value));

        return array_values(array_filter(array_map('trim', $parts), fn ($line) => $line !== ''));
    }
}
