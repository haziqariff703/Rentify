<?php
/**
 * My Invoices - Clean Corporate Blue
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Invoice> $invoices
 */
?>

<style>
    /* Google Fonts - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

    /* ========================================
       DIAGONAL MICRO-STRIPE BACKGROUND
       ======================================== */
    .invoices-corporate-wrapper {
        background-color: #f8fafc;
        background-image: repeating-linear-gradient(
            135deg,
            transparent,
            transparent 10px,
            rgba(148, 163, 184, 0.05) 10px,
            rgba(148, 163, 184, 0.05) 11px
        );
        background-attachment: fixed;
        min-height: 100vh;
        padding: 50px 0 80px;
        /* Pull up to cancel layout pt-5 gap */
        margin-top: -3rem;
        /* FORCE FULL VIEWPORT WIDTH */
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* ========================================
       PAGE HEADER
       ======================================== */
    .invoices-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .invoices-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .invoices-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        letter-spacing: -2px;
        background: linear-gradient(to bottom, #1e293b, #475569);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }

    /* ========================================
       BRAND BLUE HERO WIDGET
       ======================================== */
    .hero-widget {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        border-radius: 20px;
        box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.4);
        margin-bottom: 50px;
        padding: 40px;
        text-align: center;
    }

    .hero-widget-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 10px;
    }

    .hero-widget-number {
        font-family: 'Montserrat', sans-serif;
        font-size: 4rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
    }

    /* ========================================
       WHITE TABLE CONTAINER
       ======================================== */
    .white-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        padding: 40px;
        overflow: hidden;
    }

    /* Scroll Wrapper */
    .table-scroll-wrapper {
        max-height: 400px;
        overflow-y: auto;
        border-radius: 12px;
    }

    /* Custom Scrollbar */
    .table-scroll-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* ========================================
       TABLE STYLING - LIGHT THEME
       ======================================== */
    .invoices-table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Sticky Header */
    .invoices-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .invoices-table thead th {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #64748b;
        padding: 15px 18px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .invoices-table tbody tr {
        transition: background 0.3s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .invoices-table tbody tr:hover {
        background: #f8fafc;
    }

    .invoices-table tbody tr:last-child {
        border-bottom: none;
    }

    .invoices-table tbody td {
        font-family: 'Montserrat', sans-serif;
        color: #334155;
        padding: 18px;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    /* Invoice Number */
    .invoice-number {
        color: #2563eb;
        font-weight: 700;
        font-family: 'Courier New', monospace;
    }

    /* Date */
    .invoice-date {
        color: #64748b;
        font-size: 0.85rem;
    }

    /* Car Name */
    .invoice-car {
        color: #1e293b;
        font-weight: 600;
    }

    .invoice-plate {
        font-family: 'Courier New', monospace;
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* Amount */
    .invoice-amount {
        color: #059669;
        font-weight: 700;
    }

    /* ========================================
       STATUS BADGES
       ======================================== */
    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
    }

    .status-badge.paid {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.unpaid {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .status-badge.cancelled {
        background: rgba(100, 116, 139, 0.1);
        color: #64748b;
        border: 1px solid rgba(100, 116, 139, 0.2);
    }

    /* ========================================
       ACTION BUTTONS
       ======================================== */
    .outlined-btn {
        background: transparent;
        border: 1px solid #e2e8f0;
        color: #64748b;
        border-radius: 50px;
        padding: 8px 18px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .outlined-btn:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
        text-decoration: none;
    }

    .pay-btn {
        background: #2563eb;
        border: none;
        color: #ffffff;
        border-radius: 50px;
        padding: 8px 18px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .pay-btn:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .invoices-empty {
        text-align: center;
        padding: 80px 20px;
    }

    .invoices-empty i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .invoices-empty h4 {
        font-family: 'Montserrat', sans-serif;
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .invoices-empty p {
        color: #64748b;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 768px) {
        .white-card {
            margin: 0 15px;
            padding: 25px;
            border-radius: 16px;
        }

        .hero-widget {
            margin: 0 15px 40px;
            padding: 30px;
        }

        .hero-widget-number {
            font-size: 3rem;
        }

        .invoices-table thead {
            display: none;
        }

        .invoices-table tbody tr {
            display: block;
            margin-bottom: 15px;
            background: #f8fafc;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #e2e8f0;
        }

        .invoices-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .invoices-table tbody td:last-child {
            border-bottom: none;
        }

        .invoices-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 1px;
        }
    }
</style>

<!-- Clean Corporate Blue Invoices Wrapper -->
<div class="invoices-corporate-wrapper">
    <div class="container">
        <!-- Page Header -->
        <div class="invoices-header">
            <div class="invoices-subtitle">Billing & Payments</div>
            <h1 class="invoices-title">MY INVOICES</h1>
        </div>

        <!-- Brand Blue Hero Widget -->
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="hero-widget">
                    <div class="hero-widget-label">Total Invoices</div>
                    <div class="hero-widget-number"><?= count($invoices) ?></div>
                </div>
            </div>
        </div>

        <?php if (!empty($invoices) && count($invoices) > 0): ?>
            <!-- White Table Card -->
            <div class="white-card">
                <div class="table-scroll-wrapper">
                    <table class="invoices-table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Car / Service</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoices as $invoice): ?>
                                <tr>
                                    <td data-label="Invoice #">
                                        <span class="invoice-number">#<?= h($invoice->invoice_number) ?></span>
                                    </td>
                                    <td class="invoice-date" data-label="Date">
                                        <?= h($invoice->created->format('d M Y')) ?>
                                    </td>
                                    <td data-label="Car">
                                        <?php if ($invoice->booking && $invoice->booking->car): ?>
                                            <div class="invoice-car"><?= h($invoice->booking->car->car_model) ?></div>
                                            <div class="invoice-plate"><?= h($invoice->booking->car->plate_number) ?></div>
                                        <?php else: ?>
                                            <span class="text-muted">Car Removed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Amount">
                                        <span class="invoice-amount">RM <?= number_format($invoice->amount, 2) ?></span>
                                    </td>
                                    <td data-label="Status">
                                        <?php 
                                        $statusClass = match(strtolower($invoice->status)) {
                                            'paid' => 'paid',
                                            'unpaid' => 'unpaid',
                                            'cancelled' => 'cancelled',
                                            default => 'cancelled'
                                        };
                                        ?>
                                        <span class="status-badge <?= $statusClass ?>">
                                            <?= h($invoice->status) ?>
                                        </span>
                                    </td>
                                    <td data-label="Actions">
                                        <?php if (strtolower($invoice->status) === 'unpaid'): ?>
                                            <?= $this->Html->link(
                                                '<i class="fas fa-credit-card"></i> Pay Now',
                                                ['action' => 'view', $invoice->id],
                                                ['class' => 'pay-btn', 'escape' => false]
                                            ) ?>
                                        <?php elseif (strtolower($invoice->status) === 'paid'): ?>
                                            <?= $this->Html->link(
                                                '<i class="fas fa-file-download"></i> Receipt',
                                                ['action' => 'view', $invoice->id],
                                                ['class' => 'outlined-btn', 'escape' => false]
                                            ) ?>
                                        <?php else: ?>
                                            <?= $this->Html->link(
                                                'View',
                                                ['action' => 'view', $invoice->id],
                                                ['class' => 'outlined-btn']
                                            ) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                <nav><ul class="pagination"><?= $this->Paginator->numbers() ?></ul></nav>
            </div>

        <?php else: ?>
            <!-- Empty State -->
            <div class="white-card">
                <div class="invoices-empty">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <h4>No Invoices Found</h4>
                    <p>You have no pending bills or history.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>