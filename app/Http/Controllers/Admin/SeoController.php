<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\PageImageSeoService;
use App\Services\PageSeoService;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class SeoController extends Controller
{
    /**
     * List the 5 locked CMS pages with their SEO workflow status, Published
     * robots/canonical, and last-publish metadata. Read-only — never
     * updates anything.
     */
    public function index(PageSeoService $seoService): View
    {
        $pages = Page::whereIn('slug', array_keys(config('cms.pages')))
            ->get()
            ->keyBy('slug');

        $rows = [];

        foreach (config('cms.pages') as $slug => $pageData) {
            $page = $pages->get($slug);

            if (! $page) {
                continue;
            }

            $published = $seoService->getPublished($page, $seoService->staticFallback($slug));

            $rows[] = [
                'page' => $page,
                'name' => $pageData['name'],
                'route_name' => $pageData['route_name'],
                'public_url' => route($pageData['route_name']),
                'has_draft' => $page->hasSeoDraft(),
                'robots' => $published['robots'],
                'canonical' => $published['canonical'],
                'canonical_source' => $published['source']['canonical'],
                'published_at' => $page->seo_published_at,
                'published_by' => $page->seoPublishedBy,
            ];
        }

        return view('admin.seo.index', ['rows' => $rows]);
    }

    /**
     * Edit-SEO workspace for one of the 5 locked pages: Draft SEO form,
     * search-result preview data, and the alt-text audit panel.
     */
    public function edit(Page $page, PageSeoService $seoService, PageImageSeoService $imageSeoService): View
    {
        $fallback = $seoService->staticFallback($page->slug);

        $previewUrl = URL::temporarySignedRoute(
            'admin.preview.page',
            now()->addMinutes((int) config('content-workflow.preview_expiration_minutes', 30)),
            ['page' => $page->slug],
        );

        return view('admin.seo.edit', [
            'page' => $page,
            'pageMeta' => config("cms.pages.{$page->slug}"),
            'editorSeo' => $page->editorSeoData(),
            'publishedSeo' => $seoService->getPublished($page, $fallback),
            'previewSeo' => $seoService->getPreview($page, $fallback),
            'automaticCanonical' => route($page->route_name),
            'previewUrl' => $previewUrl,
            'imageAudit' => $imageSeoService->auditForPage($page),
        ]);
    }
}
