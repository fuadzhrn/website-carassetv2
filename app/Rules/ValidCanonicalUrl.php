<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Restricts pages.canonical_url to a genuine absolute http(s) URL that an
 * admin could plausibly want as a canonical target — never a relative
 * path, never javascript:/data:/file:, never one carrying credentials.
 * Purely a syntactic/policy check against parse_url() output (see
 * config('seo.canonical')); makes no network request and never resolves
 * a route itself (that fallback lives in PageSeoService).
 */
class ValidCanonicalUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (! is_string($value) || str_contains($value, '<') || str_contains($value, '>')) {
            $fail('Canonical URL tidak boleh mengandung tag HTML.');

            return;
        }

        if (mb_strlen($value) > 2048) {
            $fail('Canonical URL maksimal 2048 karakter.');

            return;
        }

        $parts = parse_url($value);

        if ($parts === false || ! isset($parts['scheme'], $parts['host'])) {
            $fail('Canonical URL harus berupa URL absolut yang valid.');

            return;
        }

        if (! in_array($parts['scheme'], ['http', 'https'], true)) {
            $fail('Canonical URL hanya boleh menggunakan skema http atau https.');

            return;
        }

        if (isset($parts['user']) || isset($parts['pass'])) {
            $fail('Canonical URL tidak boleh menyertakan username atau password.');

            return;
        }

        if (! config('seo.canonical.allow_fragment', false) && isset($parts['fragment'])) {
            $fail('Canonical URL tidak boleh menyertakan fragment (#).');

            return;
        }

        if (! config('seo.canonical.allow_query_string', false) && isset($parts['query'])) {
            $fail('Canonical URL tidak boleh menyertakan query string.');

            return;
        }

        if (config('seo.canonical.require_https_in_production', true)
            && app()->isProduction()
            && $parts['scheme'] !== 'https') {
            $fail('Canonical URL wajib menggunakan https pada production.');

            return;
        }

        if (! config('seo.canonical.allow_external_domain', false)) {
            $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);

            if ($appHost && strcasecmp($parts['host'], $appHost) !== 0) {
                $fail('Canonical URL harus menggunakan domain yang sama dengan situs ini.');

                return;
            }
        }
    }
}
