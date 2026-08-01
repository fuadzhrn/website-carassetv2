<?php

/*
|--------------------------------------------------------------------------
| CarAsset — Home Page Fallback Content
|--------------------------------------------------------------------------
|
| Salinan terstruktur dan akurat dari konten yang SUDAH ADA di
| resources/views/pages/home/sections/*.blade.php pada saat PROMPT 17
| ditulis. Ini BUKAN konten baru — tidak ada kata, angka, atau klaim yang
| ditambahkan di luar apa yang sudah tampil di halaman Home.
|
| Dipakai sebagai fallback oleh ContentService ketika:
| - baris page_sections belum diisi admin (content kosong/[]);
| - field tertentu belum diisi admin (merge per-field);
| - HomeContentSeeder mengisi konten awal database.
|
| Field yang TIDAK ADA di sini (mis. gambar Hero, background Consultation
| CTA) sengaja tidak dibuat karena desain Home saat ini memang tidak
| memilikinya — lihat catatan di setiap section.
|
*/

return [
    'sections' => [

        // Hero TIDAK memakai gambar — hanya ikon mark abstrak (car-front)
        // yang posisinya dikunci desain. Karena itu tidak ada
        // image_media_id/image_alt di sini (jangan memaksakan gambar
        // yang tidak ada pada desain aktual).
        'hero' => [
            'eyebrow' => 'Platform Aset Kendaraan Produktif',
            'title_line_1' => 'Mobil Bekerja.',
            'title_line_2' => 'Bertumbuh.',
            'subtitle' => 'Miliki Asetnya. Biarkan Mobilnya Bekerja.',
            'description' => 'CarAsset membantu mitra memiliki kendaraan produktif yang dikelola secara profesional untuk mendukung pertumbuhan aset secara bertahap dan transparan.',

            'primary_cta' => [
                'label' => 'Konsultasi Sekarang',
                'destination_type' => 'internal',
                'route_name' => 'about-contact',
                'anchor' => 'contact',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
            'secondary_cta' => [
                'label' => 'Pelajari Cara Kerja',
                'destination_type' => 'internal',
                'route_name' => 'home',
                'anchor' => 'cara-kerja',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],

            'status_items' => [
                ['label' => 'Aset Milik Mitra', 'is_active' => true],
                ['label' => 'Dikelola Profesional', 'is_active' => true],
                ['label' => 'Monitoring Transparan', 'is_active' => true],
            ],
        ],

        'income-opportunity' => [
            'eyebrow' => 'Mengapa Aset Produktif Penting',
            'title' => 'Menambah Penghasilan Tidak Selalu Berarti Menambah Jam Kerja.',
            // Dua paragraf asli digabung satu field "narrative", dipisah
            // baris kosong — Blade akan memecahnya kembali jadi 2 <p>.
            'narrative' => "Biaya hidup terus bertumbuh, sementara mengandalkan satu sumber penghasilan dapat membuat kondisi finansial lebih rentan terhadap perubahan. Menambah penghasilan tidak selalu harus berarti menambah jam kerja.\n\nAset yang dikelola secara tepat dapat membantu membangun sumber penghasilan tambahan secara bertahap. CarAsset menghadirkan kendaraan sebagai aset produktif yang dikelola secara profesional, sehingga mitra tidak perlu menjalankan operasionalnya sendiri.",
            // Baris asli dipisah "\n" (mewakili <br> di panel editorial).
            'editorial_statement' => "Kendaraan tidak hanya digunakan.\nKendaraan juga dapat dikelola menjadi aset produktif.",

            'image_media_id' => null,
            'image_alt' => 'Kendaraan listrik sedang mengisi daya sebagai ilustrasi kendaraan produktif',

            'cta' => [
                'label' => 'Kenali Bisnis CarAsset',
                'destination_type' => 'internal',
                'route_name' => 'business',
                'anchor' => '',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
        ],

        'process-summary' => [
            'eyebrow' => 'Cara CarAsset Bekerja',
            'title' => 'Satu Sistem. Tiga Langkah untuk Membuat Aset Tetap Produktif.',
            'description' => 'CarAsset menghubungkan kepemilikan kendaraan, pengelolaan operasional, dan pertumbuhan aset dalam satu sistem kemitraan.',

            'steps' => [
                'own' => [
                    'title' => 'Miliki Asetnya',
                    'description' => 'Kendaraan menjadi aset milik mitra dengan struktur kepemilikan yang jelas sesuai ketentuan program.',
                    'is_active' => true,
                ],
                'operate' => [
                    'title' => 'Kami Kelola Operasionalnya',
                    'description' => 'CarAsset membantu mengelola driver, operasional, perawatan, dan monitoring kendaraan secara profesional.',
                    'is_active' => true,
                ],
                'grow' => [
                    'title' => 'Kembangkan Kepemilikannya',
                    'description' => 'Nilai aset dan hasil operasional dapat mendukung rencana pertumbuhan unit secara bertahap sesuai kondisi dan ketentuan program.',
                    'is_active' => true,
                ],
            ],

            'cta' => [
                'label' => 'Pelajari Bisnis CarAsset',
                'destination_type' => 'internal',
                'route_name' => 'business',
                'anchor' => '',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
        ],

        'partnership-choice' => [
            'eyebrow' => 'Pilih Jalur Kemitraan',
            'title' => 'Satu Ekosistem, Dua Cara untuk Bertumbuh Bersama CarAsset.',
            'description' => 'Pilih program yang paling sesuai dengan posisi dan tujuan Anda.',

            'owner' => [
                // "eyebrow" per-panel ada di desain aktual meski tidak
                // tercantum eksplisit di struktur contoh prompt.
                'eyebrow' => 'Untuk Pemilik Aset',
                'title' => 'Mitra Owner',
                'description' => 'Miliki kendaraan atas nama Anda dan percayakan pengelolaan operasionalnya kepada CarAsset.',
                'image_media_id' => null,
                'image_alt' => 'Konsultasi bisnis mengenai kepemilikan kendaraan sebagai aset',
                'benefits' => [
                    ['text' => 'Kepemilikan aset yang jelas', 'is_active' => true],
                    ['text' => 'Pengelolaan operasional profesional', 'is_active' => true],
                    ['text' => 'Monitoring dan laporan berkala', 'is_active' => true],
                    ['text' => '', 'is_active' => false],
                ],
                'cta' => [
                    'label' => 'Pelajari Mitra Owner',
                    'destination_type' => 'internal',
                    'route_name' => 'partnership',
                    'anchor' => 'mitra-owner',
                    'external_url' => '',
                    'open_new_tab' => false,
                    'is_active' => true,
                ],
            ],

            'driver' => [
                'eyebrow' => 'Untuk Driver',
                'title' => 'Mitra Driver',
                'description' => 'Jalankan kendaraan secara produktif sambil membangun peluang menuju kepemilikan unit sesuai ketentuan program.',
                'image_media_id' => null,
                'image_alt' => 'Driver profesional mengemudikan kendaraan CarAsset',
                'benefits' => [
                    ['text' => 'Jalur bertahap menuju kepemilikan', 'is_active' => true],
                    ['text' => 'Dukungan ekosistem operasional', 'is_active' => true],
                    ['text' => 'Peluang membangun sumber penghasilan tambahan', 'is_active' => true],
                    ['text' => '', 'is_active' => false],
                ],
                'cta' => [
                    'label' => 'Pelajari Mitra Driver',
                    'destination_type' => 'internal',
                    'route_name' => 'partnership',
                    'anchor' => 'mitra-driver',
                    'external_url' => '',
                    'open_new_tab' => false,
                    'is_active' => true,
                ],
            ],
        ],

        // Consultation CTA TIDAK memakai background image pada desain
        // aktual (hanya elemen dekoratif ".ca-consultation__route", bukan
        // foto) — karena itu tidak ada background_media_id/background_alt
        // di sini (jangan memaksakan gambar yang tidak ada pada desain).
        'consultation-cta' => [
            'eyebrow' => 'Mulai Bersama CarAsset',
            'title' => 'Mulai dari Satu Unit. Bangun Aset Produktif Anda.',
            'description' => 'Kenali cara kerja program, pilihan kemitraan, dan ilustrasi operasional bersama tim CarAsset sebelum mengambil keputusan.',

            'trust_points' => [
                ['text' => 'Aset atas nama mitra', 'is_active' => true],
                ['text' => 'Pengelolaan profesional', 'is_active' => true],
                ['text' => 'Perlindungan dan perawatan', 'is_active' => true],
                ['text' => 'Monitoring operasional', 'is_active' => true],
            ],

            'primary_cta' => [
                'label' => 'Jadwalkan Konsultasi',
                'destination_type' => 'internal',
                'route_name' => 'about-contact',
                'anchor' => 'contact',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
            'secondary_cta' => [
                'label' => 'Lihat Simulasi & Perlindungan',
                'destination_type' => 'internal',
                'route_name' => 'simulation',
                'anchor' => '',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],

            'microcopy' => 'Konsultasi awal membantu Anda memahami program, proses, serta asumsi operasional yang digunakan.',
        ],
    ],

    // Path statis lama, dipakai HANYA sebagai fallback bila CMS media
    // kosong/file tidak ditemukan — bukan dipindahkan ke storage admin.
    'fallback_images' => [
        'income-opportunity' => 'assets/images/home/income-opportunity.webp',
        'partnership-choice.owner' => 'assets/images/home/owner-program.webp',
        'partnership-choice.driver' => 'assets/images/home/driver-program.webp',
    ],
];
