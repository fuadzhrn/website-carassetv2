/**
 * CarAsset — Form Konsultasi (contact-form.js)
 *
 * Form ini SEKARANG submit sungguhan ke server (POST /konsultasi) —
 * validasi otoritatif selalu di server (StoreContactMessageRequest).
 * Script ini HANYA progressive enhancement: loading state, mencegah
 * double-submit, memindahkan fokus ke error pertama setelah render ulang
 * dari server, counter karakter, dan mengaktifkan tombol kirim hanya
 * setelah consent dicentang. TIDAK PERNAH mem-preventDefault submit,
 * TIDAK PERNAH mengirim via fetch, TIDAK PERNAH menyentuh CSRF. Form
 * tetap bisa dikirim tanpa JavaScript sama sekali.
 */
(function () {
    var form = document.querySelector('[data-contact-form]');

    if (!form) {
        return;
    }

    // --- Focus first invalid field after a server-side re-render ----------
    var firstInvalid = form.querySelector('[aria-invalid="true"]');
    if (firstInvalid) {
        firstInvalid.focus();
    }

    // --- Character counter for the message field ---------------------------
    var messageField = form.querySelector('[data-message-counter]');
    if (messageField) {
        var max = parseInt(messageField.getAttribute('maxlength'), 10) || 3000;
        var counter = document.createElement('p');
        counter.className = 'ca-field__help';
        counter.setAttribute('data-message-counter-display', '');

        messageField.insertAdjacentElement('afterend', counter);

        var updateCounter = function () {
            counter.textContent = messageField.value.length + ' / ' + max + ' karakter';
        };

        messageField.addEventListener('input', updateCounter);
        updateCounter();
    }

    // --- Enable submit only once consent is checked -------------------------
    var consentField = form.querySelector('#contact-consent');
    var submitButton = form.querySelector('[data-contact-submit]');

    if (consentField && submitButton && !submitButton.disabled) {
        var syncSubmitState = function () {
            submitButton.disabled = !consentField.checked;
            submitButton.setAttribute('aria-disabled', consentField.checked ? 'false' : 'true');
        };

        consentField.addEventListener('change', syncSubmitState);
        syncSubmitState();
    }

    // --- Loading state + simple double-submit guard -------------------------
    form.addEventListener('submit', function () {
        if (form.dataset.submitting === 'true') {
            return;
        }

        form.dataset.submitting = 'true';

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.setAttribute('aria-disabled', 'true');
            submitButton.classList.add('is-loading');
        }
    });
})();
