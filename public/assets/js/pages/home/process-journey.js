(function () {
    var journey = document.querySelector('[data-process-journey]');

    if (!journey) {
        return;
    }

    var steps = journey.querySelectorAll('[data-process-step]');

    if (!steps.length) {
        return;
    }

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion || typeof IntersectionObserver === 'undefined') {
        return;
    }

    journey.classList.add('is-enhanced');

    var observer = new IntersectionObserver(
        function (entries, obs) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                var index = Array.prototype.indexOf.call(steps, entry.target);
                var delay = Math.max(index, 0) * 120;

                window.setTimeout(function () {
                    entry.target.classList.add('is-visible');
                }, delay);

                obs.unobserve(entry.target);
            });
        },
        { threshold: 0.3 }
    );

    steps.forEach(function (step) {
        observer.observe(step);
    });
})();
