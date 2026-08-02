<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentRevision;
use App\Models\Page;
use App\Services\ContentWorkflowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentRevisionController extends Controller
{
    public function __construct(private readonly ContentWorkflowService $workflowService)
    {
    }

    /**
     * List a section's revision history, newest first, paginated. Read-only
     * — never mutates workflow state.
     */
    public function index(Page $page, string $sectionKey): View
    {
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        $revisions = $section->revisions()
            ->with('createdBy')
            ->orderByDesc('revision_number')
            ->paginate(config('content-workflow.revision_pagination', 20));

        return view('admin.content-revisions.index', [
            'page' => $page,
            'section' => $section->load('updatedBy', 'publishedBy'),
            'sectionKey' => $sectionKey,
            'revisions' => $revisions,
        ]);
    }

    /**
     * Copy one revision's snapshot into the Draft — never touches
     * Published content/is_active directly. $contentRevision must belong
     * to $section; otherwise this 404s rather than silently redirecting,
     * since a mismatch here would only ever be a forged/stale URL.
     */
    public function restore(Request $request, Page $page, string $sectionKey, ContentRevision $contentRevision): RedirectResponse
    {
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        if ($contentRevision->page_section_id !== $section->id) {
            throw new NotFoundHttpException();
        }

        $this->workflowService->restoreRevisionToDraft($section, $contentRevision, $request->user());

        return redirect(route('admin.pages.'.$page->slug).'#section-'.$sectionKey)
            ->with('success', 'Versi revisi berhasil dipulihkan sebagai Draft. Tinjau melalui Preview sebelum dipublikasikan.');
    }
}
