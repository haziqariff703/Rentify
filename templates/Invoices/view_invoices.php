<?php

/**
 * Invoice View - User View with PDF Download
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
$booking = $invoice->booking;
$user = $booking->user;
$car = $booking->car;

// 1. FIND PAYMENT & FORMAT METHOD STRING
$paymentInfo = null;
$methodDisplay = '-';

// Check invoice status first - this is the source of truth after admin confirmation
$invoiceIsPaid = strtolower($invoice->status ?? 'unpaid') === 'paid';

if (!empty($booking->payments)) {
    foreach ($booking->payments as $p) {
        // Show receipt if: payment is paid/refunded, OR invoice is marked paid (for admin-confirmed cash)
        if ($p->payment_status === 'paid' || $p->payment_status === 'refunded' || $invoiceIsPaid) {
            $paymentInfo = $p;

            // Format the raw database string into human text
            $raw = $p->payment_method;
            if ($raw === 'card') {
                $methodDisplay = 'Credit/Debit Card';
            } elseif (str_contains($raw, 'online_transfer')) {
                $parts = explode('_', $raw);
                $bank = isset($parts[2]) ? ucfirst($parts[2]) : 'Transfer';
                $methodDisplay = 'FPX Online (' . $bank . ')';
            } elseif ($raw === 'cash') {
                $methodDisplay = 'Cash at Counter';
            } else {
                $methodDisplay = ucfirst(str_replace('_', ' ', $raw));
            }
            break;
        }
    }
}

// 2. REVERSE CALCULATOR (Smart Breakdown)
$subtotal = 0;
$tax = 0;
$addons = 0;
$days = 0;
$baseCost = 0;

if ($booking && $booking->car) {
    // A. Calculate Days (Inclusive: Jan 1 to Jan 2 = 2 Days)
    $days = $booking->end_date->diffInDays($booking->start_date) + 1;

    // B. Calculate Base Rental Cost
    $baseCost = $booking->car->price_per_day * $days;

    // C. Reverse Tax Calculation (Total / 1.06)
    $preTaxTotal = $invoice->amount / 1.06;

    // D. Derive Add-ons (PreTaxTotal - BaseCarCost)
    $addons = $preTaxTotal - $baseCost;

    // Safety: If floating point math makes it -0.00001, set to 0
    if ($addons < 0.01)
        $addons = 0;

    // E. Calculate Tax Amount
    $tax = $invoice->amount - $preTaxTotal;
}

// 3. BASE64 ENCODE LOGO FOR PDF PRINTING
$logoPath = WWW_ROOT . 'img' . DS . 'rentify_logo_black.png';
$logoBase64 = '';
if (file_exists($logoPath)) {
    $logoData = file_get_contents($logoPath);
    $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="container py-4" data-html2canvas-ignore="true">
    <!-- Page Header -->
    <div class="invoice-page-header">
        <div>
            <h2><?= __('Invoice') ?> #<?= h($invoice->invoice_number) ?></h2>
            <p class="text-muted">
                <?php
                $statusColors = [
                    'paid' => ['bg' => '#dcfce7', 'text' => '#166534'],
                    'unpaid' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                    'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                ];
                $invStatus = strtolower($invoice->status ?? 'unpaid');
                $statusStyle = $statusColors[$invStatus] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
                ?>
                <span class="inv-status-badge"
                    style="background: <?= $statusStyle['bg'] ?>; color: <?= $statusStyle['text'] ?>">
                    <?= h(ucfirst($invoice->status)) ?>
                </span>
                <span class="inv-amount">RM <?= number_format($invoice->amount, 2) ?></span>
            </p>
        </div>
        <div class="header-actions">
            <?php if (strtolower($invoice->status) === 'unpaid' && strtolower($booking->booking_status) !== 'cancelled'): ?>
                <?= $this->Html->link(
                    '<i class="fas fa-credit-card me-2"></i>' . __('Pay Now'),
                    ['controller' => 'Payments', 'action' => 'add', '?' => ['booking_id' => $invoice->booking_id, 'amount' => $invoice->amount]],
                    ['class' => 'btn btn-success', 'escape' => false]
                ) ?>
            <?php endif; ?>
            <button onclick="downloadPDF()" class="btn btn-dark">
                <i class="fas fa-download me-2"></i><?= __('Save as PDF') ?>
            </button>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to My Invoices'),
                ['action' => 'myInvoices'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>
</div>

<style>
    .invoice-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 16px;
    }

    .invoice-page-header h2 {
        margin: 0;
        color: #1e293b;
    }

    .invoice-page-header .text-muted {
        margin: 8px 0 0;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .inv-status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .inv-amount {
        font-size: 1.1rem;
        font-weight: 700;
        color: #059669;
    }

    .invoice-page-header .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .invoice-page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="invoice-wrapper">
    <div id="invoice-to-print" class="invoice-paper">

        <div class="row mb-5">
            <div class="col-6">
                <img src="<?= $this->Url->webroot('img/rentify_logo_black.png') ?>" alt="Rentify" class="brand-logo-img"
                    style="height: 150px; width: auto;">
                <div class="text-muted small mt-2">
                    <strong>Rentify Sdn Bhd</strong> (12345-X)<br>
                    Level 15, Menara Tech<br>
                    Shah Alam, Selangor, 40000
                </div>
            </div>
            <div class="col-6 text-end">
                <h1 class="fw-bold text-uppercase mb-1" style="color: #1e293b; letter-spacing: 2px;">Invoice</h1>
                <div class="text-primary fw-bold fs-5">#<?= h($invoice->invoice_number) ?></div>
                <div class="text-muted small mt-1">Issued: <?= h($invoice->created->format('d M Y')) ?></div>

                <div class="mt-3">
                    <?php if (strtolower($invoice->status) === 'paid'): ?>
                        <div class="stamp is-paid">PAID</div>
                    <?php elseif (strtolower($invoice->status) === 'cancelled'): ?>
                        <div class="stamp is-cancelled">VOID</div>
                    <?php else: ?>
                        <div class="stamp is-due">UNPAID</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr class="border-light my-4">

        <div class="row mb-5">
            <div class="col-6">
                <label class="small text-uppercase fw-bold text-muted mb-2">Billed To:</label>
                <h5 class="fw-bold mb-1"><?= h($user->name) ?></h5>
                <div class="text-muted small"><?= h($user->email) ?></div>
                <div class="text-muted small"><?= h($user->phone ?? '') ?></div>
            </div>
            <div class="col-6 text-end">

                <?php if ($paymentInfo): ?>
                    <div class="receipt-box">
                        <div class="receipt-header">
                            ✓ Payment Receipt
                        </div>

                        <div class="receipt-row">
                            <span class="receipt-label">Paid Via:</span>
                            <span class="receipt-value"><?= h($methodDisplay) ?></span>
                        </div>

                        <div class="receipt-row">
                            <span class="receipt-label">Date:</span>
                            <span class="receipt-value"><?= h($paymentInfo->created->format('d M Y, h:i A')) ?></span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-2">
                        <label class="small text-uppercase fw-bold text-muted mb-2">Total Due:</label>
                        <h2 class="fw-bold text-danger">RM <?= number_format($invoice->amount, 2) ?></h2>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-container mb-5">
            <table class="w-100 custom-table">
                <thead>
                    <tr>
                        <th class="text-start ps-3">Description</th>
                        <th class="text-center">Rate</th>
                        <th class="text-center">Duration</th>
                        <th class="text-end pe-3">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-3 py-3">
                            <div class="fw-bold text-dark"><?= h($car->brand . ' ' . $car->car_model) ?></div>
                            <div class="small text-muted">Plate: <?= h($car->plate_number) ?></div>
                            <div class="small text-muted mt-1">
                                <?= h($booking->start_date->format('d M')) ?> -
                                <?= h($booking->end_date->format('d M Y')) ?>
                            </div>
                        </td>
                        <td class="text-center py-3">RM <?= number_format($car->price_per_day, 2) ?></td>
                        <td class="text-center py-3"><?= $days ?> Days</td>
                        <td class="text-end pe-3 py-3 fw-bold">RM <?= number_format($baseCost, 2) ?></td>
                    </tr>

                    <?php
                    // Calculate individual add-on costs from booking flags and category rates
                    $category = $car->category ?? null;
                    $chauffeurCost = 0;
                    $gpsCost = 0;
                    $insuranceCost = 0;

                    if ($booking->has_chauffeur && $category) {
                        $chauffeurCost = (float)($category->chauffeur_daily_rate ?? 0) * $days;
                    }
                    if ($booking->has_gps && $category) {
                        $gpsCost = (float)($category->gps_daily_rate ?? 0) * $days;
                    }
                    if ($booking->has_full_insurance && $category) {
                        $insuranceCost = (float)($category->insurance_daily_rate ?? 0) * $days;
                    }

                    $hasAnyAddon = $booking->has_chauffeur || $booking->has_gps || $booking->has_full_insurance;
                    ?>

                    <?php if ($hasAnyAddon): ?>
                        <?php if ($booking->has_chauffeur): ?>
                            <tr>
                                <td class="ps-3 py-2">
                                    <div class="text-dark"><i class="fas fa-user-tie text-muted me-2"></i>Chauffeur Service</div>
                                </td>
                                <td class="text-center py-2">RM <?= number_format($category->chauffeur_daily_rate ?? 0, 2) ?></td>
                                <td class="text-center py-2"><?= $days ?> Days</td>
                                <td class="text-end pe-3 py-2">RM <?= number_format($chauffeurCost, 2) ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($booking->has_gps): ?>
                            <tr>
                                <td class="ps-3 py-2">
                                    <div class="text-dark"><i class="fas fa-map-marker-alt text-muted me-2"></i>GPS Navigation</div>
                                </td>
                                <td class="text-center py-2">RM <?= number_format($category->gps_daily_rate ?? 0, 2) ?></td>
                                <td class="text-center py-2"><?= $days ?> Days</td>
                                <td class="text-end pe-3 py-2">RM <?= number_format($gpsCost, 2) ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($booking->has_full_insurance): ?>
                            <tr>
                                <td class="ps-3 py-2">
                                    <div class="text-dark"><i class="fas fa-shield-alt text-muted me-2"></i>Full Coverage Insurance</div>
                                </td>
                                <td class="text-center py-2">RM <?= number_format($category->insurance_daily_rate ?? 0, 2) ?></td>
                                <td class="text-center py-2"><?= $days ?> Days</td>
                                <td class="text-end pe-3 py-2">RM <?= number_format($insuranceCost, 2) ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php elseif ($addons > 0): ?>
                        <!-- Fallback for legacy bookings without specific addon flags -->
                        <tr>
                            <td class="ps-3 py-3">
                                <div class="fw-bold text-dark">Add-on Services</div>
                                <div class="small text-muted">Optional Extras</div>
                            </td>
                            <td class="text-center py-3">-</td>
                            <td class="text-center py-3">-</td>
                            <td class="text-end pe-3 py-3 fw-bold">RM <?= number_format($addons, 2) ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end mb-5">
            <div class="col-5">
                <div class="d-flex justify-content-between mb-2 small text-muted">
                    <span>Subtotal</span>
                    <span>RM <?= number_format($baseCost + $addons, 2) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2 small text-muted border-bottom pb-2">
                    <span>SST (6%)</span>
                    <span>RM <?= number_format($tax, 2) ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="fw-bold fs-5 text-dark">Total</span>
                    <span class="fw-bold fs-4 text-primary">RM <?= number_format($invoice->amount, 2) ?></span>
                </div>
            </div>
        </div>

        <div class="mt-auto pt-4 border-top">
            <div class="row align-items-center">
                <div class="col-8">
                    <h6 class="fw-bold small mb-1">Terms & Conditions</h6>
                    <p class="small text-muted mb-0">
                        Payment is due within 24 hours of booking. Late returns will be charged at the daily rate plus a
                        RM50 penalty. Please keep this invoice for your records.
                    </p>
                </div>
                <div class="col-4 text-end">
                    <img src="<?= $this->Url->webroot('img/rentify_logo_black.png') ?>" alt="Rentify"
                        class="brand-logo-img opacity-50" style="height: 150px; width: auto;">
                </div>
            </div>

        </div>
    </div>

    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Syne', sans-serif;
        }

        .invoice-wrapper {
            display: flex;
            justify-content: center;
            padding-bottom: 50px;
        }

        .invoice-paper {
            background: white;
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .brand-logo {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -1px;
        }


        /* Receipt Box Styling */
        .receipt-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 15px;
            display: inline-block;
            text-align: left;
            min-width: 240px;
            border-left: 4px solid #059669;
        }

        .receipt-header {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: #166534;
            text-transform: uppercase;
            margin-bottom: 8px;
            border-bottom: 1px solid #bbf7d0;
            padding-bottom: 4px;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-table td {
            padding: 4px 0;
            font-size: 0.85rem;
        }

        .receipt-label {
            float: left;
            color: #6b7280;
            font-size: 0.85rem;
        }

        .receipt-value {
            float: right;
            color: #1f2937;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .receipt-row {
            display: block;
            overflow: hidden;
            margin-bottom: 6px;
            clear: both;
        }

        .receipt-row::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Table */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table thead th {
            background-color: #f8fafc;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 12px;
            border-bottom: 2px solid #e2e8f0;
        }

        .custom-table tbody td {
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        /* Stamps */
        .stamp {
            display: inline-block;
            padding: 5px 20px;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 2px;
            border: 3px solid;
            border-radius: 8px;
            transform: rotate(-3deg);
        }

        .is-paid {
            color: #059669;
            border-color: #059669;
            background: #ecfdf5;
        }

        .is-due {
            color: #dc2626;
            border-color: #dc2626;
            background: #fef2f2;
        }

        .is-cancelled {
            color: #94a3b8;
            border-color: #94a3b8;
            text-decoration: line-through;
        }
    </style>

    <script>
        window.RentifyData = {
            invoiceNumber: "<?= h($invoice->invoice_number) ?>"
        };
    </script>
    <script src="<?= $this->Url->assetUrl('js/views/Invoices/view.js') ?>?v=<?= time() ?>"></script>