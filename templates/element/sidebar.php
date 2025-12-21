<?php

/**
 * Sidebar Element for Admin Layout
 * Reusable navigation sidebar for admin pages
 */
?>
<aside class="admin-sidebar">
    <!-- Brand Section - Customize your logo here -->
    <div class="sidebar-brand">
        <div class="sidebar-brand-placeholder">
            <i class="fas fa-car me-2"></i> RENTIFY
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <div class="nav-section-title">Main Menu</div>

        <div class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Admins', 'action' => 'dashboard']) ?>"
                class="nav-link <?= $this->request->getParam('action') === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-th-large"></i>
                Dashboard
            </a>
        </div>

        <div class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>"
                class="nav-link <?= $this->request->getParam('controller') === 'Cars' ? 'active' : '' ?>">
                <i class="fas fa-car"></i>
                Cars
            </a>
        </div>

        <div class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'index']) ?>"
                class="nav-link <?= $this->request->getParam('controller') === 'Bookings' ? 'active' : '' ?>">
                <i class="fas fa-calendar-check"></i>
                Bookings
            </a>
        </div>

        <div class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>"
                class="nav-link <?= $this->request->getParam('controller') === 'Users' ? 'active' : '' ?>">
                <i class="fas fa-users"></i>
                Users
            </a>
        </div>

        <div class="nav-section-title">Management</div>

        <div class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Payments', 'action' => 'index']) ?>"
                class="nav-link <?= $this->request->getParam('controller') === 'Payments' ? 'active' : '' ?>">
                <i class="fas fa-credit-card"></i>
                Payments
            </a>
        </div>

        <div class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'CarCategories', 'action' => 'index']) ?>"
                class="nav-link <?= $this->request->getParam('controller') === 'CarCategories' ? 'active' : '' ?>">
                <i class="fas fa-tags"></i>
                Categories
            </a>
        </div>

        <div class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Maintenances', 'action' => 'index']) ?>"
                class="nav-link <?= $this->request->getParam('controller') === 'Maintenances' ? 'active' : '' ?>">
                <i class="fas fa-wrench"></i>
                Maintenance
            </a>
        </div>

        <div class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'index']) ?>"
                class="nav-link <?= $this->request->getParam('controller') === 'Reviews' ? 'active' : '' ?>">
                <i class="fas fa-star"></i>
                Reviews
            </a>
        </div>
    </nav>

    <!-- User Profile Section -->
    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-info">
                <h6>Admin</h6>
                <small>Administrator</small>
            </div>
        </div>
    </div>
</aside>