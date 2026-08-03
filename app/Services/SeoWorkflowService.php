<?php

namespace App\Services;

use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Single entry point for the SEO Draft/Publish/Discard workflow — the SEO
 * equivalent of ContentWorkflowService, but scoped to pages.* metadata
 * only and deliberately without a revision history (PROMPT 24 explicitly
 * does not require one). Reuses the same transaction/locking pattern for
 * consistency, not because the two workflows are the same thing.
 *
 * The public website only ever reads Page::meta_title/meta_description/
 * meta_robots/canonical_url (see PageSeoService's 'published' mode) —
 * nothing here ever touches those four columns except publish().
 */
class SeoWorkflowService
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    /**
     * Save an SEO Draft. Never touches the Published SEO columns, never
     * touches seo_published_at/seo_published_by.
     *
     * @param array{meta_title: ?string, meta_description: ?string, meta_robots: string, canonical_url: ?string} $seo
     */
    public function saveDraft(Page $page, array $seo, User $admin): Page
    {
        DB::transaction(function () use ($page, $seo, $admin) {
            $page->draft_meta_title = $seo['meta_title'];
            $page->draft_meta_description = $seo['meta_description'];
            $page->draft_meta_robots = $seo['meta_robots'];
            $page->draft_canonical_url = $seo['canonical_url'];
            $page->seo_workflow_status = Page::SEO_WORKFLOW_DRAFT;
            $page->seo_updated_by = $admin->id;
            $page->seo_draft_updated_at = now();
            $page->save();
        });

        $this->activityLog->record('seo.draft_saved', $page->slug, null, $admin);

        return $page->refresh();
    }

    /**
     * Publish the current SEO Draft: copies the draft_* columns into the
     * Published columns, stamps seo_published_at/seo_published_by, then
     * clears the Draft fields.
     *
     * @throws RuntimeException if the page has no SEO Draft to publish.
     */
    public function publish(Page $page, User $admin): Page
    {
        return DB::transaction(function () use ($page, $admin) {
            /** @var Page $locked */
            $locked = Page::whereKey($page->id)->lockForUpdate()->firstOrFail();

            if (! $locked->hasSeoDraft()) {
                throw new RuntimeException('no_seo_draft');
            }

            $unchanged = $locked->draft_meta_title === $locked->meta_title
                && $locked->draft_meta_description === $locked->meta_description
                && $locked->draft_meta_robots === $locked->meta_robots
                && $locked->draft_canonical_url === $locked->canonical_url;

            if (! $unchanged) {
                $locked->meta_title = $locked->draft_meta_title;
                $locked->meta_description = $locked->draft_meta_description;
                $locked->meta_robots = $locked->draft_meta_robots;
                $locked->canonical_url = $locked->draft_canonical_url;
                $locked->seo_published_at = now();
                $locked->seo_published_by = $admin->id;
                $locked->seo_updated_by = $admin->id;
            }

            $locked->draft_meta_title = null;
            $locked->draft_meta_description = null;
            $locked->draft_meta_robots = null;
            $locked->draft_canonical_url = null;
            $locked->seo_draft_updated_at = null;
            $locked->seo_workflow_status = Page::SEO_WORKFLOW_PUBLISHED;
            $locked->save();

            $this->activityLog->record('seo.published', $locked->slug, null, $admin);

            return $locked;
        });
    }

    /**
     * Discard the current SEO Draft. Published SEO fields/seo_published_at/
     * seo_published_by are all untouched.
     */
    public function discardDraft(Page $page, User $admin): Page
    {
        DB::transaction(function () use ($page, $admin) {
            $page->draft_meta_title = null;
            $page->draft_meta_description = null;
            $page->draft_meta_robots = null;
            $page->draft_canonical_url = null;
            $page->seo_draft_updated_at = null;
            $page->seo_workflow_status = Page::SEO_WORKFLOW_PUBLISHED;
            $page->seo_updated_by = $admin->id;
            $page->save();
        });

        $this->activityLog->record('seo.draft_discarded', $page->slug, null, $admin);

        return $page->refresh();
    }

    public function hasChanges(Page $page): bool
    {
        return $page->hasSeoDraft();
    }
}
