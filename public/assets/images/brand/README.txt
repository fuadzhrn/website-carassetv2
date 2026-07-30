CarAsset — Logo Brand
======================

Folder ini menyimpan file logo RESMI CarAsset. Logo TIDAK dibuat, digambar
ulang, atau diinterpretasikan oleh developer/AI — file logo asli akan
dimasukkan MANUAL oleh pemilik proyek (klien/tim brand CarAsset).

FILE YANG WAJIB DIMASUKKAN MANUAL
----------------------------------
1. logo-horizontal.png
   Digunakan untuk header desktop.

2. logo-stacked.png
   Digunakan untuk area yang membutuhkan logo vertikal.

3. logo-icon.png
   Digunakan untuk tampilan ringkas atau kebutuhan ikon brand.

4. logo-on-dark.png
   Digunakan pada footer atau background gelap.

5. favicon.png
   Digunakan sebagai favicon website.

ATURAN PENGGUNAAN LOGO
------------------------
- Jangan mengubah warna logo.
- Jangan meregangkan (stretch) logo.
- Jangan memotong (crop) logo.
- Jangan memberi efek glow atau shadow berlebihan.
- Jaga clear space di sekeliling logo (jangan menempelkan elemen lain
  terlalu dekat dengan logo).
- Gunakan helper asset() setiap kali logo dipanggil dari Blade, jangan
  hardcode path absolut.

CONTOH PATH BLADE
------------------
<img src="{{ asset('assets/images/brand/logo-horizontal.png') }}" alt="CarAsset">

JIKA LOGO BELUM TERSEDIA
-------------------------
Selama file di atas belum dimasukkan, gunakan placeholder HTML yang rapi
(contoh: teks wordmark "CarAsset" dengan class .ca-placeholder-media dari
public/assets/css/base/global.css). JANGAN menampilkan broken image
(mis. tag <img> yang menunjuk ke file yang belum ada).
