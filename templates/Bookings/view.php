<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */

// Check if admin
$identity = $this->request->getAttribute('identity');
$isAdmin = $identity && $identity->role === 'admin';
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php if ($isAdmin): ?>
                <?= $this->Html->link(__('Edit Booking'), ['action' => 'edit', $booking->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Form->postLink(__('Delete Booking'), ['action' => 'delete', $booking->id], ['confirm' => __('Are you sure you want to delete # {0}?', $booking->id), 'class' => 'side-nav-item']) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('List Bookings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?php if (!$isAdmin): ?>
                <?= $this->Html->link(__('New Booking'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            <?php endif; ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookings view content">
            <h3>Booking #<?= h($booking->id) ?></h3>

            <?php if ($isAdmin && $booking->booking_status === 'pending'): ?>
                <!-- Admin Approval Section -->
                <div class="card mb-4 border-warning">
                    <div class="card-header bg-warning text-dark">
                        <i class="fas fa-clock"></i> <strong>Pending Approval</strong>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">This booking is waiting for admin approval.</p>
                        <div class="d-flex gap-2">
                            <?= $this->Form->postLink(
                                '<i class="fas fa-check"></i> Approve Booking',
                                ['controller' => 'Admins', 'action' => 'approveBooking', $booking->id],
                                [
                                    'class' => 'btn btn-success',
                                    'escape' => false,
                                    'confirm' => __('Approve this booking? The car status will be updated to Rented.'),
                                ]
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-times"></i> Reject Booking',
                                ['controller' => 'Admins', 'action' => 'rejectBooking', $booking->id],
                                [
                                    'class' => 'btn btn-danger',
                                    'escape' => false,
                                    'confirm' => __('Reject this booking?'),
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <table class="table">
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $booking->hasValue('user') ? $this->Html->link($booking->user->name, ['controller' => 'Users', 'action' => 'view', $booking->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Car') ?></th>
                    <td><?= $booking->hasValue('car') ? $this->Html->link($booking->car->car_model, ['controller' => 'Cars', 'action' => 'view', $booking->car->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Booking Status') ?></th>
                    <td>
                        <?php
                        $statusClass = match ($booking->booking_status) {
                            'pending' => 'bg-warning text-dark',
                            'confirmed' => 'bg-success',
                            'cancelled' => 'bg-danger',
                            'completed' => 'bg-info',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= ucfirst(h($booking->booking_status)) ?></span>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($booking->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Price') ?></th>
                    <td>$<?= $booking->total_price === null ? '0' : $this->Number->format($booking->total_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($booking->start_date?->format('M d, Y')) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($booking->end_date?->format('M d, Y')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($booking->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($booking->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Invoices') ?></h4>
                <?php if (!empty($booking->invoices)) : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Invoice Number') ?></th>
                                <th><?= __('Amount') ?></th>
                                <th><?= __('Status') ?></th>
                                <th><?= __('Created') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($booking->invoices as $invoice) : ?>
                                <tr>
                                    <td><?= h($invoice->id) ?></td>
                                    <td><?= h($invoice->invoice_number) ?></td>
                                    <td>$<?= h($invoice->amount) ?></td>
                                    <td>
                                        <?php
                                        $invStatusClass = match ($invoice->status) {
                                            'paid' => 'bg-success',
                                            'unpaid' => 'bg-warning text-dark',
                                            default => 'bg-secondary'
                                        };
                                        ?>
                                        <span class="badge <?= $invStatusClass ?>"><?= ucfirst(h($invoice->status)) ?></span>
                                    </td>
                                    <td><?= h($invoice->created) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Invoices', 'action' => 'view', $invoice->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                        <?php if ($isAdmin): ?>
                                            <?= $this->Html->link(__('Edit'), ['controller' => 'Invoices', 'action' => 'edit', $invoice->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No invoices found.</p>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Payments') ?></h4>
                <?php if (!empty($booking->payments)) : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Amount') ?></th>
                                <th><?= __('Payment Method') ?></th>
                                <th><?= __('Payment Date') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($booking->payments as $payment) : ?>
                                <tr>
                                    <td><?= h($payment->id) ?></td>
                                    <td>$<?= h($payment->amount) ?></td>
                                    <td><?= h($payment->payment_method) ?></td>
                                    <td><?= h($payment->payment_date) ?></td>
                                    <td>
                                        <?php
                                        $payStatusClass = match ($payment->payment_status) {
                                            'paid' => 'bg-success',
                                            'pending' => 'bg-warning text-dark',
                                            'failed' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                        ?>
                                        <span class="badge <?= $payStatusClass ?>"><?= ucfirst(h($payment->payment_status)) ?></span>
                                    </td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payment->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                        <?php if ($isAdmin): ?>
                                            <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payment->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No payments found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>