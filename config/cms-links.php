<?php

/*
|--------------------------------------------------------------------------
| CarAsset CMS — CTA Link Whitelist
|--------------------------------------------------------------------------
|
| Whitelist route internal dan anchor yang benar-benar ada pada front-end
| (diaudit langsung dari markup, bukan asumsi). CmsLinkService menolak
| CTA admin yang menunjuk ke route/anchor di luar daftar ini.
|
*/

return [
    'routes' => [
        'home',
        'product.byd-atto-1',
        'business',
        'partnership',
        'simulation',
        'about-contact',
    ],

    'anchors' => [
        'home' => ['peluang-penghasilan', 'cara-kerja', 'konsultasi-home'],
        'product.byd-atto-1' => ['product-hero', 'product-colors', 'product-variants', 'product-specifications'],
        'business' => ['peluang-bisnis', 'own', 'operate', 'grow', 'alur-bisnis'],
        'partnership' => ['pilih-program', 'mitra-owner', 'mitra-driver', 'paket-kemitraan', 'persyaratan'],
        'simulation' => ['dasar-perhitungan', 'simulasi-satu-unit', 'simulasi-beberapa-unit', 'perlindungan-monitoring', 'disclaimer-simulasi'],
        'about-contact' => ['tentang-carasset', 'visi-misi-nilai', 'legalitas-partner', 'faq', 'contact'],
    ],
];
