<?php

/*
|--------------------------------------------------------------------------
| CarAsset — Bisnis CarAsset Page Fallback Content
|--------------------------------------------------------------------------
|
| Salinan terstruktur dan akurat dari konten yang SUDAH ADA di
| resources/views/pages/business/sections/*.blade.php pada saat
| PROMPT 18 ditulis — tidak ada kata, angka, atau klaim baru.
|
| Beberapa field yang disarankan skema PROMPT 18 SENGAJA TIDAK dibuat di
| sini karena elemen visualnya memang tidak ada pada desain Bisnis saat
| ini (audit langsung dari Blade, bukan asumsi):
| - opportunity: tidak ada 'supporting_narrative', 'key_points', maupun
|   'callout' — section ini hanya berisi hero+deskripsi+diagram+1 link.
|   'diagram' juga memakai 4 label (bukan 3 seperti contoh skema) karena
|   diagram aktual memang punya 4 zona terkunci.
| - own: tidak ada 'ownership_statement', 'callouts', maupun 'cta' — key
|   points-nya juga berupa satu baris teks polos (bukan title+description
|   terpisah), jadi memakai bentuk {text,is_active} seperti Home.
| - operate: tidak ada 'image', 'callout', maupun 'cta' — sama sekali
|   tidak ada elemen tersebut pada desain aktual. Kolom "helper" pada tiap
|   blok monitoring adalah teks pill status AWAL yang tampil sebelum
|   public/assets/js/pages/business/monitoring-illustration.js mengambil
|   alih rotasi animasi (file itu tidak diubah — lihat catatan di PageController).
| - grow: tidak ada 'callout', dan setiap stage tidak punya 'description'
|   (hanya label tahap + judul tahap) — juga tidak ada 'image'.
| - business-flow: desain aktual punya DUA tombol CTA (bukan satu), jadi
|   memakai 'primary_cta'/'secondary_cta' seperti Home, bukan 'cta'
|   tunggal.
|
| Disclaimer/caption yang bersifat kepatuhan (mis. catatan dashboard
| ilustrasi OPERATE, disclaimer pertumbuhan GROW) TETAP DIKUNCI di Blade
| publik, bukan bagian dari CMS — tidak tercantum di sini.
|
*/

