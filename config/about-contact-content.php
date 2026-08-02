<?php

/*
|--------------------------------------------------------------------------
| CarAsset — Tentang & Kontak Page Fallback Content
|--------------------------------------------------------------------------
|
| Salinan terstruktur dan akurat dari konten yang SUDAH ADA di
| resources/views/pages/about-contact/sections/*.blade.php pada saat
| PROMPT 21 ditulis — tidak ada narasi baru, tidak ada badan usaha, tidak
| ada nomor legalitas, tidak ada partner, tidak ada FAQ, tidak ada alamat,
| dan tidak ada map yang dikarang.
|
| KEPUTUSAN AUDIT PENTING (dibaca sebelum mengubah):
|
| 1) about.tagline sengaja null di sini, BUKAN "Mobil Bekerja. Aset
|    Bertumbuh." — strip dekoratif tagline di Blade lama menyalin teks
|    yang identik dengan config('site-settings...brand.tagline') default
|    (dipakai juga oleh footer). Untuk menghindari dua sumber kebenaran
|    tagline brand (sesuai semangat larangan "dua sumber data kontak"),
|    presenter publik memakai about.tagline HANYA sebagai override; bila
|    null/kosong, jatuh ke site_settings.brand.tagline (sumber yang sama
|    dipakai footer).
|
| 2) vision.editorial_status & mission.editorial_status = 'draft' — teks
|    lama di Blade secara eksplisit disertai catatan "Redaksi visi/misi
|    menunggu persetujuan final perusahaan", yaitu pengakuan pertama-pihak
|    bahwa redaksi ini BELUM resmi. Sesuai aturan draft PROMPT 21, redaksi
|    ini tetap disalin sebagai fallback (bukan dihapus/diganti null) tapi
|    TIDAK ditampilkan sebagai pernyataan resmi di publik selama masih
|    draft — publik menampilkan pesan umum sebagai gantinya.
|
| 3) legal.data_status = 'draft' — entity_name & registration_number di
|    Blade lama HANYA berisi teks placeholder literal ("Menunggu data
|    resmi perusahaan"), bukan data asli, sehingga tetap null di sini.
|    registered_address, SEBALIKNYA, adalah alamat NYATA (ditandai class
|    `ca-legal__value--filled` yang berbeda dari 3 baris placeholder
|    lainnya) — nilai ini disalin apa adanya dan presenter publik
|    menampilkannya independen dari legal.data_status (lihat komentar di
|    PageController), karena tidak ada indikasi apa pun bahwa alamat ini
|    dipersengketakan.
|
| 4) partners = [] dan legal.documents = [] — 4 kotak "Logo Partner Resmi"
|    di Blade lama adalah placeholder generik (bukan nama partner nyata),
|    dan baris "Dokumen Pendukung" juga hanya placeholder. Tidak ada
|    partner/dokumen nyata untuk dipindahkan.
|
| 5) contact-form.form.title diisi SAMA dengan title section (bukan judul
|    terpisah) — desain lama hanya punya SATU <x-section-heading> yang
|    melayani baik "section" maupun "form", tidak ada judul kedua yang
|    terpisah. Presenter publik hanya merender title utama sekali (tidak
|    duplikat), form.title disimpan agar validasi "required" pada schema
|    tetap terpenuhi tanpa mengarang teks baru.
|
| 6) Informasi kontak (WhatsApp/email/alamat/jam layanan) TIDAK disimpan
|    di sini sama sekali — tetap satu-satunya sumber di site_settings via
|    SettingsService, sesuai instruksi eksplisit PROMPT 21.
|
| 7) map.embed_url adalah URL Google Maps embed NYATA yang sudah ada di
|    Blade lama (disalin apa adanya, host www.google.com, path
|    /maps/embed — lolos whitelist AllowedMapEmbedUrl). map.is_active
|    dibiarkan true (desain lama memang selalu menampilkan peta), tapi
|    presenter publik TETAP menggerbanginya di belakang syarat tambahan:
|    contact.address terisi DAN site.data_status === 'confirmed' (lihat
|    PageController::presentContactForm()) — site.data_status berstatus
|    'draft' secara default, sehingga peta TIDAK akan tampil sampai admin
|    benar-benar mengonfirmasi status data website, sesuai aturan
|    eksplisit PROMPT 21 meskipun map.is_active bernilai true.
*/

