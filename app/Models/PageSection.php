<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['section_name', 'content', 'is_active', 'sort_order', 'workflow_status', 'draft_content', 'draft_is_active', 'draft_updated_at', 'published_at', 'published_by'])]
class PageSection extends Model
{
    public const WORKFLOW_DRAFT = 'draft';

    public const WORKFLOW_PUBLISHED = 'published';

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'draft_content' => 'array',
            'draft_is_active' => 'boolean',
            'draft_updated_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function publishedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(ContentRevision::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    /**
     * True only when this section has unpublished changes waiting —
     * workflow_status alone isn't enough since draft_content could in
     * theory be null even while flagged draft (defensive: both must hold).
     */
    public function hasDraft(): bool
    {
        return $this->workflow_status === self::WORKFLOW_DRAFT && $this->draft_content !== null;
    }

    /**
     * What the editor form should show: the Draft if one exists, otherwise
     * the currently Published content as the starting point.
     *
     * @return array<string, mixed>
     */
    public function editorContent(): array
    {
        return $this->hasDraft() ? $this->draft_content : ($this->content ?? []);
    }

    public function editorIsActive(): bool
    {
        if ($this->hasDraft() && $this->draft_is_active !== null) {
            return (bool) $this->draft_is_active;
        }

        return (bool) $this->is_active;
    }

    public function latestRevision(): ?ContentRevision
    {
        return $this->revisions()->orderByDesc('revision_number')->first();
    }
}
