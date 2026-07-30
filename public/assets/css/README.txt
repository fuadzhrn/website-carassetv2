CarAsset — Struktur & Urutan Pemuatan CSS
============================================

FUNGSI SETIAP FOLDER
----------------------
base/
  Fondasi: reset, design token (variables), tipografi, utility class, dan
  aturan global situs. Tidak boleh berisi style section/halaman tertentu.

layouts/
  CSS untuk elemen struktural yang tampil di banyak halaman: header,
  footer, navigasi desktop. Satu file per elemen layout.

components/
  CSS untuk komponen Blade reusable: button, section-heading, icon-box,
  faq-item, stat-item, form-field, dll. Satu file per komponen bila
  memang punya style yang cukup untuk dipisah.

pages/{home,business,partnership,simulation,about-contact}/
  CSS khusus tiap section pada halaman terkait. Satu file CSS section
  HANYA dibuat pada tahap pengerjaan halaman itu sendiri, dan hanya jika
  section tersebut benar-benar butuh gaya di luar base/layouts/components.

URUTAN PEMUATAN CSS (WAJIB, di layouts/app.blade.php)
-------------------------------------------------------
1. base/reset.css
2. base/variables.css
3. base/typography.css
4. base/utilities.css
5. base/global.css
6. layouts/*.css      (header, footer, navigation — dimuat oleh halaman
                        yang memakainya)
7. components/*.css   (hanya yang dipakai oleh section pada halaman itu)
8. pages/{halaman}/*.css (CSS khusus section, urutan paling akhir agar
                        bisa override bila memang diperlukan)

ATURAN PENEMPATAN CSS
------------------------
- Jangan menulis seluruh CSS proyek ke dalam satu file besar.
- CSS section hanya dimuat pada halaman yang memakainya (jangan
  memuat CSS halaman Business di halaman Home, dst).
- Nama class memakai prefix "ca-" dan/atau pola BEM
  (ca-block__element--modifier) secara konsisten.
- Jangan menggunakan style inline pada Blade kecuali benar-benar
  diperlukan (mis. nilai dinamis dari data yang tidak bisa berupa class).
- Seluruh warna WAJIB diambil dari variabel di base/variables.css —
  jangan hardcode kode warna brand di file lain.
- Seluruh spacing utama (jarak antarseksi, padding container) WAJIB
  mengambil dari variabel spacing di base/variables.css.
- Hindari !important kecuali benar-benar diperlukan (mis. utility
  visibility yang harus selalu menang).
