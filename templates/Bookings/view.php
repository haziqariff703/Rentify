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

// Status colors
$statusColors = [
    'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
    'confirmed' => ['bg' => '#dcfce7', 'text' => '#166534'],
    'completed' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
    'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b']
];
$currentStatus = $statusColors[$booking->booking_status] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
?>

<div class="view-booking-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2>Booking #<?= h($booking->id) ?></h2>
            <p class="text-muted">
                <span class="status-badge" style="background: <?= $currentStatus['bg'] ?>; color: <?= $currentStatus['text'] ?>">
                    <?= h(ucfirst($booking->booking_status)) ?>
                </span>
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
                    ['confirm' => __('Are you sure you want to delete this booking?'), 'class' => 'btn btn-outline-danger', 'escape' => false]
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
    <?php if ($isAdmin && $booking->booking_status === 'pending'): ?>
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
                            <span class="status-badge" style="background: <?= $currentStatus['bg'] ?>; color: <?= $currentStatus['text'] ?>">
                                <?= h(ucfirst($booking->booking_status)) ?>
                            </span>
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
                                    <?php
                                    $invStatusClass = match ($invoice->status) {
                                        'paid' => 'bg-success',
                                        'unpaid' => 'bg-warning text-dark',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <tr>
                                        <td><code><?= h($invoice->invoice_number) ?></code></td>
                                        <td>RM <?= $this->Number->format($invoice->amount) ?></td>
                                        <td><span class="badge <?= $invStatusClass ?>"><?= ucfirst(h($invoice->status)) ?></span></td>
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
                                    <?php
                                    $payStatusClass = match ($payment->payment_status) {
                                        'paid' => 'bg-success',
                                        'pending' => 'bg-warning text-dark',
                                        'refunded' => 'bg-info',
                                        'failed' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <tr>
                                        <td><strong>RM <?= $this->Number->format($payment->amount) ?></strong></td>
                                        <td><?= h($payment->payment_method) ?></td>
                                        <td><?= h($payment->payment_date?->format('M d, Y')) ?></td>
                                        <td><span class="badge <?= $payStatusClass ?>"><?= ucfirst(h($payment->payment_status)) ?></span></td>
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

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&display=swap');

    .view-booking-container {
        font-family: 'Syne', sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header h2 {
        margin: 0;
        color: #1e293b;
    }

    .page-header .text-muted {
        margin: 8px 0 0;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .date-badge {
        color: #64748b;
        font-size: 0.9rem;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Approval Banner */
    .approval-banner {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .approval-content {
        display: flex;
        align-items: center;
        gap: 16px;
        color: #92400e;
    }

    .approval-content i {
        font-size: 2rem;
    }

    .approval-content p {
        margin: 0;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .approval-actions {
        display: flex;
        gap: 10px;
    }

    .view-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .form-card.full-width {
        grid-column: 1 / -1;
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 16px 20px;
    }

    .form-card .card-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .form-card .card-body {
        padding: 20px;
    }

    /* Car Preview */
    .image-card .card-body {
        padding: 0;
        position: relative;
    }

    .car-preview-image {
        width: 100%;
        height: 280px;
        object-fit: cover;
    }

    .car-info-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
    }

    .car-info-overlay h4 {
        margin: 0 0 4px;
        font-size: 1.1rem;
    }

    .car-info-overlay .car-price {
        margin: 0 0 12px;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .no-image-placeholder {
        width: 100%;
        height: 280px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .no-image-placeholder i {
        font-size: 4rem;
        margin-bottom: 16px;
    }

    /* View Table */
    .view-table {
        width: 100%;
        border-collapse: collapse;
    }

    .view-table tr {
        border-bottom: 1px solid #f1f5f9;
    }

    .view-table tr:last-child {
        border-bottom: none;
    }

    .view-table th {
        text-align: left;
        padding: 12px 16px 12px 0;
        width: 120px;
        color: #64748b;
        font-weight: 500;
    }

    .view-table td {
        padding: 12px 0;
        color: #1e293b;
    }

    .price-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #059669;
    }

    /* Specs Grid */
    .specs-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .spec-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        background: #f8fafc;
        border-radius: 10px;
    }

    .spec-item i {
        font-size: 1.2rem;
        color: #3b82f6;
        width: 24px;
    }

    .spec-label {
        display: block;
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .spec-value {
        display: block;
        font-weight: 600;
        color: #1e293b;
    }

    /* Related Sections */
    .related-sections {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .related-sections .table {
        margin: 0;
    }

    .related-sections .table thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
    }

    .related-sections .table tbody td {
        vertical-align: middle;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .view-grid {
            grid-template-columns: 1fr;
        }

        .specs-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .specs-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .approval-banner {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>