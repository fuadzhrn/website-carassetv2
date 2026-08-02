<?php

/*
|--------------------------------------------------------------------------
| CarAsset — Program Kemitraan Page Fallback Content
|--------------------------------------------------------------------------
|
| Salinan terstruktur dan akurat dari konten yang SUDAH ADA di
| resources/views/pages/partnership/sections/*.blade.php pada saat
| PROMPT 19 ditulis — tidak ada kata, benefit, paket, atau ketentuan baru.
|
| Penyesuaian struktur dari skema yang disarankan PROMPT 19 (mengikuti
| desain aktual, bukan asumsi):
| - owner-program: 4 callout berposisi tetap (tl/tr/bl/br) dipakai sebagai
|   list datar {label,is_active}, bukan objek "callout" tunggal — desain
|   aktual memang punya 4 callout berposisi, bukan 1. partner_roles,
|   carasset_roles, dan benefits berupa satu baris teks polos (bukan
|   title+description terpisah), jadi memakai bentuk {text,is_active}.
| - packages-benefits: tidak ada 'additional_benefits' terpisah pada
|   desain aktual (hanya satu daftar benefit per paket) — field itu
|   sengaja kosong/tidak dipakai. Paket unggulan disimpan sebagai SATU
|   field 'featured_package' (radio-group tunggal di admin), bukan
|   'is_featured' per-paket — ini mencegah lebih dari satu paket
|   berstatus unggulan tanpa perlu validasi silang tambahan.
| - terms: "checkpoints" aktual hanya 4 item (bukan 5), dan tidak ada
|   daftar 'documents' terpisah — 5 accordion yang ada language dipetakan
|   langsung ke verification/payment/cancellation/rights_obligations/
|   operational_terms. rights_obligations memakai item {label,text}
|   (grid 2x2), sementara verification/payment/operational_terms memakai
|   item {text} datar (list). cancellation hanya title+description (satu
|   paragraf, bukan list) — kalimat asli memakai <strong> yang TIDAK
|   dipertahankan sebagai HTML (aturan keamanan konten), hanya teks polos.
|   Terms memakai primary_cta/secondary_cta (2 tombol nyata), bukan 1 cta.
|
*/

