<?php

/**
 * Booking View - Admin Interface (Following Cars/view.php Layout)
 * 
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */

// Check if admin
$identity = $this->request->getAttribute('identity');
$isAdmin = $identity && $identity->role === 'admin';

// Location labels
$locationLabels = [
    'airport' => 'Airport Terminal 1',
    'city' => 'City Center HQ',
    'north' => 'Northern Branch',
    'south' => 'Southern Outlet'
];

?>

<div class="view-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2>Booking #<?= h($booking->id) ?></h2>
            <p class="text-muted">
                <?= $this->Status->bookingBadge($booking->display_status) ?>
                <span class="date-badge">
                    <i class="fas fa-calendar me-1"></i>
                    <?= h($booking->created?->format('M d, Y')) ?>
                </span>
            </p>
        </div>
        <div class="header-actions">
            <?php if ($isAdmin): ?>
                <?= $this->Html->link(
                    '<i class="fas fa-edit me-2"></i>' . __('Edit'),
                    ['action' => 'edit', $booking->id],
                    ['class' => 'btn btn-primary', 'escape' => false]
                ) ?>
                <?= $this->Form->postLink(
                    '<i class="fas fa-trash me-2"></i>' . __('Delete'),
                    ['action' => 'delete', $booking->id],
                    [
                        'class' => 'btn btn-outline-danger delete-confirm',
                        'escape' => false,
                        'data-confirm-message' => __('Are you sure you want to delete this booking?')
                    ]
                ) ?>
            <?php endif; ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- Admin Approval Banner -->
    <?php if ($isAdmin && $booking->display_status === 'pending'): ?>
        <div class="approval-banner">
            <div class="approval-content">
                <i class="fas fa-clock"></i>
                <div>
                    <strong>Pending Approval</strong>
                    <p>This booking is waiting for admin review</p>
                </div>
            </div>
            <div class="approval-actions">
                <?= $this->Form->postLink(
                    '<i class="fas fa-check me-2"></i>Approve',
                    ['controller' => 'Admins', 'action' => 'approveBooking', $booking->id],
                    ['class' => 'btn btn-success', 'escape' => false, 'confirm' => 'Approve this booking?']
                ) ?>
                <?= $this->Form->postLink(
                    '<i class="fas fa-times me-2"></i>Reject',
                    ['controller' => 'Admins', 'action' => 'rejectBooking', $booking->id],
                    ['class' => 'btn btn-danger', 'escape' => false, 'confirm' => 'Reject this booking?']
                ) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="view-grid">
        <!-- Left Column: Car Preview -->
        <div class="form-card image-card">
            <div class="card-header">
                <h5><i class="fas fa-car me-2"></i><?= __('Vehicle') ?></h5>
            </div>
            <div class="card-body">
                <?php if ($booking->hasValue('car') && $booking->car->image): ?>
                    <img src="<?= $this->Url->webroot('img/' . $booking->car->image) ?>"
                        alt="<?= h($booking->car->car_model) ?>"
                        class="car-preview-image">
                    <div class="car-info-overlay">
                        <h4><?= h($booking->car->brand) ?> <?= h($booking->car->car_model) ?></h4>
                        <p class="car-price">RM <?= $this->Number->format($booking->car->price_per_day) ?>/day</p>
                        <?= $this->Html->link('View Car Details', ['controller' => 'Cars', 'action' => 'view', $booking->car->id], ['class' => 'btn btn-sm btn-light']) ?>
                    </div>
                <?php else: ?>
                    <div class="no-image-placeholder">
                        <i class="fas fa-car"></i>
                        <p>No car image</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Booking Details -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2"></i><?= __('Booking Details') ?></h5>
            </div>
            <div class="card-body">
                <table class="view-table">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><code>#<?= $this->Number->format($booking->id) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= __('Customer') ?></th>
                        <td>
                            <?php if ($booking->hasValue('user')): ?>
                                <?= $this->Html->link($booking->user->name, ['controller' => 'Users', 'action' => 'view', $booking->user->id]) ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Vehicle') ?></th>
                        <td>
                            <?php if ($booking->hasValue('car')): ?>
                                <?= $this->Html->link($booking->car->brand . ' ' . $booking->car->car_model, ['controller' => 'Cars', 'action' => 'view', $booking->car->id]) ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td>
                            <?= $this->Status->bookingBadge($booking->display_status) ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Total Price') ?></th>
                        <td class="price-value">RM <?= $this->Number->format($booking->total_price ?? 0) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Rental Period Card -->
        <div class="form-card full-width">
            <div class="card-header">
                <h5><i class="fas fa-calendar-alt me-2"></i><?= __('Rental Period & Location') ?></h5>
            </div>
            <div class="card-body">
                <div class="specs-grid">
                    <div class="spec-item">
                        <i class="fas fa-calendar-check"></i>
                        <div>
                            <span class="spec-label"><?= __('Pick-up Date') ?></span>
                            <span class="spec-value"><?= h($booking->start_date?->format('D, M d, Y')) ?></span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-calendar-times"></i>
                        <div>
                            <span class="spec-label"><?= __('Return Date') ?></span>
                            <span class="spec-value"><?= h($booking->end_date?->format('D, M d, Y')) ?></span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <span class="spec-label"><?= __('Pick-up Location') ?></span>
                            <span class="spec-value">
                                <?php
                                $loc = $booking->pickup_location;
                                echo $loc ? h($locationLabels[$loc] ?? ucfirst($loc)) : '—';
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <span class="spec-label"><?= __('Duration') ?></span>
                            <span class="spec-value">
                                <?php
                                $days = 1;
                                if ($booking->start_date && $booking->end_date) {
                                    $days = $booking->end_date->diffInDays($booking->start_date);
                                    if ($days == 0) $days = 1;
                                }
                                echo $days . ' ' . ($days == 1 ? 'day' : 'days');
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-plus-circle"></i>
                        <div>
                            <span class="spec-label"><?= __('Created') ?></span>
                            <span class="spec-value"><?= h($booking->created?->format('M d, Y, g:i A')) ?></span>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i class="fas fa-edit"></i>
                        <div>
                            <span class="spec-label"><?= __('Last Modified') ?></span>
                            <span class="spec-value"><?= h($booking->modified?->format('M d, Y, g:i A')) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Data Sections -->
    <div class="related-sections">
        <!-- Invoices -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-file-invoice me-2"></i><?= __('Invoices') ?>
                    <span class="badge bg-light text-dark ms-2"><?= count($booking->invoices ?? []) ?></span>
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($booking->invoices)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?= __('Invoice #') ?></th>
                                    <th><?= __('Amount') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th><?= __('Created') ?></th>
                                    <th><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($booking->invoices as $invoice): ?>
                                    <tr>
                                        <td><code><?= h($invoice->invoice_number) ?></code></td>
                                        <td>RM <?= $this->Number->format($invoice->amount) ?></td>
                                        <td><?= $this->Status->paymentBadge($invoice->status) ?></td>
                                        <td><?= h($invoice->created?->format('M d, Y')) ?></td>
                                        <td>
                                            <?= $this->Html->link('<i class="fas fa-eye"></i>', ['controller' => 'Invoices', 'action' => 'view', $invoice->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                            <?php if ($isAdmin): ?>
                                                <?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'Invoices', 'action' => 'edit', $invoice->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-inbox me-2"></i>No invoices found</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Payments -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-credit-card me-2"></i><?= __('Payments') ?>
                    <span class="badge bg-light text-dark ms-2"><?= count($booking->payments ?? []) ?></span>
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($booking->payments)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?= __('Amount') ?></th>
                                    <th><?= __('Method') ?></th>
                                    <th><?= __('Date') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($booking->payments as $payment): ?>
                                    <tr>
                                        <td><strong>RM <?= $this->Number->format($payment->amount) ?></strong></td>
                                        <td><?= h($payment->payment_method) ?></td>
                                        <td><?= h($payment->payment_date?->format('M d, Y')) ?></td>
                                        <td><?= $this->Status->paymentBadge($payment->payment_status) ?></td>
                                        <td>
                                            <?= $this->Html->link('<i class="fas fa-eye"></i>', ['controller' => 'Payments', 'action' => 'view', $payment->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                            <?php if ($isAdmin): ?>
                                                <?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'Payments', 'action' => 'edit', $payment->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-inbox me-2"></i>No payments found</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>