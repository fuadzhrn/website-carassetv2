<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A consultation request submitted through the public contact form.
 *
 * Deliberately minimal: no reply/notification logic lives here (that is
 * explicitly out of scope through PROMPT 22) — this model only stores
 * what was submitted and tracks the admin review status.
 */
#[Fillable(['name', 'whatsapp', 'email', 'program', 'message', 'consent', 'consented_at', 'ip_address', 'user_agent'])]
class ContactMessage extends Model
{
    public const STATUS_NEW = 'new';

    public const STATUS_READ = 'read';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_ARCHIVED = 'archived';

    /**
     * @return array<int, string>
     */
    public static function statuses(): array
    {
        return [self::STATUS_NEW, self::STATUS_READ, self::STATUS_COMPLETED, self::STATUS_ARCHIVED];
    }

    protected function casts(): array
    {
        return [
            'consent' => 'boolean',
            'consented_at' => 'datetime',
            'read_at' => 'datetime',
            'completed_at' => 'datetime',
            'archived_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function handledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (! $status || $status === 'all') {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Search name/program/email/whatsapp — always parameter-bound, never
     * raw string interpolation.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        $search = trim((string) $search);

        if ($search === '') {
            return $query;
        }

        return $query->where(function (Builder $query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('program', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('whatsapp', 'like', "%{$search}%");
        });
    }

    public function scopeNewest(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}
