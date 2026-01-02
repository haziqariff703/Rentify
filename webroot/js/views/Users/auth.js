/**
 * Auth Page JavaScript
 * Handles login/register slider toggle.
 *
 * @file webroot/js/views/Users/auth.js
 */
document.addEventListener('DOMContentLoaded', function() {
    const registerButton = document.getElementById('register');
    const loginButton = document.getElementById('login');
    const container = document.getElementById('container');

    if (registerButton && loginButton && container) {
        registerButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        loginButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });
    }
});
