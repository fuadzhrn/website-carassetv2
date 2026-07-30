(function () {
    function initIcons() {
        if (typeof lucide === 'undefined' || typeof lucide.createIcons !== 'function') {
            return;
        }

        lucide.createIcons({
            attrs: {
                'stroke-width': 1.75,
            },
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initIcons);
    } else {
        initIcons();
    }
})();
