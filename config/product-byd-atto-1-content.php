<?php

/*
|--------------------------------------------------------------------------
| CarAsset — Produk BYD ATTO 1 Fallback Content
|--------------------------------------------------------------------------
|
| PROMPT 27 (FINAL). Sama seperti fallback config 5 halaman sebelumnya —
| hanya dipakai sebagai default ketika section belum punya konten di
| database, BUKAN tempat mengedit konten (itu tugas admin lewat CMS).
| File ini TIDAK bisa diedit admin.
|
| KEPUTUSAN AUDIT PENTING (dibaca sebelum mengubah):
|
| 1) Belum ada data resmi varian/spesifikasi/fitur BYD ATTO 1 yang
|    dikonfirmasi klien. Sesuai instruksi eksplisit PROMPT 27 ("jangan
|    pernah mengarang varian/warna/spesifikasi/fitur/garansi/jarak
|    tempuh/kapasitas baterai/daya/harga/status ketersediaan"),
|    'variants' dan 'specification_categories'/'features' SENGAJA
|    dikosongkan ([]) dengan *_data_status 'draft' — publik menyembunyikan
|    section/bagian ini sepenuhnya sampai admin mengisi & mengonfirmasi
|    data asli.
|
| 2) 'gallery' berisi SATU foto NYATA BYD ATTO 1 (bukan lagi ilustrasi
|    generik) — foto dokumentasi publik berlisensi CC0 1.0 (domain
|    publik), diambil dari Wikimedia Commons atas instruksi eksplisit
|    pengguna untuk mengganti ilustrasi placeholder dengan gambar mobil
|    nyata. Sumber, lisensi, dan atribusi didokumentasikan lengkap di
|    PRODUCT-ASSET-SOURCES-BYD-ATTO-1.md. Dua kandidat foto lain dari
|    sumber yang sama SENGAJA ditolak karena melanggar aturan gambar
|    proyek ini sendiri: satu menampilkan tulisan harga (foto pameran di
|    Thailand), satu lagi menampilkan pelat nomor asli yang dapat
|    diidentifikasi (foto di Bandung) — keduanya tidak dipakai. Karena
|    hanya satu foto bersih yang ditemukan, galeri publik saat ini hanya
|    berisi satu item; ini BUKAN batasan teknis, hanya keterbatasan aset
|    yang tersedia secara bebas — foto resmi tambahan dari klien akan
|    memperluas galeri ini tanpa perubahan kode.
|
| 3) product-hero.hero_media_id JUGA diisi seeder dengan foto nyata yang
|    sama — supaya Hero tidak tampil kosong.
|
| 4) product-hero HANYA berisi teks editorial umum tentang identitas
|    produk (nama model, positioning sebagai kendaraan listrik untuk aset
|    produktif) — ini BUKAN data spesifikasi/harga, jadi aman diisi tanpa
|    menunggu konfirmasi klien.
|
| 5) Section "Keterkaitan dengan CarAsset" (product-carasset-integration)
|    DIHAPUS sepenuhnya atas instruksi eksplisit pengguna — halaman Produk
|    kini hanya memiliki 4 section terkunci: product-hero, product-colors,
|    product-variants, product-specifications.
|
| 6) Fitur "Daftar Warna" (pilihan warna kendaraan dengan swatch hex +
|    foto eksterior per warna) DIHAPUS sepenuhnya dari section
|    product-colors atas instruksi eksplisit pengguna (form repeater-nya
|    dinilai membuat halaman admin terlalu panjang/rumit untuk klien).
|    Section product-colors sekarang HANYA berisi galeri foto kendaraan
|    (label admin diubah menjadi "Galeri Kendaraan") — tidak ada lagi
|    colors/colors_data_status/colors_status_note/display_note di sini.
|
| 7) Tidak ada field harga di mana pun pada file ini.
*/

