<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Restricts map.embed_url to a genuine HTTPS embed URL on a whitelisted
 * map host — never an arbitrary URL, never raw HTML/iframe/script, never
 * verified against any external API. Purely a syntactic/whitelist check
 * against parse_url() output; makes no network request.
 */
class AllowedMapEmbedUrl implements ValidationRule
{
    /**
     * @var array<int, string>
     */
    private const ALLOWED_HOSTS = [
        'www.google.com',
        'maps.google.com',
    ];

    /**
     * @var array<int, string>
     */
    private const ALLOWED_PATH_PREFIXES = [
        '/maps/embed',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (! is_string($value) || str_contains($value, '<') || str_contains($value, '>')) {
            $fail('URL map embed tidak boleh mengandung tag HTML.');

            return;
        }

        $parts = parse_url($value);

        if ($parts === false || ! isset($parts['scheme'], $parts['host'], $parts['path'])) {
            $fail('URL map embed tidak valid.');

            return;
        }

        if ($parts['scheme'] !== 'https') {
            $fail('URL map embed harus menggunakan HTTPS.');

            return;
        }

        if (isset($parts['user']) || isset($parts['pass'])) {
            $fail('URL map embed tidak boleh menyertakan informasi pengguna.');

            return;
        }

        if (! in_array($parts['host'], self::ALLOWED_HOSTS, true)) {
            $fail('URL map embed hanya diperbolehkan dari domain yang diizinkan (Google Maps).');

            return;
        }

        $hasAllowedPath = false;

        foreach (self::ALLOWED_PATH_PREFIXES as $prefix) {
            if (str_starts_with($parts['path'], $prefix)) {
                $hasAllowedPath = true;

                break;
            }
        }

        if (! $hasAllowedPath) {
            $fail('URL map embed harus berupa URL embed resmi (/maps/embed), bukan URL peta biasa.');
        }
    }
}
