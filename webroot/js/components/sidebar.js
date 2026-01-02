/**
 * Sidebar JavaScript Component
 * Handles sidebar toggle, overlay, and keyboard interactions.
 * 
 * @file webroot/js/components/sidebar.js
 */
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const menuLinks = document.querySelectorAll('.sidebar-menu-link');

    // Guard clause if elements don't exist
    if (!sidebar || !sidebarToggle) {
        return;
    }

    // Toggle sidebar slide-out on hamburger click
    sidebarToggle.addEventListener('click', function() {
        toggleSidebar();
    });

    // Close sidebar when clicking overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            closeSidebar();
        });
    }

    // Close sidebar when clicking a menu link
    menuLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            closeSidebar();
        });
    });

    // Close sidebar on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('sidebar-active')) {
            closeSidebar();
        }
    });

    function toggleSidebar() {
        sidebar.classList.toggle('sidebar-active');
        if (sidebarOverlay) {
            sidebarOverlay.classList.toggle('active');
        }

        // Update hamburger icon
        const icon = sidebarToggle.querySelector('i');
        if (icon) {
            if (sidebar.classList.contains('sidebar-active')) {
                icon.classList.remove('bi-list');
                icon.classList.add('bi-x-lg');
            } else {
                icon.classList.remove('bi-x-lg');
                icon.classList.add('bi-list');
            }
        }
    }

    function closeSidebar() {
        sidebar.classList.remove('sidebar-active');
        if (sidebarOverlay) {
            sidebarOverlay.classList.remove('active');
        }

        // Reset hamburger icon
        const icon = sidebarToggle.querySelector('i');
        if (icon) {
            icon.classList.remove('bi-x-lg');
            icon.classList.add('bi-list');
        }
    }
});
