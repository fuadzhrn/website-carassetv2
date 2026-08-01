<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class CmsStructureSeeder extends Seeder
{
    /**
     * Sync the 5 locked pages and their 25 sections from config/cms.php.
     *
     * Safe to run repeatedly: existing pages/sections are left completely
     * untouched (no content, status, or metadata is overwritten) — only
     * missing pages/sections are created.
     */
    public function run(): void
    {
        foreach (config('cms.pages') as $slug => $pageData) {
            $page = Page::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $pageData['name'],
                    'route_name' => $pageData['route_name'],
                    'status' => $pageData['status'] ?? Page::STATUS_ACTIVE,
                ]
            );

            foreach ($pageData['sections'] as $sectionKey => $sectionData) {
                $exists = PageSection::where('page_id', $page->id)
                    ->where('section_key', $sectionKey)
                    ->exists();

                if ($exists) {
                    continue;
                }

                // Guarded fields (page_id, section_key) diisi lewat properti
                // langsung, bukan mass assignment — keduanya sengaja tidak
                // fillable karena struktur section tidak boleh diubah admin.
                $section = new PageSection();
                $section->page_id = $page->id;
                $section->section_key = $sectionKey;
                $section->section_name = $sectionData['name'];
                $section->content = [];
                $section->is_active = true;
                $section->sort_order = $sectionData['sort_order'];
                $section->save();
            }
        }
    }
}
