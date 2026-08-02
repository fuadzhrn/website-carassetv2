<?php

namespace App\Services;

use App\Models\Media;
use App\Models\Page;
use App\Models\PageSection;

/**
 * Read-only audit of every image a page's sections currently reference,
 * for the "Pemeriksaan Alt Text Gambar" panel on the SEO editor. Never
 * writes to the database, never invents alt text, never scans for a
 * fourth alt-text source beyond the three the public site itself already
 * uses (see PageController::resolveImage()): section override -> Media
 * Library alt_text -> static config fallback.
 *
 * Reads each section's raw Draft-or-Published content (PageSection::
 * editorContent(), NOT ContentService's fallback-merged output) so a
 * missing/null alt can be told apart from an explicit admin override —
 * merged content can't make that distinction once the fallback has been
 * layered in.
 */
class PageImageSeoService
{
    /**
     * @var array<string, string>
     */
    private const CONTENT_CONFIG = [
        'home' => 'home-content',
        'business' => 'business-content',
        'partnership' => 'partnership-content',
        'simulation' => 'simulation-content',
        'about-contact' => 'about-contact-content',
    ];

    /**
     * @return array<int, array{section_key: string, section_label: string, field_path: string, media_id: ?int, thumbnail_url: ?string, media_name: ?string, alt_effective: ?string, alt_source: string, status: string, edit_url: string}>
     */
    public function auditForPage(Page $page): array
    {
        $configPrefix = self::CONTENT_CONFIG[$page->slug] ?? null;

        if ($configPrefix === null) {
            return [];
        }

        $fallbackSections = config("{$configPrefix}.sections", []);
        $sectionNames = config("cms.pages.{$page->slug}.sections", []);

        $sections = $page->sections()->ordered()->get();

        $matchesBySection = [];

        foreach ($sections as $section) {
            $content = $section->editorContent();
            $fallbackContent = $fallbackSections[$section->section_key] ?? [];

            $matchesBySection[$section->section_key] = $this->scan($content, $fallbackContent);
        }

        $mediaIds = collect($matchesBySection)
            ->flatten(1)
            ->pluck('media_id')
            ->filter()
            ->unique()
            ->values();

        $mediaById = Media::whereIn('id', $mediaIds)->get()->keyBy('id');

        $rows = [];

        foreach ($sections as $section) {
            $sectionLabel = $sectionNames[$section->section_key]['name'] ?? $section->section_name ?? $section->section_key;

            foreach ($matchesBySection[$section->section_key] as $match) {
                $rows[] = $this->buildRow($page, $section, $sectionLabel, $match, $mediaById);
            }
        }

        return $rows;
    }

    /**
     * Recursively find every `*_media_id` (or bare `media_id`) key and its
     * sibling `*_alt` (or `alt`) key at the same array level, walking the
     * fallback content array in lockstep so a static fallback alt can be
     * read without guessing field names.
     *
     * @param array<array-key, mixed> $content
     * @param array<array-key, mixed> $fallbackContent
     * @return array<int, array{path: string, media_id: ?int, alt_override: ?string, alt_fallback: ?string}>
     */
    private function scan(array $content, array $fallbackContent, string $prefix = ''): array
    {
        $matches = [];

        foreach ($content as $key => $value) {
            $path = $prefix === '' ? (string) $key : $prefix.'.'.$key;
            $fallbackValue = $fallbackContent[$key] ?? null;

            if (is_array($value)) {
                $childFallback = is_array($fallbackValue) ? $fallbackValue : [];
                array_push($matches, ...$this->scan($value, $childFallback, $path));

                continue;
            }

            $isMediaKey = is_string($key) && ($key === 'media_id' || str_ends_with($key, '_media_id'));

            if (! $isMediaKey) {
                continue;
            }

            // A null media_id still counts as "an image field this section
            // uses" — the public page falls back to a static asset in that
            // case (see PageController::resolveImage()), so its alt text is
            // still worth auditing, not silently skipped.
            $altKey = $key === 'media_id' ? 'alt' : preg_replace('/_media_id$/', '_alt', $key);
            $altOverride = $content[$altKey] ?? null;
            $altFallback = $fallbackContent[$altKey] ?? null;

            $matches[] = [
                'path' => $path,
                'media_id' => $value !== null ? (int) $value : null,
                'alt_override' => (is_string($altOverride) && trim($altOverride) !== '') ? $altOverride : null,
                'alt_fallback' => (is_string($altFallback) && trim($altFallback) !== '') ? $altFallback : null,
            ];
        }

        return $matches;
    }

    /**
     * @param array{path: string, media_id: ?int, alt_override: ?string, alt_fallback: ?string} $match
     * @param \Illuminate\Support\Collection<int, Media> $mediaById
     * @return array{section_key: string, section_label: string, field_path: string, media_id: ?int, thumbnail_url: ?string, media_name: ?string, alt_effective: ?string, alt_source: string, status: string, edit_url: string}
     */
    private function buildRow(Page $page, PageSection $section, string $sectionLabel, array $match, $mediaById): array
    {
        $media = $mediaById->get($match['media_id']);
        $altMedia = ($media?->alt_text !== null && trim((string) $media?->alt_text) !== '') ? $media->alt_text : null;

        if ($match['alt_override'] !== null) {
            $altEffective = $match['alt_override'];
            $source = 'section';
        } elseif ($altMedia !== null) {
            $altEffective = $altMedia;
            $source = 'media_library';
        } elseif ($match['alt_fallback'] !== null) {
            $altEffective = $match['alt_fallback'];
            $source = 'fallback';
        } else {
            $altEffective = null;
            $source = 'kosong';
        }

        $status = ($altEffective !== null && trim($altEffective) !== '') ? 'tersedia' : 'perlu_ditinjau';

        $editUrl = ($source === 'media_library' && $media)
            ? route('admin.media.edit', $media)
            : route('admin.pages.'.$page->slug).'#section-'.$section->section_key;

        return [
            'section_key' => $section->section_key,
            'section_label' => $sectionLabel,
            'field_path' => $match['path'],
            'media_id' => $match['media_id'],
            'thumbnail_url' => $media?->url(),
            'media_name' => $media?->original_name,
            'alt_effective' => $altEffective,
            'alt_source' => $source,
            'status' => $status,
            'edit_url' => $editUrl,
        ];
    }
}
