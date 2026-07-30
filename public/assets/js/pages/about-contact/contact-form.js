/**
 * CarAsset — Validasi front-end Form Konsultasi (contact-form.js)
 *
 * PENTING: Form ini BELUM terhubung ke backend, email, atau WhatsApp.
 * Integrasi pengiriman sungguhan (backend/API WhatsApp) akan dikerjakan
 * pada fase terpisah setelah sistem resmi tersedia. Script ini HANYA
 * memvalidasi input di sisi klien dan menampilkan status informatif —
 * tidak pernah mengirim request jaringan, menyimpan data, atau
 * menampilkan pesan "berhasil terkirim".
 */
(function () {
    var form = document.querySelector('[data-contact-form]');

    if (!form) {
        return;
    }

    var statusEl = form.querySelector('[data-contact-status]');

    var EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    // Longgar: menerima 08xx / 8xx / +628xx / 628xx dengan 8-13 digit setelah awalan.
    var WHATSAPP_PATTERN = /^(\+62|62|0)8[0-9]{7,12}$/;

    function getField(name) {
        return form.querySelector('[name="' + name + '"]');
    }

    function setError(field, message) {
        if (!field) {
            return;
        }

        field.setAttribute('aria-invalid', 'true');

        var errorEl = document.getElementById(field.id + '-error');
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.hidden = false;
        }
    }

    function clearError(field) {
        if (!field) {
            return;
        }

        field.removeAttribute('aria-invalid');

        var errorEl = document.getElementById(field.id + '-error');
        if (errorEl) {
            errorEl.textContent = '';
            errorEl.hidden = true;
        }
    }

    function setStatus(message, tone) {
        if (!statusEl) {
            return;
        }

        statusEl.textContent = message;
        statusEl.classList.remove('is-success', 'is-error');

        if (tone) {
            statusEl.classList.add(tone === 'error' ? 'is-error' : 'is-success');
        }
    }

    function validate() {
        var firstInvalid = null;
        var isValid = true;

        function markInvalid(field, message) {
            setError(field, message);
            isValid = false;
            if (!firstInvalid) {
                firstInvalid = field;
            }
        }

        var nameField = getField('name');
        if (nameField) {
            if (!nameField.value.trim()) {
                markInvalid(nameField, 'Nama lengkap wajib diisi.');
            } else {
                clearError(nameField);
            }
        }

        var whatsappField = getField('whatsapp');
        if (whatsappField) {
            var whatsappValue = whatsappField.value.trim().replace(/[\s-]/g, '');
            if (!whatsappValue) {
                markInvalid(whatsappField, 'Nomor WhatsApp wajib diisi.');
            } else if (!WHATSAPP_PATTERN.test(whatsappValue)) {
                markInvalid(whatsappField, 'Gunakan format nomor WhatsApp yang valid, contoh: 0812xxxxxxx.');
            } else {
                clearError(whatsappField);
            }
        }

        var emailField = getField('email');
        if (emailField) {
            var emailValue = emailField.value.trim();
            if (emailValue && !EMAIL_PATTERN.test(emailValue)) {
                markInvalid(emailField, 'Format email tidak valid.');
            } else {
                clearError(emailField);
            }
        }

        var programField = getField('program');
        if (programField) {
            if (!programField.value) {
                markInvalid(programField, 'Pilih jenis program terlebih dahulu.');
            } else {
                clearError(programField);
            }
        }

        var messageField = getField('message');
        if (messageField) {
            if (!messageField.value.trim()) {
                markInvalid(messageField, 'Pesan tidak boleh kosong.');
            } else {
                clearError(messageField);
            }
        }

        var consentField = getField('consent');
        if (consentField) {
            if (!consentField.checked) {
                markInvalid(consentField, 'Persetujuan informasi wajib dicentang.');
            } else {
                clearError(consentField);
            }
        }

        return { isValid: isValid, firstInvalid: firstInvalid };
    }

    form.addEventListener('submit', function (event) {
        // Backend belum tersedia — pengiriman selalu dicegah di sini.
        event.preventDefault();

        var result = validate();

        if (!result.isValid) {
            setStatus('Periksa kembali data yang belum sesuai pada form di atas.', 'error');
            if (result.firstInvalid) {
                result.firstInvalid.focus();
            }
            return;
        }

        // TIDAK mengirim request, TIDAK menyimpan data, TIDAK membuka
        // WhatsApp otomatis, dan TIDAK menampilkan pesan "berhasil terkirim"
        // karena belum ada backend yang terhubung. Form sengaja TIDAK
        // dikosongkan karena data belum benar-benar dikirim ke mana pun.
        setStatus('Form telah diperiksa, tetapi pengiriman belum aktif karena backend belum dihubungkan.', 'success');
    });
})();
