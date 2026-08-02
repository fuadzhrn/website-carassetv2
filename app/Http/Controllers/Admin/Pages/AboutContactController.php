<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Page;
use App\Services\ContentService;
use App\Services\SettingsService;
use Illuminate\View\View;

class AboutContactController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly SettingsService $settingsService,
    ) {
    }

    /**
     * Show the Tentang & Kontak section editor. Read-only — no validation,
     * no writes.
     */
    public function index(): View
    {
        $fallbacks = config('about-contact-content.sections', []);
        $sections = $this->contentService->getPageSectionsContent('about-contact', $fallbacks, 'preview');

        $mediaIds = $this->collectMediaIds($sections);
        $mediaById = $mediaIds === []
            ? collect()
            : Media::whereIn('id', $mediaIds)->get()->keyBy('id');

        $sectionModels = $this->contentService->getSections('about-contact', false)->keyBy('section_key');

        return view('admin.pages.about-contact.index', [
            'page' => Page::where('slug', 'about-contact')->firstOrFail(),
            'sections' => $sections,
            'sectionModels' => $sectionModels,
            'mediaById' => $mediaById,
            'recentMedia' => Media::latest()->limit(24)->get(),
            'allowedRoutes' => config('cms-links.routes', []),
            'allowedAnchors' => config('cms-links.anchors', []),
            'globalContact' => [
                'whatsapp' => $this->settingsService->get('contact.whatsapp'),
                'email' => $this->settingsService->get('contact.email'),
                'address' => $this->settingsService->get('contact.address'),
                'business_hours' => $this->settingsService->get('contact.business_hours'),
                'site_data_status' => $this->settingsService->get('site.data_status', 'draft'),
            ],
        ]);
    }

    /**
     * @param array<string, array{content: array<string, mixed>}> $sections
     * @return array<int, int>
     */
    private function collectMediaIds(array $sections): array
    {
        $ids = [];

        $scan = function (array $content) use (&$ids, &$scan): void {
            foreach ($content as $key => $value) {
                if (is_array($value)) {
                    $scan($value);

                    continue;
                }

                if (str_ends_with((string) $key, '_media_id') && $value !== null) {
                    $ids[] = (int) $value;
                }
            }
        };

        foreach ($sections as $section) {
            $scan($section['content']);
        }

        return array_values(array_unique($ids));
    }
}
