<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\CmsLinkService;
use App\Services\ContentService;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(ContentService $contentService, CmsLinkService $linkService): View
    {
        $fallbacks = config('home-content.sections', []);
        $sections = $contentService->getPageSectionsContent('home', $fallbacks);
        $fallbackImages = config('home-content.fallback_images', []);

        $home = [
            'hero' => $this->presentHero($sections['hero'], $linkService),
            'income-opportunity' => $this->presentIncomeOpportunity($sections['income-opportunity'], $linkService, $fallbackImages),
            'process-summary' => $this->presentProcessSummary($sections['process-summary'], $linkService),
            'partnership-choice' => $this->presentPartnershipChoice($sections['partnership-choice'], $linkService, $fallbackImages),
            'consultation-cta' => $this->presentConsultationCta($sections['consultation-cta'], $linkService),
        ];

        return view('pages.home.index', ['home' => $home]);
    }

    public function business(ContentService $contentService, CmsLinkService $linkService): View
    {
        $fallbacks = config('business-content.sections', []);
        $sections = $contentService->getPageSectionsContent('business', $fallbacks);
        $fallbackImages = config('business-content.fallback_images', []);

        $business = [
            'opportunity' => $this->presentBusinessOpportunity($sections['opportunity'], $linkService, $fallbackImages),
            'own' => $this->presentBusinessOwn($sections['own'], $fallbackImages),
            'operate' => $this->presentBusinessOperate($sections['operate']),
            'grow' => $this->presentBusinessGrow($sections['grow'], $linkService),
            'business-flow' => $this->presentBusinessFlow($sections['business-flow'], $linkService),
        ];

        return view('pages.business.index', ['business' => $business]);
    }

    public function partnership()
    {
        return view('pages.partnership.index');
    }

    public function simulation()
    {
        return view('pages.simulation.index');
    }

    public function aboutContact()
    {
        return view('pages.about-contact.index');
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentHero(array $section, CmsLinkService $linkService): array
    {
        $content = $section['content'];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title_line_1' => $content['title_line_1'] ?? null,
            'title_line_2' => $content['title_line_2'] ?? null,
            'subtitle' => $content['subtitle'] ?? null,
            'description' => $content['description'] ?? null,
            'status_items' => $this->filterItems($content['status_items'] ?? [], 'label', 3),
            'primary_cta' => $linkService->resolve($content['primary_cta'] ?? null),
            'secondary_cta' => $linkService->resolve($content['secondary_cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fallbackImages
     * @return array<string, mixed>
     */
    private function presentIncomeOpportunity(array $section, CmsLinkService $linkService, array $fallbackImages): array
    {
        $content = $section['content'];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'narrative_paragraphs' => $this->splitLines($content['narrative'] ?? null, "\n\n"),
            'editorial_lines' => $this->splitLines($content['editorial_statement'] ?? null, "\n"),
            'image' => $this->resolveImage(
                $content['image_media_id'] ?? null,
                $content['image_alt'] ?? null,
                $fallbackImages['income-opportunity'] ?? null,
                'Kendaraan listrik sedang mengisi daya sebagai ilustrasi kendaraan produktif',
            ),
            'cta' => $linkService->resolve($content['cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentProcessSummary(array $section, CmsLinkService $linkService): array
    {
        $content = $section['content'];
        $steps = [];

        foreach (['own', 'operate', 'grow'] as $stepKey) {
            $step = $content['steps'][$stepKey] ?? [];

            if (($step['is_active'] ?? true) === false) {
                continue;
            }

            $steps[$stepKey] = [
                'title' => $step['title'] ?? null,
                'description' => $step['description'] ?? null,
            ];
        }

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'steps' => $steps,
            'cta' => $linkService->resolve($content['cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fallbackImages
     * @return array<string, mixed>
     */
    private function presentPartnershipChoice(array $section, CmsLinkService $linkService, array $fallbackImages): array
    {
        $content = $section['content'];

        $programs = [];

        foreach (['owner', 'driver'] as $programKey) {
            $program = $content[$programKey] ?? [];

            $programs[$programKey] = [
                'eyebrow' => $program['eyebrow'] ?? null,
                'title' => $program['title'] ?? null,
                'description' => $program['description'] ?? null,
                'image' => $this->resolveImage(
                    $program['image_media_id'] ?? null,
                    $program['image_alt'] ?? null,
                    $fallbackImages["partnership-choice.{$programKey}"] ?? null,
                    $programKey === 'owner'
                        ? 'Konsultasi bisnis mengenai kepemilikan kendaraan sebagai aset'
                        : 'Driver profesional mengemudikan kendaraan CarAsset',
                ),
                'benefits' => $this->filterItems($program['benefits'] ?? [], 'text', 4),
                'cta' => $linkService->resolve($program['cta'] ?? null),
            ];
        }

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'owner' => $programs['owner'],
            'driver' => $programs['driver'],
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentConsultationCta(array $section, CmsLinkService $linkService): array
    {
        $content = $section['content'];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'trust_points' => $this->filterItems($content['trust_points'] ?? [], 'text', 4),
            'primary_cta' => $linkService->resolve($content['primary_cta'] ?? null),
            'secondary_cta' => $linkService->resolve($content['secondary_cta'] ?? null),
            'microcopy' => $content['microcopy'] ?? null,
        ];
    }

    /**
     * Keep only active, non-empty repeater items (benefits/status
     * items/trust points), capped at $max — admin-cleared or deactivated
     * slots are dropped entirely rather than rendered empty.
     *
     * Original slot indexes are preserved (not reindexed) so callers that
     * key a fixed, locked icon to each slot's position (e.g. hero's status
     * bar) still point at the right icon even when an earlier slot was
     * dropped.
     *
     * @param array<int, array<string, mixed>> $items
     * @return array<int, array<string, mixed>>
     */
    private function filterItems(array $items, string $textField, int $max): array
    {
        $filtered = array_filter($items, function ($item) use ($textField) {
            return ($item[$textField] ?? '') !== '' && ($item['is_active'] ?? true) !== false;
        });

        return array_slice($filtered, 0, $max, true);
    }

    /**
     * Split a plain-text field into lines/paragraphs on a given separator,
     * dropping empty entries — used for fields whose current design
     * renders multiple <p>/line-break segments from one textarea value.
     *
     * @return array<int, string>
     */
    private function splitLines(?string $value, string $separator): array
    {
        if (! $value) {
            return [];
        }

        $parts = explode($separator, str_replace("\r\n", "\n", $value));

        return array_values(array_filter(array_map('trim', $parts), fn ($line) => $line !== ''));
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fallbackImages
     * @return array<string, mixed>
     */
    private function presentBusinessOpportunity(array $section, CmsLinkService $linkService, array $fallbackImages): array
    {
        $content = $section['content'];
        $diagram = $content['diagram'] ?? [];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'diagram' => [
                'step_1_label' => $diagram['step_1_label'] ?? null,
                'step_2_label' => $diagram['step_2_label'] ?? null,
                'step_3_label' => $diagram['step_3_label'] ?? null,
                'step_4_label' => $diagram['step_4_label'] ?? null,
            ],
            // fallback alt "" disengaja — gambar hero ini dekoratif (teks
            // utama sudah ada di overlay), bukan gambar informatif.
            'image' => $this->resolveImage(
                $content['image_media_id'] ?? null,
                $content['image_alt'] ?? null,
                $fallbackImages['opportunity'] ?? null,
                '',
            ),
            'cta' => $linkService->resolve($content['cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fallbackImages
     * @return array<string, mixed>
     */
    private function presentBusinessOwn(array $section, array $fallbackImages): array
    {
        $content = $section['content'];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'image' => $this->resolveImage(
                $content['image_media_id'] ?? null,
                $content['image_alt'] ?? null,
                $fallbackImages['own'] ?? null,
                'Ilustrasi serah terima kunci kendaraan sebagai simbol kepemilikan aset',
            ),
            'key_points' => $this->filterItems($content['key_points'] ?? [], 'text', 4),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentBusinessOperate(array $section): array
    {
        $content = $section['content'];
        $panel = $content['monitoring_panel'] ?? [];

        $blocks = [];

        foreach (['unit_status', 'driver_profile', 'vehicle_activity', 'maintenance_schedule', 'operational_report'] as $blockKey) {
            $block = $panel[$blockKey] ?? [];

            if (($block['is_active'] ?? true) === false || ($block['label'] ?? '') === '') {
                continue;
            }

            $blocks[$blockKey] = [
                'label' => $block['label'] ?? null,
                'value' => $block['value'] ?? null,
                'helper' => $block['helper'] ?? null,
            ];
        }

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'key_points' => $this->filterItems($content['key_points'] ?? [], 'text', 4),
            'monitoring_panel' => [
                'illustration_label' => $panel['illustration_label'] ?? null,
                'panel_title' => $panel['panel_title'] ?? null,
                'blocks' => $blocks,
            ],
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentBusinessGrow(array $section, CmsLinkService $linkService): array
    {
        $content = $section['content'];

        $stages = array_filter($content['stages'] ?? [], function ($stage) {
            return ($stage['is_active'] ?? true) !== false && (($stage['title'] ?? '') !== '');
        });

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'stages' => array_slice($stages, 0, 4, true),
            'cta' => $linkService->resolve($content['cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentBusinessFlow(array $section, CmsLinkService $linkService): array
    {
        $content = $section['content'];

        $stages = array_filter($content['stages'] ?? [], function ($stage) {
            return ($stage['is_active'] ?? true) !== false && (($stage['title'] ?? '') !== '');
        });

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'stages' => array_slice($stages, 0, 5, true),
            'closing_statement' => $content['closing_statement'] ?? null,
            'primary_cta' => $linkService->resolve($content['primary_cta'] ?? null),
            'secondary_cta' => $linkService->resolve($content['secondary_cta'] ?? null),
        ];
    }

    /**
     * @return array{url: ?string, alt: string}
     */
    private function resolveImage(?int $mediaId, ?string $overrideAlt, ?string $fallbackPath, string $fallbackAlt): array
    {
        if ($mediaId) {
            $media = Media::find($mediaId);
            $url = $media?->url();

            if ($url) {
                return [
                    'url' => $url,
                    'alt' => $overrideAlt ?: ($media->alt_text ?: $fallbackAlt),
                ];
            }
        }

        return [
            'url' => $fallbackPath ? asset($fallbackPath) : null,
            'alt' => $overrideAlt ?: $fallbackAlt,
        ];
    }
}
