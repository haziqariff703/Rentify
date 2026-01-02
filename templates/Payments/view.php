<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */

// Status colors
$statusColors = [
    'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
    'paid' => ['bg' => '#dcfce7', 'text' => '#166534'],
    'completed' => ['bg' => '#dcfce7', 'text' => '#166534'],
    'failed' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
    'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
];
$status = strtolower($payment->payment_status ?? 'pending');
$currentStatus = $statusColors[$status] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
?>

<div class="view-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2>Payment #<?= h($payment->id) ?></h2>
            <p class="text-muted">
                <span class="status-badge"
                    style="background: <?= $currentStatus['bg'] ?>; color: <?= $currentStatus['text'] ?>">
                    <?= h(ucfirst($payment->payment_status)) ?>
                </span>
                <span class="amount-badge">RM <?= $this->Number->format($payment->amount, ['places' => 2]) ?></span>
            </p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-edit me-2"></i>' . __('Edit'),
                ['action' => 'edit', $payment->id],
                ['class' => 'btn btn-primary', 'escape' => false]
            ) ?>
            <?= $this->Form->postLink(
                '<i class="fas fa-trash me-2"></i>' . __('Delete'),
                ['action' => 'delete', $payment->id],
                [
                    'class' => 'btn btn-outline-danger delete-confirm',
                    'escape' => false,
                    'data-confirm-message' => __('Are you sure you want to delete this payment?')
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
        <!-- Payment Details -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-credit-card me-2"></i><?= __('Payment Details') ?></h5>
            </div>
            <div class="card-body">
                <table class="view-table">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><code>#<?= $this->Number->format($payment->id) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= __('Booking') ?></th>
                        <td>
                            <?php if ($payment->hasValue('booking')): ?>
                                <?= $this->Html->link('Booking #' . $payment->booking->id, ['controller' => 'Bookings', 'action' => 'view', $payment->booking->id]) ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Amount') ?></th>
                        <td class="price-value">RM <?= $this->Number->format($payment->amount, ['places' => 2]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Method') ?></th>
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
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td>
                            <span class="status-badge"
                                style="background: <?= $currentStatus['bg'] ?>; color: <?= $currentStatus['text'] ?>">
                                <?= h(ucfirst($payment->payment_status)) ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Dates Card -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-calendar-alt me-2"></i><?= __('Date Information') ?></h5>
            </div>
            <div class="card-body">
                <table class="view-table">
                    <tr>
                        <th><?= __('Payment Date') ?></th>
                        <td><?= $payment->payment_date ? (is_object($payment->payment_date) ? $payment->payment_date->format('M d, Y') : date('M d, Y', strtotime($payment->payment_date))) : '—' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($payment->created?->format('M d, Y, g:i A')) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($payment->modified?->format('M d, Y, g:i A')) ?></td>
                    </tr>
                </table>

                <?php if ($payment->hasValue('booking')): ?>
                    <div class="mt-4 pt-3 border-top">
                        <?= $this->Html->link(
                            '<i class="fas fa-calendar-check me-2"></i>' . __('View Related Booking'),
                            ['controller' => 'Bookings', 'action' => 'view', $payment->booking_id],
                            ['class' => 'btn btn-outline-primary w-100', 'escape' => false]
                        ) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>