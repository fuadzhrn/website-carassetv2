<?php

namespace App\Services;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Support\Collection;

/**
 * Single entry point for reading CMS content (pages + sections).
 *
 * Controllers depend on this service instead of querying Page/PageSection
 * directly from Blade. Every read method is null-safe and falls back to
 * caller-supplied defaults — it never invents content and never writes
 * to the database.
 */
class ContentService
{
    /**
     * Find a page by its internal slug, regardless of status.
     */
    public function getPage(string $slug): ?Page
    {
        return Page::where('slug', $slug)->first();
    }

    /**
     * Find a page by its internal slug, only if it is active.
     */
    public function getActivePage(string $slug): ?Page
    {
        return Page::active()->where('slug', $slug)->first();
    }

    /**
     * Find a page by its public route name.
     */
    public function getPageByRouteName(string $routeName): ?Page
    {
        return Page::where('route_name', $routeName)->first();
    }

    /**
     * Get a page's sections ordered by sort_order.
     *
     * @return Collection<int, PageSection>
     */
    public function getSections(string $pageSlug, bool $onlyActive = true): Collection
    {
        $page = $this->getPage($pageSlug);

        if (! $page) {
            return new Collection();
        }

        $query = $page->sections()->ordered();

        if ($onlyActive) {
            $query->active();
        }

        return $query->get();
    }

    /**
     * Get a single section by page slug + section key.
     */
    public function getSection(string $pageSlug, string $sectionKey): ?PageSection
    {
        $page = $this->getPage($pageSlug);

        if (! $page) {
            return null;
        }

        return $page->sections()->where('section_key', $sectionKey)->first();
    }

    /**
     * Get a section's content merged over a fallback array.
     *
     * Database values win field-by-field; anything missing, null, or not
     * an array falls back to the caller-supplied default. Never mutates
     * the database.
     *
     * @param array<string, mixed> $fallback
     * @return array<string, mixed>
     */
    public function getSectionContent(string $pageSlug, string $sectionKey, array $fallback = []): array
    {
        $section = $this->getSection($pageSlug, $sectionKey);

        if (! $section || ! is_array($section->content) || $section->content === []) {
            return $fallback;
        }

        return $this->mergeContent($fallback, $section->content);
    }

    /**
     * Get every section of a page in one query, each merged over its own
     * fallback content — for controllers that need the whole page at once
     * (e.g. the public Home page) instead of one getSectionContent() call
     * per section.
     *
     * $version controls which content is read — this is the ONLY switch
     * between the two, and it must always be decided server-side by the
     * caller (public controllers always pass 'published'; only
     * ContentPreviewController ever passes 'preview'). Never derive this
     * from a request/query parameter.
     *
     * - 'published' (default): reads content/is_active ONLY. Never touches
     *   draft_content/draft_is_active, even if a Draft exists. This is
     *   what every public page controller uses.
     * - 'preview': reads draft_content/draft_is_active when a Draft
     *   exists, falling back to content/is_active otherwise (see
     *   PageSection::editorContent()/editorIsActive()). Admin editors use
     *   this same mode so the form always shows the Draft being worked on.
     *
     * @param array<string, array<string, mixed>> $fallbacks section_key => fallback content
     * @return array<string, array{content: array<string, mixed>, is_active: bool, section_name: ?string}>
     */
    public function getPageSectionsContent(string $pageSlug, array $fallbacks = [], string $version = 'published'): array
    {
        $usePreview = $version === 'preview';

        $page = $this->getPage($pageSlug);
        $sectionsByKey = $page ? $page->sections()->ordered()->get()->keyBy('section_key') : collect();

        $result = [];

        foreach ($fallbacks as $sectionKey => $fallbackContent) {
            $section = $sectionsByKey->get($sectionKey);

            if (! $section) {
                $result[$sectionKey] = [
                    'content' => $fallbackContent,
                    'is_active' => true,
                    'section_name' => null,
                ];

                continue;
            }

            $sectionContent = $usePreview ? $section->editorContent() : ($section->content ?? []);
            $sectionIsActive = $usePreview ? $section->editorIsActive() : (bool) $section->is_active;
            $hasContent = $sectionContent !== [];

            $result[$sectionKey] = [
                'content' => $hasContent ? $this->mergeContent($fallbackContent, $sectionContent) : $fallbackContent,
                'is_active' => $sectionIsActive,
                'section_name' => $section->section_name,
            ];
        }

        return $result;
    }

    /**
     * Merge database content over fallback content, distinguishing list
     * (repeater) arrays from associative ones:
     *
     * - Associative sub-arrays (e.g. a CTA object) are merged field-by-field
     *   so a field the admin hasn't touched still gets its fallback value.
     * - List arrays (e.g. benefits/status_items/trust_points) are replaced
     *   WHOLESALE by the database value when present — admin edits to a
     *   repeater must fully control what's shown, including emptying it,
     *   never spliced item-by-item against the fallback list.
     *
     * Deliberately not array_replace_recursive()/array_merge_recursive():
     * neither can tell a "list of items" apart from a "record of fields",
     * so both mismerge repeaters in exactly the way described above.
     *
     * @param array<string, mixed> $fallback
     * @param array<string, mixed> $database
     * @return array<string, mixed>
     */
    private function mergeContent(array $fallback, array $database): array
    {
        $result = $fallback;

        foreach ($database as $key => $value) {
            if (is_array($value) && array_is_list($value)) {
                $result[$key] = $value;

                continue;
            }

            if (is_array($value) && isset($result[$key]) && is_array($result[$key]) && ! array_is_list($result[$key])) {
                $result[$key] = $this->mergeContent($result[$key], $value);

                continue;
            }

            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * Whether a section exists and is marked active.
     *
     * Sections that don't exist are treated as inactive (fail-safe: never
     * show a fallback for a section the admin deliberately turned off).
     */
    public function isSectionActive(string $pageSlug, string $sectionKey): bool
    {
        $section = $this->getSection($pageSlug, $sectionKey);

        return (bool) $section?->is_active;
    }

    /**
     * Get a page's SEO fields (meta_title/meta_description) merged over a fallback.
     *
     * @param array<string, mixed> $fallback
     * @return array<string, mixed>
     */
    public function getPageSeo(string $pageSlug, array $fallback = []): array
    {
        $page = $this->getPage($pageSlug);

        if (! $page) {
            return $fallback;
        }

        return array_replace_recursive($fallback, array_filter([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
        ], fn ($value) => $value !== null));
    }
}
