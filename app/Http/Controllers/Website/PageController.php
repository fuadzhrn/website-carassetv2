<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\CmsLinkService;
use App\Services\ConsultationFormTokenService;
use App\Services\ContentService;
use App\Services\SettingsService;
use App\Services\SimulationFormatterService;
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

    public function partnership(ContentService $contentService, CmsLinkService $linkService): View
    {
        $fallbacks = config('partnership-content.sections', []);
        $sections = $contentService->getPageSectionsContent('partnership', $fallbacks);
        $fallbackImages = config('partnership-content.fallback_images', []);

        $partnership = [
            'program-selector' => $this->presentProgramSelector($sections['program-selector']),
            'owner-program' => $this->presentOwnerProgram($sections['owner-program'], $linkService, $fallbackImages),
            'driver-program' => $this->presentDriverProgram($sections['driver-program'], $linkService, $fallbackImages),
            'packages-benefits' => $this->presentPackagesBenefits($sections['packages-benefits'], $linkService),
            'terms' => $this->presentTerms($sections['terms'], $linkService),
        ];

        return view('pages.partnership.index', ['partnership' => $partnership]);
    }

    public function simulation(ContentService $contentService, CmsLinkService $linkService, SimulationFormatterService $formatter): View
    {
        $fallbacks = config('simulation-content.sections', []);
        $sections = $contentService->getPageSectionsContent('simulation', $fallbacks);
        $fallbackImages = config('simulation-content.fallback_images', []);
        $fieldFormats = config('simulation-content.field_formats', []);

        $simulation = [
            'assumptions' => $this->presentAssumptions($sections['assumptions'], $formatter, $fieldFormats['assumptions'] ?? []),
            'one-unit' => $this->presentOneUnit($sections['one-unit'], $linkService, $formatter, $fieldFormats['one-unit'] ?? []),
            'multiple-units' => $this->presentMultipleUnits($sections['multiple-units'], $linkService, $formatter, $fieldFormats['multiple-units'] ?? []),
            'protection-monitoring' => $this->presentProtectionMonitoring($sections['protection-monitoring'], $linkService, $fallbackImages),
            'disclaimer' => $this->presentSimulationDisclaimer($sections['disclaimer'], $linkService),
        ];

        return view('pages.simulation.index', ['simulation' => $simulation]);
    }

    public function aboutContact(ContentService $contentService, CmsLinkService $linkService, SettingsService $settingsService, ConsultationFormTokenService $formTokenService): View
    {
        $fallbacks = config('about-contact-content.sections', []);
        $sections = $contentService->getPageSectionsContent('about-contact', $fallbacks);
        $fallbackImages = config('about-contact-content.fallback_images', []);

        $aboutContact = [
            'about' => $this->presentAbout($sections['about'], $linkService, $settingsService, $fallbackImages),
            'vision-mission-values' => $this->presentVisionMissionValues($sections['vision-mission-values']),
            'legal-partners' => $this->presentLegalPartners($sections['legal-partners']),
            'faq' => $this->presentFaq($sections['faq']),
            'contact-form' => $this->presentContactForm($sections['contact-form'], $settingsService, $formTokenService),
        ];

        return view('pages.about-contact.index', ['aboutContact' => $aboutContact]);
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
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentProgramSelector(array $section): array
    {
        $content = $section['content'];

        $paths = [];

        foreach (['owner', 'driver'] as $pathKey) {
            $path = $content[$pathKey] ?? [];

            $paths[$pathKey] = [
                'label' => $path['label'] ?? null,
                'title' => $path['title'] ?? null,
                'description' => $path['description'] ?? null,
                'cta_label' => $path['cta_label'] ?? null,
                'is_active' => ($path['is_active'] ?? true) !== false,
            ];
        }

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'owner' => $paths['owner'],
            'driver' => $paths['driver'],
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fallbackImages
     * @return array<string, mixed>
     */
    private function presentOwnerProgram(array $section, CmsLinkService $linkService, array $fallbackImages): array
    {
        $content = $section['content'];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'narrative' => $content['narrative'] ?? null,
            'image' => $this->resolveImage(
                $content['image_media_id'] ?? null,
                $content['image_alt'] ?? null,
                $fallbackImages['owner-program'] ?? null,
                'Calon mitra owner dengan kendaraan listrik yang akan dikelola sebagai aset produktif',
            ),
            'callouts' => $this->filterItems($content['callouts'] ?? [], 'label', 4),
            'partner_roles' => $this->filterItems($content['partner_roles'] ?? [], 'text', 4),
            'carasset_roles' => $this->filterItems($content['carasset_roles'] ?? [], 'text', 4),
            'benefits' => $this->filterItems($content['benefits'] ?? [], 'text', 3),
            'cta' => $linkService->resolve($content['cta'] ?? null),
            'microcopy' => $content['microcopy'] ?? null,
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fallbackImages
     * @return array<string, mixed>
     */
    private function presentDriverProgram(array $section, CmsLinkService $linkService, array $fallbackImages): array
    {
        $content = $section['content'];
        $panel = $content['after_unit_panel'] ?? [];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'narrative' => $content['narrative'] ?? null,
            'image' => $this->resolveImage(
                $content['image_media_id'] ?? null,
                $content['image_alt'] ?? null,
                $fallbackImages['driver-program'] ?? null,
                'Driver profesional yang menjalankan kendaraan dalam program Mitra Driver CarAsset',
            ),
            'timeline' => $this->filterItems($content['timeline'] ?? [], 'title', 5),
            'after_unit_panel' => [
                'is_active' => ($panel['is_active'] ?? true) !== false,
                'title' => $panel['title'] ?? null,
                'description' => $panel['description'] ?? null,
                'items' => $this->filterItems($panel['items'] ?? [], 'text', 3),
            ],
            'cta' => $linkService->resolve($content['cta'] ?? null),
            'note' => $content['note'] ?? null,
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentPackagesBenefits(array $section, CmsLinkService $linkService): array
    {
        $content = $section['content'];
        $featuredPackage = $content['featured_package'] ?? null;

        $packages = [];

        foreach (['one_unit', 'five_units', 'ten_units'] as $packageKey) {
            $package = $content['packages'][$packageKey] ?? [];

            if (($package['is_active'] ?? true) === false) {
                continue;
            }

            $packages[$packageKey] = [
                'unit_count' => (int) ($package['unit_count'] ?? 0),
                'label' => $package['label'] ?? null,
                'title' => $package['title'] ?? null,
                'description' => $package['description'] ?? null,
                'benefits' => $this->filterItems($package['benefits'] ?? [], 'text', 3),
                'is_featured' => $featuredPackage === $packageKey,
                'cta' => $linkService->resolve($package['cta'] ?? null),
            ];
        }

        return [
            'is_active' => $section['is_active'],
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'packages' => $packages,
            'disclaimer' => $content['disclaimer'] ?? null,
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentTerms(array $section, CmsLinkService $linkService): array
    {
        $content = $section['content'];

        $group = function (string $key, int $max, string $itemTextField = 'text') use ($content) {
            $data = $content[$key] ?? [];

            return [
                'is_active' => ($data['is_active'] ?? true) !== false,
                'title' => $data['title'] ?? null,
                'items' => $this->filterItems($data['items'] ?? [], $itemTextField, $max),
            ];
        };

        $cancellation = $content['cancellation'] ?? [];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'checkpoints' => $this->filterItems($content['checkpoints'] ?? [], 'title', 4),
            'verification' => $group('verification', 4),
            'payment' => $group('payment', 3),
            'cancellation' => [
                'is_active' => ($cancellation['is_active'] ?? true) !== false,
                'title' => $cancellation['title'] ?? null,
                'description' => $cancellation['description'] ?? null,
            ],
            'rights_obligations' => $group('rights_obligations', 4, 'label'),
            'operational_terms' => $group('operational_terms', 5),
            'legal_note' => $content['legal_note'] ?? null,
            'cta_title' => $content['cta_title'] ?? null,
            'cta_description' => $content['cta_description'] ?? null,
            'primary_cta' => $linkService->resolve($content['primary_cta'] ?? null),
            'secondary_cta' => $linkService->resolve($content['secondary_cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fieldFormats dot-key ("operational_days.value") => format
     * @return array<string, mixed>
     */
    private function presentAssumptions(array $section, SimulationFormatterService $formatter, array $fieldFormats): array
    {
        $content = $section['content'];
        $dataStatus = $content['data_status'] ?? 'draft';

        $numericFields = ['operational_days', 'daily_result', 'operating_cost', 'vehicle_installment', 'management_component'];
        $result = [];

        foreach ($numericFields as $field) {
            $format = $fieldFormats["{$field}.value"] ?? null;
            $result[$field] = [
                'label' => $content[$field]['label'] ?? null,
                'helper' => $content[$field]['helper'] ?? null,
                'amount' => $this->simulationAmount($content[$field]['value'] ?? null, $format, $dataStatus, $formatter),
            ];
        }

        // Jenis nilai (persen/rupiah) belum ditentukan audit — tidak pernah
        // dianggap tersedia terlepas dari data_status.
        $result['revenue_share'] = [
            'label' => $content['revenue_share']['label'] ?? null,
            'helper' => $content['revenue_share']['helper'] ?? null,
            'amount' => ['raw_value' => null, 'formatted_value' => null, 'is_available' => false],
        ];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'data_status' => $dataStatus,
            'fields' => $result,
            'callout' => [
                'is_active' => ($content['callout']['is_active'] ?? true) !== false,
                'title' => $content['callout']['title'] ?? null,
                'description' => $content['callout']['description'] ?? null,
            ],
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fieldFormats
     * @return array<string, mixed>
     */
    private function presentOneUnit(array $section, CmsLinkService $linkService, SimulationFormatterService $formatter, array $fieldFormats): array
    {
        $content = $section['content'];
        $dataStatus = $content['data_status'] ?? 'draft';

        $numericFields = ['gross_operational_result', 'operating_cost', 'vehicle_obligation', 'management_component', 'projected_partner_result'];
        $result = [];

        foreach ($numericFields as $field) {
            $format = $fieldFormats["{$field}.value"] ?? 'rupiah';
            $result[$field] = [
                'label' => $content[$field]['label'] ?? null,
                'helper' => $content[$field]['helper'] ?? null,
                'amount' => $this->simulationAmount($content[$field]['value'] ?? null, $format, $dataStatus, $formatter),
            ];
        }

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'data_status' => $dataStatus,
            'fields' => $result,
            'summary_note' => $content['summary_note'] ?? null,
            'cta' => $linkService->resolve($content['cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fieldFormats
     * @return array<string, mixed>
     */
    private function presentMultipleUnits(array $section, CmsLinkService $linkService, SimulationFormatterService $formatter, array $fieldFormats): array
    {
        $content = $section['content'];
        $dataStatus = $content['data_status'] ?? 'draft';
        $metrics = ['gross_operational_result', 'operating_cost', 'vehicle_obligation', 'management_component', 'projected_partner_result'];

        $units = [];

        foreach (['one_unit', 'five_units', 'ten_units'] as $unitKey) {
            $unit = $content['units'][$unitKey] ?? [];

            if (($unit['is_active'] ?? true) === false) {
                continue;
            }

            $fields = [];

            foreach ($metrics as $metric) {
                $format = $fieldFormats[$metric] ?? 'rupiah';
                $fields[$metric] = $this->simulationAmount($unit[$metric] ?? null, $format, $dataStatus, $formatter);
            }

            $units[$unitKey] = [
                'unit_count' => (int) ($unit['unit_count'] ?? 0),
                'label' => $unit['label'] ?? null,
                'description' => $unit['description'] ?? null,
                'fields' => $fields,
                'note' => $unit['note'] ?? null,
            ];
        }

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'data_status' => $dataStatus,
            'units' => $units,
            'comparison_note' => $content['comparison_note'] ?? null,
            'cta' => $linkService->resolve($content['cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fallbackImages
     * @return array<string, mixed>
     */
    private function presentProtectionMonitoring(array $section, CmsLinkService $linkService, array $fallbackImages): array
    {
        $content = $section['content'];
        $features = [];

        foreach (['insurance', 'warranty', 'gps', 'monitoring', 'maintenance', 'reporting'] as $featureKey) {
            $feature = $content['features'][$featureKey] ?? [];

            if (($feature['is_active'] ?? true) === false || ($feature['title'] ?? '') === '') {
                continue;
            }

            $features[$featureKey] = [
                'title' => $feature['title'] ?? null,
                'description' => $feature['description'] ?? null,
            ];
        }

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'image' => $this->resolveImage(
                $content['image_media_id'] ?? null,
                $content['image_alt'] ?? null,
                $fallbackImages['protection-monitoring'] ?? null,
                '',
            ),
            'features' => $features,
            'callout' => [
                'is_active' => ($content['callout']['is_active'] ?? false) !== false && ($content['callout']['description'] ?? '') !== '',
                'title' => $content['callout']['title'] ?? null,
                'description' => $content['callout']['description'] ?? null,
            ],
            'cta' => $linkService->resolve($content['cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentSimulationDisclaimer(array $section, CmsLinkService $linkService): array
    {
        $content = $section['content'];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description_paragraphs' => $this->splitLines($content['description'] ?? null, "\n\n"),
            'points' => $this->filterItems($content['points'] ?? [], 'text', 6),
            'cta_title' => $content['cta_title'] ?? null,
            'cta_description' => $content['cta_description'] ?? null,
            'primary_cta' => $linkService->resolve($content['primary_cta'] ?? null),
            'secondary_cta' => $linkService->resolve($content['secondary_cta'] ?? null),
            'microcopy' => $content['microcopy'] ?? null,
        ];
    }

    /**
     * Decide whether a simulation number may be shown as official data.
     * draft (or any non-"confirmed" status) never surfaces the number,
     * regardless of whether a value happens to be present — the whole
     * point of the draft state is that partially-entered numbers must
     * not leak to the public page. null is never coerced to 0, and 0 is
     * never treated as "empty".
     *
     * @return array{raw_value: int|float|null, formatted_value: ?string, is_available: bool}
     */
    private function simulationAmount(int|float|null $value, ?string $format, string $dataStatus, SimulationFormatterService $formatter): array
    {
        $isAvailable = $dataStatus === 'confirmed' && $value !== null;

        return [
            'raw_value' => $value,
            'formatted_value' => $isAvailable ? $formatter->displayValue($value, $format) : null,
            'is_available' => $isAvailable,
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @param array<string, string> $fallbackImages
     * @return array<string, mixed>
     */
    private function presentAbout(array $section, CmsLinkService $linkService, SettingsService $settingsService, array $fallbackImages): array
    {
        $content = $section['content'];

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            // about.tagline hanya override — jatuh ke tagline brand global
            // (satu sumber yang sama dipakai footer) bila kosong.
            'tagline' => $content['tagline'] ?: $settingsService->get('brand.tagline', 'Mobil Bekerja. Aset Bertumbuh.'),
            'narrative_paragraphs' => $this->splitLines($content['narrative'] ?? null, "\n\n"),
            'positioning_lines' => $this->splitLines($content['positioning_statement'] ?? null, "\n"),
            'image' => $this->resolveImage(
                $content['image_media_id'] ?? null,
                $content['image_alt'] ?? null,
                $fallbackImages['about'] ?? null,
                '',
            ),
            'primary_cta' => $linkService->resolve($content['primary_cta'] ?? null),
            'secondary_cta' => $linkService->resolve($content['secondary_cta'] ?? null),
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentVisionMissionValues(array $section): array
    {
        $content = $section['content'];
        $vision = $content['vision'] ?? [];
        $mission = $content['mission'] ?? [];

        $missionItems = ($mission['editorial_status'] ?? 'draft') === 'confirmed'
            ? $this->filterItems($mission['items'] ?? [], 'text', 8)
            : [];

        $values = [];

        foreach (['trust', 'growth', 'productive', 'partnership'] as $valueKey) {
            $value = $content['values'][$valueKey] ?? [];

            if (($value['is_active'] ?? true) === false) {
                continue;
            }

            $values[$valueKey] = [
                'title' => $value['title'] ?? ucfirst($valueKey),
                'description' => $value['description'] ?? null,
            ];
        }

        return [
            'is_active' => $section['is_active'],
            'vision' => [
                'label' => $vision['label'] ?? null,
                'is_confirmed' => ($vision['editorial_status'] ?? 'draft') === 'confirmed',
                'statement' => ($vision['editorial_status'] ?? 'draft') === 'confirmed' ? ($vision['statement'] ?? null) : null,
            ],
            'mission' => [
                'label' => $mission['label'] ?? null,
                'is_confirmed' => ($mission['editorial_status'] ?? 'draft') === 'confirmed',
                'items' => $missionItems,
            ],
            'values' => $values,
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentLegalPartners(array $section): array
    {
        $content = $section['content'];
        $legal = $content['legal'] ?? [];
        $isLegalConfirmed = ($legal['data_status'] ?? 'draft') === 'confirmed';

        $documents = $isLegalConfirmed
            ? $this->filterItems($legal['documents'] ?? [], 'title', 10)
            : [];

        $partners = array_map(function ($partner) {
            $logoMediaId = $partner['logo_media_id'] ?? null;
            $media = $logoMediaId ? Media::find($logoMediaId) : null;

            $partner['logo_url'] = $media?->url();
            $partner['logo_alt'] = $partner['logo_alt'] ?: ($media?->alt_text ?: ($partner['name'] ? 'Logo '.$partner['name'] : ''));

            return $partner;
        }, $this->filterItems($content['partners'] ?? [], 'name', 12));

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'legal' => [
                'entity_name' => $isLegalConfirmed ? ($legal['entity_name'] ?? null) : null,
                'registration_number' => $isLegalConfirmed ? ($legal['registration_number'] ?? null) : null,
                // registered_address ditampilkan independen dari
                // legal.data_status — lihat catatan #3 di
                // config/about-contact-content.php: nilai ini nyata
                // (ditandai --filled di desain lama), bukan placeholder
                // yang dipersengketakan seperti entity_name/registration_number.
                'registered_address' => $legal['registered_address'] ?? null,
                'documents' => $documents,
            ],
            'partners' => $partners,
            'partner_note' => $content['partner_note'] ?? null,
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentFaq(array $section): array
    {
        $content = $section['content'];

        $items = array_filter($content['items'] ?? [], function ($item) {
            return ($item['is_active'] ?? true) !== false
                && ($item['question'] ?? '') !== ''
                && ($item['answer'] ?? '') !== '';
        });

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'items' => array_slice($items, 0, 20, true),
            'closing_note' => $content['closing_note'] ?? null,
        ];
    }

    /**
     * @param array{content: array<string, mixed>, is_active: bool} $section
     * @return array<string, mixed>
     */
    private function presentContactForm(array $section, SettingsService $settingsService, ConsultationFormTokenService $formTokenService): array
    {
        $content = $section['content'];
        $form = $content['form'] ?? [];
        $map = $content['map'] ?? [];

        $address = $settingsService->get('contact.address');
        $siteDataStatus = $settingsService->get('site.data_status', 'draft');

        $mapAvailable = ($map['is_active'] ?? false) === true
            && (string) $address !== ''
            && $siteDataStatus === 'confirmed'
            && ($map['embed_url'] ?? '') !== '';

        return [
            'is_active' => $section['is_active'],
            'eyebrow' => $content['eyebrow'] ?? null,
            'title' => $content['title'] ?? null,
            'description' => $content['description'] ?? null,
            'contact_panel' => [
                'title' => $content['contact_panel']['title'] ?? null,
                'description' => $content['contact_panel']['description'] ?? null,
            ],
            'form' => [
                'description' => $form['description'] ?? null,
                'submit_label' => $form['submit_label'] ?? null,
                'microcopy' => $form['microcopy'] ?? null,
                'consent_label' => $form['consent_label'] ?? null,
                'program_options' => array_filter(
                    $this->filterItems($form['program_options'] ?? [], 'label', 6),
                    fn ($option) => ($option['value'] ?? '') !== ''
                ),
                'token' => $formTokenService->generate(),
            ],
            'map' => [
                'is_available' => $mapAvailable,
                'embed_url' => $mapAvailable ? $map['embed_url'] : null,
                'title' => $mapAvailable ? ($map['title'] ?? null) : null,
            ],
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
