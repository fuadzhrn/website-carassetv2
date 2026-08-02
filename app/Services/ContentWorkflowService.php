<?php

namespace App\Services;

use App\Models\ContentRevision;
use App\Models\PageSection;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Single entry point for the Draft/Preview/Publish/Revision workflow.
 *
 * The public website only ever reads PageSection::content/is_active
 * (see ContentService's 'published' mode) — nothing here ever touches
 * those two columns except publish(). Every other method only touches
 * draft_content/draft_is_active/workflow_status.
 *
 * No cache to invalidate: ContentService reads page_sections directly on
 * every request (it has never used a cache store), so there is nothing
 * to clear at any step below.
 */
class ContentWorkflowService
{
    /**
     * Save a Draft. Never touches content/is_active/published_at/
     * published_by, never creates a revision.
     *
     * @param array<string, mixed> $content
     */
    public function saveDraft(PageSection $section, array $content, bool $isActive, User $admin): PageSection
    {
        DB::transaction(function () use ($section, $content, $isActive, $admin) {
            $section->draft_content = $content;
            $section->draft_is_active = $isActive;
            $section->workflow_status = PageSection::WORKFLOW_DRAFT;
            $section->updated_by = $admin->id;
            $section->draft_updated_at = now();
            $section->save();
        });

        return $section->refresh();
    }

    /**
     * Publish the current Draft: copies draft_content/draft_is_active into
     * content/is_active, stamps published_at/published_by, snapshots a
     * ContentRevision (unless the Draft is byte-for-byte identical to what
     * is already Published), then clears the Draft fields.
     *
     * @throws RuntimeException if the section has no Draft to publish.
     */
    public function publish(PageSection $section, User $admin): PageSection
    {
        return DB::transaction(function () use ($section, $admin) {
            /** @var PageSection $locked */
            $locked = PageSection::whereKey($section->id)->lockForUpdate()->firstOrFail();

            if (! $locked->hasDraft()) {
                throw new RuntimeException('no_draft');
            }

            $this->ensureBaseline($locked, $admin);

            $draftContent = $locked->draft_content;
            $draftIsActive = $locked->draft_is_active !== null ? (bool) $locked->draft_is_active : (bool) $locked->is_active;

            $unchanged = $this->contentsEqual($draftContent, $locked->content ?? [])
                && $draftIsActive === (bool) $locked->is_active;

            if (! $unchanged) {
                $locked->content = $draftContent;
                $locked->is_active = $draftIsActive;
                $locked->published_at = now();
                $locked->published_by = $admin->id;
                $locked->updated_by = $admin->id;

                $this->createRevision($locked, ContentRevision::ACTION_PUBLISHED, $admin);
            }

            $locked->draft_content = null;
            $locked->draft_is_active = null;
            $locked->draft_updated_at = null;
            $locked->workflow_status = PageSection::WORKFLOW_PUBLISHED;
            $locked->save();

            return $locked;
        });
    }

    /**
     * Discard the current Draft. Published content/is_active/published_at/
     * published_by are all untouched — the public website never sees any
     * effect from this at all.
     */
    public function discardDraft(PageSection $section, User $admin): PageSection
    {
        DB::transaction(function () use ($section, $admin) {
            $section->draft_content = null;
            $section->draft_is_active = null;
            $section->draft_updated_at = null;
            $section->workflow_status = PageSection::WORKFLOW_PUBLISHED;
            $section->updated_by = $admin->id;
            $section->save();
        });

        return $section->refresh();
    }

    /**
     * Copies one historical revision's snapshot into the Draft fields —
     * never into content/is_active directly. The admin must still Preview
     * and Publish for this to reach the public site.
     */
    public function restoreRevisionToDraft(PageSection $section, ContentRevision $revision, User $admin): PageSection
    {
        DB::transaction(function () use ($section, $revision, $admin) {
            $section->draft_content = $revision->content;
            $section->draft_is_active = $revision->is_active;
            $section->workflow_status = PageSection::WORKFLOW_DRAFT;
            $section->updated_by = $admin->id;
            $section->draft_updated_at = now();
            $section->save();
        });

        return $section->refresh();
    }

    public function hasUnpublishedChanges(PageSection $section): bool
    {
        return $section->hasDraft();
    }

    public function nextRevisionNumber(PageSection $section): int
    {
        return (int) ($section->revisions()->max('revision_number') ?? 0) + 1;
    }

    /**
     * Creates the one-time revision_number=1 snapshot of whatever was
     * already Published before this workflow existed — only when the
     * section has no revisions yet and genuinely has non-empty Published
     * content. Never invents a timestamp/admin for the ORIGINAL publish;
     * the baseline is explicitly labeled as captured now, not back-dated.
     */
    private function ensureBaseline(PageSection $section, User $admin): void
    {
        if ($section->revisions()->exists()) {
            return;
        }

        if ($section->content === null || $section->content === []) {
            return;
        }

        ContentRevision::create([
            'page_section_id' => $section->id,
            'revision_number' => 1,
            'content' => $section->content,
            'is_active' => $section->is_active,
            'action' => ContentRevision::ACTION_BASELINE,
            'created_by' => $admin->id,
            'note' => 'Baseline konten sebelum workflow revisi diaktifkan.',
        ]);
    }

    private function createRevision(PageSection $section, string $action, User $admin): ContentRevision
    {
        return ContentRevision::create([
            'page_section_id' => $section->id,
            'revision_number' => $this->nextRevisionNumber($section),
            'content' => $section->content,
            'is_active' => $section->is_active,
            'action' => $action,
            'created_by' => $admin->id,
            'note' => null,
        ]);
    }

    /**
     * @param array<string, mixed> $a
     * @param array<string, mixed> $b
     */
    private function contentsEqual(array $a, array $b): bool
    {
        return $a == $b;
    }
}
