(function () {
    'use strict';

    var form = document.querySelector('[data-settings-form]');
    var status = document.querySelector('[data-settings-status]');

    if (!form || !status) {
        return;
    }

    var markChanged = function () {
        status.hidden = false;
    };

    form.addEventListener('input', markChanged);
    form.addEventListener('change', markChanged);

    form.addEventListener('submit', function () {
        status.hidden = true;
    });
})();
