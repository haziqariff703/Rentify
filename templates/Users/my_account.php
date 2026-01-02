<?php

/**
 * My Account - Customer Profile View
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800&display=swap');

    .account-wrapper {
        background-color: #f8fafc;
        min-height: 100vh;
        padding: 40px 0;
    }

    .page-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #64748b;
        text-align: center;
        margin-bottom: 8px;
    }

    .page-heading {
        font-family: 'Montserrat', sans-serif;
        font-size: 3.5rem;
        font-weight: 900;
        color: #0f172a;
        text-align: center;
        margin-bottom: 32px;
        letter-spacing: -1px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .page-heading .accent {
        color: #1e40af;
    }

    /* Profile Card - Clean White */
    .profile-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
        padding: 32px;
        margin-bottom: 32px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 24px;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid #059669;
        object-fit: cover;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #059669;
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.15);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .profile-email {
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        color: #64748b;
        margin: 0 0 8px 0;
    }

    .profile-member {
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .btn-edit-profile {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0f172a;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-edit-profile:hover {
        background: #1e293b;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Stats Row */
    .stats-row {
        display: flex;
        justify-content: center;
        gap: 40px;
    }

    .stat-item {
        text-align: center;
        flex: 1;
        max-width: 150px;
    }

    .stat-number {
        font-family: 'Montserrat', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        color: #059669;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
    }

    .stat-divider {
        width: 1px;
        height: 50px;
        background-color: #e2e8f0;
    }

    /* Info Cards */
    .info-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
        overflow: hidden;
        height: 100%;
    }

    .info-card-header {
        background: #1e293b;
        padding: 16px 24px;
    }

    .info-card-header h5 {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
    }

    .info-card-body {
        padding: 24px;
    }

    .info-row {
        margin-bottom: 20px;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
        margin-bottom: 4px;
    }

    .info-value {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        font-weight: 600;
        color: #0f172a;
    }

    /* Quick Links */
    .quick-links {
        text-align: center;
        margin: 40px 0;
    }

    .quick-links-title {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #94a3b8;
        margin-bottom: 16px;
    }

    .btn-quick-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        border: 2px solid #e2e8f0;
        color: #0f172a;
        padding: 12px 24px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
        margin: 0 8px;
    }

    .btn-quick-link:hover {
        border-color: #0f172a;
        background: #0f172a;
        color: #ffffff;
    }

    /* Related Sections */
    .related-section {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .related-section-header {
        background: #1e293b;
        padding: 16px 24px;
    }

    .related-section-header h5 {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
    }

    .related-section table {
        width: 100%;
        border-collapse: collapse;
    }

    .related-section th {
        background: #f8fafc;
        padding: 14px 20px;
        text-align: left;
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }

    .related-section td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        color: #0f172a;
    }

    .related-section tr:last-child td {
        border-bottom: none;
    }

    .related-section tr:hover {
        background: #fafbfc;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        background: #f1f5f9;
        color: #3b82f6;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background: #3b82f6;
        color: #ffffff;
    }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state p {
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        margin-bottom: 16px;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .stats-row {
            flex-wrap: wrap;
            gap: 24px;
        }

        .stat-divider {
            display: none;
        }
    }
</style>

<div class="account-wrapper">
    <div class="container">

        <!-- Page Title -->
        <p class="page-title">Account Settings</p>
        <h1 class="page-heading">My <span class="accent">Account</span></h1>

        <!-- Profile Card with Stats -->
        <div class="profile-card">
            <div class="profile-header">
                <?php if (!empty($user->avatar) && file_exists(WWW_ROOT . 'img' . DS . $user->avatar)): ?>
                    <div class="profile-avatar">
                        <img src="<?= $this->Url->webroot('img/' . $user->avatar) ?>" alt="Avatar">
                    </div>
                <?php else: ?>
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>

                <div class="profile-info">
                    <h2 class="profile-name"><?= h($user->name) ?></h2>
                    <p class="profile-email"><?= h($user->email) ?></p>
                    <p class="profile-member">Member since <?= $user->created ? $user->created->format('M Y') : '-' ?></p>
                </div>

                <?= $this->Html->link(
                    'Edit Profile',
                    ['action' => 'editProfile'],
                    ['class' => 'btn-edit-profile', 'escape' => false]
                ) ?>
            </div>

            <!-- Stats Row -->
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-number"><?= count($user->bookings ?? []) ?></div>
                    <div class="stat-label">Bookings</div>
                </div>

                <div class="stat-divider"></div>

                <div class="stat-item">
                    <div class="stat-number"><?= count($user->reviews ?? []) ?></div>
                    <div class="stat-label">Reviews</div>
                </div>

                <div class="stat-divider"></div>

                <div class="stat-item">
                    <div class="stat-number"><?= $user->created ? $user->created->format('Y') : '-' ?></div>
                    <div class="stat-label">Member Since</div>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <h5>Personal Information</h5>
                    </div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <div class="info-label">Full Name</div>
                            <div class="info-value"><?= h($user->name) ?></div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">IC Number</div>
                            <div class="info-value"><?= h($user->ic_number) ?: '-' ?></div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Email Address</div>
                            <div class="info-value"><?= h($user->email) ?></div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value"><?= h($user->phone) ?: '-' ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <h5>Address & Account</h5>
                    </div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <div class="info-label">Registered Address</div>
                            <div class="info-value">
                                <?= $user->address ? nl2br(h($user->address)) : '<span class="text-muted">No address provided</span>' ?>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Member Since</div>
                            <div class="info-value"><?= $user->created ? $user->created->format('d M Y') : '-' ?></div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">Last Updated</div>
                            <div class="info-value"><?= $user->modified ? $user->modified->format('d M Y, h:i A') : '-' ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="quick-links">
            <p class="quick-links-title">Quick Links</p>
            <div>
                <?= $this->Html->link(
                    'My Bookings',
                    ['controller' => 'Bookings', 'action' => 'myBookings'],
                    ['class' => 'btn-quick-link', 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    'Browse Cars',
                    ['controller' => 'Cars', 'action' => 'index'],
                    ['class' => 'btn-quick-link', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Related Bookings -->
        <div class="related-section">
            <div class="related-section-header">
                <h5>My Bookings</h5>
            </div>
        <?php if (!empty($user->bookings)): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Car ID</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user->bookings as $booking): ?>
                            <tr>
                                <td>#<?= h($booking->id) ?></td>
                                <td><?= h($booking->car_id) ?></td>
                                <td><?= h($booking->start_date->format('d M Y')) ?></td>
                                <td><?= h($booking->end_date->format('d M Y')) ?></td>
                                <td>RM <?= $this->Number->format($booking->total_price ?? 0, ['places' => 2]) ?></td>
                                <td>
                                    <?php
                                    $statusClass = match ($booking->booking_status) {
                                        'confirmed' => 'bg-success text-white',
                                        'pending' => 'bg-warning text-dark',
                                        'cancelled' => 'bg-danger text-white',
                                        'completed' => 'bg-info text-white',
                                        default => 'bg-secondary text-white'
                                    };
                                    ?>
                                    <span class="status-badge <?= $statusClass ?>"><?= ucfirst(h($booking->booking_status)) ?></span>
                                </td>
                                <td>
                                        <?= $this->Html->link('View', ['controller' => 'Bookings', 'action' => 'viewBookings', $booking->id], ['class' => 'action-btn']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-calendar-times d-block"></i>
                <p>You haven't made any bookings yet.</p>
                <?= $this->Html->link(
                    '<i class="fas fa-car me-2"></i>Browse Cars & Book Now',
                    ['controller' => 'Cars', 'action' => 'index'],
                    ['class' => 'btn btn-primary rounded-pill px-4', 'escape' => false]
                ) ?>
            </div>
        <?php endif; ?>
        </div>

        <!-- Related Reviews -->
        <div class="related-section">
            <div class="related-section-header">
                <h5>My Reviews</h5>
            </div>
        <?php if (!empty($user->reviews)): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Car ID</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user->reviews as $review): ?>
                            <tr>
                                <td>#<?= h($review->id) ?></td>
                                <td><?= h($review->car_id) ?></td>
                                <td>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= $review->rating ? 'text-warning' : 'text-muted' ?>"></i>
                                    <?php endfor; ?>
                                </td>
                                <td><?= h($review->comment) ?></td>
                                <td><?= h($review->created->format('d M Y')) ?></td>
                                <td>
                                        <?= $this->Html->link('View', ['controller' => 'Reviews', 'action' => 'view', $review->id], ['class' => 'action-btn']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-comment-slash d-block"></i>
                <p>You haven't written any reviews yet.</p>
            </div>
        <?php endif; ?>
        </div>

    </div>
</div>