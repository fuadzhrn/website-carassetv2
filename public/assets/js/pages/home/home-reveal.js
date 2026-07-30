(function () {
    var targets = document.querySelectorAll('[data-reveal]');

    if (!targets.length) {
        return;
    }

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion || typeof IntersectionObserver === 'undefined') {
        return;
    }

    targets.forEach(function (target) {
        target.classList.add('is-enhanced');
    });

    var observer = new IntersectionObserver(
        function (entries, obs) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                obs.unobserve(entry.target);
            });
        },
        { threshold: 0.2 }
    );

    targets.forEach(function (target) {
        observer.observe(target);
    });
})();
