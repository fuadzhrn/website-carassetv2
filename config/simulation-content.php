<?php

/*
|--------------------------------------------------------------------------
| CarAsset — Simulasi & Perlindungan Page Fallback Content
|--------------------------------------------------------------------------
|
| Salinan terstruktur dari teks yang SUDAH ADA di
| resources/views/pages/simulation/sections/*.blade.php pada saat
| PROMPT 20 ditulis. TIDAK ADA rumus, TIDAK ADA angka baru, TIDAK ADA
| nilai contoh — hanya salinan teks dan struktur.
|
| ANGKA — KEPUTUSAN 2026-08-02 (menggantikan keputusan audit PROMPT 20):
| PROMPT 20 sebelumnya menemukan bahwa public/assets/js/pages/simulation/
| simulation-config.js menyimpan angka yang KOMENTARNYA SENDIRI menyatakan
| "resmi dari dokumen klien" (operatingDays=27, dailyDeposit=230000,
| operationalCost=500000, monthlyInstallment=5100000), namun PROMPT 20
| juga mendaftarkan angka-angka ini sebagai BELUM KONSISTEN berdasarkan
| pembahasan proyek yang lebih baru (di luar repo ini): hari operasional
| 27 vs 28 hari, cicilan ~Rp5.100.000 vs ~Rp5.200.000, dan nilai harian
| ~Rp60.000 vs ~Rp70.000 (catatan: nilai harian yang disengketakan itu
| adalah setoran skema Mitra Driver — TIDAK dibahas di simulation-config.js
| sama sekali, sehingga tidak relevan dengan field-field di bawah). Karena
| konflik itu, seluruh angka sempat dikosongkan (null, data_status='draft').
|
| Pemilik proyek secara eksplisit meminta (2026-08-02) agar angka yang
| SUDAH ADA di simulation-config.js dipakai sebagai data resmi CMS,
| menggantikan sikap tunggu-konfirmasi sebelumnya. Maka:
| - assumptions.*, one-unit.*, multiple-units.units.one_unit.* diisi
|   persis dari scenarios.oneUnit (dan assumptions) di simulation-config.js;
| - multiple-units.units.five_units/ten_units diisi dari scenarios.fiveUnits/
|   tenUnits — nilai ini TETAP estimasi linear (1 unit x5/x10), bukan angka
|   resmi terpisah, sehingga badge "Estimasi Linear — Bukan Angka Resmi"
|   (lihat sections/multiple-units.blade.php) tetap tampil untuk keduanya;
| - data_status seluruh 3 section = 'confirmed' agar publik tidak lagi
|   menampilkan teks "Menunggu angka final klien"/"Menunggu Konfirmasi".
| simulation-config.js/simulation-render.js sendiri tetap tidak di-include
| lagi di halaman (lihat pages/simulation/index.blade.php) — angka publik
| sekarang murni berasal dari CMS ini, bukan dari JS tersebut.
|
| assumptions.managementShare / assumptions.ownerShare / one-unit &
| multiple-units managementComponent/projectedOwnerResult di JS lama
| disimpan sebagai TEKS RASIO ("40% dari hasil operasional"), bukan
| nominal Rupiah. Skema CMS di sini menampilkan rasio itu APA ADANYA
| sebagai nilai persentase (format 'percentage', value 40/60) — bukan
| menghitung/mengarang nominal Rupiah yang tidak pernah ada di sumber.
| assumptions.revenue_share sebelumnya terkunci karena jenisnya belum
| ditentukan; sekarang ditentukan sebagai persentase (60, bagian Mitra)
| untuk melengkapi assumptions.management_component (40, bagian CarAsset).
|
| Field yang TIDAK punya rumus/relasi otomatis apa pun di sini — setiap
| angka independen, admin mengisi manual, sistem tidak pernah menghitung
| turunan dari field lain.
*/

