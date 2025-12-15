<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Invoice'), ['action' => 'edit', $invoice->invoice_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invoice'), ['action' => 'delete', $invoice->invoice_id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->invoice_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invoices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invoice'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoices view content">
            <h3><?= h($invoice->invoice_number) ?></h3>
            <table>
                <tr>
                    <th><?= __('Booking') ?></th>
                    <td><?= $invoice->hasValue('booking') ? $this->Html->link($invoice->booking->booking_id, ['controller' => 'Bookings', 'action' => 'view', $invoice->booking->booking_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Number') ?></th>
                    <td><?= h($invoice->invoice_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($invoice->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Id') ?></th>
                    <td><?= $this->Number->format($invoice->invoice_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($invoice->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($invoice->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($invoice->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>