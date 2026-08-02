<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\Admin\Pages\Business\UpdateBusinessSectionRequest;
use App\Models\Page;
use App\Services\ContentWorkflowService;
use Illuminate\Http\RedirectResponse;

class BusinessSectionController
{
    public function __construct(private readonly ContentWorkflowService $workflowService)
    {
    }

    /**
     * Save one Business section's content + active status AS A DRAFT —
     * this never touches the Published content/is_active the public site
     * reads. section_name, sort_order, and page_id are never touched
     * either. $sectionKey is already constrained to the 5 known keys at
     * the route level.
     */
    public function update(UpdateBusinessSectionRequest $request, string $sectionKey): RedirectResponse
    {
        $page = Page::where('slug', 'business')->firstOrFail();
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        $this->workflowService->saveDraft(
            $section,
            $request->validated('content', []),
            $request->boolean('is_active'),
            $request->user(),
        );

        return redirect(route('admin.pages.business').'#section-'.$sectionKey)
            ->with('success', 'Draft section berhasil disimpan.');
    }
}
