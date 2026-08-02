// Draft/Preview/Publish/Revision workflow — presentation helpers only.
// Every action (Save Draft, Publish, Discard, Restore) is a real
// server-side form submission; nothing here uses fetch/AJAX, changes
// workflow state locally, or bypasses validation.
(function () {
    'use strict';

    // --- Confirm dialogs (Publish/Discard/Restore) — native <dialog> -------
    document.querySelectorAll('[data-confirm-dialog]').forEach(function (dialog) {
        var opener = document.querySelector('[data-confirm-dialog-open="' + dialog.id + '"]');

        if (opener) {
            opener.addEventListener('click', function () {
                if (typeof dialog.showModal === 'function') {
                    dialog.showModal();
                }
            });
        }

        dialog.querySelectorAll('[data-confirm-dialog-close]').forEach(function (closeButton) {
            closeButton.addEventListener('click', function () {
                dialog.close();
            });
        });

        dialog.addEventListener('click', function (event) {
            var rect = dialog.getBoundingClientRect();
            var clickedOutside =
                event.clientY < rect.top ||
                event.clientY > rect.top + rect.height ||
                event.clientX < rect.left ||
                event.clientX > rect.left + rect.width;

            if (clickedOutside) {
                dialog.close();
            }
        });

        // Prevent double-submit on the confirm form itself.
        dialog.querySelectorAll('form').forEach(function (form) {
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
        });
    });

    // --- Warn before opening Preview if the section form is dirty -----------
    document.querySelectorAll('.ca-admin-home-form').forEach(function (form) {
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

        var panel = form.closest('.ca-admin-home-panel');
        var previewLink = panel ? panel.querySelector('.ca-admin-section-action-bar a[target="_blank"]') : null;

        if (previewLink) {
            previewLink.addEventListener('click', function (event) {
                if (isDirty && !window.confirm('Form belum disimpan sebagai Draft. Buka Preview tanpa menyimpan?')) {
                    event.preventDefault();
                }
            });
        }
    });
})();
