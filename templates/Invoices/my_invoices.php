<?php
/**
 * My Invoices - User Dashboard (Centered Layout)
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Invoice> $invoices
 */
?>

<style>
    .badge-soft-success { background-color: #d1e7dd; color: #0f5132; }
    .badge-soft-danger { background-color: #f8d7da; color: #842029; }
    .badge-soft-secondary { background-color: #e2e3e5; color: #41464b; }
    
    .invoice-card {
        border-radius: 12px;
        border: 1px solid #f0f0f0;
        transition: transform 0.2s;
    }
    .invoice-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2">My Invoices</h2>
        <p class="text-muted">View and manage your payment history</p>
    </div>

    <div class="row g-4 mb-5 justify-content-center"> <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white h-100 p-3" style="border-radius: 15px;">
                <div class="card-body text-center"> <h6 class="text-uppercase opacity-75">Total Invoices</h6>
                    <h2 class="fw-bold mb-0"><?= count($invoices) ?></h2>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($invoices) && count($invoices) > 0): ?>
        <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-4">Invoice #</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Car / Service</th>
                            <th class="py-3">Amount</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-primary">
                                    #<?= h($invoice->invoice_number) ?>
                                </td>
                                <td class="text-muted">
                                    <?= h($invoice->created->format('d M Y')) ?>
                                </td>
                                <td>
                                    <?php if ($invoice->booking && $invoice->booking->car): ?>
                                        <span class="fw-bold text-dark"><?= h($invoice->booking->car->car_model) ?></span>
                                        <div class="small text-muted"><?= h($invoice->booking->car->plate_number) ?></div>
                                    <?php else: ?>
                                        <span class="text-muted">Car Removed</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold">
                                    RM <?= number_format($invoice->amount, 2) ?>
                                </td>
                                <td>
                                    <?php 
                                    $statusClass = match(strtolower($invoice->status)) {
                                        'paid' => 'badge-soft-success',
                                        'unpaid' => 'badge-soft-danger',
                                        'cancelled' => 'badge-soft-secondary',
                                        default => 'badge-soft-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass ?> px-3 py-2 rounded-pill text-uppercase">
                                        <?= h($invoice->status) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <?php if (strtolower($invoice->status) === 'unpaid'): ?>
                                        <?= $this->Html->link(
                                            '<i class="fas fa-credit-card me-1"></i> Pay Now',
                                            ['action' => 'view', $invoice->id],
                                            ['class' => 'btn btn-sm btn-success fw-bold shadow-sm', 'escape' => false]
                                        ) ?>
                                    <?php elseif (strtolower($invoice->status) === 'paid'): ?>
                                        <?= $this->Html->link(
                                            '<i class="fas fa-file-download me-1"></i> Receipt',
                                            ['action' => 'view', $invoice->id],
                                            ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]
                                        ) ?>
                                    <?php else: ?>
                                        <?= $this->Html->link(
                                            'View',
                                            ['action' => 'view', $invoice->id],
                                            ['class' => 'btn btn-sm btn-light text-muted']
                                        ) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-5">
            <nav><ul class="pagination"><?= $this->Paginator->numbers() ?></ul></nav>
        </div>

    <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-file-invoice-dollar fa-4x text-muted opacity-25"></i>
            </div>
            <h4 class="text-muted">No Invoices Found</h4>
            <p class="text-muted">You have no pending bills or history.</p>
        </div>
    <?php endif; ?>
</div>