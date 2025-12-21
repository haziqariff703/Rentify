<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */

// Check if admin
$identity = $this->request->getAttribute('identity');
$isAdmin = $identity && $identity->role === 'admin';
?>
<div class="bookings index content">
    <?php if (!$isAdmin): ?>
        <?= $this->Html->link(__('New Booking'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Bookings') ?></h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id', 'Customer') ?></th>
                    <th><?= $this->Paginator->sort('car_id', 'Car') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('total_price') ?></th>
                    <th><?= $this->Paginator->sort('booking_status', 'Status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                    <?php if ($isAdmin): ?>
                        <th class="actions"><?= __('Approval') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= $this->Number->format($booking->id) ?></td>
                        <td><?= $booking->hasValue('user') ? $this->Html->link($booking->user->name, ['controller' => 'Users', 'action' => 'view', $booking->user->id]) : '' ?></td>
                        <td><?= $booking->hasValue('car') ? $this->Html->link($booking->car->car_model, ['controller' => 'Cars', 'action' => 'view', $booking->car->id]) : '' ?></td>
                        <td><?= h($booking->start_date?->format('M d, Y')) ?></td>
                        <td><?= h($booking->end_date?->format('M d, Y')) ?></td>
                        <td>$<?= $booking->total_price === null ? '0' : $this->Number->format($booking->total_price) ?></td>
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
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $booking->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                            <?php if ($isAdmin): ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $booking->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['action' => 'delete', $booking->id],
                                    [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'confirm' => __('Are you sure you want to delete booking #{0}?', $booking->id),
                                    ]
                                ) ?>
                            <?php endif; ?>
                        </td>
                        <?php if ($isAdmin): ?>
                            <td class="actions">
                                <?php if ($booking->booking_status === 'pending'): ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fas fa-check"></i> Approve',
                                        ['controller' => 'Admins', 'action' => 'approveBooking', $booking->id],
                                        [
                                            'class' => 'btn btn-sm btn-success',
                                            'escape' => false,
                                            'confirm' => __('Approve booking #{0}? This will mark the car as Rented.', $booking->id),
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
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>