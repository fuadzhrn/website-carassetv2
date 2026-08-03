<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;

/**
 * Single entry point for recording activity-log rows. Deliberately thin —
 * records only the event name, page_slug, section_key, and causer. Never
 * accepts or stores full JSON content, never stores a raw source URL.
 */
class ActivityLogService
{
    public function record(string $event, ?string $pageSlug = null, ?string $sectionKey = null, ?User $causer = null): ActivityLog
    {
        return ActivityLog::create([
            'event' => $event,
            'page_slug' => $pageSlug,
            'section_key' => $sectionKey,
            'causer_id' => $causer?->id,
        ]);
    }
}
