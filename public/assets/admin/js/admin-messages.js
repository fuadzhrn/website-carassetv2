(function () {
    'use strict';

    // --- Confirm dialog (delete) — native <dialog>, Escape/focus-trap free -
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
    });

    // --- Prevent double-submit on status-change forms -----------------------
    document.querySelectorAll('.ca-admin-message-detail__actions form').forEach(function (form) {
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
})();
