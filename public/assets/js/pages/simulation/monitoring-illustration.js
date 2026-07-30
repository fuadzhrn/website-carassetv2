(function () {
    var panel = document.querySelector('[data-monitoring-panel]');

    if (!panel) {
        return;
    }

    var tabs = panel.querySelectorAll('[data-monitoring-tab]');
    var rows = panel.querySelectorAll('[data-monitoring-content]');

    if (!tabs.length || !rows.length) {
        return;
    }

    function setActive(key) {
        tabs.forEach(function (tab) {
            var isActive = tab.getAttribute('data-monitoring-tab') === key;
            tab.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });

        rows.forEach(function (row) {
            row.classList.toggle('is-active', row.getAttribute('data-monitoring-content') === key);
        });
    }

    /* Progressive enhancement: HTML/CSS default menampilkan semua baris
       (tetap terbaca tanpa JavaScript). JS baru mengaktifkan mode
       satu-baris-aktif setelah script berjalan. */
    panel.classList.add('is-enhanced');
    setActive(tabs[0].getAttribute('data-monitoring-tab'));

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            setActive(tab.getAttribute('data-monitoring-tab'));
        });
    });
})();
