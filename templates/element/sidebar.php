<!-- Google Fonts - Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome 7 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.1.0/css/all.min.css">

<!-- Bootstrap Icons (for hamburger menu) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* ========================================
       CRYSTAL GLASS SIDEBAR - Bright & Airy
       ======================================== */

    .glassmorphism-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        width: 280px;
        /* Crystal Glass - Very light white tint */
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        /* Subtle border */
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.15);
        z-index: 9999;
        overflow: hidden;
        /* Changed from auto - children handle overflow */
        font-family: 'Poppins', sans-serif;
        /* Hidden off-screen by default */
        transform: translateX(-100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 1;
        pointer-events: auto;
        /* Flexbox layout for fixed footer */
        display: flex;
        flex-direction: column;
    }

    /* Sidebar Active State - Slides in */
    .glassmorphism-sidebar.sidebar-active {
        transform: translateX(0);
        pointer-events: auto;
    }

    /* Overlay backdrop */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s ease;
        pointer-events: none;
    }

    .sidebar-overlay.active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    /* Sidebar Links - Pure White with Text Shadow */
    .sidebar-menu-link {
        color: #FFFFFF !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        pointer-events: auto;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    /* Sidebar Icons - Pure White */
    .sidebar-menu-icon {
        color: #FFFFFF !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* Active Link - Soft Blue Glow */
    .sidebar-menu-link.active {
        background: rgba(30, 64, 175, 0.3) !important;
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
        border-radius: 12px;
    }

    /* Hover Effect */
    .sidebar-menu-link:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    /* ========================================
       RESPONSIVE SIDEBAR
       ======================================== */

    @media (max-width: 768px) {
        .glassmorphism-sidebar {
            width: 100%;
            max-width: 300px;
        }
    }

    @media (max-width: 480px) {
        .glassmorphism-sidebar {
            width: 85%;
            max-width: 280px;
        }

        .sidebar-menu-link {
            padding: 12px 16px;
            font-size: 14px;
        }

        .sidebar-menu-icon {
            font-size: 18px;
        }
    }

    .sidebar-menu {
        list-style: none;
        padding: 80px 0 20px 0;
        margin: 0;
        position: relative;
        /* Scrollable menu area */
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        /* Hide scrollbar but keep functionality */
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE/Edge */
    }

    /* Hide scrollbar for Chrome, Safari, Opera */
    .sidebar-menu::-webkit-scrollbar {
        display: none;
    }

    /* Animated Sliding Pill */
    .sidebar-menu::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        width: calc(100% - 30px);
        height: 50px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.4) 0%, rgba(96, 165, 250, 0.3) 100%);
        border-radius: 12px;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, width 0.3s ease;
        z-index: 0;
        opacity: 0;
        box-shadow: 0 4px 20px 0 rgba(59, 130, 246, 0.5);
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .glassmorphism-sidebar.collapsed .sidebar-menu::before {
        width: 50px;
        left: 15px;
    }

    .sidebar-menu-item {
        margin: 5px 15px;
        position: relative;
        z-index: 1;
    }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 15px;
        font-weight: 500;
        position: relative;
        white-space: nowrap;
    }

    .glassmorphism-sidebar.collapsed .sidebar-menu-link {
        padding: 15px;
        justify-content: center;
    }

    .sidebar-menu-link:hover {
        color: #ffffff;
        transform: translateX(5px);
        background: rgba(255, 255, 255, 0.1);
    }

    .glassmorphism-sidebar.collapsed .sidebar-menu-link:hover {
        transform: translateX(0) scale(1.1);
    }

    .sidebar-menu-link.active {
        color: #ffffff;
    }

    /* Left Border Accent for Active State */
    .sidebar-menu-link::after {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 0 4px 4px 0;
        transition: height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar-menu-link.active::after {
        height: 70%;
    }

    .sidebar-menu-icon {
        margin-right: 15px;
        font-size: 20px;
        width: 24px;
        text-align: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .glassmorphism-sidebar.collapsed .sidebar-menu-icon {
        margin-right: 0;
        font-size: 22px;
    }

    .sidebar-menu-text {
        flex: 1;
        transition: opacity 0.3s ease;
    }

    .glassmorphism-sidebar.collapsed .sidebar-menu-text {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }

    .sidebar-footer {
        /* Fixed at bottom using flexbox - no absolute positioning */
        flex-shrink: 0;
        width: 100%;
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .glassmorphism-sidebar.collapsed .sidebar-footer {
        padding: 20px 10px;
    }

    .sidebar-user-info {
        display: flex;
        align-items: center;
        padding: 10px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .sidebar-user-info:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        margin-right: 12px;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .glassmorphism-sidebar.collapsed .sidebar-user-avatar {
        margin-right: 0;
    }

    .sidebar-user-details {
        flex: 1;
        transition: opacity 0.3s ease;
        overflow: hidden;
    }

    .glassmorphism-sidebar.collapsed .sidebar-user-details {
        opacity: 0;
        width: 0;
    }

    .sidebar-user-name {
        font-size: 13px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-user-role {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.6);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 300;
    }

    /* Scrollbar Styling */
    .glassmorphism-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .glassmorphism-sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }

    .glassmorphism-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .glassmorphism-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .glassmorphism-sidebar {
            transform: translateX(-100%);
        }

        .glassmorphism-sidebar.mobile-open {
            transform: translateX(0);
        }

        .sidebar-toggle {
            left: auto;
            right: 20px;
        }
    }

    /* Adjust main content margin */
    body {
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<!-- Sidebar Overlay Backdrop (click to close) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="glassmorphism-sidebar" id="sidebar">
    <!-- Sidebar Menu -->
    <?php
    // === SIDEBAR CONFIGURATION ===
    $sidebarIdentity = $this->request->getAttribute('identity');
    $sidebarIsAdmin = $sidebarIdentity && $sidebarIdentity->get('role') === 'admin';
    $currentController = $this->request->getParam('controller');
    $currentAction = $this->request->getParam('action');

    // Define menu items with visibility rules
    $menuItems = [
        [
            'controller' => $sidebarIsAdmin ? 'Admins' : 'Pages',
            'action' => $sidebarIsAdmin ? 'dashboard' : 'display',
            'params' => $sidebarIsAdmin ? [] : ['home'],
            'icon' => $sidebarIsAdmin ? 'fa-gauge-high' : 'fa-house',
            'label' => $sidebarIsAdmin ? 'Dashboard' : 'Home',
            'visible' => true,
            'activeMatch' => $sidebarIsAdmin ? 'Admins:dashboard' : 'Pages:display',
        ],
        [
            'controller' => 'Users',
            'action' => 'view',
            'params' => $sidebarIdentity ? [$sidebarIdentity->getIdentifier()] : [],
            'icon' => 'fa-circle-user',
            'label' => 'My Account',
            'visible' => (bool)$sidebarIdentity,
            'activeMatch' => 'Users:view',
        ],
        [
            'controller' => 'Cars',
            'action' => 'index',
            'params' => [],
            'icon' => 'fa-car',
            'label' => 'Fleet',
            'visible' => true,
            'activeMatch' => 'Cars',
        ],
        [
            'controller' => 'Maintenances',
            'action' => 'index',
            'params' => [],
            'icon' => 'fa-wrench',
            'label' => 'Maintenances',
            'visible' => $sidebarIsAdmin,
            'activeMatch' => 'Maintenances',
        ],

        [
            'controller' => 'Users',
            'action' => 'index',
            'params' => [],
            'icon' => 'fa-users',
            'label' => 'Users',
            'visible' => $sidebarIsAdmin,
            'activeMatch' => 'Users:index',
        ],

        [
            'controller' => 'Bookings',
            'action' => $sidebarIsAdmin ? 'index' : 'myBookings',
            'params' => [],
            'icon' => 'fa-calendar-check',
            'label' => $sidebarIsAdmin ? 'Bookings' : 'My Bookings',
            'visible' => true,
            'activeMatch' => 'Bookings',
        ],
        [
            'controller' => 'Invoices',
            'action' => $sidebarIsAdmin ? 'index' : 'myInvoices',
            'params' => [],
            'icon' => 'fa-receipt',
            'label' => $sidebarIsAdmin ? 'Invoices' : 'My Invoices',
            'visible' => true,
            'activeMatch' => 'Invoices',
        ],
        [
            'controller' => 'Reviews',
            'action' => $sidebarIsAdmin ? 'index' : 'myReviews',
            'params' => [],
            'icon' => 'fa-star',
            'label' => $sidebarIsAdmin ? 'Reviews' : 'My Reviews',
            'visible' => true,
            'activeMatch' => 'Reviews',
        ],
        [
            'controller' => 'Payments',
            'action' => $sidebarIsAdmin ? 'index' : 'myPayments',
            'params' => [],
            'icon' => 'fa-credit-card',
            'label' => $sidebarIsAdmin ? 'Payments' : 'My Payments',
            'visible' => true,
            'activeMatch' => 'Payments',
        ],
    ];

    // Helper function for active state check
    $isMenuActive = function ($match, $controller, $action) {
        if (strpos($match, ':') !== false) {
            list($c, $a) = explode(':', $match);
            return $controller == $c && $action == $a;
        }
        return $controller == $match;
    };
    ?>
    <ul class="sidebar-menu" id="sidebarMenu">
        <?php $index = 0; ?>
        <?php foreach ($menuItems as $item): ?>
            <?php if ($item['visible']): ?>
                <li class="sidebar-menu-item">
                    <a href="<?= $this->Url->build(array_merge(
                                    ['controller' => $item['controller'], 'action' => $item['action']],
                                    $item['params']
                                )) ?>"
                        class="sidebar-menu-link <?= $isMenuActive($item['activeMatch'], $currentController, $currentAction) ? 'active' : '' ?>"
                        data-index="<?= $index++ ?>">
                        <i class="fa-solid <?= $item['icon'] ?> sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text"><?= $item['label'] ?></span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Login/Logout -->
        <?php if ($sidebarIdentity): ?>
            <li class="sidebar-menu-item">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>"
                    class="sidebar-menu-link" data-index="<?= $index++ ?>">
                    <i class="fa-solid fa-right-from-bracket sidebar-menu-icon"></i>
                    <span class="sidebar-menu-text">Logout</span>
                </a>
            </li>
        <?php else: ?>
            <li class="sidebar-menu-item">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>"
                    class="sidebar-menu-link" data-index="<?= $index++ ?>">
                    <i class="fa-solid fa-right-to-bracket sidebar-menu-icon"></i>
                    <span class="sidebar-menu-text">Login</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>

    <!-- Sidebar Footer with User Info -->
    <?php if ($sidebarIdentity): ?>
        <div class="sidebar-footer">
            <div class="sidebar-user-info">
                <div class="sidebar-user-avatar">
                    <?= strtoupper(substr($sidebarIdentity->get('email'), 0, 1)) ?>
                </div>
                <div class="sidebar-user-details">
                    <div class="sidebar-user-name">
                        <?= h($sidebarIdentity->get('email')) ?>
                    </div>
                    <div class="sidebar-user-role"><?= $sidebarIsAdmin ? 'Admin' : 'User' ?></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuLinks = document.querySelectorAll('.sidebar-menu-link');

        // Toggle sidebar slide-out on hamburger click
        sidebarToggle.addEventListener('click', function() {
            toggleSidebar();
        });

        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', function() {
            closeSidebar();
        });

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
            sidebarOverlay.classList.toggle('active');

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
            sidebarOverlay.classList.remove('active');

            // Reset hamburger icon
            const icon = sidebarToggle.querySelector('i');
            if (icon) {
                icon.classList.remove('bi-x-lg');
                icon.classList.add('bi-list');
            }
        }
    });
</script>