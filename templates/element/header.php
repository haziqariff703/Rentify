<!-- Navigation (Bootstrap 5 - Styled to match Sidebar Theme) -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="navbar">
    <div class="container">
        <?php
        $identity = $this->request->getAttribute('identity');
        $homeLink = $this->Url->build('/');
        if ($identity && $identity->role === 'admin') {
            $homeLink = $this->Url->build(['controller' => 'Admins', 'action' => 'dashboard']);
        }

        // Bookings link: different destination based on login/role
        if ($identity) {
            if ($identity->role === 'admin') {
                $bookingsUrl = $this->Url->build(['controller' => 'Bookings', 'action' => 'index']);
            } else {
                $bookingsUrl = $this->Url->build(['controller' => 'Bookings', 'action' => 'myBookings']);
            }
        } else {
            $bookingsUrl = $this->Url->build(['controller' => 'Users', 'action' => 'add']);
        }

        ?>
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $homeLink ?>">
            <i class="fas fa-car-side fs-4"></i>
            <span>RENTIFY</span>
        </a>

        <!-- Mobile Menu Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>">
                        <i class="fas fa-car me-1"></i> Fleet
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->Url->build('/') ?>#about">
                        <i class="fas fa-info-circle me-1"></i> About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $bookingsUrl ?>">
                        <i class="fas fa-calendar-alt me-1"></i> Bookings
                    </a>
                </li>

                <?php
                if ($identity):
                ?>
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                            </div>
                            <span>My Account</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="userDropdown">
                            <?php if ($identity->role === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="<?= $this->Url->build(['controller' => 'Admins', 'action' => 'dashboard']) ?>">
                                        <i class="fas fa-chart-line" style="color: #6366f1;"></i>
                                        <span style="color: #6366f1; font-weight: 600;">Admin Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $identity->getIdentifier()]) ?>">
                                    <i class="fas fa-id-card text-muted"></i> Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-3">
                        <div class="d-flex gap-2">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="btn btn-outline-styled">Login</a>
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="btn btn-primary-gradient">Get Started</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>