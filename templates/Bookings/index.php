<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */

// Check if admin
$identity = $this->request->getAttribute('identity');
$isAdmin = $identity && $identity->role === 'admin';
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Booking Management') ?></h2>
            <p><?= __('Manage all customer bookings') ?></p>
        </div>
        <?php if (!$isAdmin): ?>
            <?= $this->Html->link(
                '<i class="fas fa-plus me-2"></i>' . __('New Booking'),
                ['action' => 'add'],
                ['class' => 'btn-add', 'escape' => false]
            ) ?>
        <?php endif; ?>
    </div>

    <!-- Bookings DataTable -->
    <div class="table-responsive">
        <table id="bookingsTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="filterable" data-column="1">
                        <span class="th-text">Customer</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="2">
                        <span class="th-text">Car</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Price</th>
                    <th class="filterable" data-column="6">
                        <span class="th-text">Payment</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="7">
                        <span class="th-text">Status</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Actions</th>
                    <?php if ($isAdmin): ?>
                        <th>Approval</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <?php
                    // Determine payment status from invoices
                    $isPaid = false;
                    if (!empty($booking->invoices)) {
                        foreach ($booking->invoices as $invoice) {
                            if ($invoice->status === 'paid') {
                                $isPaid = true;
                                break;
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td data-order="<?= h($booking->id) ?>"><code>#<?= h($booking->id) ?></code></td>
                        <td><?= $booking->hasValue('user') ? $this->Html->link($booking->user->name, ['controller' => 'Users', 'action' => 'view', $booking->user->id]) : '' ?></td>
                        <td><?= $booking->hasValue('car') ? $this->Html->link($booking->car->brand . ' ' . $booking->car->car_model, ['controller' => 'Cars', 'action' => 'view', $booking->car->id]) : '' ?></td>
                        <td><?= h($booking->start_date?->format('M d, Y')) ?></td>
                        <td><?= h($booking->end_date?->format('M d, Y')) ?></td>
                        <td class="price-cell">RM <?= $booking->total_price === null ? '0' : $this->Number->format($booking->total_price) ?></td>
                        <td>
                            <?= $this->Status->paymentBadge($isPaid ? 'paid' : 'pending') ?>
                        </td>
                        <td>
                            <?= $this->Status->bookingBadge($booking->display_status) ?>
                        </td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $booking->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?php if ($isAdmin): ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit"></i>',
                                    ['action' => 'edit', $booking->id],
                                    ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash"></i>',
                                    ['action' => 'delete', $booking->id],
                                    [
                                        'class' => 'btn btn-sm btn-outline-danger delete-confirm',
                                        'escape' => false,
                                        'title' => 'Delete',
                                        'data-confirm-message' => __('Are you sure you want to delete booking #{0}?', $booking->id)
                                    ]
                                ) ?>
                            <?php endif; ?>
                        </td>
                        <?php if ($isAdmin): ?>
                            <td class="actions-cell">
                                <?php if ($booking->booking_status === 'pending'): ?>
                                    <?php
                                    $confirmMsg = $isPaid
                                        ? __('Approve booking #{0}? This will mark the car as Rented.', $booking->id)
                                        : __('WARNING: Payment for booking #{0} is still PENDING. Approve anyway?', $booking->id);

                                    $btnClass = $isPaid ? 'btn-success' : 'btn-warning';
                                    ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fas fa-check"></i> ' . ($isPaid ? 'Approve' : 'Override'),
                                        ['controller' => 'Admins', 'action' => 'approveBooking', $booking->id],
                                        [
                                            'class' => 'btn btn-sm ' . $btnClass,
                                            'escape' => false,
                                            'confirm' => $confirmMsg,
                                        ]
                                    ) ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fas fa-times"></i> Reject',
                                        ['controller' => 'Admins', 'action' => 'rejectBooking', $booking->id],
                                        [
                                            'class' => 'btn btn-sm btn-danger',
                                            'escape' => false,
                                            'confirm' => __('Reject booking #{0}?', $booking->id),
                                        ]
                                    ) ?>
                                <?php elseif ($booking->booking_status === 'confirmed'): ?>
                                    <span class="text-success"><i class="fas fa-check-circle"></i> Approved</span>
                                <?php elseif ($booking->booking_status === 'cancelled'): ?>
                                    <span class="text-danger"><i class="fas fa-times-circle"></i> Rejected</span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- DataTables styling and initialization handled by shared files: datatables-custom.css and datatables-init.js -->