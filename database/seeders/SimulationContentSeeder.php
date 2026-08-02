<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class SimulationContentSeeder extends Seeder
{
    /**
     * Fill the 5 Simulasi & Perlindungan sections' content from
     * config/simulation-content.php — ONLY for sections whose content is
     * still empty. Never overwrites a section an admin has already edited,
     * never touches is_active, updated_by, section_name, or sort_order,
     * never creates/deletes pages or sections, never invents simulation
     * numbers (config values are null wherever the source figures were
     * unconfirmed/conflicting — see config/simulation-content.php's header
     * comment for the audit trail).
     *
     * Safe to run repeatedly.
     */
    public function run(): void
    {
        $page = Page::where('slug', 'simulation')->first();

        if (! $page) {
            $this->command?->error('SimulationContentSeeder dibatalkan: page dengan slug "simulation" tidak ditemukan. Jalankan CmsStructureSeeder terlebih dahulu.');

            return;
        }

        $sectionsContent = config('simulation-content.sections', []);
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