return [
    'sections' => [

        'opportunity' => [
            'eyebrow' => 'Model Bisnis CarAsset',
            'title' => 'Dari Kendaraan Menjadi Aset yang Tetap Produktif.',
            'description' => 'CarAsset membantu mitra menempatkan kendaraan sebagai aset produktif melalui pengelolaan operasional yang terstruktur. Mitra memiliki asetnya, sementara CarAsset membantu menjalankan sistem operasional, monitoring, dan pengelolaan kendaraan sesuai ketentuan program.',

            'diagram' => [
                'step_1_label' => 'Kepemilikan',
                'step_2_label' => 'Operasional',
                'step_3_label' => 'Hasil Operasional',
                'step_4_label' => 'Pengembangan Aset',
            ],

            'image_media_id' => null,
            // alt sengaja kosong — gambar hero dekoratif (teks sudah ada di overlay).
            'image_alt' => '',

            'cta' => [
                'label' => 'Lihat Cara Aset Dikelola',
                'destination_type' => 'internal',
                'route_name' => 'business',
                'anchor' => 'operate',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
        ],

        'own' => [
            'eyebrow' => '01 — OWN',
            'title' => 'Miliki Asetnya dengan Kepemilikan yang Jelas.',
            'description' => 'Kendaraan dalam program CarAsset dirancang menjadi aset milik mitra. CarAsset berperan sebagai pengelola operasional, sedangkan kepemilikan tetap berada pada mitra sesuai dokumen dan ketentuan kerja sama.',

            'image_media_id' => null,
            'image_alt' => 'Ilustrasi serah terima kunci kendaraan sebagai simbol kepemilikan aset',

            'key_points' => [
                ['text' => 'Kepemilikan aset atas nama mitra sesuai ketentuan program', 'is_active' => true],
                ['text' => 'Struktur peran mitra dan pengelola yang jelas', 'is_active' => true],
                ['text' => 'Kendali aset tetap berada pada pemiliknya', 'is_active' => true],
                ['text' => '', 'is_active' => false],
            ],
        ],

        'operate' => [
            'eyebrow' => '02 — OPERATE',
            'title' => 'Operasional Dikelola agar Aset Tetap Produktif.',
            'description' => 'CarAsset membantu mengelola berbagai kebutuhan operasional kendaraan, mulai dari pengelolaan driver, pemantauan aktivitas, jadwal perawatan, hingga penyusunan laporan operasional sesuai sistem dan ketentuan program.',

            'key_points' => [
                ['text' => 'Pengelolaan Driver', 'is_active' => true],
                ['text' => 'Monitoring Aktivitas Kendaraan', 'is_active' => true],
                ['text' => 'Perawatan Berkala', 'is_active' => true],
                ['text' => 'Laporan Operasional', 'is_active' => true],
            ],

            'monitoring_panel' => [
                'illustration_label' => 'Ilustrasi Sistem Monitoring',
                'panel_title' => 'CarAsset Fleet Overview',

                'unit_status' => [
                    'label' => 'Status Unit',
                    'value' => 'Unit Contoh',
                    'helper' => 'Dalam Operasional',
                    'is_active' => true,
                ],
                'driver_profile' => [
                    'label' => 'Profil Driver',
                    'value' => 'Driver Terdaftar',
                    'helper' => '',
                    'is_active' => true,
                ],
                'vehicle_activity' => [
                    'label' => 'Aktivitas Kendaraan',
                    'value' => 'Ringkasan Aktivitas',
                    'helper' => '',
                    'is_active' => true,
                ],
                'maintenance_schedule' => [
                    'label' => 'Jadwal Perawatan',
                    'value' => 'Jadwal Berikutnya',
                    'helper' => 'Jadwal Perawatan',
                    'is_active' => true,
                ],
                'operational_report' => [
                    'label' => 'Laporan Operasional',
                    'value' => 'Ringkasan Operasional',
                    'helper' => 'Laporan Tersedia',
                    'is_active' => true,
                ],
            ],
        ],

        'grow' => [
            'eyebrow' => '03 — GROW',
            'title' => 'Bangun Kepemilikan Secara Bertahap.',
            'description' => 'CarAsset menghubungkan nilai aset dan hasil operasional dalam sebuah konsep pertumbuhan. Pengembangan unit dilakukan secara bertahap sesuai performa operasional, kondisi pembiayaan, nilai aset, dan ketentuan program.',

            'stages' => [
                ['label' => 'Tahap 1', 'title' => 'Mulai dari Unit Pertama', 'is_active' => true],
                ['label' => 'Tahap 2', 'title' => 'Optimalkan Operasional Aset', 'is_active' => true],
                ['label' => 'Tahap 3', 'title' => 'Rencanakan Pengembangan Kepemilikan', 'is_active' => true],
                ['label' => '', 'title' => '', 'is_active' => false],
            ],

            'cta' => [
                'label' => 'Pelajari Program Kemitraan',
                'destination_type' => 'internal',
                'route_name' => 'partnership',
                'anchor' => '',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
        ],

        'business-flow' => [
            'eyebrow' => 'Alur Bisnis CarAsset',
            'title' => 'Dari Konsultasi hingga Aset Mulai Dikelola.',
            'description' => 'Setiap proses dilakukan secara bertahap agar calon mitra memahami program, dokumen, peran, serta mekanisme operasional sebelum kendaraan mulai dikelola.',

            'stages' => [
                ['title' => 'Konsultasi Awal', 'description' => 'Calon mitra mempelajari program, pilihan kemitraan, dan gambaran operasional bersama tim CarAsset.', 'is_active' => true],
                ['title' => 'Verifikasi Data', 'description' => 'Dokumen dan kelayakan calon mitra diperiksa sesuai proses pembiayaan dan ketentuan program.', 'is_active' => true],
                ['title' => 'Pengadaan Unit', 'description' => 'Proses pengadaan dan persiapan kendaraan dilakukan setelah persyaratan dan ketentuan program disetujui.', 'is_active' => true],
                ['title' => 'Unit Mulai Dikelola', 'description' => 'Kendaraan dipersiapkan untuk operasional sesuai sistem pengelolaan CarAsset dan mitra operasional terkait.', 'is_active' => true],
                ['title' => 'Monitoring dan Laporan', 'description' => 'Mitra memperoleh informasi operasional sesuai sistem pelaporan dan ketentuan yang diberlakukan.', 'is_active' => true],
            ],

            'closing_statement' => 'Detail tahapan, persyaratan, dan waktu proses mengikuti hasil konsultasi serta ketentuan program yang berlaku.',

            'primary_cta' => [
                'label' => 'Pilih Program Kemitraan',
                'destination_type' => 'internal',
                'route_name' => 'partnership',
                'anchor' => '',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
            'secondary_cta' => [
                'label' => 'Konsultasi Sekarang',
                'destination_type' => 'internal',
                'route_name' => 'about-contact',
                'anchor' => 'contact',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
        ],
    ],

    // Path statis lama, dipakai HANYA sebagai fallback bila CMS media
    // kosong/file tidak ditemukan — bukan dipindahkan ke storage admin.
    'fallback_images' => [
        'opportunity' => 'assets/images/business/business-opportunity-hero.webp',
        'own' => 'assets/images/business/ownership-asset.webp',
    ],
];
