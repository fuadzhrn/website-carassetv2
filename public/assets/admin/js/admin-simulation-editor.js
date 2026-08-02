// Simulasi & Perlindungan editor — formatting/preview helpers ONLY.
// This file never computes, sums, multiplies, or derives any simulation
// number; it only reflects what the admin already typed back as a
// formatted Rupiah/hari/persen string for readability, and helps the
// admin notice an incomplete "confirmed" submission before saving
// (server-side validation remains the real source of truth either way).
(function () {
    'use strict';

    var forms = document.querySelectorAll('[data-simulation-section-form]');
    var rupiahFormatter = null;
    var decimalFormatter = null;

    try {
        rupiahFormatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        });
        decimalFormatter = new Intl.NumberFormat('id-ID');
    } catch (error) {
        rupiahFormatter = null;
        decimalFormatter = null;
    }

    function formatPreview(rawValue, format) {
        if (rawValue === '' || rawValue === null || typeof rawValue === 'undefined') {
            return null;
        }

        var numeric = Number(rawValue);

        if (Number.isNaN(numeric)) {
            return null;
        }

        if (format === 'rupiah') {
            return rupiahFormatter ? rupiahFormatter.format(numeric) : 'Rp' + numeric;
        }

        if (format === 'days') {
            return (decimalFormatter ? decimalFormatter.format(numeric) : String(numeric)) + ' hari';
        }

        if (format === 'percentage') {
            return numeric.toString().replace('.', ',') + '%';
        }

        return decimalFormatter ? decimalFormatter.format(numeric) : String(numeric);
    }

    // --- Numeric preview (Pratinjau Format Data) ----------------------------
    document.querySelectorAll('[data-numeric-field]').forEach(function (field) {
        var format = field.getAttribute('data-numeric-format');
        var input = field.querySelector('[data-numeric-input]');
        var preview = field.querySelector('[data-numeric-preview] [data-numeric-preview-value]');
        var previewWrapper = field.querySelector('[data-numeric-preview]');

        if (!input || !preview || format === 'null' || !format) {
            return;
        }

        function updatePreview() {
            var formatted = formatPreview(input.value, format);

            if (formatted === null) {
                preview.textContent = 'Belum diisi';
                previewWrapper.classList.add('is-pending');
            } else {
                preview.textContent = formatted;
                previewWrapper.classList.remove('is-pending');
            }
        }

        input.addEventListener('input', updatePreview);
        updatePreview();
    });

    // --- Confirmed-but-incomplete hint (client-side notice only) -----------
    document.querySelectorAll('[data-status-field]').forEach(function (statusField) {
        var radios = statusField.querySelectorAll('input[type="radio"]');
        var form = statusField.closest('form');

        if (!radios.length || !form) {
            return;
        }

        var warning = document.createElement('p');
        warning.className = 'ca-admin-status-warning';
        warning.style.display = 'none';
        warning.textContent = 'Status "Telah Dikonfirmasi" dipilih, tetapi beberapa nilai angka pada section ini masih kosong. Server akan menolak penyimpanan sampai seluruh nilai utama terisi.';
        statusField.appendChild(warning);

        function checkCompleteness() {
            var confirmedRadio = statusField.querySelector('input[type="radio"][value="confirmed"]');
            var isConfirmed = confirmedRadio && confirmedRadio.checked;

            if (!isConfirmed) {
                warning.style.display = 'none';
                return;
            }

            var numericInputs = form.querySelectorAll('[data-numeric-input]');
            var hasEmpty = Array.prototype.some.call(numericInputs, function (input) {
                return input.value === '';
            });

            warning.style.display = hasEmpty ? 'block' : 'none';
        }

        radios.forEach(function (radio) {
            radio.addEventListener('change', checkCompleteness);
        });

        form.querySelectorAll('[data-numeric-input]').forEach(function (input) {
            input.addEventListener('input', checkCompleteness);
        });

        checkCompleteness();
    });

    // --- CTA destination-type show/hide + anchor <select> filtering --------
    document.querySelectorAll('[data-cta-fields]').forEach(function (fieldset) {
        var typeSelect = fieldset.querySelector('[data-cta-destination-type]');
        var routeSelect = fieldset.querySelector('[data-cta-route-name]');
        var anchorSelect = fieldset.querySelector('[data-cta-anchor]');
        var internalGroup = fieldset.querySelector('[data-cta-group="internal"]');
        var externalGroup = fieldset.querySelector('[data-cta-group="external"]');
        var allowedAnchors = {};

        try {
            allowedAnchors = JSON.parse(fieldset.getAttribute('data-allowed-anchors') || '{}');
        } catch (error) {
            allowedAnchors = {};
        }

        function updateVisibility() {
            var type = typeSelect ? typeSelect.value : 'internal';

            if (internalGroup) {
                internalGroup.classList.toggle('is-visible', type === 'internal');
            }
            if (externalGroup) {
                externalGroup.classList.toggle('is-visible', type === 'external');
            }
        }

        function rebuildAnchorOptions(preserveValue) {
            if (!anchorSelect || !routeSelect) {
                return;
            }

            var anchors = allowedAnchors[routeSelect.value] || [];
            var previous = preserveValue !== undefined ? preserveValue : anchorSelect.value;

            anchorSelect.innerHTML = '';

            var emptyOption = document.createElement('option');
            emptyOption.value = '';
            emptyOption.textContent = 'Tidak ada';
            anchorSelect.appendChild(emptyOption);

            anchors.forEach(function (anchor) {
                var option = document.createElement('option');
                option.value = anchor;
                option.textContent = anchor;
                if (anchor === previous) {
                    option.selected = true;
                }
                anchorSelect.appendChild(option);
            });
        }

        if (typeSelect) {
            typeSelect.addEventListener('change', updateVisibility);
        }

        if (routeSelect) {
            routeSelect.addEventListener('change', function () {
                rebuildAnchorOptions('');
            });
        }

        updateVisibility();
    });

    // --- Character counters for fields with maxlength ----------------------
    document.querySelectorAll('.ca-admin-home-form [maxlength]').forEach(function (field) {
        var max = parseInt(field.getAttribute('maxlength'), 10);

        if (!max) {
            return;
        }

        var counter = document.createElement('p');
        counter.className = 'ca-admin-field__helper';
        counter.setAttribute('data-char-counter', '');

        field.insertAdjacentElement('afterend', counter);

        var updateCounter = function () {
            counter.textContent = field.value.length + ' / ' + max + ' karakter';
        };

        field.addEventListener('input', updateCounter);
        updateCounter();
    });

    // --- Unsaved-changes warning per form -----------------------------------
    forms.forEach(function (form) {
        var isDirty = false;

        form.addEventListener('input', function () {
            isDirty = true;
        });

        form.addEventListener('change', function () {
            isDirty = true;
        });

        form.addEventListener('submit', function () {
            isDirty = false;
        });

        window.addEventListener('beforeunload', function (event) {
            if (!isDirty) {
                return;
            }

            event.preventDefault();
            event.returnValue = '';
        });
    });
})();
