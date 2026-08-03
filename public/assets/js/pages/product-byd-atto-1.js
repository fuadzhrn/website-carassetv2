// Produk BYD ATTO 1 — public page progressive enhancement. Without this
// script, every gallery thumbnail already renders as a visible, labelled
// element (see product-colors.blade.php), so nothing is hidden — this only
// adds the ability to swap the shared stage image and mark the active
// thumbnail, entirely client-side. Buttons are native <button> elements,
// so Enter/Space already work without extra JS.
// Never recolors an image, never uses canvas/WebGL, never fetches
// anything, never uses localStorage/cookies, never uses innerHTML for
// CMS-supplied text (textContent only).
(function () {
    'use strict';

    // Last-resort safety net if a referenced Media file goes missing after
    // page load (e.g. deleted from disk outside the app) — swaps to the
    // one local placeholder guaranteed to exist, instead of leaving a
    // broken-image icon. Never fetches anything, never retried in a loop
    // (the `data-fallback-applied` guard stops a second error on the
    // fallback itself from recursing).
    var FALLBACK_IMAGE_SRC = '/assets/images/products/byd-atto-1/gallery/byd-atto-1-real-front.webp';

    function guardBrokenImage(img) {
        if (!img || img.tagName !== 'IMG') {
            return;
        }

        img.addEventListener('error', function () {
            if (img.dataset.fallbackApplied === '1') {
                return;
            }

            img.dataset.fallbackApplied = '1';
            img.src = FALLBACK_IMAGE_SRC;
        });
    }

    document.querySelectorAll('.ca-product-hero, .ca-product-colors, .ca-product-variants, .ca-product-specifications').forEach(function (section) {
        section.querySelectorAll('img').forEach(guardBrokenImage);
    });

    document.querySelectorAll('[data-product-gallery]').forEach(function (widget) {
        var stageImage = widget.querySelector('[data-product-gallery-image]');
        var caption = widget.querySelector('[data-product-gallery-caption]');
        var status = widget.querySelector('[data-product-gallery-status]');
        var thumbs = Array.from(widget.querySelectorAll('[data-product-gallery-thumb]'));

        if (!stageImage || thumbs.length === 0) {
            return;
        }

        thumbs.forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                var imageUrl = thumb.getAttribute('data-image');
                var imageAlt = thumb.getAttribute('data-alt') || '';
                var captionText = thumb.getAttribute('data-caption') || '';
                var isTemporary = thumb.getAttribute('data-temporary') === '1';

                if (imageUrl) {
                    stageImage.setAttribute('src', imageUrl);
                    stageImage.setAttribute('alt', imageAlt);
                }

                if (caption) {
                    caption.textContent = captionText;
                }

                if (status) {
                    status.textContent = 'Visual Sementara';
                    status.hidden = !isTemporary;
                }

                thumbs.forEach(function (otherThumb) {
                    var isActive = otherThumb === thumb;
                    otherThumb.classList.toggle('is-active', isActive);
                    otherThumb.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                });
            });
        });
    });
})();
