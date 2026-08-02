<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'route_name', 'meta_title', 'meta_description', 'status', 'meta_robots', 'canonical_url', 'draft_meta_title', 'draft_meta_description', 'draft_meta_robots', 'draft_canonical_url', 'seo_workflow_status', 'seo_draft_updated_at', 'seo_published_at', 'seo_updated_by', 'seo_published_by'])]
class Page extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const SEO_WORKFLOW_DRAFT = 'draft';
    public const SEO_WORKFLOW_PUBLISHED = 'published';

    protected function casts(): array
    {
        return [
            'seo_draft_updated_at' => 'datetime',
            'seo_published_at' => 'datetime',
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function seoUpdatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seo_updated_by');
    }

    public function seoPublishedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seo_published_by');
    }

    /**
     * True only when this page has an unpublished SEO change waiting —
     * mirrors PageSection::hasDraft()'s same defensive double-check
     * (workflow_status alone isn't proof a Draft actually exists).
     */
    public function hasSeoDraft(): bool
    {
        return $this->seo_workflow_status === self::SEO_WORKFLOW_DRAFT
            && ($this->draft_meta_title !== null
                || $this->draft_meta_description !== null
                || $this->draft_meta_robots !== null
                || $this->draft_canonical_url !== null);
    }

    /**
     * What the SEO editor form should show: the Draft if one exists,
     * otherwise the currently Published SEO fields as the starting point.
     *
     * @return array{meta_title: ?string, meta_description: ?string, meta_robots: ?string, canonical_url: ?string}
     */
    public function editorSeoData(): array
    {
        if ($this->hasSeoDraft()) {
            return [
                'meta_title' => $this->draft_meta_title,
                'meta_description' => $this->draft_meta_description,
                'meta_robots' => $this->draft_meta_robots,
                'canonical_url' => $this->draft_canonical_url,
            ];
        }

        return $this->publishedSeoData();
    }

    /**
     * @return array{meta_title: ?string, meta_description: ?string, meta_robots: ?string, canonical_url: ?string}
     */
    public function publishedSeoData(): array
    {
        return [
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_robots' => $this->meta_robots,
            'canonical_url' => $this->canonical_url,
        ];
    }

    /**
     * Same as editorSeoData() — kept as a separate name so callers that
     * mean "what should Preview show" read clearly, even though the value
     * (Draft-or-Published) is identical to the editor's starting point.
     *
     * @return array{meta_title: ?string, meta_description: ?string, meta_robots: ?string, canonical_url: ?string}
     */
    public function previewSeoData(): array
    {
        return $this->editorSeoData();
    }
}
