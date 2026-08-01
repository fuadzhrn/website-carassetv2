(function () {
    'use strict';

    var STORAGE_KEY = 'ca-admin-sidebar-collapsed';

    var shell = document.querySelector('.ca-admin-shell');
    var toggle = document.querySelector('[data-sidebar-toggle]');

    function setCollapsed(collapsed) {
        if (!shell) {
            return;
        }

        shell.classList.toggle('is-collapsed', collapsed);

        if (toggle) {
            toggle.setAttribute('aria-expanded', String(!collapsed));
            toggle.setAttribute(
                'aria-label',
                collapsed ? 'Perluas sidebar' : 'Ciutkan sidebar'
            );
        }

        try {
            sessionStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
        } catch (error) {
            // sessionStorage tidak tersedia (mode privat dsb.) — abaikan, bukan data sensitif.
        }
    }

    if (shell && toggle) {
        try {
            if (sessionStorage.getItem(STORAGE_KEY) === '1') {
                setCollapsed(true);
            }
        } catch (error) {
            // abaikan bila sessionStorage tidak tersedia
        }

        toggle.addEventListener('click', function () {
            setCollapsed(!shell.classList.contains('is-collapsed'));
        });
    }

    document.querySelectorAll('[data-flash-close]').forEach(function (button) {
        button.addEventListener('click', function () {
            var flash = button.closest('[data-flash-message]');

            if (flash) {
                flash.remove();
            }
        });
    });
})();
