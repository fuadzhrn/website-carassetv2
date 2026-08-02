<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageWorkspaceController extends Controller
{
    /**
     * Static metadata for the 5 locked public pages and their sections.
     *
     * This mirrors the sitemap/section structure already built in the
     * public front-end (see PROJECT-AUDIT-BACKEND-CMS-CARASSET.txt) — it is
     * not read from a database because the CMS tables do not exist yet.
     *
     * @return array<string, array{title: string, description: string, route: string, sections: array<int, string>}>
     */
    private function pages(): array
    {
        return [
            'home' => [
                'title' => 'Home',
                'description' => 'Halaman utama — pengenalan konsep Smart Asset Mobility dan pintu masuk ke seluruh program.',
                'route' => 'home',
                'sections' => [
                    'Hero & Value Proposition',
                    'Pentingnya Penghasilan Tambahan',
                    'Cara Singkat CarAsset Bekerja',
                    'Pilihan Program Kemitraan',
                    'CTA Konsultasi',
                ],
            ],
            'business' => [
                'title' => 'Bisnis CarAsset',
                'description' => 'Penjelasan model bisnis CarAsset — dari kepemilikan hingga pengembangan aset.',
                'route' => 'business',
                'sections' => [
                    'Peluang Bisnis Kendaraan Produktif',
                    'OWN',
                    'OPERATE',
                    'GROW',
                    'Alur Bisnis',
                ],
            ],
            'partnership' => [
                'title' => 'Program Kemitraan',
                'description' => 'Detail program Mitra Owner dan Mitra Driver, paket, benefit, serta persyaratan.',
                'route' => 'partnership',
                'sections' => [
                    'Pilih Program Anda',
                    'Mitra Owner',
                    'Mitra Driver',
                    'Paket & Benefit',
                    'Persyaratan & Ketentuan',
                ],
            ],
            'simulation' => [
                'title' => 'Simulasi & Perlindungan',
                'description' => 'Simulasi proyeksi hasil operasional dan gambaran perlindungan aset.',
                'route' => 'simulation',
                'sections' => [
                    'Dasar Perhitungan',
                    'Simulasi 1 Unit',
                    'Simulasi Beberapa Unit',
                    'Perlindungan & Monitoring',
                    'Disclaimer',
                ],
            ],
            'about-contact' => [
                'title' => 'Tentang & Kontak',
                'description' => 'Profil perusahaan, legalitas, FAQ, dan informasi kontak.',
                'route' => 'about-contact',
                'sections' => [
                    'Tentang CarAsset',
                    'Visi, Misi & Nilai',
                    'Legalitas & Partner',
                    'FAQ',
                    'Kontak & Form',
                ],
            ],
        ];
    }

    /**
     * List the 5 managed pages.
     */
    public function index(): View
    {
        return view('admin.pages.index', [
            'pages' => $this->pages(),
        ]);
    }

    public function aboutContact(): View
    {
        return $this->workspace('about-contact');
    }

    /**
     * Render the shared workspace placeholder for a single locked page key.
     */
    private function workspace(string $key): View
    {
        $page = $this->pages()[$key];

        return view('admin.pages.workspace-placeholder', [
            'pageKey' => $key,
            'title' => $page['title'],
            'description' => $page['description'],
            'publicRoute' => $page['route'],
            'sections' => $page['sections'],
        ]);
    }
}
