<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\Admin\Pages\Partnership\UpdatePartnershipSectionRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PartnershipSectionController
{
    /**
     * Save one Program Kemitraan section's content + active status.
     *
     * section_name, sort_order, and page_id are never touched here — only
     * content, is_active, and updated_by. $sectionKey is already
     * constrained to the 5 known keys at the route level.
     */
    public function update(UpdatePartnershipSectionRequest $request, string $sectionKey): RedirectResponse
    {
        $page = Page::where('slug', 'partnership')->firstOrFail();
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        DB::transaction(function () use ($request, $section) {
            $section->content = $request->validated('content', []);
            $section->is_active = $request->boolean('is_active');
            $section->updated_by = $request->user()->id;
            $section->save();
        });

        return redirect(route('admin.pages.partnership').'#section-'.$sectionKey)
            ->with('success', 'Section Program Kemitraan berhasil diperbarui.');
    }
}
