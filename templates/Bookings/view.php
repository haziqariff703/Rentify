<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Booking'), ['action' => 'edit', $booking->booking_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Booking'), ['action' => 'delete', $booking->booking_id], ['confirm' => __('Are you sure you want to delete # {0}?', $booking->booking_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bookings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Booking'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookings view content">
            <h3><?= h($booking->booking_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $booking->hasValue('user') ? $this->Html->link($booking->user->name, ['controller' => 'Users', 'action' => 'view', $booking->user->user_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Car') ?></th>
                    <td><?= $booking->hasValue('car') ? $this->Html->link($booking->car->car_model, ['controller' => 'Cars', 'action' => 'view', $booking->car->car_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Booking Status') ?></th>
                    <td><?= h($booking->booking_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Booking Id') ?></th>
                    <td><?= $this->Number->format($booking->booking_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Price') ?></th>
                    <td><?= $booking->total_price === null ? '' : $this->Number->format($booking->total_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($booking->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($booking->end_date) ?></td>
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
        </div>
    </div>
</div>