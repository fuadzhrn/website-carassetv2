<?php

namespace App\Services;

/**
 * Resolves a CMS CTA array (destination_type/route_name/anchor/external_url)
 * into a safe URL, or null if it shouldn't be rendered at all.
 *
 * This is the ONLY place admin-supplied link data is turned into an actual
 * href — route names and anchors are checked against config('cms-links'),
 * external URLs are restricted to http/https. Never call route() directly
 * with unvalidated admin input.
 */
class CmsLinkService
{
    /**
     * @param array<string, mixed>|null $cta
     * @return array{label: string, url: string, target: string, rel: ?string}|null
     */
    public function resolve(?array $cta): ?array
    {
        if (! $cta || ($cta['is_active'] ?? true) === false) {
            return null;
        }

        $label = trim((string) ($cta['label'] ?? ''));

        if ($label === '') {
            return null;
        }

        $type = $cta['destination_type'] ?? 'none';

        return match ($type) {
            'internal' => $this->resolveInternal($cta, $label),
            'external' => $this->resolveExternal($cta, $label),
            default => null,
        };
    }

    /**
     * @param array<string, mixed> $cta
     * @return array{label: string, url: string, target: string, rel: ?string}|null
     */
    private function resolveInternal(array $cta, string $label): ?array
    {
        $routeName = $cta['route_name'] ?? null;
        $allowedRoutes = config('cms-links.routes', []);

        if (! $routeName || ! in_array($routeName, $allowedRoutes, true)) {
            return null;
        }

        $url = route($routeName);

        $anchor = trim((string) ($cta['anchor'] ?? ''));
        $allowedAnchors = config("cms-links.anchors.{$routeName}", []);

        if ($anchor !== '' && in_array($anchor, $allowedAnchors, true)) {
            $url .= '#'.$anchor;
        }

        return [
            'label' => $label,
            'url' => $url,
            'target' => '_self',
            'rel' => null,
        ];
    }

    /**
     * @param array<string, mixed> $cta
     * @return array{label: string, url: string, target: string, rel: ?string}|null
     */
    private function resolveExternal(array $cta, string $label): ?array
    {
        $url = trim((string) ($cta['external_url'] ?? ''));

        if ($url === '' || ! $this->isSafeExternalUrl($url)) {
            return null;
        }

        $openNewTab = (bool) ($cta['open_new_tab'] ?? false);

        return [
            'label' => $label,
            'url' => $url,
            'target' => $openNewTab ? '_blank' : '_self',
            'rel' => $openNewTab ? 'noopener noreferrer' : null,
        ];
    }

    private function isSafeExternalUrl(string $url): bool
    {
        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        if (! in_array($scheme, ['http', 'https'], true)) {
            return false;
        }

        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}
