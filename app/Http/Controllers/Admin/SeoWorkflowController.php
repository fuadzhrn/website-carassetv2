<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Seo\UpdatePageSeoRequest;
use App\Models\Page;
use App\Services\SeoWorkflowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class SeoWorkflowController extends Controller
{
    public function __construct(private readonly SeoWorkflowService $workflowService)
    {
    }

    public function saveDraft(UpdatePageSeoRequest $request, Page $page): RedirectResponse
    {
        $this->workflowService->saveDraft($page, $request->validated(), $request->user());

        return redirect(route('admin.seo.edit', $page->slug))
            ->with('success', 'Draft SEO berhasil disimpan.');
    }

    public function publish(Request $request, Page $page): RedirectResponse
    {
        try {
            $this->workflowService->publish($page, $request->user());
        } catch (RuntimeException $e) {
            if ($e->getMessage() === 'no_seo_draft') {
                return redirect(route('admin.seo.edit', $page->slug))
                    ->with('error', 'Tidak ada Draft SEO yang dapat dipublikasikan.');
            }

            throw $e;
        }

        return redirect(route('admin.seo.edit', $page->slug))
            ->with('success', 'SEO halaman berhasil dipublikasikan.');
    }

    public function discardDraft(Request $request, Page $page): RedirectResponse
    {
        $this->workflowService->discardDraft($page, $request->user());

        return redirect(route('admin.seo.edit', $page->slug))
            ->with('success', 'Perubahan Draft SEO berhasil dibatalkan.');
    }
}
