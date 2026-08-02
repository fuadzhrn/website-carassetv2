<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PartnershipContentSeeder extends Seeder
{
    /**
     * Fill the 5 Partnership sections' content from
     * config/partnership-content.php — ONLY for sections whose content is
     * still empty. Never overwrites a section an admin has already edited,
     * never touches is_active, updated_by, section_name, or sort_order, and
     * never creates/deletes pages or sections (CmsStructureSeeder's job).
     *
     * Safe to run repeatedly.
     */
    public function run(): void
    {
        $page = Page::where('slug', 'partnership')->first();

        if (! $page) {
            $this->command?->error('PartnershipContentSeeder dibatalkan: page dengan slug "partnership" tidak ditemukan. Jalankan CmsStructureSeeder terlebih dahulu.');

            return;
        }

        $sectionsContent = config('partnership-content.sections', []);
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
