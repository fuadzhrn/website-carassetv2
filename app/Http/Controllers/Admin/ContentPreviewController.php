<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Public\ProductBydAtto1Controller;
use App\Http\Controllers\Website\PageController;
use App\Models\Page;
use App\Services\CmsLinkService;
use App\Services\ConsultationFormTokenService;
use App\Services\ContentService;
use App\Services\PageSeoService;
use App\Services\SettingsService;
use App\Services\SimulationFormatterService;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentPreviewController extends Controller
{
    /**
     * Whitelist of the only 5 slugs Preview ever renders — never derived
     * from the URL beyond this fixed map, never used to build a Blade
     * path from raw input.
     *
     * @var array<int, string>
     */
    private const ALLOWED_SLUGS = ['home', 'business', 'partnership', 'simulation', 'about-contact', 'product-byd-atto-1'];

    /**
     * Renders one page using Draft-or-Published content (see
     * ContentService's 'preview' mode) behind a temporary signed URL. The
     * `signed` middleware (route definition) + auth/admin/active
     * middleware (route group) both already ran before this method is
     * reached — this method only picks which page to render and forces
     * no-store/noindex on the response.
     */
    public function show(
        Page $page,
        PageController $pageController,
        ProductBydAtto1Controller $productController,
        ContentService $contentService,
        CmsLinkService $linkService,
        SettingsService $settingsService,
        SimulationFormatterService $formatter,
        ConsultationFormTokenService $formTokenService,
        PageSeoService $seoService,
    ): Response {
        if (! in_array($page->slug, self::ALLOWED_SLUGS, true)) {
            throw new NotFoundHttpException();
        }

        $seoSlug = $page->slug;
        $previewData = [
            'previewMode' => true,
            'previewEditorUrl' => route('admin.pages.'.$page->slug),
            'previewPublishedUrl' => route($page->route_name),
            // Shown only in the preview banner (never to public visitors) —
            // what SEO would become Published if the admin hits Publish
            // SEO right now. Null when there is no SEO Draft to show.
            'previewSeoTarget' => $page->hasSeoDraft() ? $page->editorSeoData() : null,
            'seo' => $page->slug === 'product-byd-atto-1'
                ? $productController->seoFor($seoService, 'preview')
                : $pageController->seoFor($seoSlug, $seoService, 'preview'),
        ];

        [$view, $dataKey, $data] = match ($page->slug) {
            'home' => ['pages.home.index', 'home', $pageController->homeData($contentService, $linkService, 'preview')],
            'business' => ['pages.business.index', 'business', $pageController->businessData($contentService, $linkService, 'preview')],
            'partnership' => ['pages.partnership.index', 'partnership', $pageController->partnershipData($contentService, $linkService, 'preview')],
            'simulation' => ['pages.simulation.index', 'simulation', $pageController->simulationData($contentService, $linkService, $formatter, 'preview')],
            'about-contact' => ['pages.about-contact.index', 'aboutContact', $pageController->aboutContactData($contentService, $linkService, $settingsService, $formTokenService, 'preview')],
            'product-byd-atto-1' => ['pages.product-byd-atto-1.index', 'product', $productController->productData($contentService, $linkService, 'preview')],
        };

        return response()
            ->view($view, [$dataKey => $data, ...$previewData])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, private')
            ->header('X-Robots-Tag', 'noindex, nofollow, noarchive');
    }
}
