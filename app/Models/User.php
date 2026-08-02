<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function updatedSections(): HasMany
    {
        return $this->hasMany(PageSection::class, 'updated_by');
    }

    public function uploadedMedia(): HasMany
    {
        return $this->hasMany(Media::class, 'uploaded_by');
    }

    public function handledContactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class, 'handled_by');
    }

    public function publishedSections(): HasMany
    {
        return $this->hasMany(PageSection::class, 'published_by');
    }

    public function contentRevisions(): HasMany
    {
        return $this->hasMany(ContentRevision::class, 'created_by');
    }

    public function seoUpdatedPages(): HasMany
    {
        return $this->hasMany(Page::class, 'seo_updated_by');
    }

    public function seoPublishedPages(): HasMany
    {
        return $this->hasMany(Page::class, 'seo_published_by');
    }
}
