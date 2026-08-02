<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An immutable snapshot of one PageSection's Published content at the
 * moment it was published (or a one-time baseline captured just before
 * the workflow system existed). Never edited, never deleted through the
 * admin panel — see ContentWorkflowService, the only writer.
 */
#[Fillable(['page_section_id', 'revision_number', 'content', 'is_active', 'action', 'created_by', 'note'])]
class ContentRevision extends Model
{
    public const ACTION_BASELINE = 'baseline';

    public const ACTION_PUBLISHED = 'published';

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_active' => 'boolean',
            'revision_number' => 'integer',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(PageSection::class, 'page_section_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
