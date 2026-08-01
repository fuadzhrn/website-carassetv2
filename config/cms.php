<?php

/*
|--------------------------------------------------------------------------
| CarAsset CMS — Locked Page & Section Structure
|--------------------------------------------------------------------------
|
| Ini adalah SATU-SATUNYA sumber struktur 5 halaman dan 25 section yang
| dikunci untuk Custom Structured CMS CarAsset. CmsStructureSeeder membaca
| array ini untuk membuat/menyinkronkan baris `pages` dan `page_sections`.
|
| File ini BUKAN tempat menyimpan konten (teks/gambar/CTA) — hanya
| identitas struktural (nama, slug, route, urutan section). Konten
| sebenarnya disimpan di kolom `page_sections.content` (JSON) dan diisi
| bertahap mulai PROMPT 17.
|
*/

return [
    'pages' => [
        'home' => [
            'name' => 'Home',
            'slug' => 'home',
            'route_name' => 'home',
            'status' => 'active',
            'sections' => [
                'hero' => [
                    'name' => 'Hero & Value Proposition',
                    'sort_order' => 1,
                ],
                'income-opportunity' => [
                    'name' => 'Pentingnya Penghasilan Tambahan',
                    'sort_order' => 2,
                ],
                'process-summary' => [
                    'name' => 'Cara Singkat CarAsset Bekerja',
                    'sort_order' => 3,
                ],
                'partnership-choice' => [
                    'name' => 'Pilihan Program Kemitraan',
                    'sort_order' => 4,
                ],
                'consultation-cta' => [
                    'name' => 'CTA Konsultasi',
                    'sort_order' => 5,
                ],
            ],
        ],

        'business' => [
            'name' => 'Bisnis CarAsset',
            'slug' => 'business',
            'route_name' => 'business',
            'status' => 'active',
            'sections' => [
                'opportunity' => [
                    'name' => 'Peluang Bisnis Kendaraan Produktif',
                    'sort_order' => 1,
                ],
                'own' => [
                    'name' => 'OWN',
                    'sort_order' => 2,
                ],
                'operate' => [
                    'name' => 'OPERATE',
                    'sort_order' => 3,
                ],
                'grow' => [
                    'name' => 'GROW',
                    'sort_order' => 4,
                ],
                'business-flow' => [
                    'name' => 'Alur Bisnis',
                    'sort_order' => 5,
                ],
            ],
        ],

        'partnership' => [
            'name' => 'Program Kemitraan',
            'slug' => 'partnership',
            'route_name' => 'partnership',
            'status' => 'active',
            'sections' => [
                'program-selector' => [
                    'name' => 'Pilih Program Anda',
                    'sort_order' => 1,
                ],
                'owner-program' => [
                    'name' => 'Mitra Owner',
                    'sort_order' => 2,
                ],
                'driver-program' => [
                    'name' => 'Mitra Driver',
                    'sort_order' => 3,
                ],
                'packages-benefits' => [
                    'name' => 'Paket & Benefit',
                    'sort_order' => 4,
                ],
                'terms' => [
                    'name' => 'Persyaratan & Ketentuan',
                    'sort_order' => 5,
                ],
            ],
        ],

        'simulation' => [
            'name' => 'Simulasi & Perlindungan',
            'slug' => 'simulation',
            'route_name' => 'simulation',
            'status' => 'active',
            'sections' => [
                'assumptions' => [
                    'name' => 'Dasar Perhitungan',
                    'sort_order' => 1,
                ],
                'one-unit' => [
                    'name' => 'Simulasi 1 Unit',
                    'sort_order' => 2,
                ],
                'multiple-units' => [
                    'name' => 'Simulasi Beberapa Unit',
                    'sort_order' => 3,
                ],
                'protection-monitoring' => [
                    'name' => 'Perlindungan & Monitoring',
                    'sort_order' => 4,
                ],
                'disclaimer' => [
                    'name' => 'Disclaimer',
                    'sort_order' => 5,
                ],
            ],
        ],

        'about-contact' => [
            'name' => 'Tentang & Kontak',
            'slug' => 'about-contact',
            'route_name' => 'about-contact',
            'status' => 'active',
            'sections' => [
                'about' => [
                    'name' => 'Tentang CarAsset',
                    'sort_order' => 1,
                ],
                'vision-mission-values' => [
                    'name' => 'Visi, Misi & Nilai',
                    'sort_order' => 2,
                ],
                'legal-partners' => [
                    'name' => 'Legalitas & Partner',
                    'sort_order' => 3,
                ],
                'faq' => [
                    'name' => 'FAQ',
                    'sort_order' => 4,
                ],
                'contact-form' => [
                    'name' => 'Kontak & Form',
                    'sort_order' => 5,
                ],
            ],
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Site settings — hanya daftar key valid (group.key) yang boleh
    | disimpan di tabel `site_settings`. SiteSettingSeeder membaca daftar
    | ini untuk membuat baris kosong (value = null) bila belum ada.
    | Value sebenarnya diisi admin lewat PROMPT 16 (Pengaturan Website).
    |----------------------------------------------------------------------
    */
    'settings' => [
        'brand' => [
            'logo_horizontal' => 'media',
            'logo_on_dark' => 'media',
            'favicon' => 'media',
            'tagline' => 'text',
        ],
        'contact' => [
            'whatsapp' => 'phone',
            'email' => 'email',
            'address' => 'textarea',
            'business_hours' => 'text',
        ],
        'footer' => [
            'description' => 'textarea',
        ],
        'social' => [
            'instagram' => 'url',
        ],
    ],
];
