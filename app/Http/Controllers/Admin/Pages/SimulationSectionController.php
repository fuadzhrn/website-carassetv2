<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\Admin\Pages\Simulation\UpdateSimulationSectionRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SimulationSectionController
{
    /**
     * Save one Simulasi & Perlindungan section's content + active status.
     *
     * section_name, sort_order, page_id, and unit_count are never touched
     * here — only content, is_active, and updated_by. $sectionKey is
     * already constrained to the 5 known keys at the route level.
     *
     * No cache to clear here: ContentService reads page_sections directly
     * on every request (unlike SettingsService, it never caches), so there
     * is nothing to invalidate after this save.
     */
    public function update(UpdateSimulationSectionRequest $request, string $sectionKey): RedirectResponse
    {
        $page = Page::where('slug', 'simulation')->firstOrFail();
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        DB::transaction(function () use ($request, $section) {
            $section->content = $request->validated('content', []);
            $section->is_active = $request->boolean('is_active');
            $section->updated_by = $request->user()->id;
            $section->save();
        });

        return redirect(route('admin.pages.simulation').'#section-'.$sectionKey)
            ->with('success', 'Section Simulasi & Perlindungan berhasil diperbarui.');
    }
}
