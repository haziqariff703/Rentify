/**
 * Flash Toast Auto-Dismiss
 * Automatically removes toast notifications after 3 seconds.
 *
 * Usage: Include this script once in layouts, not in individual flash elements.
 * Each toast should have class 'toast' and a unique ID.
 *
 * @file webroot/js/components/flash.js
 */
document.addEventListener('DOMContentLoaded', function() {
    // Find all toasts and auto-dismiss them
    const toasts = document.querySelectorAll('.toast.show');
    
    toasts.forEach(function(toast) {
        setTimeout(function() {
            if (toast) {
                toast.classList.add('fade');
                setTimeout(function() {
                    toast.remove();
                }, 300);
            }
        }, 3000);
    });
});
