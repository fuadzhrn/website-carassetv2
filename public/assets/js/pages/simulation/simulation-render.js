/**
 * CarAsset — Simulation Renderer (simulation-render.js)
 *
 * Membaca window.CarAssetSimulationConfig dan mengisi setiap elemen
 * ber-atribut [data-simulation-field] dengan nilai dari config tersebut.
 * TIDAK melakukan perhitungan finansial apa pun — hanya membaca dan
 * menampilkan. Jika nilai null/tidak ditemukan, fallback Blade yang
 * sudah ada di HTML dibiarkan apa adanya (tidak ditimpa dengan 0/Rp0).
 */
(function () {
    var FALLBACK_TEXT = 'Menunggu angka final klien';

    /**
     * Mengambil nilai dari object berdasarkan path bertitik,
     * mis. getValueByPath(config, 'assumptions.operatingDays').
     * Mengembalikan undefined bila path tidak ditemukan — TIDAK
     * mengembalikan 0 atau string kosong sebagai pengganti.
     */
    function getValueByPath(object, path) {
        if (!object || !path) {
            return undefined;
        }

        return path.split('.').reduce(function (value, key) {
            if (value === null || value === undefined) {
                return undefined;
            }
            return value[key];
        }, object);
    }

    /**
     * Format angka sebagai Rupiah HANYA bila value adalah angka final
     * (bukan null/undefined) dan elemen meminta format currency.
     * Tidak pernah memformat null menjadi "Rp0".
     */
    function formatValue(value, format) {
        if (typeof value !== 'number' || Number.isNaN(value)) {
            return String(value);
        }

        if (format === 'currency') {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(value);
        }

        if (format === 'days') {
            return value + ' hari';
        }

        return new Intl.NumberFormat('id-ID').format(value);
    }

    function renderSimulationFields() {
        var config = window.CarAssetSimulationConfig;
        var fields = document.querySelectorAll('[data-simulation-field]');

        if (!fields.length) {
            return;
        }

        fields.forEach(function (field) {
            var path = field.getAttribute('data-simulation-field');
            var format = field.getAttribute('data-simulation-format');
            var value = getValueByPath(config, path);

            // null/undefined -> biarkan fallback Blade yang sudah ada.
            if (value === null || value === undefined || value === '') {
                field.textContent = field.getAttribute('data-simulation-fallback') || FALLBACK_TEXT;
                field.classList.add('is-pending');
                return;
            }

            field.textContent = formatValue(value, format);
            field.classList.remove('is-pending');
            field.classList.add('is-final');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderSimulationFields);
    } else {
        renderSimulationFields();
    }
})();
