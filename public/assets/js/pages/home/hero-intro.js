(function () {
    var hero = document.querySelector('[data-hero-intro]');

    if (!hero) {
        return;
    }

    var parts = hero.querySelectorAll('[data-hero-part]');

    if (!parts.length) {
        return;
    }

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
        return;
    }

    hero.classList.add('is-enhanced');

    var STAGGER_MS = 220;

    parts.forEach(function (part, index) {
        window.setTimeout(function () {
            part.classList.add('is-visible');
        }, index * STAGGER_MS + 80);
    });
})();
