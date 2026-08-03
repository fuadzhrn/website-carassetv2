<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\Admin\Pages\ProductBydAtto1\UpdateProductBydAtto1SectionRequest;
use App\Models\Page;
use App\Services\ContentWorkflowService;
use Illuminate\Http\RedirectResponse;

class ProductBydAtto1SectionController
{
    public function __construct(private readonly ContentWorkflowService $workflowService)
    {
    }

    /**
     * Save one Produk BYD ATTO 1 section's content + active status AS A
     * DRAFT — this never touches the Published content/is_active the
     * public site reads. section_name, sort_order, page_id are never
     * touched either. $sectionKey is already constrained to the 5 known
     * keys at the route level.
     */
    public function update(UpdateProductBydAtto1SectionRequest $request, string $sectionKey): RedirectResponse
    {
        $page = Page::where('slug', 'product-byd-atto-1')->firstOrFail();
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        $this->workflowService->saveDraft(
            $section,
            $request->validated('content', []),
            $request->boolean('is_active'),
            $request->user(),
        );

        return redirect(route('admin.pages.product-byd-atto-1').'#section-'.$sectionKey)
            ->with('success', 'Draft section Produk berhasil disimpan.');
    }
}
