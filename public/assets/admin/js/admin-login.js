(function () {
    'use strict';

    var toggle = document.querySelector('[data-password-toggle]');
    var passwordInput = document.querySelector('[data-password-input]');

    if (toggle && passwordInput) {
        var iconShow = toggle.querySelector('[data-icon-show]');
        var iconHide = toggle.querySelector('[data-icon-hide]');

        toggle.addEventListener('click', function () {
            var isHidden = passwordInput.getAttribute('type') === 'password';

            passwordInput.setAttribute('type', isHidden ? 'text' : 'password');
            toggle.setAttribute('aria-pressed', String(isHidden));
            toggle.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');

            if (iconShow && iconHide) {
                iconShow.hidden = isHidden;
                iconHide.hidden = !isHidden;
            }
        });
    }

    var capslockIndicator = document.querySelector('[data-capslock-indicator]');

    if (passwordInput && capslockIndicator) {
        var updateCapsLock = function (event) {
            if (typeof event.getModifierState !== 'function') {
                return;
            }

            capslockIndicator.hidden = !event.getModifierState('CapsLock');
        };

        passwordInput.addEventListener('keyup', updateCapsLock);
        passwordInput.addEventListener('keydown', updateCapsLock);
        passwordInput.addEventListener('blur', function () {
            capslockIndicator.hidden = true;
        });
    }

    var form = document.querySelector('.ca-admin-auth__form');
    var submitButton = document.querySelector('[data-submit-button]');
    var submitLabel = document.querySelector('[data-submit-label]');

    if (form && submitButton) {
        var hasSubmitted = false;

        form.addEventListener('submit', function (event) {
            if (hasSubmitted) {
                event.preventDefault();
                return;
            }

            hasSubmitted = true;
            submitButton.classList.add('is-loading');
            submitButton.setAttribute('aria-disabled', 'true');

            if (submitLabel) {
                submitLabel.textContent = 'Memproses...';
            }
        });
    }
})();
