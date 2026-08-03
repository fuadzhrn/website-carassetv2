// Produk BYD ATTO 1 editor — presentation helpers only. Never fetches BYD
// data, never scrapes prices/specs, never generates or recolors images,
// never autosaves, never publishes via fetch/AJAX — server-side validation
// (UpdateProductBydAtto1SectionRequest) remains the source of truth.
(function () {
    'use strict';

    var forms = document.querySelectorAll('[data-product-section-form]');

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

    // --- Featured-variant radio: highlight the selected variant panel -------
    document.querySelectorAll('input[name="content[featured_variant]"]').forEach(function (radio) {
        function updatePanelState() {
            var panel = radio.closest('.ca-admin-variant-panel');

            if (panel) {
                panel.classList.toggle('is-featured', radio.checked);
            }
        }

        radio.addEventListener('change', function () {
            document.querySelectorAll('input[name="content[featured_variant]"]').forEach(function (otherRadio) {
                var otherPanel = otherRadio.closest('.ca-admin-variant-panel');

                if (otherPanel) {
                    otherPanel.classList.toggle('is-featured', otherRadio.checked);
                }
            });
        });

        updatePanelState();
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
