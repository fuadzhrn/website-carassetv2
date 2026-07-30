(function () {
    var dashboard = document.querySelector('[data-monitoring-dashboard]');

    if (!dashboard) {
        return;
    }

    var statusEl = dashboard.querySelector('[data-monitoring-status]');

    if (!statusEl) {
        return;
    }

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion || typeof IntersectionObserver === 'undefined') {
        return;
    }

    var states = [
        { text: 'Dalam Operasional', modifier: 'ca-operate__tile-status--green' },
        { text: 'Jadwal Perawatan', modifier: 'ca-operate__tile-status--slate' },
        { text: 'Laporan Tersedia', modifier: 'ca-operate__tile-status--green' },
    ];

    var index = 0;
    var intervalId = null;
    var ROTATE_INTERVAL_MS = 4500;

    function applyState(state) {
        statusEl.textContent = state.text;
        statusEl.classList.remove('ca-operate__tile-status--green', 'ca-operate__tile-status--slate');
        statusEl.classList.add(state.modifier);
    }

    function startRotating() {
        if (intervalId) {
            return;
        }

        intervalId = window.setInterval(function () {
            index = (index + 1) % states.length;
            applyState(states[index]);
        }, ROTATE_INTERVAL_MS);
    }

    var observer = new IntersectionObserver(
        function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    startRotating();
                }
            });
        },
        { threshold: 0.4 }
    );

    observer.observe(dashboard);
})();
