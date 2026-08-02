<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\ContentWorkflowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class ContentWorkflowController extends Controller
{
    public function __construct(private readonly ContentWorkflowService $workflowService)
    {
    }

    /**
     * Publish the Draft currently sitting on one section. section_key is
     * resolved manually against $page->sections() — never trusted as a
     * free-standing lookup — so a section can never be published under
     * the wrong page.
     */
    public function publish(Request $request, Page $page, string $sectionKey): RedirectResponse
    {
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();
        $redirect = redirect(route('admin.pages.'.$page->slug).'#section-'.$sectionKey);

        try {
            $this->workflowService->publish($section, $request->user());
        } catch (RuntimeException $e) {
            if ($e->getMessage() === 'no_draft') {
                return $redirect->with('error', 'Tidak ada Draft yang dapat dipublikasikan.');
            }

            throw $e;
        }

        return $redirect->with('success', 'Section berhasil dipublikasikan.');
    }

    public function discardDraft(Request $request, Page $page, string $sectionKey): RedirectResponse
    {
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        $this->workflowService->discardDraft($section, $request->user());

        return redirect(route('admin.pages.'.$page->slug).'#section-'.$sectionKey)
            ->with('success', 'Perubahan Draft berhasil dibatalkan.');
    }
}
