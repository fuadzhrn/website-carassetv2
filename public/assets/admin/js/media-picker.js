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

    document.querySelectorAll('[data-media-picker]').forEach(function (picker) {
        var openButton = picker.querySelector('[data-media-picker-open]');
        var closeButton = picker.querySelector('[data-media-picker-close]');
        var clearButton = picker.querySelector('[data-media-picker-clear]');
        var modal = picker.querySelector('[data-media-picker-modal]');
        var input = picker.querySelector('[data-media-picker-input]');
        var previewWrap = picker.querySelector('[data-media-picker-preview]');

        if (!modal || !input || !previewWrap) {
            return;
        }

        if (openButton) {
            openButton.addEventListener('click', function () {
                if (typeof modal.showModal === 'function') {
                    modal.showModal();
                }
            });
        }

        if (closeButton) {
            closeButton.addEventListener('click', function () {
                modal.close();
            });
        }

        modal.addEventListener('click', function (event) {
            if (isClickOutsideDialogPanel(modal, event)) {
                modal.close();
            }
        });

        modal.querySelectorAll('[data-media-picker-item]').forEach(function (item) {
            item.addEventListener('click', function () {
                var id = item.getAttribute('data-media-id') || '';
                var url = item.getAttribute('data-media-url') || '';
                var alt = item.getAttribute('data-media-alt') || '';

                input.value = id;
                renderPreview(previewWrap, url, alt);

                if (clearButton) {
                    clearButton.hidden = false;
                }

                modal.close();
            });
        });

        if (clearButton) {
            clearButton.addEventListener('click', function () {
                input.value = '';
                renderEmptyPreview(previewWrap);
                clearButton.hidden = true;
            });
        }
    });

    function renderPreview(previewWrap, url, alt) {
        previewWrap.innerHTML = '';

        if (url) {
            var img = document.createElement('img');
            img.src = url;
            img.alt = alt;
            img.setAttribute('data-media-picker-image', '');
            previewWrap.appendChild(img);
        }

        var altLabel = document.createElement('span');
        altLabel.className = 'ca-admin-media-picker__alt';
        altLabel.setAttribute('data-media-picker-alt', '');
        altLabel.textContent = alt;
        previewWrap.appendChild(altLabel);
    }

    function renderEmptyPreview(previewWrap) {
        previewWrap.innerHTML =
            '<span class="ca-admin-media-picker__empty" data-media-picker-empty>Belum ada gambar dipilih</span>';
    }
})();
