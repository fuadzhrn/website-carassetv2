<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class AboutContactContentSeeder extends Seeder
{
    /**
     * Fill the 5 Tentang & Kontak sections' content from
     * config/about-contact-content.php — ONLY for sections whose content
     * is still empty. Never overwrites a section an admin has already
     * edited, never touches is_active, updated_by, section_name, or
     * sort_order, never invents legal/partner/FAQ/contact data.
     *
     * Safe to run repeatedly.
     */
    public function run(): void
    {
        $page = Page::where('slug', 'about-contact')->first();

        if (! $page) {
            $this->command?->error('AboutContactContentSeeder dibatalkan: page dengan slug "about-contact" tidak ditemukan. Jalankan CmsStructureSeeder terlebih dahulu.');

            return;
        }

        $sectionsContent = config('about-contact-content.sections', []);
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