return [
    'sections' => [

        'assumptions' => [
            'eyebrow' => 'Simulasi & Perlindungan',
            'title' => 'Pahami Cara Ilustrasi Operasional Disusun.',
            'description' => 'Simulasi CarAsset menggunakan sejumlah asumsi operasional untuk membantu calon mitra memahami alur pengelolaan kendaraan. Seluruh nilai pada halaman ini masih menunggu konfirmasi final perusahaan.',

            'data_status' => 'confirmed',
            'status_note' => null,

            'operational_days' => [
                'label' => 'Hari Operasional',
                'value' => 27,
                'helper' => 'Jumlah hari operasional per periode, dalam hari.',
            ],

            'daily_result' => [
                'label' => 'Setoran / Hasil Operasional Harian',
                'value' => 230000,
                'helper' => 'Nilai hasil atau setoran operasional per hari, dalam Rupiah.',
            ],

            'operating_cost' => [
                'label' => 'Biaya Operasional',
                'value' => 500000,
                'helper' => 'Biaya operasional per bulan, dalam Rupiah.',
            ],

            'vehicle_installment' => [
                'label' => 'Cicilan Kendaraan',
                'value' => 5100000,
                'helper' => 'Cicilan atau kewajiban kendaraan per bulan, dalam Rupiah.',
            ],

            'management_component' => [
                'label' => 'Komponen Pengelolaan',
                'value' => 40,
                'helper' => 'Porsi pembagian hasil operasional untuk CarAsset, dalam persen.',
            ],

            'revenue_share' => [
                'label' => 'Pembagian Hasil Operasional',
                'value' => 60,
                'helper' => 'Porsi pembagian hasil operasional untuk Mitra, dalam persen.',
            ],

            // Dipetakan dari paragraf catatan yang sudah ada di Blade lama
            // (<p class="ca-assumptions__note">) — bukan kotak callout baru.
            'callout' => [
                'title' => null,
                'description' => 'Nilai final akan disesuaikan setelah asumsi operasional, skema pembiayaan, dan pembagian program dikonfirmasi oleh perusahaan.',
                'is_active' => true,
            ],
        ],

        'one-unit' => [
            'eyebrow' => 'Ilustrasi Satu Unit',
            'title' => 'Melihat Alur Operasional dari Satu Kendaraan.',
            'description' => 'Ilustrasi ini menunjukkan bagaimana hasil operasional satu kendaraan dialokasikan ke berbagai komponen sesuai skema program.',

            'data_status' => 'confirmed',
            'status_note' => null,

            'gross_operational_result' => [
                'label' => 'Hasil Operasional Bruto',
                'value' => 6210000,
                'helper' => 'Nilai sebelum dikurangi komponen biaya dan kewajiban.',
            ],

            'operating_cost' => [
                'label' => 'Biaya Operasional',
                'value' => 500000,
                'helper' => 'Mencakup komponen biaya yang telah ditetapkan dalam program.',
            ],

            'vehicle_obligation' => [
                'label' => 'Kewajiban Kendaraan',
                'value' => 5100000,
                'helper' => 'Mencakup cicilan atau kewajiban kendaraan sesuai skema pembiayaan.',
            ],

            'management_component' => [
                'label' => 'Komponen Pengelolaan',
                'value' => 40,
                'helper' => 'Porsi pembagian hasil operasional untuk CarAsset, dalam persen.',
            ],

            'projected_partner_result' => [
                'label' => 'Proyeksi Hasil Operasional Mitra',
                'value' => 60,
                'helper' => 'Porsi pembagian hasil operasional untuk Mitra, dalam persen. Nilai ini merupakan ilustrasi, bukan jaminan hasil.',
            ],

            'summary_note' => 'Hasil aktual dapat berbeda.',

            'cta' => [
                'label' => 'Konsultasikan Simulasi 1 Unit',
                'destination_type' => 'internal',
                'route_name' => 'about-contact',
                'anchor' => 'contact',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
        ],

        'multiple-units' => [
            'eyebrow' => 'Perbandingan Skala Operasional',
            'title' => 'Bandingkan Struktur Simulasi untuk Beberapa Skala Unit.',
            'description' => 'Perbandingan ini membantu calon mitra melihat bagaimana jumlah unit memengaruhi struktur pengelolaan. Nilai skala 5 dan 10 unit merupakan estimasi linear dari simulasi 1 unit, bukan angka resmi terpisah.',

            'data_status' => 'confirmed',
            'status_note' => null,

            'units' => [
                'one_unit' => [
                    'unit_count' => 1,
                    'label' => 'Skala Awal',
                    'description' => null,
                    'gross_operational_result' => 6210000,
                    'operating_cost' => 500000,
                    'vehicle_obligation' => 5100000,
                    'management_component' => 40,
                    'projected_partner_result' => 60,
                    'note' => null,
                    'is_active' => true,
                ],
                'five_units' => [
                    'unit_count' => 5,
                    'label' => 'Skala Pengembangan',
                    'description' => null,
                    'gross_operational_result' => 31050000,
                    'operating_cost' => 2500000,
                    'vehicle_obligation' => 25500000,
                    'management_component' => 40,
                    'projected_partner_result' => 60,
                    'note' => null,
                    'is_active' => true,
                ],
                'ten_units' => [
                    'unit_count' => 10,
                    'label' => 'Skala Armada',
                    'description' => null,
                    'gross_operational_result' => 62100000,
                    'operating_cost' => 5000000,
                    'vehicle_obligation' => 51000000,
                    'management_component' => 40,
                    'projected_partner_result' => 60,
                    'note' => null,
                    'is_active' => true,
                ],
            ],

            'comparison_note' => 'Nilai pada skala 5 dan 10 unit dihitung secara linear dari simulasi 1 unit (dikalikan sesuai jumlah unit) semata-mata untuk memberi gambaran kasar skala operasional — bukan angka resmi yang dikonfirmasi terpisah oleh perusahaan. Struktur biaya, kebutuhan operasional, pembiayaan, dan pengelolaan pada skala yang lebih besar dapat berbeda dari hasil kali sederhana ini.',

            'cta' => [
                'label' => 'Minta Simulasi Berdasarkan Skala Unit',
                'destination_type' => 'internal',
                'route_name' => 'about-contact',
                'anchor' => 'contact',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
        ],

        // Enam poin (asuransi/garansi/gps/monitoring/perawatan/laporan)
        // pada desain aktual HANYA berupa ikon + label pendek berposisi
        // tetap (orbit graphic) — tidak ada teks deskripsi per fitur di
        // Blade lama, maka description dikosongkan (bukan mengarang narasi
        // baru). Tidak ada kotak callout maupun tombol CTA pada desain
        // aktual section ini (dikonfirmasi: tidak ada class CSS terkait
        // di protection-monitoring.css) — field callout/cta tetap
        // disediakan untuk kelengkapan skema & kebutuhan masa depan, tapi
        // TIDAK dirender di publik selama is_active bernilai false.
        'protection-monitoring' => [
            'eyebrow' => 'Perlindungan Aset',
            'title' => 'Aset Produktif Memerlukan Perlindungan dan Monitoring yang Terstruktur.',
            'description' => 'CarAsset merancang pengelolaan kendaraan dengan memperhatikan perlindungan, kondisi kendaraan, aktivitas operasional, perawatan, dan informasi pelaporan sesuai ketentuan program.',

            'image_media_id' => null,
            'image_alt' => '',

            'features' => [
                'insurance' => ['title' => 'Asuransi Kendaraan', 'description' => null, 'is_active' => true],
                'warranty' => ['title' => 'Garansi Kendaraan', 'description' => null, 'is_active' => true],
                'gps' => ['title' => 'GPS / Pelacakan', 'description' => null, 'is_active' => true],
                'monitoring' => ['title' => 'Monitoring Operasional', 'description' => null, 'is_active' => true],
                'maintenance' => ['title' => 'Perawatan Berkala', 'description' => null, 'is_active' => true],
                'reporting' => ['title' => 'Laporan Operasional', 'description' => null, 'is_active' => true],
            ],

            'callout' => [
                'title' => null,
                'description' => null,
                'is_active' => false,
            ],

            'cta' => [
                'label' => null,
                'destination_type' => 'none',
                'route_name' => '',
                'anchor' => '',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => false,
            ],
        ],

        // Desain aktual disclaimer punya panel CTA yang lebih kaya dari
        // skema saran PROMPT 20 (1 cta + microcopy): ada judul+deskripsi
        // pengantar CTA dan DUA tombol (konsultasi + lihat program
        // kemitraan), bukan satu. Diperluas menjadi cta_title/
        // cta_description/primary_cta/secondary_cta — pola yang sama
        // dipakai pada Partnership Terms (PROMPT 19).
        'disclaimer' => [
            'eyebrow' => 'Catatan Penting',
            'title' => 'Simulasi Merupakan Ilustrasi, Bukan Jaminan Hasil.',
            'description' => "Seluruh nilai pada halaman ini merupakan contoh tampilan dan masih menunggu angka final dari CarAsset. Simulasi disusun berdasarkan asumsi operasional, pembiayaan, biaya, pembagian, dan kondisi tertentu yang dapat berubah.\n\nHasil aktual dapat berbeda karena dipengaruhi oleh aktivitas kendaraan, biaya operasional, jadwal kerja, kondisi pembiayaan, perawatan, kondisi pasar, kebijakan mitra operasional, serta ketentuan program yang berlaku.\n\nInformasi pada halaman ini tidak boleh dianggap sebagai jaminan penghasilan, keuntungan tetap, atau hasil investasi tertentu. Calon mitra disarankan mempelajari dokumen program dan berkonsultasi sebelum mengambil keputusan.",

            'points' => [
                ['item_key' => 'point-1', 'text' => 'Angka masih menunggu konfirmasi final', 'is_active' => true],
                ['item_key' => 'point-2', 'text' => 'Hasil aktual dapat berbeda', 'is_active' => true],
                ['item_key' => 'point-3', 'text' => 'Kondisi operasional memengaruhi hasil', 'is_active' => true],
                ['item_key' => 'point-4', 'text' => 'Detail final tersedia dalam konsultasi dan dokumen program', 'is_active' => true],
            ],

            'cta_title' => 'Butuh Simulasi yang Sesuai dengan Rencana Anda?',
            'cta_description' => 'Sampaikan pilihan program dan jumlah unit yang ingin dipelajari. Tim CarAsset akan membantu menjelaskan asumsi, alur operasional, dan ketentuan yang digunakan.',
            'primary_cta' => [
                'label' => 'Konsultasikan Simulasi',
                'destination_type' => 'internal',
                'route_name' => 'about-contact',
                'anchor' => 'contact',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
            'secondary_cta' => [
                'label' => 'Pelajari Program Kemitraan',
                'destination_type' => 'internal',
                'route_name' => 'partnership',
                'anchor' => '',
                'external_url' => '',
                'open_new_tab' => false,
                'is_active' => true,
            ],
            'microcopy' => 'Konsultasi tidak menggantikan proses verifikasi, analisis kelayakan, atau ketentuan resmi program.',
        ],
    ],

    'fallback_images' => [
        'protection-monitoring' => 'assets/images/simulation/protection-monitoring.webp',
    ],

    /*
    |----------------------------------------------------------------------
    | Field formats — HANYA menentukan cara MENAMPILKAN angka (Rupiah/
    | hari/persentase/integer). Tidak berisi rumus, tidak berisi operator,
    | tidak berisi nilai turunan. Tidak dapat diubah admin.
    |----------------------------------------------------------------------
    */
    'field_formats' => [
        'assumptions' => [
            'operational_days.value' => 'days',
            'daily_result.value' => 'rupiah',
            'operating_cost.value' => 'rupiah',
            'vehicle_installment.value' => 'rupiah',
            'management_component.value' => 'percentage',
            'revenue_share.value' => 'percentage',
        ],
        'one-unit' => [
            'gross_operational_result.value' => 'rupiah',
            'operating_cost.value' => 'rupiah',
            'vehicle_obligation.value' => 'rupiah',
            'management_component.value' => 'percentage',
            'projected_partner_result.value' => 'percentage',
        ],
        'multiple-units' => [
            'gross_operational_result' => 'rupiah',
            'operating_cost' => 'rupiah',
            'vehicle_obligation' => 'rupiah',
            'management_component' => 'percentage',
            'projected_partner_result' => 'percentage',
        ],
    ],
];
