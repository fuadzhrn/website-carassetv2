<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    /**
     * Fill the 5 Home sections' content from config/home-content.php —
     * ONLY for sections whose content is still empty. Never overwrites a
     * section an admin has already edited, never touches is_active,
     * updated_by, section_name, or sort_order, and never creates/deletes
     * pages or sections (those are CmsStructureSeeder's job — see
     * PROMPT 15).
     *
     * Safe to run repeatedly.
     */
    public function run(): void
    {
        $page = Page::where('slug', 'home')->first();

        if (! $page) {
            $this->command?->error('HomeContentSeeder dibatalkan: page dengan slug "home" tidak ditemukan. Jalankan CmsStructureSeeder terlebih dahulu.');

            return;
        }

        $sectionsContent = config('home-content.sections', []);
        $sections = $page->sections()->get()->keyBy('section_key');

        foreach ($sectionsContent as $sectionKey => $content) {
            $section = $sections->get($sectionKey);

            if (! $section) {
                // Section belum ada (struktur PROMPT 15 belum lengkap) —
                // tidak membuat section baru di sini.
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
