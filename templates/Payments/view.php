<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Payment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="payments view content">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Payment Receipt #<?= h($payment->id) ?></h3>
                
                <?= $this->Html->link(
                    '⬅ Back to Booking', 
                    ['controller' => 'Bookings', 'action' => 'view', $payment->booking_id], 
                    ['class' => 'button']
                ) ?>
            </div>

            <table>
                <tr>
                    <th><?= __('Booking ID') ?></th>
                    <td>
                        <?= $payment->hasValue('booking') ? $this->Html->link('Booking #' . $payment->booking->id, ['controller' => 'Bookings', 'action' => 'view', $payment->booking->id]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Amount Paid') ?></th>
                    <td>RM <?= $this->Number->format($payment->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Method') ?></th>
                    <td><?= h($payment->payment_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td>
                        <span style="color: green; font-weight: bold; text-transform: uppercase;">
                            <?= h($payment->payment_status) ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Payment Date') ?></th>
                    <td><?= h($payment->payment_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>