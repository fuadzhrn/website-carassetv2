<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(): View
    {
        return view('admin.dashboard.index', [
            'quickAccessPages' => [
                ['route' => 'admin.pages.home', 'title' => 'Home', 'description' => 'Hero, penawaran, dan CTA utama halaman depan.'],
                ['route' => 'admin.pages.product-byd-atto-1', 'title' => 'Produk BYD ATTO 1', 'description' => 'Warna, varian, spesifikasi, fitur, dan keterkaitan dengan CarAsset.'],
                ['route' => 'admin.pages.business', 'title' => 'Bisnis CarAsset', 'description' => 'Model bisnis, OWN, OPERATE, GROW, dan alur bisnis.'],
                ['route' => 'admin.pages.partnership', 'title' => 'Program Kemitraan', 'description' => 'Mitra Owner, Mitra Driver, paket, dan persyaratan.'],
                ['route' => 'admin.pages.simulation', 'title' => 'Simulasi & Perlindungan', 'description' => 'Dasar perhitungan, simulasi unit, dan perlindungan.'],
                ['route' => 'admin.pages.about-contact', 'title' => 'Tentang & Kontak', 'description' => 'Profil perusahaan, legalitas, FAQ, dan kontak.'],
            ],
            'newMessageCount' => ContactMessage::query()->where('status', ContactMessage::STATUS_NEW)->count(),
            'draftSectionCount' => PageSection::query()->where('workflow_status', PageSection::WORKFLOW_DRAFT)->count(),
            'draftSeoCount' => Page::query()->where('seo_workflow_status', Page::SEO_WORKFLOW_DRAFT)->count(),
        ]);
    }
}
