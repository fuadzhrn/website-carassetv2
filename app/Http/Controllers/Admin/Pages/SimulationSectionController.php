<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\Admin\Pages\Simulation\UpdateSimulationSectionRequest;
use App\Models\Page;
use App\Services\ContentWorkflowService;
use Illuminate\Http\RedirectResponse;

class SimulationSectionController
{
    public function __construct(private readonly ContentWorkflowService $workflowService)
    {
    }

    /**
     * Save one Simulasi & Perlindungan section's content + active status
     * AS A DRAFT — this never touches the Published content/is_active
     * the public site reads. section_name, sort_order, page_id, and
     * unit_count are never touched either. $sectionKey is already
     * constrained to the 5 known keys at the route level.
     */
    public function update(UpdateSimulationSectionRequest $request, string $sectionKey): RedirectResponse
    {
        $page = Page::where('slug', 'simulation')->firstOrFail();
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        $this->workflowService->saveDraft(
            $section,
            $request->validated('content', []),
            $request->boolean('is_active'),
            $request->user(),
        );

        return redirect(route('admin.pages.simulation').'#section-'.$sectionKey)
            ->with('success', 'Draft section berhasil disimpan.');
    }
}
