(function () {
    var accordion = document.querySelector('[data-accordion]');

    if (!accordion) {
        return;
    }

    var triggers = accordion.querySelectorAll('[data-accordion-trigger]');

    if (!triggers.length) {
        return;
    }

    function getPanel(trigger) {
        var panelId = trigger.getAttribute('aria-controls');
        return panelId ? document.getElementById(panelId) : null;
    }

    function closeTrigger(trigger) {
        var panel = getPanel(trigger);

        trigger.setAttribute('aria-expanded', 'false');

        if (panel) {
            panel.hidden = true;
        }
    }

    function openTrigger(trigger) {
        var panel = getPanel(trigger);

        trigger.setAttribute('aria-expanded', 'true');

        if (panel) {
            panel.hidden = false;
        }
    }

    /* Progressive enhancement: HTML dimulai dalam keadaan terbuka penuh
       (tetap terbaca tanpa JavaScript). JS baru menutup panel selain yang
       pertama setelah script berjalan. */
    triggers.forEach(function (trigger, index) {
        if (index === 0) {
            openTrigger(trigger);
        } else {
            closeTrigger(trigger);
        }

        trigger.addEventListener('click', function () {
            var isOpen = trigger.getAttribute('aria-expanded') === 'true';

            triggers.forEach(closeTrigger);

            if (!isOpen) {
                openTrigger(trigger);
            }
        });
    });
})();
