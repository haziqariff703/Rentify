<!-- Navigation (Bootstrap 5) -->
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm" id="navbar">
    <div class="container">
        <?php 
        $identity = $this->request->getAttribute('identity');
        $homeLink = $this->Url->build('/');
        if ($identity && $identity->role === 'admin') {
            $homeLink = $this->Url->build(['controller' => 'Admins', 'action' => 'dashboard']);
        }
        ?>
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $homeLink ?>">
            <i class="fas fa-car-side text-primary"></i>
            <span class="fw-bold text-dark">RENTIFY</span>
        </a>

        <!-- Mobile Menu Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>">Fleet</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->Url->build('/') ?>#about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'index']) ?>">Bookings</a>
                </li>

                <?php 
                if ($identity): 
                ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fs-5"></i>
                            <span>My Account</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $identity->getIdentifier()]) ?>">
                                    <i class="fas fa-id-card text-muted"></i> Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
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
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="btn btn-outline-secondary px-4">Login</a>
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="btn btn-primary px-4 text-white">Get Started</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>