(function () {
    'use strict';

    function isClickOutsideDialogPanel(dialog, event) {
        var rect = dialog.getBoundingClientRect();

        return (
            event.clientY < rect.top ||
            event.clientY > rect.top + rect.height ||
            event.clientX < rect.left ||
            event.clientX > rect.left + rect.width
        );
    }

    // Preview file before upload/replace using a local object URL only.
    document.querySelectorAll('[data-media-upload-form]').forEach(function (form) {
        var input = form.querySelector('[data-media-file-input]');
        var previewWrap = form.querySelector('[data-media-preview]');
        var previewImg = form.querySelector('[data-media-preview-image]');
        var currentObjectUrl = null;

        if (!input || !previewWrap || !previewImg) {
            return;
        }

        input.addEventListener('change', function () {
            if (currentObjectUrl) {
                URL.revokeObjectURL(currentObjectUrl);
                currentObjectUrl = null;
            }

            var file = input.files && input.files[0];

            if (!file) {
                previewWrap.hidden = true;
                previewImg.removeAttribute('src');
                return;
            }

            currentObjectUrl = URL.createObjectURL(file);
            previewImg.src = currentObjectUrl;
            previewWrap.hidden = false;
        });
    });

    // Delete confirmation dialog (media edit page).
    var openDeleteButton = document.querySelector('[data-open-delete-modal]');
    var deleteModal = document.querySelector('[data-delete-modal]');
    var closeDeleteButton = document.querySelector('[data-close-delete-modal]');

    if (openDeleteButton && deleteModal && typeof deleteModal.showModal === 'function') {
        openDeleteButton.addEventListener('click', function () {
            deleteModal.showModal();
        });
    }

    if (closeDeleteButton && deleteModal) {
        closeDeleteButton.addEventListener('click', function () {
            deleteModal.close();
        });
    }

    if (deleteModal) {
        deleteModal.addEventListener('click', function (event) {
            if (isClickOutsideDialogPanel(deleteModal, event)) {
                deleteModal.close();
            }
        });
    }
})();
