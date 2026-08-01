<?php

namespace App\Services;

use App\Models\Media;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

/**
 * Single entry point for reading/writing site_settings. Controllers and the
 * SiteSettingsComposer depend on this instead of querying SiteSetting
 * directly — every read is cached and every write clears that cache.
 */
class SettingsService
{
    private const CACHE_KEY = 'carasset.site_settings';

    /**
     * In-process memo so multiple composers/partials in the same request
     * (header, footer, seo-meta, contact section, ...) share one lookup
     * instead of re-hitting the cache store per Blade include.
     *
     * @var array<string, mixed>|null
     */
    private static ?array $resolved = null;

    public function get(string $key, mixed $fallback = null): mixed
    {
        $value = $this->all()[$key] ?? null;

        return ($value === null || $value === '') ? $fallback : $value;
    }

    /**
     * @return array<string, mixed> key => value, without the group prefix
     */
    public function group(string $group): array
    {
        $prefix = $group.'.';
        $result = [];

        foreach ($this->all() as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $result[substr($key, strlen($prefix))] = $value;
            }
        }

        return $result;
    }

    /**
     * @return array<string, mixed> flat "group.key" => value
     */
    public function all(): array
    {
        if (self::$resolved !== null) {
            return self::$resolved;
        }

        return self::$resolved = Cache::rememberForever(self::CACHE_KEY, function () {
            return SiteSetting::all()
                ->mapWithKeys(fn (SiteSetting $setting) => [$setting->group.'.'.$setting->key => $setting->value])
                ->all();
        });
    }

    /**
     * Persist multiple settings at once. Only keys present in
     * config('site-settings.groups') are ever written — anything else in
     * $settings is silently ignored (whitelist, not a free key-value store).
     *
     * @param array<string, mixed> $settings flat "group.key" => value
     */
    public function setMany(array $settings, User $user): void
    {
        foreach (config('site-settings.groups') as $groupKey => $groupData) {
            foreach ($groupData['fields'] as $fieldKey => $fieldData) {
                $settingKey = $groupKey.'.'.$fieldKey;

                if (! array_key_exists($settingKey, $settings)) {
                    continue;
                }

                $setting = SiteSetting::where('group', $groupKey)->where('key', $fieldKey)->first();

                if (! $setting) {
                    $setting = new SiteSetting();
                    $setting->group = $groupKey;
                    $setting->key = $fieldKey;
                    $setting->type = $fieldData['type'];
                }

                $setting->value = $settings[$settingKey];
                $setting->save();
            }
        }

        $this->forgetCache();
    }

    /**
     * Resolve a `type=media` setting into its Media model, if the value is
     * a real media ID. Legacy raw-path values (see mediaUrl()) return null
     * here since there is no Media record to resolve to.
     */
    public function getMedia(string $key): ?Media
    {
        $value = $this->get($key);

        if (! $value || ! is_numeric($value)) {
            return null;
        }

        return Media::find((int) $value);
    }

    /**
     * Resolve a `type=media` setting straight to a public URL.
     *
     * Supports two value formats: a numeric Media ID (current format,
     * resolved through Media::url()), and a legacy static asset path
     * string (the format PROMPT 15's seeder used before Media Library
     * existed) — resolved via asset() if the file still exists.
     */
    public function mediaUrl(string $key, ?string $fallback = null): ?string
    {
        $value = $this->get($key);

        if (! $value) {
            return $fallback;
        }

        if (is_numeric($value)) {
            $media = Media::find((int) $value);

            return $media?->url() ?? $fallback;
        }

        if (is_string($value) && file_exists(public_path($value))) {
            return asset($value);
        }

        return $fallback;
    }

    /**
     * Alt text for a `type=media` setting, when resolvable from a real
     * Media record (legacy raw-path values have no alt text to read).
     */
    public function mediaAlt(string $key, ?string $fallback = null): ?string
    {
        return $this->getMedia($key)?->alt_text ?? $fallback;
    }

    /**
     * Build a wa.me URL from a `type=phone` setting, or null if the value
     * is empty or doesn't normalize into a plausible phone number.
     *
     * Indonesian numbers starting with "0" are rewritten to the "62"
     * country code — the display value itself (returned by get()) is
     * never touched, only the digits used to build the URL.
     */
    public function whatsappUrl(string $key): ?string
    {
        $value = $this->get($key);

        if (! $value) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', (string) $value);

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        return strlen($digits) >= 8 ? 'https://wa.me/'.$digits : null;
    }

    public function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        self::$resolved = null;
    }
}
