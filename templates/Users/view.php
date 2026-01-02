<?php

/**
 * User Profile View - Standardized Layout
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="view-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2>User Profile: <?= h($user->name) ?></h2>
            <p class="text-muted">
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-user-tag me-1 text-primary"></i> <?= ucfirst(h($user->role)) ?>
                </span>
                <span class="ms-2 plate-badge">
                    <i class="fas fa-hashtag me-1"></i>ID: <?= h($user->id) ?>
                </span>
            </p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-edit me-2"></i>Edit User',
                ['action' => 'edit', $user->id],
                ['class' => 'btn btn-primary rounded-pill px-4', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>Back to List',
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary rounded-pill px-4', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- User Quick Stats Row -->
    <div class="specs-grid mb-4">
        <div class="spec-item shadow-sm border-0">
            <i class="fas fa-calendar-check text-primary"></i>
            <div>
                <span class="spec-label">Total Bookings</span>
                <span class="spec-value text-primary fs-5"><?= count($user->bookings ?? []) ?></span>
            </div>
        </div>
        <div class="spec-item shadow-sm border-0">
            <i class="fas fa-star text-warning"></i>
            <div>
                <span class="spec-label">Reviews Given</span>
                <span class="spec-value text-warning fs-5"><?= count($user->reviews ?? []) ?></span>
            </div>
        </div>
        <div class="spec-item shadow-sm border-0">
            <i class="fas fa-user-clock text-info"></i>
            <div>
                <span class="spec-label">Member Since</span>
                <span class="spec-value text-info fs-5"><?= $user->created ? $user->created->format('Y') : '-' ?></span>
            </div>
        </div>
    </div>

    <div class="view-grid">
        <!-- Avatar/Identity Card -->
        <div class="form-card image-card">
            <div class="card-header">
                <h5><i class="fas fa-id-badge me-2"></i><?= __('User Identity') ?></h5>
            </div>
            <div class="card-body">
                <?php if (!empty($user->avatar) && file_exists(WWW_ROOT . 'img' . DS . $user->avatar)): ?>
                    <img src="<?= $this->Url->webroot('img/' . $user->avatar) ?>" alt="Avatar" class="car-preview-image">
                <?php else: ?>
                    <div class="no-image-placeholder">
                        <i class="fas fa-user"></i>
                        <span class="mt-2">No Profile Image</span>
                    </div>
                <?php endif; ?>
                <div class="car-info-overlay">
                    <h4><?= h($user->name) ?></h4>
                    <div class="car-price opacity-75"><?= h($user->email) ?></div>
                </div>
            </div>
        </div>

        <!-- Personal Information Card -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-user-circle me-2"></i><?= __('Personal Information') ?></h5>
            </div>
            <div class="card-body">
                <table class="view-table">
                    <tr>
                        <th><?= __('Full Name') ?></th>
                        <td class="fw-bold"><?= h($user->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Email') ?></th>
                        <td><?= h($user->email) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('IC Number') ?></th>
                        <td><?= h($user->ic_number) ?: '<span class="text-muted italic">Not specified</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Phone') ?></th>
                        <td><?= h($user->phone) ?: '<span class="text-muted italic">Not specified</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Role') ?></th>
                        <td><span class="badge bg-primary-soft text-primary"><?= ucfirst(h($user->role)) ?></span></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Address Card -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-map-marker-alt me-2"></i><?= __('Contact Address') ?></h5>
            </div>
            <div class="card-body">
                <div class="p-3 bg-light rounded shadow-sm">
                    <?php if ($user->address): ?>
                        <p class="mb-0 text-dark"><?= nl2br(h($user->address)) ?></p>
                    <?php else: ?>
                        <p class="mb-0 text-muted italic"><i class="fas fa-info-circle me-1"></i>No address provided</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Account Metadata Card -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-clock me-2"></i><?= __('Account Details') ?></h5>
            </div>
            <div class="card-body">
                <table class="view-table">
                    <tr>
                        <th><?= __('Member Since') ?></th>
                        <td><?= $user->created ? $user->created->format('d M Y') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Last Updated') ?></th>
                        <td><?= $user->modified ? $user->modified->format('d M Y, h:i A') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td><span class="status-badge confirmed">Active</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Related Bookings -->
        <div class="form-card full-width mt-4">
            <div class="card-header">
                <h5><i class="fas fa-calendar-alt me-2"></i><?= __('Booking History') ?></h5>
            </div>
            <div class="card-body">
                <?php if (!empty($user->bookings)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Car</th>
                                    <th>Dates</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user->bookings as $booking): ?>
                                    <tr>
                                        <td><span class="fw-bold">#<?= h($booking->id) ?></span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-car text-muted me-2"></i>
                                                <span>Car #<?= h($booking->car_id) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <span class="text-muted">From:</span> <?= $booking->start_date->format('d M Y') ?><br>
                                                <span class="text-muted">To:</span> <?= $booking->end_date->format('d M Y') ?>
                                            </div>
                                        </td>
                                        <td><span class="text-success fw-bold">RM <?= $this->Number->format($booking->total_price, ['places' => 2]) ?></span></td>
                                        <td>
                                            <?= $this->Status->bookingBadge($booking->booking_status) ?>
                                        </td>
                                        <td class="text-end">
                                            <?= $this->Html->link('<i class="fas fa-eye"></i>', ['controller' => 'Bookings', 'action' => 'view', $booking->id], ['class' => 'btn btn-sm btn-outline-primary rounded-circle shadow-sm', 'escape' => false, 'title' => 'View Booking']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-calendar-times mb-3 fs-1 opacity-25"></i>
                        <p>No bookings found for this user.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Related Reviews -->
        <div class="form-card full-width mt-4">
            <div class="card-header">
                <h5><i class="fas fa-star me-2"></i><?= __('User Reviews') ?></h5>
            </div>
            <div class="card-body">
                <?php if (!empty($user->reviews)): ?>
                    <div class="reviews-list">
                        <?php foreach ($user->reviews as $review): ?>
                            <div class="review-item border-bottom pb-3 mb-3">
                                <div class="review-header d-flex justify-content-between align-items-center mb-2">
                                    <div class="review-rating text-warning">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?= $i <= $review->rating ? '' : 'text-muted' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="review-date small text-muted"><?= $review->created->format('d M Y') ?></span>
                                </div>
                                <p class="review-comment mb-0 italic text-dark"><?= h($review->comment) ?></p>
                                <div class="mt-2">
                                    <?= $this->Html->link('View Car', ['controller' => 'Cars', 'action' => 'view', $review->car_id], ['class' => 'small text-primary text-decoration-none']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-comment-slash mb-3 fs-1 opacity-25"></i>
                        <p>No reviews found for this user.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>