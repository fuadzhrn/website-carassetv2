(function () {
    var header = document.querySelector('[data-header]');

    if (!header) {
        return;
    }

    var SCROLL_THRESHOLD = 20;
    var ticking = false;

    function updateHeaderState() {
        if (window.scrollY > SCROLL_THRESHOLD) {
            header.classList.add('ca-header--scrolled');
        } else {
            header.classList.remove('ca-header--scrolled');
        }
        ticking = false;
    }

    function onScroll() {
        if (!ticking) {
            window.requestAnimationFrame(updateHeaderState);
            ticking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    updateHeaderState();
})();
