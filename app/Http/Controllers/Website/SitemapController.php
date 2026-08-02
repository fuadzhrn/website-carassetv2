<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\PageSeoService;
use Illuminate\Http\Response;

/**
 * Generates sitemap.xml from the 5 locked pages in config('cms.pages') —
 * never from an open-ended database query, never a per-admin-editable
 * list. A page is only left out when its Published robots setting is
 * explicitly "noindex,nofollow" (see PageSeoService); nothing else about
 * a page (draft content, section visibility) changes what appears here.
 */
class SitemapController extends Controller
{
    public function index(PageSeoService $seoService): Response
    {
        $pages = Page::whereIn('slug', array_keys(config('cms.pages')))->get()->keyBy('slug');

        $urls = [];

        foreach (config('cms.pages') as $slug => $pageData) {
            $page = $pages->get($slug);
            $robots = $page ? $seoService->resolveRobots($page->meta_robots) : 'index,follow';

            if ($robots === 'noindex,nofollow') {
                continue;
            }

            $urls[] = [
                'loc' => route($pageData['route_name']),
                'lastmod' => ($page?->updated_at ?? now())->toAtomString(),
                'changefreq' => $slug === 'home' ? 'daily' : 'weekly',
                'priority' => $slug === 'home' ? '1.0' : '0.8',
            ];
        }

        $xml = view('sitemap.index', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