return [
    'page' => [
        'name' => 'Produk BYD ATTO 1',
        'slug' => 'product-byd-atto-1',
        'route_name' => 'product.byd-atto-1',
        'public_path' => '/produk/byd-atto-1',
    ],

    'sections' => [

        'product-hero' => [
            'eyebrow' => 'Kendaraan Listrik untuk Aset Produktif',
            'model_name' => 'BYD ATTO 1',
            'title' => 'BYD ATTO 1 — Kendaraan Listrik yang Siap Menjadi Bagian dari Aset Produktif Anda.',
            'tagline' => 'Efisien. Modern. Terhubung dengan Ekosistem CarAsset.',
            'description' => 'BYD ATTO 1 hadir sebagai pilihan kendaraan listrik yang dirancang untuk kebutuhan mobilitas sehari-hari. Dalam ekosistem CarAsset, kendaraan ini dapat menjadi bagian dari program kepemilikan dan pengelolaan aset produktif sesuai ketentuan program yang berlaku.',

            'hero_media_id' => null,
            'hero_alt' => '',

            'badges' => [],

            'primary_cta' => [
                'label' => 'Konsultasi Program Kemitraan',
                'destination_type' => 'internal',
                'route_name' => 'partnership',
                'anchor' => '',
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

            'microcopy' => 'Visual kendaraan sementara — aset resmi menunggu konfirmasi.',
        ],

        'product-colors' => [
            'eyebrow' => 'Galeri Kendaraan',
            'title' => 'Galeri BYD ATTO 1',
            'description' => 'Visual kendaraan berikut adalah foto dokumentasi publik BYD ATTO 1 dan bersifat sementara hingga aset resmi dari klien disetujui.',

            'gallery' => [],
            'gallery_note' => 'Foto kendaraan bersifat sementara (dokumentasi publik) hingga aset resmi dari klien disetujui.',
        ],

        'product-variants' => [
            'eyebrow' => 'Varian',
            'title' => 'Varian BYD ATTO 1',
            'description' => 'Informasi varian akan ditampilkan setelah data resmi varian, spesifikasi, dan fitur disetujui perusahaan.',

            'data_status' => 'draft',
            'status_note' => '',

            'variants' => [],
        ],

        'product-specifications' => [
            'eyebrow' => 'Spesifikasi & Fitur',
            'title' => 'Spesifikasi & Fitur BYD ATTO 1',
            'description' => 'Spesifikasi dan fitur akan ditampilkan setelah data resmi disetujui perusahaan.',

            'data_status' => 'draft',
            'status_note' => '',

            'specification_categories' => [],
            'features' => [],
        ],
    ],

    /*
    |------------------------------------------------------------------
    | Raw local-path fallback — hanya dipakai jika hero_media_id /
    | image_media_id sama sekali tidak bisa di-resolve ke sebuah Media
    | (misal Media dihapus manual dari database). Dalam kondisi normal,
    | ProductBydAtto1ContentSeeder sudah mengisi hero_media_id/
    | image_media_id dengan ID Media generik yang sebenarnya, sehingga
    | jalur ini jarang dipakai.
    |------------------------------------------------------------------
    */
    'fallback_images' => [
        'product-hero' => 'assets/images/products/byd-atto-1/gallery/byd-atto-1-real-front.webp',
    ],

    /*
    |------------------------------------------------------------------
    | Foto NYATA BYD ATTO 1 yang dibuat ProductBydAtto1ContentSeeder
    | sebagai baris Media (idempotent — dicocokkan lewat file_path,
    | bukan dibuat ulang tiap seeding). CC0 1.0 (domain publik), sumber
    | Wikimedia Commons — lihat PRODUCT-ASSET-SOURCES-BYD-ATTO-1.md.
    |------------------------------------------------------------------
    */
    'placeholder_media' => [
        [
            'key' => 'front',
            'file' => 'byd-atto-1-real-front.webp',
            'alt' => 'BYD ATTO 1 tampak depan-samping, warna putih, di sebuah pusat layanan BYD',
            'caption' => 'BYD ATTO 1 — tampak depan (Wikimedia Commons, CC0)',
            'view_label' => 'Tampak Depan',
        ],
    ],

    'limits' => [
        'hero_badges' => 4,
        'gallery' => 8,
        'variants' => 5,
        'variant_highlights' => 8,
        'variant_specs' => 12,
        'spec_categories' => 6,
        'spec_items_per_category' => 10,
        'feature_items' => 12,
    ],
];
