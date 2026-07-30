/**
 * CarAsset — Sumber Data Tunggal Simulasi (simulation-config.js)
 *
 * SATU-SATUNYA tempat menyimpan nilai simulasi untuk seluruh halaman
 * Simulasi & Perlindungan. Jangan menulis angka simulasi di file Blade,
 * CSS, atau file JS lain — semua section membaca dari object ini.
 *
 * Materi CarAsset saat ini masih memiliki beberapa angka yang berbeda
 * antar dokumen (contoh: 27 vs 28 hari operasional, cicilan Rp5.100.000
 * vs Rp5.200.000, setoran Rp60.000 vs Rp70.000). Karena belum ada angka
 * final yang disepakati, SELURUH nilai di bawah ini sengaja diisi
 * `null`. Jangan mengisi null dengan salah satu angka yang berbeda,
 * jangan menghitung angka baru, dan jangan menyimpulkan angka mana yang
 * benar — itu keputusan klien, bukan keputusan front-end.
 *
 * Ketika angka final sudah dikonfirmasi klien, developer cukup mengganti
 * nilai `null` di bawah ini dengan angka yang sudah disepakati. Seluruh
 * halaman akan otomatis menampilkan angka tersebut tanpa mengubah Blade.
 */
window.CarAssetSimulationConfig = {
    // 'draft' = seluruh angka masih ilustrasi. Ubah proses rendering
    // hanya setelah status ini diubah bersama tim yang berwenang.
    status: 'draft',
    label: 'Contoh tampilan — menunggu angka final klien',

    // Asumsi operasional dasar yang memengaruhi seluruh simulasi.
    // Lihat sections/assumptions.blade.php.
    assumptions: {
        operatingDays: null, // contoh perbedaan dokumen: 27 vs 28 hari — belum diputuskan
        dailyDeposit: null, // setoran/hasil operasional harian
        operationalCost: null, // biaya operasional
        monthlyInstallment: null, // contoh perbedaan dokumen: Rp5.100.000 vs Rp5.200.000
        managementShare: null, // komponen pengelolaan
        ownerShare: null, // pembagian hasil untuk mitra
    },

    // Skenario 1/5/10 unit. unitCount BUKAN hasil simulasi — ini nama
    // skala yang sudah pasti (1, 5, 10), sehingga boleh tampil sebagai
    // angka meski nilai lain di bawahnya masih null. Jangan pernah
    // mengisi nilai skenario dengan (nilai 1 unit × jumlah unit) karena
    // struktur biaya/pengelolaan tiap skala bisa berbeda.
    scenarios: {
        oneUnit: {
            unitCount: 1,
            label: 'Skala Awal',
            grossOperationalResult: null,
            operationalCost: null,
            installment: null,
            managementComponent: null,
            projectedOwnerResult: null,
        },

        fiveUnits: {
            unitCount: 5,
            label: 'Skala Pengembangan',
            grossOperationalResult: null,
            operationalCost: null,
            installment: null,
            managementComponent: null,
            projectedOwnerResult: null,
        },

        tenUnits: {
            unitCount: 10,
            label: 'Skala Armada',
            grossOperationalResult: null,
            operationalCost: null,
            installment: null,
            managementComponent: null,
            projectedOwnerResult: null,
        },
    },

    // Lapisan perlindungan & monitoring. Nilai berupa string status,
    // bukan klaim cakupan spesifik (nama asuransi, periode garansi,
    // dsb.) sampai dikonfirmasi klien.
    protection: {
        insurance: 'Menunggu konfirmasi final',
        warranty: 'Menunggu konfirmasi final',
        gps: 'Menunggu konfirmasi final',
        monitoring: 'Menunggu konfirmasi final',
        maintenance: 'Menunggu konfirmasi final',
        reporting: 'Menunggu konfirmasi final',
    },
};
