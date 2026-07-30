(function () {
    var journey = document.querySelector('[data-driver-journey]');

    if (!journey) {
        return;
    }

    var milestones = journey.querySelectorAll('[data-driver-milestone]');

    if (!milestones.length) {
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

                var index = Array.prototype.indexOf.call(milestones, entry.target);
                var delay = Math.max(index, 0) * 100;

                window.setTimeout(function () {
                    entry.target.classList.add('is-active');
                }, delay);

                obs.unobserve(entry.target);
            });
        },
        { threshold: 0.3 }
    );

    milestones.forEach(function (milestone) {
        observer.observe(milestone);
    });
})();