return [
    'sections' => [

        'program-selector' => [
            'eyebrow' => 'Program Kemitraan CarAsset',
            'title' => "Satu Ekosistem.\nDua Cara untuk Bertumbuh.",
            'description' => 'Pilih jalur kemitraan berdasarkan posisi dan tujuan Anda. CarAsset menyediakan program bagi calon pemilik aset dan driver yang ingin membangun peluang kepemilikan kendaraan secara bertahap.',

            'owner' => [
                'label' => 'Mitra Owner',
                'title' => 'Mitra Owner',
                'description' => 'Saya ingin memiliki kendaraan dan mempercayakan pengelolaan operasionalnya kepada CarAsset.',
                'anchor' => 'mitra-owner',
                'cta_label' => 'Jelajahi Mitra Owner',
                'is_active' => true,
            ],
            'driver' => [
                'label' => 'Mitra Driver',
                'title' => 'Mitra Driver',
                'description' => 'Saya ingin menjalankan kendaraan sambil membangun peluang menuju kepemilikan sesuai ketentuan program.',
                'anchor' => 'mitra-driver',
                'cta_label' => 'Jelajahi Mitra Driver',
                'is_active' => true,
            ],
        ],

        'owner-program' => [
            'eyebrow' => 'Mitra Owner',
            'title' => 'Miliki Asetnya. Operasionalnya Kami Kelola.',
            'narrative' => 'Program Mitra Owner ditujukan bagi calon mitra yang ingin memiliki kendaraan dan mempercayakan pengelolaan operasionalnya kepada CarAsset sesuai ketentuan program.',

            'image_media_id' => null,
            'image_alt' => 'Calon mitra owner dengan kendaraan listrik yang akan dikelola sebagai aset produktif',

            'callouts' => [
                ['label' => 'Aset Milik Mitra', 'is_active' => true],
                ['label' => 'Operasional Dikelola', 'is_active' => true],
                ['label' => 'Monitoring dan Laporan', 'is_active' => true],
                ['label' => 'Perawatan Sesuai Program', 'is_active' => true],
            ],

            'partner_roles' => [
                ['item_key' => 'pr-1', 'text' => 'Menyiapkan dokumen yang dibutuhkan', 'is_active' => true],
                ['item_key' => 'pr-2', 'text' => 'Memilih program sesuai kebutuhan', 'is_active' => true],
                ['item_key' => 'pr-3', 'text' => 'Menjalani proses verifikasi', 'is_active' => true],
                ['item_key' => 'pr-4', 'text' => 'Memiliki aset sesuai ketentuan kerja sama', 'is_active' => true],
            ],

            'carasset_roles' => [
                ['item_key' => 'cr-1', 'text' => 'Membantu proses persiapan program', 'is_active' => true],
                ['item_key' => 'cr-2', 'text' => 'Mengelola kebutuhan operasional', 'is_active' => true],
                ['item_key' => 'cr-3', 'text' => 'Mengelola driver sesuai sistem', 'is_active' => true],
                ['item_key' => 'cr-4', 'text' => 'Membantu monitoring dan pelaporan', 'is_active' => true],
            ],

            'benefits' => [
                ['item_key' => 'b-1', 'text' => 'Struktur kepemilikan yang jelas', 'is_active' => true],
                ['item_key' => 'b-2', 'text' => 'Pengelolaan operasional profesional', 'is_active' => true],
                ['item_key' => 'b-3', 'text' => 'Monitoring dan informasi operasional', 'is_active' => true],
            ],

            'cta' => [
                'label' => 'Konsultasikan Program Owner',
                'destination_type' => 'internal',
                'route_name' => 'about-contact',
                'anchor' => 'contact',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],

            'microcopy' => 'Detail kepemilikan, pembiayaan, dan operasional mengikuti hasil verifikasi serta ketentuan program.',
        ],

        'driver-program' => [
            'eyebrow' => 'Mitra Driver',
            'title' => "Jalankan Kendaraannya.\nBangun Peluang Kepemilikannya.",
            'narrative' => 'Program Mitra Driver dirancang bagi driver yang ingin menjalankan kendaraan secara produktif sambil mengikuti proses menuju kepemilikan sesuai skema dan ketentuan program.',

            'image_media_id' => null,
            'image_alt' => 'Driver profesional yang menjalankan kendaraan dalam program Mitra Driver CarAsset',

            'timeline' => [
                ['item_key' => 'tl-1', 'label' => 'Tahap 1', 'title' => 'Mulai sebagai Mitra Driver', 'description' => 'Calon driver mengikuti proses pendaftaran, pemeriksaan, dan persiapan sesuai ketentuan program.', 'is_active' => true],
                ['item_key' => 'tl-2', 'label' => 'Tahap 2', 'title' => 'Menjalankan Operasional Kendaraan', 'description' => 'Driver menjalankan kendaraan sesuai sistem operasional dan standar yang ditetapkan.', 'is_active' => true],
                ['item_key' => 'tl-3', 'label' => 'Tahap 3', 'title' => 'Kontribusi Kepemilikan', 'description' => 'Komponen operasional dan kontribusi kepemilikan mengikuti skema yang disepakati dalam program.', 'is_active' => true],
                ['item_key' => 'tl-4', 'label' => 'Tahap 4', 'title' => 'Pemenuhan Ketentuan Program', 'description' => 'Proses kepemilikan berjalan sesuai pemenuhan kewajiban, evaluasi, dan ketentuan yang berlaku.', 'is_active' => true],
                ['item_key' => 'tl-5', 'label' => 'Tahap 5', 'title' => 'Menuju Kepemilikan Unit', 'description' => 'Setelah seluruh persyaratan program terpenuhi, proses kepemilikan mengikuti dokumen dan ketentuan final yang disepakati.', 'is_active' => true],
            ],

            'after_unit_panel' => [
                'title' => 'Setelah Unit Dimiliki',
                'description' => 'Setelah unit dimiliki, mitra driver dapat mempertimbangkan:',
                'items' => [
                    ['item_key' => 'au-1', 'text' => 'Mengoperasikan unit sendiri', 'is_active' => true],
                    ['item_key' => 'au-2', 'text' => 'Mengikuti sistem pengelolaan CarAsset', 'is_active' => true],
                    ['item_key' => 'au-3', 'text' => 'Mengembangkan peluang sumber penghasilan sesuai kondisi program', 'is_active' => true],
                ],
                'is_active' => true,
            ],

            'cta' => [
                'label' => 'Konsultasikan Program Driver',
                'destination_type' => 'internal',
                'route_name' => 'about-contact',
                'anchor' => 'contact',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],

            'note' => 'Skema kontribusi, periode, dan proses kepemilikan menunggu data final serta ketentuan resmi perusahaan.',
        ],

        'packages-benefits' => [
            'title' => 'Pilih Skala Kemitraan yang Sesuai dengan Rencana Anda.',
            'description' => 'Mulai dari satu unit atau kembangkan skala kepemilikan sesuai kebutuhan, kemampuan, proses verifikasi, dan ketentuan program.',

            // Satu field radio-group tunggal untuk paket unggulan (bukan
            // is_featured per-paket) — mencegah admin memilih lebih dari
            // satu paket unggulan di sumbernya, bukan lewat validasi
            // setelahnya. Status unggulan (Gold) bersifat sementara untuk
            // prototipe; penetapan paket unggulan sesungguhnya WAJIB
            // dikonfirmasi klien sebelum production.
            'featured_package' => 'five_units',

            'packages' => [
                'one_unit' => [
                    'unit_count' => 1,
                    'label' => 'Langkah Awal',
                    'title' => '1 Unit',
                    'description' => 'Untuk mitra yang ingin memulai dari satu aset dan memahami sistem pengelolaan CarAsset.',
                    'benefits' => [
                        ['item_key' => 'p1-1', 'text' => 'Memulai dari satu unit', 'is_active' => true],
                        ['item_key' => 'p1-2', 'text' => 'Mengenal sistem operasional', 'is_active' => true],
                        ['item_key' => 'p1-3', 'text' => 'Mendapatkan informasi monitoring sesuai program', 'is_active' => true],
                    ],
                    'additional_benefits' => [],
                    'cta' => [
                        'label' => 'Konsultasi 1 Unit',
                        'destination_type' => 'internal',
                        'route_name' => 'about-contact',
                        'anchor' => 'contact',
                        'external_url' => '',
                        'open_new_tab' => false,
                        'is_active' => true,
                    ],
                    'is_active' => true,
                ],
                'five_units' => [
                    'unit_count' => 5,
                    'label' => 'Pengembangan Portofolio',
                    'title' => '5 Unit',
                    'description' => 'Untuk mitra yang ingin membangun skala kepemilikan lebih luas secara bertahap.',
                    'benefits' => [
                        ['item_key' => 'p5-1', 'text' => 'Pengelolaan beberapa unit', 'is_active' => true],
                        ['item_key' => 'p5-2', 'text' => 'Dukungan koordinasi operasional', 'is_active' => true],
                        ['item_key' => 'p5-3', 'text' => 'Perencanaan pengembangan kepemilikan', 'is_active' => true],
                    ],
                    'additional_benefits' => [],
                    'cta' => [
                        'label' => 'Konsultasi 5 Unit',
                        'destination_type' => 'internal',
                        'route_name' => 'about-contact',
                        'anchor' => 'contact',
                        'external_url' => '',
                        'open_new_tab' => false,
                        'is_active' => true,
                    ],
                    'is_active' => true,
                ],
                'ten_units' => [
                    'unit_count' => 10,
                    'label' => 'Skala Armada',
                    'title' => '10 Unit',
                    'description' => 'Untuk mitra yang ingin merencanakan pengelolaan kendaraan dalam skala yang lebih besar.',
                    'benefits' => [
                        ['item_key' => 'p10-1', 'text' => 'Pendekatan skala armada', 'is_active' => true],
                        ['item_key' => 'p10-2', 'text' => 'Koordinasi program lebih luas', 'is_active' => true],
                        ['item_key' => 'p10-3', 'text' => 'Konsultasi struktur kepemilikan dan operasional', 'is_active' => true],
                    ],
                    'additional_benefits' => [],
                    'cta' => [
                        'label' => 'Konsultasi 10 Unit',
                        'destination_type' => 'internal',
                        'route_name' => 'about-contact',
                        'anchor' => 'contact',
                        'external_url' => '',
                        'open_new_tab' => false,
                        'is_active' => true,
                    ],
                    'is_active' => true,
                ],
            ],

            'disclaimer' => 'Benefit tambahan mengikuti periode dan ketentuan program yang berlaku.',
        ],

        'terms' => [
            'eyebrow' => 'Persyaratan & Ketentuan',
            'title' => 'Proses yang Transparan Sebelum Anda Memutuskan.',
            'description' => 'Pahami tahapan dokumen, verifikasi, pembayaran, dan operasional sebelum memulai program kemitraan.',

            'checkpoints' => [
                ['item_key' => 'cp-1', 'title' => 'Dokumen', 'is_active' => true],
                ['item_key' => 'cp-2', 'title' => 'Verifikasi', 'is_active' => true],
                ['item_key' => 'cp-3', 'title' => 'Pembayaran', 'is_active' => true],
                ['item_key' => 'cp-4', 'title' => 'Operasional', 'is_active' => true],
            ],

            'verification' => [
                'title' => 'Dokumen dan Verifikasi',
                'items' => [
                    ['item_key' => 'v-1', 'text' => 'Identitas calon mitra', 'is_active' => true],
                    ['item_key' => 'v-2', 'text' => 'Dokumen pembiayaan yang dibutuhkan', 'is_active' => true],
                    ['item_key' => 'v-3', 'text' => 'Pemeriksaan data sesuai proses program', 'is_active' => true],
                    ['item_key' => 'v-4', 'text' => 'Hasil verifikasi mengikuti pihak terkait', 'is_active' => true],
                ],
                'is_active' => true,
            ],

            'payment' => [
                'title' => 'Pembayaran dan Pelunasan',
                'items' => [
                    ['item_key' => 'pay-1', 'text' => 'Pembayaran mengikuti skema yang disepakati', 'is_active' => true],
                    ['item_key' => 'pay-2', 'text' => 'Pelunasan dilakukan sesuai jadwal program', 'is_active' => true],
                    ['item_key' => 'pay-3', 'text' => 'Biaya administrasi dan komponen pembayaran mengikuti dokumen resmi', 'is_active' => true],
                ],
                'is_active' => true,
            ],

            // Kalimat asli memakai <strong> di sekitar "menunggu konfirmasi
            // final perusahaan" — tidak dipertahankan sebagai HTML (hanya
            // teks polos) sesuai aturan keamanan konten.
            'cancellation' => [
                'title' => 'Pembatalan Program',
                'description' => 'Ketentuan pembatalan program, termasuk komponen yang dapat dikenakan, menunggu konfirmasi final perusahaan.',
                'is_active' => true,
            ],

            'rights_obligations' => [
                'title' => 'Hak dan Kewajiban',
                'items' => [
                    ['item_key' => 'ro-1', 'label' => 'Hak Mitra', 'text' => 'Mengikuti dokumen dan ketentuan kerja sama yang disepakati.', 'is_active' => true],
                    ['item_key' => 'ro-2', 'label' => 'Kewajiban Mitra', 'text' => 'Mengikuti dokumen dan ketentuan kerja sama yang disepakati.', 'is_active' => true],
                    ['item_key' => 'ro-3', 'label' => 'Peran CarAsset', 'text' => 'Mengelola operasional sesuai sistem dan ketentuan program.', 'is_active' => true],
                    ['item_key' => 'ro-4', 'label' => 'Ketentuan Penggunaan Kendaraan', 'text' => 'Mengikuti ketentuan operasional program yang berlaku.', 'is_active' => true],
                ],
                'is_active' => true,
            ],

            'operational_terms' => [
                'title' => 'Ketentuan Operasional',
                'items' => [
                    ['item_key' => 'ot-1', 'text' => 'Pengelolaan driver sesuai ketentuan program', 'is_active' => true],
                    ['item_key' => 'ot-2', 'text' => 'Jadwal operasional sesuai ketentuan program', 'is_active' => true],
                    ['item_key' => 'ot-3', 'text' => 'Perawatan kendaraan sesuai ketentuan program', 'is_active' => true],
                    ['item_key' => 'ot-4', 'text' => 'Monitoring dan laporan sesuai ketentuan program', 'is_active' => true],
                    ['item_key' => 'ot-5', 'text' => 'Penanganan kondisi operasional tertentu sesuai ketentuan program', 'is_active' => true],
                ],
                'is_active' => true,
            ],

            'legal_note' => '',

            'cta_title' => 'Masih Memiliki Pertanyaan tentang Program?',
            'cta_description' => 'Tim CarAsset akan membantu menjelaskan pilihan program, proses, dokumen, serta asumsi operasional sebelum Anda mengambil keputusan.',
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
                'label' => 'Lihat Simulasi & Perlindungan',
                'destination_type' => 'internal',
                'route_name' => 'simulation',
                'anchor' => '',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
        ],
    ],

    // Path statis lama, dipakai HANYA sebagai fallback bila CMS media
    // kosong/file tidak ditemukan — bukan dipindahkan ke storage admin.
    'fallback_images' => [
        'owner-program' => 'assets/images/partnership/owner-program.webp',
        'driver-program' => 'assets/images/partnership/driver-program.webp',
    ],
];
