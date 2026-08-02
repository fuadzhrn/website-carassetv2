<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\Admin\Pages\AboutContact\UpdateAboutContactSectionRequest;
use App\Models\Page;
use App\Services\ContentWorkflowService;
use Illuminate\Http\RedirectResponse;

class AboutContactSectionController
{
    public function __construct(private readonly ContentWorkflowService $workflowService)
    {
    }

    /**
     * Save one Tentang & Kontak section's content + active status AS A
     * DRAFT — this never touches the Published content/is_active the
     * public site reads. section_name, sort_order, and page_id are never
     * touched either. $sectionKey is already constrained to the 5 known
     * keys at the route level. Repeater item_key/sort_order are already
     * normalized server-side inside
     * UpdateAboutContactSectionRequest::prepareForValidation() before
     * this method ever runs.
     */
    public function update(UpdateAboutContactSectionRequest $request, string $sectionKey): RedirectResponse
    {
        $page = Page::where('slug', 'about-contact')->firstOrFail();
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        $this->workflowService->saveDraft(
            $section,
            $request->validated('content', []),
            $request->boolean('is_active'),
            $request->user(),
        );

        return redirect(route('admin.pages.about-contact').'#section-'.$sectionKey)
            ->with('success', 'Draft section berhasil disimpan.');
    }
}
