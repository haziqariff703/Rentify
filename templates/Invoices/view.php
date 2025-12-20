<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
$booking = $invoice->booking;
$user = $booking->user;
$car = $booking->car;
?>

<div class="row mb-3 no-print">
    <div class="col-md-12 text-end">
        <?= $this->Html->link('Back', ['action' => 'index'], ['class' => 'btn btn-secondary me-2']) ?>
        <button onclick="window.print()" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Download PDF
        </button>
    </div>
</div>

<div class="invoice-container">
    
    <div class="invoice-header">
        <div class="row align-items-center">
            <div class="col-6">
                <h1 class="text-primary" style="font-weight: 800; letter-spacing: 2px; margin: 0;">RENTIFY</h1>
                <p class="text-muted mb-0">Premium Car Rental</p>
            </div>
            <div class="col-6 text-end">
                <h3 style="font-weight: 300; margin: 0;">INVOICE</h3>
                <p class="mb-0"><strong>#<?= h($invoice->invoice_number) ?></strong></p>
                <p class="mb-1 text-muted small"><?= h($invoice->created->format('d M Y')) ?></p>
                
                <?php if(strtolower($invoice->status) == 'paid'): ?>
                    <span class="badge bg-success" style="font-size: 0.8rem;">PAID</span>
                <?php else: ?>
                    <span class="badge bg-danger" style="font-size: 0.8rem;">UNPAID</span>
                <?php endif; ?>
            </div>
        </div>
        <hr style="margin: 20px 0; border-top: 2px solid #eee;">
    </div>

    <div class="invoice-body">
        <div class="row mb-4">
            <div class="col-6">
                <h6 class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Bill To:</h6>
                <p class="mb-0 fw-bold text-dark"><?= h($user->name) ?></p>
                <p class="mb-0 text-muted small"><?= h($user->email) ?></p>
                <p class="text-muted small"><?= h($user->phone ?? '-') ?></p>
            </div>
            <div class="col-6 text-end">
                <h6 class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Pay To:</h6>
                <p class="mb-0 fw-bold text-dark">Rentify Sdn Bhd</p>
                <p class="mb-0 text-muted small">Maybank: 5555-0000-1234</p>
                <p class="text-muted small">rentify@business.com</p>
            </div>
        </div>

        <table class="table custom-table mb-4">
            <thead>
                <tr>
                    <th style="width: 45%">Description</th>
                    <th class="text-center">Dates</th>
                    <th class="text-end">Amount (RM)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-3">
                        <strong class="text-dark"><?= h($car->brand . ' ' . $car->car_model) ?></strong><br>
                        <span class="text-muted small">Plate: <?= h($car->plate_number) ?></span>
                    </td>
                    <td class="text-center py-3 align-middle small">
                        <?= h($booking->start_date->format('d M')) ?> - <?= h($booking->end_date->format('d M Y')) ?>
                    </td>
                    <td class="text-end py-3 align-middle fw-bold">
                        <?= number_format($invoice->amount, 2) ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="row justify-content-end mb-4">
            <div class="col-5">
                <div class="d-flex justify-content-between mb-1 small">
                    <span class="text-muted">Subtotal:</span>
                    <span class="fw-bold">RM <?= number_format($invoice->amount, 2) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2 border-bottom pb-2 small">
                    <span class="text-muted">Tax (0%):</span>
                    <span class="fw-bold">RM 0.00</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fs-5 fw-bold text-dark">Total:</span>
                    <span class="fs-4 fw-bold text-primary">RM <?= number_format($invoice->amount, 2) ?></span>
                </div>
            </div>
        </div>
        
        <div class="terms-section p-3 rounded" style="background-color: #f8f9fa; margin-top: auto; border: 1px solid #eee;">
            <h6 class="fw-bold small mb-2">Terms & Conditions</h6>
            <ul class="text-muted small mb-0 ps-3" style="font-size: 0.8rem;">
                <li>Payment is due within 24 hours.</li>
                <li>Late returns incur a RM 50.00 daily fee.</li>
                <li>Please reference Invoice #<?= h($invoice->invoice_number) ?> in transfer.</li>
            </ul>
        </div>
    </div>

    <div class="invoice-footer text-center mt-4">
        <p class="fw-bold mb-0 small">Thank you for choosing Rentify!</p>
        <p class="text-muted" style="font-size: 0.7rem;">Questions? Contact support@rentify.com</p>
    </div>
</div>

<style>
    /* SCREEN STYLES */
    .invoice-container {
        background: white;
        padding: 40px; 
        border: 1px solid #ddd;
        border-radius: 8px;
        max-width: 800px;
        margin: 0 auto;
        
        /* Flexbox to keep content distributed */
        display: flex;
        flex-direction: column;
        
        /* Reduced Height to fit safer on A4 */
        min-height: 250mm; 
    }

    .invoice-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .custom-table thead th {
        background-color: #343a40;
        color: white;
        padding: 10px;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    /* PRINT STYLES - CRITICAL FIXES */
    @media print {
        /* 1. Remove browser margins so our design fits */
        @page { margin: 0; size: auto; }
        
        /* 2. Hide everything else */
        body * { visibility: hidden; }
        .invoice-container, .invoice-container * { visibility: visible; }
        
        /* 3. Position and Size */
        .invoice-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100vh; /* Force full page height */
            margin: 0;
            padding: 30px 40px; /* Adjust padding for paper */
            border: none;
            box-shadow: none;
            min-height: auto; /* Let content flow naturally if needed */
        }
        
        .no-print { display: none !important; }
        
        /* Ensure Colors Print */
        .custom-table thead th {
            -webkit-print-color-adjust: exact;
            background-color: #343a40 !important;
            color: white !important;
        }
        
        .bg-primary, .bg-success, .bg-danger {
            -webkit-print-color-adjust: exact;
        }
    }
</style>