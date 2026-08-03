# Sumber Aset — Produk BYD ATTO 1

Dokumen ini mencatat asal-usul, status, dan hak pakai setiap aset gambar yang
dipakai pada halaman Produk BYD ATTO 1. Dokumen ini TIDAK menyertakan file
gambar itu sendiri — hanya metadata sumbernya.

## Ketentuan Umum

- Prioritas sumber resmi: (1) data resmi klien, (2) aset dealer/partner
  resmi, (3) situs resmi BYD Indonesia, (4) brosur resmi BYD Indonesia,
  (5) configurator resmi BYD Indonesia.
- Di luar sumber resmi (atas instruksi eksplisit pengguna, lihat catatan di
  bawah), gambar tetap wajib: berlisensi jelas (bukan hasil pencarian tanpa
  sumber), tidak berwatermark, tidak menampilkan tulisan harga, tidak
  menampilkan pelat nomor yang dapat diidentifikasi, bukan hasil AI
  generatif, dan tidak direkayasa warnanya (AI/CSS filter).
- Aset sementara wajib ditandai `temporary_public_photo` dan idealnya
  diganti dengan aset resmi klien sebelum production. Status
  `official`/`approved` TIDAK boleh dipakai sebelum klien menyetujui.

## Perubahan Kebijakan Sumber (dicatat eksplisit)

Sebelumnya galeri memakai 6 ilustrasi geometris generik buatan internal
(bukan foto). Atas instruksi eksplisit pengguna ("hapus saja saya butuh
gambar mobil yang real"), ilustrasi tersebut dihapus dan diganti dengan
foto nyata BYD ATTO 1. Pengguna diberi pilihan sumber (situs resmi BYD /
pengguna menyediakan file sendiri / sumber bebas di internet) dan memilih
**sumber bebas di internet**, sehingga verifikasi lisensi per gambar tetap
dilakukan (bukan sekadar hasil pencarian tanpa sumber) meskipun tidak
dibatasi ke domain resmi BYD.

## Daftar Aset — Foto Nyata (Dipakai)

| Nama Aset | Tujuan | Sumber | Tanggal Akses | Lokasi File Lokal | Status | Catatan Hak Pakai |
|---|---|---|---|---|---|---|
| BYD ATTO 1 — Tampak Depan (nyata) | Galeri (satu-satunya item saat ini) + fallback Hero | Wikimedia Commons — https://commons.wikimedia.org/wiki/File:BYD_ATTO_1.jpg | 2026-08-03 | `public/assets/images/products/byd-atto-1/gallery/byd-atto-1-real-front.webp` | temporary_public_photo | Lisensi **CC0 1.0 (domain publik)**. Fotografer: CalvinEriPratama. Diunggah 23 Juli 2025. Menampilkan mobil BYD ATTO 1 asli (warna putih) di sebuah pusat layanan BYD di Indonesia. Tidak ada tulisan harga, tidak ada pelat nomor yang terlihat. CC0 tidak mewajibkan atribusi, tetapi nama fotografer tetap dicatat sebagai praktik baik. |

`ProductBydAtto1ContentSeeder` menyalin file ini ke Media Library (disk
`public`, folder `media/product-byd-atto-1-gallery/`) secara idempotent
dan mereferensikan ID Media-nya (bukan path mentah) di
`product-hero.hero_media_id` dan `product-colors.gallery[].media_id`.
Karena ini Media Library sungguhan, admin dapat mengganti gambar ini
kapan saja lewat Media Library (upload pengganti atau ganti pilihan
media pada repeater) tanpa perlu mengubah kode.

## Kandidat yang DITOLAK (dicatat agar tidak dipakai ulang tanpa sadar)

Saat mencari foto tambahan untuk memperluas galeri, dua kandidat lain dari
Wikimedia Commons ditemukan tetapi **sengaja tidak dipakai** karena
melanggar aturan gambar proyek ini sendiri:

| Nama Berkas | Sumber | Alasan Ditolak |
|---|---|---|
| `2026_BYD_Atto_1_Premium.jpg` | Wikimedia Commons (foto pameran motor Bangkok, CC BY-SA 4.0, oleh Chanokchon) | Menampilkan tulisan harga besar ("459.900.-" Baht Thailand) pada kaca depan mobil di foto — melanggar larangan eksplisit "tidak ada gambar dengan tulisan harga", dan konteksnya pasar Thailand, bukan Indonesia. |
| `BYD_Atto_1_at_Universitas_Widyatama_Bandung.jpg` | Wikimedia Commons (CC BY 4.0, oleh MRWikiTankenTai) | Menampilkan pelat nomor kendaraan asli yang sebagian dapat dibaca — berisiko privasi/identifikasi pemilik kendaraan, melanggar larangan "tidak ada pelat nomor yang mengganggu". |

## Keterbatasan Saat Ini (transparan, bukan batasan teknis)

Galeri publik saat ini hanya berisi **satu** foto nyata karena hanya satu
foto bersih (tanpa harga, tanpa pelat nomor terlihat, dengan lisensi
jelas) yang berhasil ditemukan dari pencarian sumber bebas. Ini bukan
batasan kode — menambah `placeholder_media` di
`config/product-byd-atto-1-content.php` dengan foto resmi tambahan dari
klien (atau foto lain yang lolos verifikasi lisensi/konten) akan langsung
memperluas galeri tanpa perubahan kode lain.

## Folder Aset yang Disediakan (menunggu aset resmi klien)

- `public/assets/images/products/byd-atto-1/hero/` — foto hero kendaraan resmi.
- `public/assets/images/products/byd-atto-1/gallery/` — foto galeri kendaraan (lihat tabel di atas untuk yang sudah dipakai).
- `public/assets/images/products/byd-atto-1/colors/` — foto warna eksterior per varian warna (`byd-atto-1-color-[slug].webp`).
- `public/assets/images/products/byd-atto-1/features/` — foto/ilustrasi fitur resmi.
- `public/assets/images/products/byd-atto-1/placeholders/` — kosong (ilustrasi generik lama sudah dihapus).

Setiap aset baru yang ditambahkan ke folder-folder ini WAJIB ditambahkan
sebagai baris baru pada tabel di atas sebelum digunakan di Media Library,
mengikuti format yang sama (nama, tujuan, sumber, tanggal akses, lokasi
file, status, catatan hak pakai).
