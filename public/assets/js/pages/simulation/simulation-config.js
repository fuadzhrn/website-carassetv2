/**
 * CarAsset — Sumber Data Tunggal Simulasi (simulation-config.js)
 *
 * SATU-SATUNYA tempat menyimpan nilai simulasi untuk seluruh halaman
 * Simulasi & Perlindungan. Jangan menulis angka simulasi di file Blade,
 * CSS, atau file JS lain — semua section membaca dari object ini.
 *
 * Sumber: "CarAsset — Product Knowledge & Business Scheme" (dokumen resmi
 * yang diberikan klien, halaman "PROYEKSI INCOME"). Angka 1 unit di bawah
 * adalah angka resmi dari dokumen tersebut.
 *
 * CATATAN — scenarios.fiveUnits & scenarios.tenUnits:
 * Dokumen sumber TIDAK memberi rincian resmi untuk skala 5 atau 10 unit
 * (skala leveraging dokumen adalah 1→3→9→27→81→243 unit, berbeda dari
 * skala 1/5/10 yang dipakai website ini). Atas keputusan eksplisit
 * pemilik proyek, nilai 5 dan 10 unit di bawah diisi dengan ESTIMASI
 * LINEAR (angka 1 unit dikalikan 5 dan 10) HANYA untuk memberi gambaran
 * kasar skala — BUKAN angka resmi terpisah dari klien. Setiap tampilan
 * nilai ini WAJIB disertai badge/label "Estimasi Linear — Bukan Angka
 * Resmi" di Blade (lihat sections/multiple-units.blade.php) agar tidak
 * disalahartikan sebagai proyeksi resmi. Ganti dengan angka resmi begitu
 * klien memberikan rincian khusus per skala.
 *
 * CATATAN LAIN:
 * - protection.*: dokumen sumber tidak membahas asuransi/garansi/GPS,
 *   sehingga tetap menunggu konfirmasi final.
 * - Kontribusi/setoran driver (Rp60.000 vs Rp70.000 pada skema Mitra
 *   Driver) TIDAK dibahas di dokumen ini (dokumen ini membahas skema
 *   Mitra Owner) — konflik tersebut belum terselesaikan, tidak diisi di sini.
 */
window.CarAssetSimulationConfig = {
    // Masih 'draft' — skenario 5/10 unit berisi ESTIMASI (bukan angka
    // resmi terkonfirmasi terpisah), sehingga halaman belum bisa
    // dianggap final sepenuhnya.
    status: 'draft',
    label: 'Contoh tampilan — sebagian angka bersumber dari dokumen resmi, skala 5/10 unit berupa estimasi linear',

    // Asumsi operasional dasar (ilustrasi 1 unit) — sumber: dokumen
    // "PROYEKSI INCOME", pendapatan bulanan dihitung atas 27 hari
    // operasional. Lihat sections/assumptions.blade.php.
    assumptions: {
        operatingDays: 27,
        dailyDeposit: 230000, // harga sewa/hasil operasional harian
        operationalCost: 500000, // biaya operasional per bulan
        monthlyInstallment: 5100000, // cicilan kendaraan per bulan
        managementShare: '40% dari hasil operasional (CarAsset)', // rasio bagi hasil, bukan nominal rupiah — dokumen belum merinci angka Rp-nya
        ownerShare: '60% dari hasil operasional (Mitra)', // rasio bagi hasil, bukan nominal rupiah — dokumen belum merinci angka Rp-nya
    },

    // Skenario 1/5/10 unit. unitCount BUKAN hasil simulasi — ini nama
    // skala yang sudah pasti (1, 5, 10), sehingga boleh tampil sebagai
    // angka meski nilai lain berupa estimasi.
    scenarios: {
        oneUnit: {
            unitCount: 1,
            label: 'Skala Awal',
            isEstimate: false, // angka resmi dari dokumen
            grossOperationalResult: 6210000, // pendapatan bulanan (27 hari x Rp230.000)
            operationalCost: 500000,
            installment: 5100000,
            managementComponent: '40% dari hasil operasional', // rasio, bukan nominal rupiah final
            projectedOwnerResult: '60% dari hasil operasional', // rasio, bukan nominal rupiah final
        },

        // ESTIMASI LINEAR (nilai 1 unit x 5) — lihat catatan di atas.
        fiveUnits: {
            unitCount: 5,
            label: 'Skala Pengembangan',
            isEstimate: true,
            grossOperationalResult: 31050000, // 6.210.000 x 5 — estimasi linear
            operationalCost: 2500000, // 500.000 x 5 — estimasi linear
            installment: 25500000, // 5.100.000 x 5 — estimasi linear
            managementComponent: '40% dari hasil operasional', // rasio diasumsikan tetap
            projectedOwnerResult: '60% dari hasil operasional', // rasio diasumsikan tetap
        },

        // ESTIMASI LINEAR (nilai 1 unit x 10) — lihat catatan di atas.
        tenUnits: {
            unitCount: 10,
            label: 'Skala Armada',
            isEstimate: true,
            grossOperationalResult: 62100000, // 6.210.000 x 10 — estimasi linear
            operationalCost: 5000000, // 500.000 x 10 — estimasi linear
            installment: 51000000, // 5.100.000 x 10 — estimasi linear
            managementComponent: '40% dari hasil operasional', // rasio diasumsikan tetap
            projectedOwnerResult: '60% dari hasil operasional', // rasio diasumsikan tetap
        },
    },

    // Lapisan perlindungan & monitoring. Dokumen sumber belum membahas
    // cakupan asuransi/garansi/GPS — tetap menunggu konfirmasi final.
    protection: {
        insurance: 'Menunggu konfirmasi final',
        warranty: 'Menunggu konfirmasi final',
        gps: 'Menunggu konfirmasi final',
        monitoring: 'Menunggu konfirmasi final',
        maintenance: 'Menunggu konfirmasi final',
        reporting: 'Menunggu konfirmasi final',
    },
};
