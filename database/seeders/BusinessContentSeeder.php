<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class BusinessContentSeeder extends Seeder
{
    /**
     * Fill the 5 Business sections' content from config/business-content.php
     * — ONLY for sections whose content is still empty. Never overwrites a
     * section an admin has already edited, never touches is_active,
     * updated_by, section_name, or sort_order, and never creates/deletes
     * pages or sections (those are CmsStructureSeeder's job — PROMPT 15).
     *
     * Safe to run repeatedly.
     */
    public function run(): void
    {
        $page = Page::where('slug', 'business')->first();

        if (! $page) {
            $this->command?->error('BusinessContentSeeder dibatalkan: page dengan slug "business" tidak ditemukan. Jalankan CmsStructureSeeder terlebih dahulu.');

            return;
        }

        $sectionsContent = config('business-content.sections', []);
        $sections = $page->sections()->get()->keyBy('section_key');

        foreach ($sectionsContent as $sectionKey => $content) {
            $section = $sections->get($sectionKey);

            if (! $section) {
                continue;
            }

            $isEmpty = $section->content === null || $section->content === [];

            if (! $isEmpty) {
                continue;
            }

            $section->content = $content;
            $section->save();
        }
    }
}
