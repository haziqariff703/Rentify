<!-- Navigation (Bootstrap 5) -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm" id="navbar">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center gap-3">
            <!-- Hamburger Toggle Button -->
            <button class="sidebar-toggle-header" id="sidebarToggle" aria-label="Toggle Sidebar">
                <i class="bi bi-list"></i>
            </button>

            <?php
            $identity = $this->request->getAttribute('identity');
            $homeLink = $this->Url->build('/');
            if ($identity && $identity->role === 'admin') {
                $homeLink = $this->Url->build(['controller' => 'Admins', 'action' => 'dashboard']);
            }
            ?>

            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center mb-0" href="<?= $homeLink ?>">
                <?= $this->Html->image('rentify_logo.png', ['alt' => 'Rentify Logo']) ?>
            </a>
        </div>

        <!-- Right Side - Login/Get Started -->
        <div class="d-flex align-items-center gap-2">
            <?php if ($identity): ?>
                <div class="dropdown">
                    <a class="btn btn-link text-white text-decoration-none dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i>
                        <span class="d-none d-md-inline">My Account</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userDropdown">
                        <?php if ($identity->role === 'admin'): ?>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 fw-bold text-primary" href="<?= $this->Url->build(['controller' => 'Admins', 'action' => 'dashboard']) ?>">
                                    <i class="bi bi-speedometer2"></i> Admin Dashboard
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        <?php endif; ?>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $identity->getIdentifier()]) ?>">
                                <i class="bi bi-person"></i> Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="btn btn-outline-light px-4">Login</a>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="btn btn-primary px-4">Get Started</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
    #navbar {
        height: 70px;
        background: linear-gradient(rgba(30, 41, 59, 0.85), rgba(30, 41, 59, 0.9)),
            url('<?= $this->Url->assetUrl('img/header_background.jpg') ?>') !important;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    #navbar .navbar-brand img {
        height: 150px;
        max-height: 150px;
        width: auto;
    }

    .sidebar-toggle-header {
        background: rgba(59, 130, 246, 0.2);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 8px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #ffffff;
        font-size: 20px;
    }

    .sidebar-toggle-header:hover {
        background: rgba(59, 130, 246, 0.4);
        transform: scale(1.05);
    }

    .navbar-brand:hover {
        opacity: 0.9;
    }
</style>