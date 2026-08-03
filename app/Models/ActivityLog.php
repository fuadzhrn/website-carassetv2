<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A minimal, append-only record of one CMS workflow event (Draft saved,
 * Published, Discarded, Revision restored, SEO workflow, Media
 * uploaded/deleted). Never stores full JSON content or a raw source URL —
 * only which event happened, on which page/section, and who did it.
 */
#[Fillable(['event', 'page_slug', 'section_key', 'causer_id'])]
class ActivityLog extends Model
{
    const UPDATED_AT = null;

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
