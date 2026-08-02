<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\ContentService;
use Illuminate\View\View;

class PartnershipController extends Controller
{
    public function __construct(private readonly ContentService $contentService)
    {
    }

    /**
     * Show the Program Kemitraan section editor. Read-only — no validation, no writes.
     */
    public function index(): View
    {
        $fallbacks = config('partnership-content.sections', []);
        $sections = $this->contentService->getPageSectionsContent('partnership', $fallbacks);

        $mediaIds = $this->collectMediaIds($sections);
        $mediaById = $mediaIds === []
            ? collect()
            : Media::whereIn('id', $mediaIds)->get()->keyBy('id');

        $sectionModels = $this->contentService->getSections('partnership', false)->keyBy('section_key');

        return view('admin.pages.partnership.index', [
            'sections' => $sections,
            'sectionModels' => $sectionModels,
            'mediaById' => $mediaById,
            'recentMedia' => Media::latest()->limit(24)->get(),
            'allowedRoutes' => config('cms-links.routes', []),
            'allowedAnchors' => config('cms-links.anchors', []),
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
