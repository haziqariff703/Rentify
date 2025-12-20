<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
// Short variables to make code cleaner
$booking = $invoice->booking;
$user = $booking->user;
$car = $booking->car;
?>

<div class="row mb-3 no-print">
    <div class="col-md-12 text-end">
        <?= $this->Html->link('Back to List', ['action' => 'index'], ['class' => 'btn btn-secondary me-2']) ?>
        <button onclick="window.print()" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Download / Print PDF
        </button>
    </div>
</div>

<div class="invoice-container">
    <div class="invoice-header">
        <div class="row">
            <div class="col-6">
                <h1>RENTIFY</h1>
                <p>Premium Car Rental Services</p>
            </div>
            <div class="col-6 text-end">
                <h3>INVOICE</h3>
                <p><strong>Invoice #:</strong> <?= h($invoice->invoice_number) ?></p>
                <p><strong>Date:</strong> <?= h($invoice->created->format('d M Y')) ?></p>
                <?php if(strtolower($invoice->status) == 'paid'): ?>
                    <div style="color: green; font-weight: bold; border: 2px solid green; display: inline-block; padding: 5px 10px; transform: rotate(-10deg);">PAID</div>
                <?php else: ?>
                    <div style="color: red; font-weight: bold; border: 2px solid red; display: inline-block; padding: 5px 10px;">UNPAID</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="invoice-body mt-4">
        <div class="row">
            <div class="col-6">
                <h5>Bill To:</h5>
                <p>
                    <strong><?= h($user->name) ?></strong><br>
                    <?= h($user->email) ?><br>
                    <?= h($user->phone ?? 'No Phone') ?>
                </p>
            </div>
            <div class="col-6 text-end">
                <h5>Pay To:</h5>
                <p>
                    <strong>Rentify Sdn Bhd</strong><br>
                    Maybank: 5555-0000-1234<br>
                    rentify@business.com
                </p>
            </div>
        </div>

        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Description</th>
                    <th class="text-center">Dates</th>
                    <th class="text-end">Amount (RM)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong><?= h($car->brand . ' ' . $car->car_model) ?></strong><br>
                        <small>Plate Number: <?= h($car->plate_number) ?></small>
                    </td>
                    <td class="text-center">
                        <?= h($booking->start_date->format('d M')) ?> to <?= h($booking->end_date->format('d M Y')) ?>
                    </td>
                    <td class="text-end">
                        <?= number_format($invoice->amount, 2) ?>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end"><strong>Total:</strong></td>
                    <td class="text-end"><strong>RM <?= number_format($invoice->amount, 2) ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="invoice-footer mt-5 text-center text-muted">
        <p>Thank you for choosing Rentify. Please pay within 24 hours.</p>
    </div>
</div>

<style>
    /* Screen Styles */
    .invoice-container {
        background: white;
        padding: 40px;
        border: 1px solid #ddd;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    /* Print Styles */
    @media print {
        /* Hide everything by default */
        body * {
            visibility: hidden;
        }
        
        /* Show only the invoice container */
        .invoice-container, .invoice-container * {
            visibility: visible;
        }

        /* Position the invoice correctly */
        .invoice-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
            margin: 0;
            padding: 20px;
        }

        /* Hide buttons and navbars */
        .no-print, header, footer, .side-nav, .top-nav {
            display: none !important;
        }
    }
</style>