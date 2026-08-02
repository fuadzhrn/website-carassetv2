<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\Admin\Pages\Partnership\UpdatePartnershipSectionRequest;
use App\Models\Page;
use App\Services\ContentWorkflowService;
use Illuminate\Http\RedirectResponse;

class PartnershipSectionController
{
    public function __construct(private readonly ContentWorkflowService $workflowService)
    {
    }

    /**
     * Save one Program Kemitraan section's content + active status AS A
     * DRAFT — this never touches the Published content/is_active the
     * public site reads. section_name, sort_order, and page_id are never
     * touched either. $sectionKey is already constrained to the 5 known
     * keys at the route level.
     */
    public function update(UpdatePartnershipSectionRequest $request, string $sectionKey): RedirectResponse
    {
        $page = Page::where('slug', 'partnership')->firstOrFail();
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        $this->workflowService->saveDraft(
            $section,
            $request->validated('content', []),
            $request->boolean('is_active'),
            $request->user(),
        );

        return redirect(route('admin.pages.partnership').'#section-'.$sectionKey)
            ->with('success', 'Draft section berhasil disimpan.');
    }
}
