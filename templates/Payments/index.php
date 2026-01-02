<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Payment> $payments
 */
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Payments Management') ?></h2>
            <p><?= __('Track and manage all payment transactions') ?></p>
        </div>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New Payment'),
            ['action' => 'add'],
            ['class' => 'btn-add', 'escape' => false]
        ) ?>
    </div>

    <!-- Payments DataTable -->
    <div class="table-responsive">
        <table id="paymentsTable" class="table datatable-styled">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="filterable" data-column="1">
                        <span class="th-text">Booking</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Amount</th>
                    <th class="filterable" data-column="3">
                        <span class="th-text">Method</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Payment Date</th>
                    <th class="filterable" data-column="5">
                        <span class="th-text">Status</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><code>#<?= h($payment->id) ?></code></td>
                        <td>
                            <?php if ($payment->hasValue('booking')): ?>
                                <?= $this->Html->link('#' . $payment->booking->id, ['controller' => 'Bookings', 'action' => 'view', $payment->booking->id]) ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="price-cell">RM <?= $this->Number->format($payment->amount, ['places' => 2]) ?></td>
                        <td>
                            <?php
                            $method = strtolower($payment->payment_method ?? '');
                            $methodIcon = 'fa-university';
                            if (strpos($method, 'card') !== false || strpos($method, 'credit') !== false) {
                                $methodIcon = 'fa-credit-card';
                            } elseif (strpos($method, 'cash') !== false) {
                                $methodIcon = 'fa-money-bill-wave';
                            }
                            ?>
                            <span class="method-badge">
                                <i class="fas <?= $methodIcon ?> me-1"></i>
                                <?= h(ucfirst($payment->payment_method)) ?>
                            </span>
                        </td>
                        <td><?= $payment->payment_date ? (is_object($payment->payment_date) ? $payment->payment_date->format('M d, Y') : date('M d, Y', strtotime($payment->payment_date))) : '-' ?>
                        </td>
                        <td>
                            <?= $this->Status->paymentBadge($payment->payment_status) ?>
                        </td>
                        <td><?= $payment->created ? $payment->created->format('M d, Y') : '-' ?></td>
                        <td class="actions-cell">
                            <?php
                            $status = $payment->payment_status ?? '';
                            $needsConfirmation = empty($status) || $status === 'pending';
                            ?>
                            <?php if ($needsConfirmation): ?>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-check"></i>',
                                    ['action' => 'confirmCashPayment', $payment->id],
                                    [
                                        'class' => 'btn btn-sm btn-success',
                                        'escape' => false,
                                        'title' => 'Confirm Cash Payment',
                                        'confirm' => __('Are you sure you have received RM {0} in cash for this booking?', $this->Number->format($payment->amount))
                                    ]
                                ) ?>
                            <?php endif; ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $payment->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $payment->id],
                                ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $payment->id],
                                [
                                    'class' => 'btn btn-sm btn-outline-danger delete-confirm',
                                    'escape' => false,
                                    'title' => 'Delete',
                                    'data-confirm-message' => __('Are you sure you want to delete payment #{0}?', $payment->id)
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- DataTables styling and initialization handled by shared files: datatables-custom.css and datatables-init.js -->