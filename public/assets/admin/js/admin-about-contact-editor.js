// Tentang & Kontak editor — presentation helpers only. Never validates
// legalitas/partners, never sends form/consultation data, never calls a
// map/geocoding API, never autosaves — server-side validation
// (UpdateAboutContactSectionRequest) remains the source of truth.
(function () {
    'use strict';

    var forms = document.querySelectorAll('[data-about-contact-section-form]');

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

    // --- Program option value: lowercase + dash/underscore hint -------------
    document.querySelectorAll('[data-program-value-input]').forEach(function (input) {
        input.addEventListener('blur', function () {
            input.value = input.value
                .trim()
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^a-z0-9_-]/g, '');
        });
    });

    // --- Map: warn when active but address/site status not confirmed -------
    document.querySelectorAll('.ca-admin-repeater-group').forEach(function (group) {
        var mapCheckbox = group.querySelector('input[name="content[map][is_active]"]');

        if (!mapCheckbox) {
            return;
        }

        var readySpan = group.querySelector('.ca-admin-field__helper strong');
        var isReady = readySpan && readySpan.textContent.trim() === 'Siap ditampilkan';

        var warning = document.createElement('p');
        warning.className = 'ca-admin-status-warning';
        warning.style.display = 'none';
        warning.textContent = 'Peta aktif tetapi alamat/status data website belum dikonfirmasi — peta tidak akan tampil di publik sampai keduanya siap.';
        group.appendChild(warning);

        function updateWarning() {
            warning.style.display = (mapCheckbox.checked && !isReady) ? 'block' : 'none';
        }

        mapCheckbox.addEventListener('change', updateWarning);
        updateWarning();
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
