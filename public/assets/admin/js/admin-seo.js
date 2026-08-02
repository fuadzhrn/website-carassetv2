// SEO editor — character counters, live search-result preview, and
// unsaved-changes guarding ONLY. Every save/publish/discard action stays
// a real server-side form submission; nothing here uses fetch/AJAX,
// generates title/description text, computes an SEO score, or calls any
// external API.
(function () {
    'use strict';

    var form = document.querySelector('[data-seo-form]');

    if (!form) {
        return;
    }

    var titleInput = document.getElementById('seo-meta-title');
    var descriptionInput = document.getElementById('seo-meta-description');
    var canonicalInput = document.getElementById('seo-canonical-url');
    var robotsInputs = document.querySelectorAll('[data-seo-robots-input]');

    var automaticCanonical = canonicalInput ? canonicalInput.getAttribute('placeholder') : '';

    // --- Character counters -------------------------------------------------
    function statusFor(length, min, max, hardMax) {
        if (length === 0) {
            return { label: '', className: '' };
        }
        if (length < min) {
            return { label: 'Kurang Pendek', className: 'is-short' };
        }
        if (length <= max) {
            return { label: 'Rekomendasi', className: 'is-good' };
        }
        if (length <= hardMax) {
            return { label: 'Panjang', className: 'is-long' };
        }
        return { label: 'Terlalu Panjang', className: 'is-over' };
    }

    document.querySelectorAll('[data-seo-counter]').forEach(function (counter) {
        var targetId = counter.getAttribute('data-counter-for');
        var input = document.getElementById(targetId);
        var lengthEl = counter.querySelector('[data-seo-counter-length]');
        var labelEl = counter.querySelector('[data-seo-counter-label]');

        if (!input || !lengthEl || !labelEl) {
            return;
        }

        var min = parseInt(counter.getAttribute('data-recommended-min'), 10) || 0;
        var max = parseInt(counter.getAttribute('data-recommended-max'), 10) || 0;
        var hardMax = parseInt(counter.getAttribute('data-max-length'), 10) || 0;

        function update() {
            var length = input.value.length;
            var status = statusFor(length, min, max, hardMax);

            lengthEl.textContent = length;
            labelEl.textContent = status.label;
            counter.className = 'ca-admin-seo-counter ' + status.className;
        }

        input.addEventListener('input', update);
        update();
    });

    // --- Live search-result preview ------------------------------------------
    var previewTitle = document.querySelector('[data-seo-preview="title"]');
    var previewDescription = document.querySelector('[data-seo-preview="description"]');
    var previewCanonical = document.querySelector('[data-seo-preview="canonical"]');
    var previewRobots = document.querySelector('[data-seo-preview="robots"]');

    var serverPreview = {
        title: previewTitle ? previewTitle.textContent.trim() : '',
        description: previewDescription ? previewDescription.textContent.trim() : '',
        canonical: previewCanonical ? previewCanonical.textContent.trim() : '',
    };

    function updatePreview() {
        if (previewTitle) {
            var title = titleInput && titleInput.value.trim();
            previewTitle.textContent = title || serverPreview.title;
        }

        if (previewDescription) {
            var description = descriptionInput && descriptionInput.value.trim();
            previewDescription.textContent = description
                || serverPreview.description
                || 'Tidak ada meta description — mesin pencari dapat menampilkan cuplikan otomatis dari halaman.';
        }

        if (previewCanonical) {
            var canonical = canonicalInput && canonicalInput.value.trim();
            previewCanonical.textContent = canonical || automaticCanonical || serverPreview.canonical;
        }

        if (previewRobots) {
            var checkedRobots = document.querySelector('[data-seo-robots-input]:checked');
            var label = checkedRobots && checkedRobots.value === 'noindex,nofollow'
                ? 'Jangan Indeks Halaman'
                : 'Izinkan Pengindeksan';
            previewRobots.textContent = 'Robots: ' + label;
        }
    }

    if (titleInput) {
        titleInput.addEventListener('input', updatePreview);
    }
    if (descriptionInput) {
        descriptionInput.addEventListener('input', updatePreview);
    }
    if (canonicalInput) {
        canonicalInput.addEventListener('input', updatePreview);
    }
    robotsInputs.forEach(function (radio) {
        radio.addEventListener('change', updatePreview);
    });

    // --- Unsaved-changes tracking + warn before Preview ----------------------
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

    var previewLink = document.querySelector('[data-seo-preview-link]');
    if (previewLink) {
        previewLink.addEventListener('click', function (event) {
            if (isDirty && !window.confirm('Form belum disimpan sebagai Draft SEO. Buka Preview tanpa menyimpan?')) {
                event.preventDefault();
            }
        });
    }

    // --- Prevent double submit + loading state on main form -----------------
    form.addEventListener('submit', function () {
        if (form.dataset.submitting === 'true') {
            return;
        }
        form.dataset.submitting = 'true';

        var button = form.querySelector('button[type="submit"]');
        if (button) {
            button.disabled = true;
        }
    });
})();
