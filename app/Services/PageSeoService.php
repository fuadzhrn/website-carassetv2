<?php

namespace App\Services;

use App\Models\Page;

/**
 * Assembles the final title/description/robots/canonical for one page by
 * layering: page SEO fields -> global seo.* site setting -> static
 * fallback supplied by the caller -> brand name (title only). Read-only —
 * never writes to the database, never makes an HTTP request, never
 * invents content beyond these four documented layers.
 *
 * $version controls ONLY which page-level fields are read (Published vs
 * Draft-or-Published) — it is always decided server-side by the caller,
 * exactly like ContentService::getPageSectionsContent()'s $version.
 */
class PageSeoService
{
    public function __construct(private readonly SettingsService $settingsService)
    {
    }

    /**
     * @param array{title?: ?string, description?: ?string} $fallback
     * @return array{title: string, description: ?string, robots: string, canonical: string, source: array<string, string>}
     */
    public function getForPage(Page $page, array $fallback = [], string $version = 'published'): array
    {
        return $version === 'preview'
            ? $this->getPreview($page, $fallback)
            : $this->getPublished($page, $fallback);
    }

    /**
     * @param array{title?: ?string, description?: ?string} $fallback
     * @return array{title: string, description: ?string, robots: string, canonical: string, source: array<string, string>}
     */
    public function getPublished(Page $page, array $fallback = []): array
    {
        return $this->assemble($page, $page->publishedSeoData(), $fallback);
    }

    /**
     * @param array{title?: ?string, description?: ?string} $fallback
     * @return array{title: string, description: ?string, robots: string, canonical: string, source: array<string, string>}
     */
    public function getPreview(Page $page, array $fallback = []): array
    {
        return $this->assemble($page, $page->previewSeoData(), $fallback);
    }

    /**
     * @param array{meta_title: ?string, meta_description: ?string, meta_robots: ?string, canonical_url: ?string} $seoData
     * @param array{title?: ?string, description?: ?string} $fallback
     * @return array{title: string, description: ?string, robots: string, canonical: string, source: array<string, string>}
     */
    private function assemble(Page $page, array $seoData, array $fallback): array
    {
        $brandName = $this->settingsService->get('brand.name', 'CarAsset');

        $titleSource = 'page';
        $title = $seoData['meta_title'];

        if ($title === null) {
            $title = $this->settingsService->get('seo.default_title');
            $titleSource = 'global';
        }

        if ($title === null) {
            $title = $fallback['title'] ?? null;
            $titleSource = 'static';
        }

        if ($title === null) {
            $title = $brandName;
            $titleSource = 'static';
        }

        $descriptionSource = 'page';
        $description = $seoData['meta_description'];

        if ($description === null) {
            $description = $this->settingsService->get('seo.default_description');
            $descriptionSource = 'global';
        }

        if ($description === null) {
            $description = $fallback['description'] ?? null;
            $descriptionSource = 'static';
        }

        [$robots, $robotsSource] = $this->resolveRobotsWithSource($seoData['meta_robots']);
        [$canonical, $canonicalSource] = $this->resolveCanonicalWithSource($page, $seoData['canonical_url']);

        return [
            'title' => $title,
            'description' => $description,
            'robots' => $robots,
            'canonical' => $canonical,
            'source' => [
                'title' => $titleSource,
                'description' => $descriptionSource,
                'robots' => $robotsSource,
                'canonical' => $canonicalSource,
            ],
        ];
    }

    public function resolveRobots(?string $pageRobots): string
    {
        return $this->resolveRobotsWithSource($pageRobots)[0];
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function resolveRobotsWithSource(?string $pageRobots): array
    {
        if ($pageRobots !== null && $pageRobots !== '') {
            return [$pageRobots, 'page'];
        }

        $globalRobots = $this->settingsService->get('seo.default_robots');

        if ($globalRobots !== null && $globalRobots !== '') {
            return [$globalRobots, 'global'];
        }

        return ['index,follow', 'default'];
    }

    public function resolveCanonical(Page $page, ?string $canonical): string
    {
        return $this->resolveCanonicalWithSource($page, $canonical)[0];
    }

    /**
     * Static title/description fallback text — the same literal strings
     * each page's Blade `@section('title', ...)` already used before this
     * module existed. Never invented, never derived from H1/content.
     * Shared by every public controller and the admin SEO editor so there
     * is exactly one place holding this text.
     *
     * @return array{title: ?string, description: ?string}
     */
    public function staticFallback(string $slug): array
    {
        return match ($slug) {
            'home' => [
                'title' => 'CarAsset — Mobil Bekerja, Aset Bertumbuh',
                'description' => 'CarAsset membantu mitra memiliki dan mengelola kendaraan produktif melalui sistem operasional yang profesional dan transparan.',
            ],
            'business' => [
                'title' => 'Bisnis CarAsset — Own, Operate, Grow',
                'description' => 'Pelajari bagaimana CarAsset membantu mitra memiliki, mengoperasikan, dan mengembangkan aset kendaraan produktif melalui sistem yang profesional.',
            ],
            'partnership' => [
                'title' => 'Program Kemitraan CarAsset',
                'description' => 'Pelajari program Mitra Owner dan Mitra Driver CarAsset serta pilihan skala kemitraan kendaraan produktif.',
            ],
            'simulation' => [
                'title' => 'Simulasi dan Perlindungan Aset CarAsset',
                'description' => 'Pelajari contoh ilustrasi operasional, perbandingan skala unit, serta sistem perlindungan dan monitoring aset dalam program CarAsset.',
            ],
            'about-contact' => [
                'title' => 'Tentang dan Kontak CarAsset',
                'description' => 'Kenali CarAsset, nilai perusahaan, informasi legalitas, pertanyaan umum, dan cara berkonsultasi mengenai program kendaraan produktif.',
            ],
            default => ['title' => null, 'description' => null],
        };
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function resolveCanonicalWithSource(Page $page, ?string $canonical): array
    {
        if ($canonical !== null && $canonical !== '') {
            return [$canonical, 'custom'];
        }

        return [route($page->route_name), 'route'];
    }
}
