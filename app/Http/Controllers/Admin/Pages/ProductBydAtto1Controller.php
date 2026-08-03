<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Page;
use App\Services\ContentService;
use Illuminate\View\View;

class ProductBydAtto1Controller extends Controller
{
    public function __construct(private readonly ContentService $contentService)
    {
    }

    /**
     * Show the Produk BYD ATTO 1 section editor. Read-only — no
     * validation, no writes, no computation of any kind.
     */
    public function index(): View
    {
        $fallbacks = config('product-byd-atto-1-content.sections', []);
        $sections = $this->contentService->getPageSectionsContent('product-byd-atto-1', $fallbacks, 'preview');

        $mediaIds = $this->collectMediaIds($sections);
        $mediaById = $mediaIds === []
            ? collect()
            : Media::whereIn('id', $mediaIds)->get()->keyBy('id');

        $sectionModels = $this->contentService->getSections('product-byd-atto-1', false)->keyBy('section_key');

        return view('admin.pages.product-byd-atto-1.index', [
            'page' => Page::where('slug', 'product-byd-atto-1')->firstOrFail(),
            'sections' => $sections,
            'sectionModels' => $sectionModels,
            'mediaById' => $mediaById,
            'recentMedia' => Media::latest()->limit(24)->get(),
            'allowedRoutes' => config('cms-links.routes', []),
            'allowedAnchors' => config('cms-links.anchors', []),
            'limits' => config('product-byd-atto-1-content.limits', []),
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

                $isMediaKey = $key === 'media_id' || str_ends_with((string) $key, '_media_id');

                if ($isMediaKey && $value !== null) {
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
