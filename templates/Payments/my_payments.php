<?php
/** @var \App\View\AppView $this */
?>
<div class="container py-5">
    <h2 class="mb-4 fw-bold">My Payment History</h2>
    
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Date</th>
                        <th>Booking ID</th>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?= h($payment->created->format('d M Y, h:i A')) ?></td>
                        <td>#<?= h($payment->booking_id) ?></td>
                        <td><?= ucfirst(str_replace('_', ' ', h($payment->payment_method))) ?></td>
                        <td class="fw-bold text-success">RM <?= number_format($payment->amount, 2) ?></td>
                        <td><span class="badge bg-success">Success</span></td>
                        <td>
                            <?= $this->Html->link('View', ['action' => 'view', $payment->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>