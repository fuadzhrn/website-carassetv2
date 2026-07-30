(function () {
    var nav = document.querySelector('[data-program-nav]');

    if (!nav) {
        return;
    }

    var navLinks = nav.querySelectorAll('[data-program-nav-link]');
    var targets = [
        document.getElementById('mitra-owner'),
        document.getElementById('mitra-driver'),
    ].filter(Boolean);

    if (!navLinks.length || !targets.length || typeof IntersectionObserver === 'undefined') {
        return;
    }

    function setActive(id) {
        navLinks.forEach(function (link) {
            var isActive = link.getAttribute('data-program-nav-link') === id;
            link.classList.toggle('is-active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'true');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    }

    var observer = new IntersectionObserver(
        function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    setActive(entry.target.id);
                }
            });
        },
        {
            root: null,
            rootMargin: '-160px 0px -55% 0px',
            threshold: 0,
        }
    );

    targets.forEach(function (target) {
        observer.observe(target);
    });
})();
