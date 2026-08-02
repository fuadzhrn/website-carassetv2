/**
 * CarAsset — Mobile navigation (mobile-navigation.js)
 *
 * Manages ONLY the open/closed state of the existing header nav panel —
 * it never builds new markup, never duplicates the nav links, and never
 * touches desktop behavior (CSS alone decides how the panel is
 * presented per breakpoint). Vanilla JS, no dependencies.
 */
(function () {
    'use strict';

    var toggle = document.querySelector('[data-mobile-menu-toggle]');
    var panel = document.querySelector('[data-mobile-nav-panel]');
    var overlay = document.querySelector('[data-mobile-nav-overlay]');
    var header = document.querySelector('[data-header]');

    if (!toggle || !panel) {
        return;
    }

    var OPEN_LABEL = toggle.getAttribute('data-label-open') || 'Buka menu navigasi';
    var CLOSE_LABEL = toggle.getAttribute('data-label-close') || 'Tutup menu navigasi';
    var MOBILE_MEDIA = window.matchMedia('(max-width: 1023px)');

    var isOpen = false;
    var scrollY = 0;

    function focusableElements() {
        return panel.querySelectorAll('a[href], button:not([disabled])');
    }

    function lockBodyScroll() {
        scrollY = window.scrollY || window.pageYOffset;
        document.body.style.position = 'fixed';
        document.body.style.top = '-' + scrollY + 'px';
        document.body.style.width = '100%';
        document.body.classList.add('ca-body--menu-open');
    }

    function unlockBodyScroll() {
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.width = '';
        document.body.classList.remove('ca-body--menu-open');
        window.scrollTo(0, scrollY);
    }

    function openMenu() {
        if (isOpen) {
            return;
        }

        isOpen = true;
        panel.classList.add('is-open');
        if (overlay) {
            overlay.classList.add('is-open');
        }
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', CLOSE_LABEL);
        toggle.classList.add('is-active');
        if (header) {
            header.classList.add('ca-header--menu-open');
        }
        lockBodyScroll();

        var firstLink = panel.querySelector('a[href]');
        if (firstLink) {
            firstLink.focus();
        }

        document.addEventListener('keydown', onKeydown);
    }

    function closeMenu(options) {
        if (!isOpen) {
            return;
        }

        isOpen = false;
        panel.classList.remove('is-open');
        if (overlay) {
            overlay.classList.remove('is-open');
        }
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', OPEN_LABEL);
        toggle.classList.remove('is-active');
        if (header) {
            header.classList.remove('ca-header--menu-open');
        }
        unlockBodyScroll();

        document.removeEventListener('keydown', onKeydown);

        var returnFocus = !options || options.returnFocus !== false;
        if (returnFocus) {
            toggle.focus();
        }
    }

    function onKeydown(event) {
        if (event.key === 'Escape' || event.key === 'Esc') {
            closeMenu();
            return;
        }

        // Simple focus trap while the panel behaves as a full-screen dialog.
        if (event.key === 'Tab') {
            var items = focusableElements();
            if (!items.length) {
                return;
            }

            var first = items[0];
            var last = items[items.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    }

    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', OPEN_LABEL);

    toggle.addEventListener('click', function () {
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    if (overlay) {
        overlay.addEventListener('click', function () {
            closeMenu();
        });
    }

    // Close when any link inside the panel is chosen (including anchors
    // that jump within the same page — the panel must not stay open).
    panel.querySelectorAll('a[href]').forEach(function (link) {
        link.addEventListener('click', function () {
            closeMenu({ returnFocus: false });
        });
    });

    // Reset state whenever the viewport crosses back to desktop, so a
    // menu left open on mobile never leaks into the desktop layout after
    // resize, and body scroll is never left locked.
    function handleViewportChange(event) {
        if (!event.matches) {
            closeMenu({ returnFocus: false });
        }
    }

    if (typeof MOBILE_MEDIA.addEventListener === 'function') {
        MOBILE_MEDIA.addEventListener('change', handleViewportChange);
    } else if (typeof MOBILE_MEDIA.addListener === 'function') {
        // Safari < 14 fallback.
        MOBILE_MEDIA.addListener(handleViewportChange);
    }
})();
