<?php

/**
 * My Account - Customer Profile View
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        object-fit: cover;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        height: 100%;
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
    }

    .stat-badge {
        background: linear-gradient(135deg, #f6f8fb 0%, #e9ecef 100%);
        border-radius: 12px;
        padding: 15px 20px;
        text-align: center;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }
</style>

<div class="container py-5">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <?php if (!empty($user->avatar) && file_exists(WWW_ROOT . 'img' . DS . $user->avatar)): ?>
                    <img src="<?= $this->Url->webroot('img/' . $user->avatar) ?>" alt="Avatar" class="profile-avatar">
                <?php else: ?>
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col">
                <h2 class="fw-bold mb-1"><?= h($user->name) ?></h2>
                <p class="mb-2 opacity-75"><?= h($user->email) ?></p>
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                    <i class="fas fa-user-tag me-1"></i> <?= ucfirst(h($user->role)) ?>
                </span>
            </div>
            <div class="col-auto">
                <?= $this->Html->link(
                    '<i class="fas fa-edit me-2"></i>Edit Profile',
                    ['action' => 'editProfile'],
                    ['class' => 'btn btn-light btn-lg rounded-pill px-4', 'escape' => false]
                ) ?>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-badge">
                <div class="stat-number"><?= count($user->bookings ?? []) ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-badge">
                <div class="stat-number"><?= count($user->reviews ?? []) ?></div>
                <div class="stat-label">Reviews Given</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-badge">
                <div class="stat-number"><?= $user->created ? $user->created->format('Y') : '-' ?></div>
                <div class="stat-label">Member Since</div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="fw-bold mb-4"><i class="fas fa-id-card text-primary me-2"></i>Personal Information</h5>

                <div class="mb-3">
                    <div class="info-label">Full Name</div>
                    <div class="info-value"><?= h($user->name) ?></div>
                </div>

                <div class="mb-3">
                    <div class="info-label">IC Number</div>
                    <div class="info-value"><?= h($user->ic_number) ?: '-' ?></div>
                </div>

                <div class="mb-3">
                    <div class="info-label">Email Address</div>
                    <div class="info-value"><?= h($user->email) ?></div>
                </div>

                <div>
                    <div class="info-label">Phone Number</div>
                    <div class="info-value"><?= h($user->phone) ?: '-' ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-card">
                <h5 class="fw-bold mb-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Address</h5>

                <div class="mb-4">
                    <div class="info-label">Registered Address</div>
                    <div class="info-value">
                        <?= $user->address ? nl2br(h($user->address)) : '<span class="text-muted">No address provided</span>' ?>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-4"><i class="fas fa-clock text-primary me-2"></i>Account Details</h5>

                <div class="mb-3">
                    <div class="info-label">Member Since</div>
                    <div class="info-value"><?= $user->created ? $user->created->format('d M Y') : '-' ?></div>
                </div>

                <div>
                    <div class="info-label">Last Updated</div>
                    <div class="info-value"><?= $user->modified ? $user->modified->format('d M Y, h:i A') : '-' ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mt-5 text-center">
        <h5 class="text-muted mb-4">Quick Links</h5>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <?= $this->Html->link(
                '<i class="fas fa-calendar-alt me-2"></i>My Bookings',
                ['controller' => 'Bookings', 'action' => 'myBookings'],
                ['class' => 'btn btn-outline-primary rounded-pill px-4', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-car me-2"></i>Browse Cars',
                ['controller' => 'Cars', 'action' => 'index'],
                ['class' => 'btn btn-outline-secondary rounded-pill px-4', 'escape' => false]
            ) ?>
        </div>
    </div>
</div>