return [
    'sections' => [

        'about' => [
            'eyebrow' => 'Tentang CarAsset',
            'title' => 'Menghubungkan Kepemilikan Kendaraan dengan Pengelolaan yang Produktif.',
            'tagline' => null,
            'narrative' => "CarAsset adalah platform kemitraan kepemilikan kendaraan produktif yang menghubungkan mitra, kendaraan, dan pengelolaan operasional dalam satu ekosistem.\n\nMelalui pendekatan Own–Operate–Grow, CarAsset membantu mitra memahami proses kepemilikan, pengelolaan kendaraan, monitoring operasional, serta peluang pengembangan aset secara bertahap sesuai ketentuan program.",
            'positioning_statement' => "Bukan sekadar memiliki kendaraan.\nCarAsset membantu membuat aset tetap bekerja.",

            'image_media_id' => null,
            'image_alt' => '',

            'primary_cta' => [
                'label' => 'Kenali Program Kemitraan',
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

        // Tidak ada eyebrow/title/description tingkat section pada desain
        // aktual — blok visi dan blok misi masing-masing punya eyebrow
        // sendiri ("Arah Visi CarAsset"/"Arah Misi CarAsset", dipetakan
        // ke vision.label/mission.label). Field section-level tetap ada
        // untuk kelengkapan skema tapi tidak dirender (tidak ada slot UI).
        'vision-mission-values' => [
            'eyebrow' => null,
            'title' => null,
            'description' => null,

            'vision' => [
                'label' => 'Arah Visi CarAsset',
                'direction' => null,
                'statement' => 'Membangun ekosistem kendaraan produktif yang menghubungkan kepemilikan, pengelolaan, dan pertumbuhan aset secara profesional dan berkelanjutan.',
                'editorial_status' => 'draft',
            ],

            'mission' => [
                'label' => 'Arah Misi CarAsset',
                'intro' => null,
                'items' => [
                    ['item_key' => 'mission-1', 'text' => 'Membantu mitra memahami dan membangun kepemilikan kendaraan produktif.', 'is_active' => true, 'sort_order' => 1],
                    ['item_key' => 'mission-2', 'text' => 'Mengembangkan pengelolaan operasional yang terstruktur dan transparan.', 'is_active' => true, 'sort_order' => 2],
                    ['item_key' => 'mission-3', 'text' => 'Mendukung pertumbuhan aset melalui sistem kemitraan yang bertahap.', 'is_active' => true, 'sort_order' => 3],
                ],
                'editorial_status' => 'draft',
            ],

            'values' => [
                'trust' => [
                    'title' => 'Trust',
                    'description' => 'Membangun hubungan melalui keterbukaan informasi, proses yang jelas, dan komunikasi yang bertanggung jawab.',
                    'is_active' => true,
                ],
                'growth' => [
                    'title' => 'Growth',
                    'description' => 'Mendorong pengembangan kepemilikan dan kapasitas mitra secara bertahap sesuai kondisi program.',
                    'is_active' => true,
                ],
                'productive' => [
                    'title' => 'Productive',
                    'description' => 'Menempatkan kendaraan sebagai aset yang dirancang untuk tetap aktif dan dikelola secara terstruktur.',
                    'is_active' => true,
                ],
                'partnership' => [
                    'title' => 'Partnership',
                    'description' => 'Membangun kerja sama yang menempatkan peran, tanggung jawab, dan tujuan mitra secara jelas.',
                    'is_active' => true,
                ],
            ],
        ],

        'legal-partners' => [
            'eyebrow' => 'Legalitas & Kolaborasi',
            'title' => 'Informasi Perusahaan yang Transparan dan Terverifikasi.',
            'description' => 'Informasi legalitas, badan usaha, dan partner akan ditampilkan setelah dokumen serta materi resmi disampaikan dan disetujui oleh perusahaan.',

            'legal' => [
                'data_status' => 'draft',
                'status_note' => null,
                'entity_name' => null,
                'registration_number' => null,
                'registered_address' => 'Gajah Mada Tower, Lt. 19-01, Jl. Gajah Mada No.19-26, Kota Jakarta Pusat, DKI Jakarta 10130',
                'documents' => [],
            ],

            'partners' => [],
            'partner_note' => 'Logo dan informasi partner akan ditampilkan setelah memperoleh aset dan persetujuan resmi.',
        ],

        'faq' => [
            'eyebrow' => 'FAQ Utama',
            'title' => 'Pertanyaan yang Sering Diajukan.',
            'description' => 'Jawaban ringkas atas pertanyaan umum seputar program CarAsset. Detail lebih lanjut selalu tersedia melalui konsultasi langsung.',

            'items' => [
                ['item_key' => 'faq-1', 'question' => 'Apakah kendaraan menjadi milik mitra?', 'answer' => 'Program CarAsset dirancang dengan struktur kepemilikan kendaraan oleh mitra sesuai dokumen, proses pembiayaan, dan ketentuan program yang disepakati. Detail kepemilikan dijelaskan dalam konsultasi dan dokumen kerja sama.', 'is_active' => true, 'sort_order' => 1],
                ['item_key' => 'faq-2', 'question' => 'Siapa yang mengelola operasional kendaraan?', 'answer' => 'CarAsset membantu mengelola kebutuhan operasional kendaraan sesuai program, termasuk pengelolaan driver, monitoring, perawatan, dan pelaporan. Ruang lingkup final mengikuti dokumen program.', 'is_active' => true, 'sort_order' => 2],
                ['item_key' => 'faq-3', 'question' => 'Apakah kendaraan mendapatkan garansi dan asuransi?', 'answer' => 'Perlindungan kendaraan, termasuk garansi dan asuransi, mengikuti jenis kendaraan, paket, pihak penyedia, serta ketentuan program. Detail cakupan menunggu konfirmasi resmi perusahaan.', 'is_active' => true, 'sort_order' => 3],
                ['item_key' => 'faq-4', 'question' => 'Bagaimana mitra memonitor kendaraan?', 'answer' => 'CarAsset merancang sistem monitoring dan pelaporan agar mitra memperoleh informasi operasional sesuai fitur dan ketentuan program. Bentuk sistem final akan mengikuti konfirmasi perusahaan.', 'is_active' => true, 'sort_order' => 4],
                ['item_key' => 'faq-5', 'question' => 'Bagaimana cara mendaftar sebagai Mitra Owner?', 'answer' => 'Calon Mitra Owner dapat memulai melalui konsultasi, memilih program, menyiapkan dokumen, serta menjalani proses verifikasi sesuai ketentuan yang berlaku.', 'is_active' => true, 'sort_order' => 5],
                ['item_key' => 'faq-6', 'question' => 'Bagaimana cara mengikuti Program Mitra Driver?', 'answer' => 'Calon Mitra Driver mengikuti proses pendaftaran, pemeriksaan dokumen, persiapan operasional, dan ketentuan lain yang ditetapkan dalam program. Skema kontribusi dan periode kepemilikan menunggu data final perusahaan.', 'is_active' => true, 'sort_order' => 6],
                ['item_key' => 'faq-7', 'question' => 'Apakah hasil operasional dijamin?', 'answer' => 'Tidak. Informasi dan simulasi yang ditampilkan merupakan ilustrasi. Hasil aktual dapat berbeda karena dipengaruhi kondisi operasional, pembiayaan, biaya, perawatan, kondisi pasar, dan ketentuan program.', 'is_active' => true, 'sort_order' => 7],
                ['item_key' => 'faq-8', 'question' => 'Di mana saya dapat memperoleh informasi program yang lebih rinci?', 'answer' => 'Informasi rinci tersedia melalui konsultasi bersama tim CarAsset dan dokumen program yang telah disetujui perusahaan.', 'is_active' => true, 'sort_order' => 8],
            ],

            'closing_note' => null,
        ],

        'contact-form' => [
            'eyebrow' => null,
            'title' => 'Mulai Percakapan tentang Aset Produktif Anda.',
            'description' => 'Sampaikan program yang ingin dipelajari. Tim CarAsset akan membantu menjelaskan alur, dokumen, asumsi operasional, dan ketentuan program.',

            'contact_panel' => [
                'title' => 'Informasi Kontak',
                'description' => null,
            ],

            'form' => [
                // Sama dengan title di atas — lihat catatan #5 di header file ini.
                'title' => 'Mulai Percakapan tentang Aset Produktif Anda.',
                'description' => null,
                'submit_label' => 'Siapkan Pesan Konsultasi',
                'microcopy' => 'Form versi prototipe. Pengiriman belum aktif.',
                // Redaksi asli yang sudah ada & disetujui pada checkbox
                // consent di Blade lama (PROMPT 21) — ditambahkan sebagai
                // field CMS sesuai instruksi eksplisit PROMPT 22, bukan
                // redaksi baru.
                'consent_label' => 'Saya memahami bahwa informasi awal pada website merupakan ilustrasi dan detail final mengikuti konsultasi serta ketentuan program.',

                'program_options' => [
                    ['item_key' => 'program-1', 'label' => 'Mitra Owner', 'value' => 'mitra-owner', 'is_active' => true, 'sort_order' => 1],
                    ['item_key' => 'program-2', 'label' => 'Mitra Driver', 'value' => 'mitra-driver', 'is_active' => true, 'sort_order' => 2],
                    ['item_key' => 'program-3', 'label' => 'Simulasi 1 Unit', 'value' => 'simulasi-1-unit', 'is_active' => true, 'sort_order' => 3],
                    ['item_key' => 'program-4', 'label' => 'Simulasi 5 Unit', 'value' => 'simulasi-5-unit', 'is_active' => true, 'sort_order' => 4],
                    ['item_key' => 'program-5', 'label' => 'Simulasi 10 Unit', 'value' => 'simulasi-10-unit', 'is_active' => true, 'sort_order' => 5],
                    ['item_key' => 'program-6', 'label' => 'Konsultasi Umum', 'value' => 'konsultasi-umum', 'is_active' => true, 'sort_order' => 6],
                ],
            ],

            'map' => [
                'is_active' => true,
                'embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3093.878843926693!2d106.81870909999999!3d-6.1607189!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5df4fccc6e7%3A0x66b6d7b7ea79dc8a!2sGajah%20Mada%20Plaza%20Mall!5e1!3m2!1sid!2sid!4v1785448057387!5m2!1sid!2sid',
                'title' => 'Lokasi kantor CarAsset — Gajah Mada Tower',
            ],
        ],
    ],

    'fallback_images' => [
        'about' => 'assets/images/about-contact/about-carasset.webp',
    ],

    'limits' => [
        'mission_items' => 8,
        'legal_documents' => 10,
        'partners' => 12,
        'faq_items' => 20,
        'program_options' => 6,
    ],
];
