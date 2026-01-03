<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Car $car
 */

$statusColors = [
    'available' => ['bg' => '#dcfce7', 'text' => '#166534'],
    'booked' => ['bg' => '#fef3c7', 'text' => '#92400e'],
    'maintenance' => ['bg' => '#fee2e2', 'text' => '#991b1b']
];
$currentStatus = $statusColors[$car->status] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
?>

<div class="view-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2><?= h($car->brand) ?> <?= h($car->car_model) ?></h2>
            <p class="text-muted">
                <span class="plate-badge"><?= h($car->plate_number) ?></span>
                <span class="status-badge" style="background: <?= $currentStatus['bg'] ?>; color: <?= $currentStatus['text'] ?>">
                    <?= h(ucfirst($car->status)) ?>
                </span>
            </p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-edit me-2"></i>' . __('Edit Car'),
                ['action' => 'edit', $car->id],
                ['class' => 'btn btn-primary', 'escape' => false]
            ) ?>
            <?= $this->Form->postLink(
                '<i class="fas fa-trash me-2"></i>' . __('Delete'),
                ['action' => 'delete', $car->id],
                [
                    'class' => 'btn btn-outline-danger delete-confirm',
                    'escape' => false,
                    'data-confirm-message' => __('Are you sure you want to delete this car?')
                ]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <div class="view-grid">
        <!-- Left Column: Image Preview -->
        <div class="form-card image-card">
            <div class="card-header">
                <h5><i class="fas fa-image me-2"></i><?= __('Car Image') ?></h5>
            </div>
            <div class="card-body">
                <?php if ($car->image): ?>
                    <img src="<?= $this->Url->webroot('img/' . $car->image) ?>"
                        alt="<?= h($car->car_model) ?>"
                        class="car-preview-image">
                    <p class="image-filename mt-2"><i class="fas fa-file-image me-1"></i><?= h($car->image) ?></p>
                <?php else: ?>
                    <div class="no-image-placeholder">
                        <i class="fas fa-car"></i>
                        <p>No image available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Car Details -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-car me-2"></i><?= __('Car Information') ?></h5>
            </div>
            <div class="card-body">
                <table class="view-table">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><code>#<?= $this->Number->format($car->id) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= __('Category') ?></th>
                        <td>
                            <?php if ($car->hasValue('category')): ?>
                                <?php
                                // Get color from category (single source of truth)
                                $themeColor = h($car->category->badge_color ?? '#3b82f6');
                                ?>
                                <span class="category-badge" style="background: <?= $themeColor ?>20; color: <?= $themeColor ?>">
                                    <?= h($car->category->name) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Brand') ?></th>
                        <td><?= h($car->brand) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Model') ?></th>
                        <td><?= h($car->car_model) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Year') ?></th>
                        <td><?= $car->year ? $this->Number->format($car->year) : '—' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Plate Number') ?></th>
                        <td><code><?= h($car->plate_number) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= __('Price/Day') ?></th>
                        <td class="price-value">RM <?= $this->Number->format($car->price_per_day, ['places' => 2]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td>
                            <span class="status-badge" style="background: <?= $currentStatus['bg'] ?>; color: <?= $currentStatus['text'] ?>">
                                <?= h(ucfirst($car->status)) ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Specifications Card -->
        <div class="form-card full-width">
            <div class="card-header">
                <h5><i class="fas fa-cogs me-2"></i><?= __('Specifications') ?></h5>
            </div>
            <div class="card-body">
                <div class="specs-grid">
                    <div class="spec-item">
                        <i class="fas fa-cog"></i>
                        <div>
                            <span class="spec-label"><?= __('Transmission') ?></span>
                            <span class="spec-value"><?= h($car->transmission) ?: '—' ?></span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-users"></i>
                        <div>
                            <span class="spec-label"><?= __('Seats') ?></span>
                            <span class="spec-value"><?= $this->Number->format($car->seats) ?> seats</span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-engine"></i>
                        <div>
                            <span class="spec-label"><?= __('Engine') ?></span>
                            <span class="spec-value"><?= h($car->engine) ?: '—' ?></span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-tachometer-alt"></i>
                        <div>
                            <span class="spec-label"><?= __('0-60 Time') ?></span>
                            <span class="spec-value"><?= h($car->zero_to_sixty) ?: '—' ?></span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-palette"></i>
                        <div>
                            <span class="spec-label"><?= __('Theme Color') ?></span>
                            <span class="spec-value">
                                <?php $catColor = h($car->category->badge_color ?? '#3b82f6'); ?>
                                <span class="color-swatch" style="background: <?= $catColor ?>"></span>
                                <?= $catColor ?> (from <?= h($car->category->name ?? 'Category') ?>)
                            </span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <span class="spec-label"><?= __('Created') ?></span>
                            <span class="spec-value"><?= h($car->created->format('M d, Y')) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Data Sections -->
    <div class="related-sections">
        <!-- Related Bookings -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-calendar-check me-2"></i><?= __('Related Bookings') ?>
                    <span class="badge bg-light text-dark ms-2"><?= count($car->bookings) ?></span>
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($car->bookings)) : ?>
                    <!-- Booking Status Summary -->
                    <div class="booking-summary mb-3">
                        <?php
                        $statusCounts = ['pending' => 0, 'confirmed' => 0, 'completed' => 0, 'cancelled' => 0];
                        foreach ($car->bookings as $booking) {
                            $status = $booking->booking_status ?? 'pending';
                            if (isset($statusCounts[$status])) {
                                $statusCounts[$status]++;
                            }
                        }
                        ?>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="status-count pending">
                                <i class="fas fa-clock me-1"></i><?= $statusCounts['pending'] ?> Pending
                            </span>
                            <span class="status-count confirmed">
                                <i class="fas fa-check-circle me-1"></i><?= $statusCounts['confirmed'] ?> Confirmed
                            </span>
                            <span class="status-count completed">
                                <i class="fas fa-flag-checkered me-1"></i><?= $statusCounts['completed'] ?> Completed
                            </span>
                            <span class="status-count cancelled">
                                <i class="fas fa-times-circle me-1"></i><?= $statusCounts['cancelled'] ?> Cancelled
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?= __('ID') ?></th>
                                    <th><?= __('User') ?></th>
                                    <th><?= __('Start Date') ?></th>
                                    <th><?= __('End Date') ?></th>
                                    <th><?= __('Total') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($car->bookings as $booking) : ?>
                                    <?php
                                    $statusClass = match ($booking->booking_status) {
                                        'pending' => 'bg-warning text-dark',
                                        'confirmed' => 'bg-success',
                                        'completed' => 'bg-primary',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <tr>
                                        <td><code>#<?= h($booking->id) ?></code></td>
                                        <td><?= h($booking->user_id) ?></td>
                                        <td><?= h($booking->start_date) ?></td>
                                        <td><?= h($booking->end_date) ?></td>
                                        <td>RM <?= $this->Number->format($booking->total_price) ?></td>
                                        <td><span class="badge <?= $statusClass ?>"><?= h(ucfirst($booking->booking_status)) ?></span></td>
                                        <td>
                                            <?= $this->Html->link('<i class="fas fa-eye"></i>', ['controller' => 'Bookings', 'action' => 'view', $booking->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-inbox me-2"></i>No bookings found</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Related Maintenances -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-tools me-2"></i><?= __('Maintenance History') ?>
                    <span class="badge bg-light text-dark ms-2"><?= count($car->maintenances) ?></span>
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($car->maintenances)) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?= __('ID') ?></th>
                                    <th><?= __('Description') ?></th>
                                    <th><?= __('Cost') ?></th>
                                    <th><?= __('Date') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($car->maintenances as $maintenance) : ?>
                                    <tr>
                                        <td><code>#<?= h($maintenance->id) ?></code></td>
                                        <td><?= h($maintenance->description) ?></td>
                                        <td>RM <?= $this->Number->format($maintenance->cost ?? 0) ?></td>
                                        <td><?= h($maintenance->maintenance_date) ?></td>
                                        <td><span class="badge bg-warning text-dark"><?= h($maintenance->status) ?></span></td>
                                        <td>
                                            <?= $this->Html->link('<i class="fas fa-eye"></i>', ['controller' => 'Maintenances', 'action' => 'view', $maintenance->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-inbox me-2"></i>No maintenance records</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Related Reviews -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-star me-2"></i><?= __('Customer Reviews') ?>
                    <span class="badge bg-light text-dark ms-2"><?= count($car->reviews) ?></span>
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($car->reviews)) : ?>
                    <div class="reviews-list">
                        <?php foreach ($car->reviews as $review) : ?>
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?= $i <= $review->rating ? 'text-warning' : 'text-muted' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="review-date"><?= h($review->created->format('M d, Y')) ?></span>
                                </div>
                                <p class="review-comment"><?= h($review->comment) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-inbox me-2"></i>No reviews yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>