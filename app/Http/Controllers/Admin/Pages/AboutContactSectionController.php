<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Requests\Admin\Pages\AboutContact\UpdateAboutContactSectionRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AboutContactSectionController
{
    /**
     * Save one Tentang & Kontak section's content + active status.
     *
     * section_name, sort_order, and page_id are never touched here — only
     * content, is_active, and updated_by. $sectionKey is already
     * constrained to the 5 known keys at the route level. Repeater
     * item_key/sort_order are already normalized server-side inside
     * UpdateAboutContactSectionRequest::prepareForValidation() before this
     * method ever runs.
     *
     * No cache to clear: ContentService reads page_sections directly on
     * every request (unlike SettingsService, it never caches).
     */
    public function update(UpdateAboutContactSectionRequest $request, string $sectionKey): RedirectResponse
    {
        $page = Page::where('slug', 'about-contact')->firstOrFail();
        $section = $page->sections()->where('section_key', $sectionKey)->firstOrFail();

        DB::transaction(function () use ($request, $section) {
            $section->content = $request->validated('content', []);
            $section->is_active = $request->boolean('is_active');
            $section->updated_by = $request->user()->id;
            $section->save();
        });

        return redirect(route('admin.pages.about-contact').'#section-'.$sectionKey)
            ->with('success', 'Section Tentang & Kontak berhasil diperbarui.');
    }
}
