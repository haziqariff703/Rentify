<?php
/**
 * My Payment History - Clean Corporate Blue
 * @var \App\View\AppView $this
 */
$this->assign('title', 'My Payment History');
?>

<style>
    /* Google Fonts - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');

    /* ========================================
       DIAGONAL MICRO-STRIPE BACKGROUND
       ======================================== */
    .payments-corporate-wrapper {
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
       WHITE PANEL CONTAINER + DEEP LIFT SHADOW
       ======================================== */
    .white-panel {
        background: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        box-shadow:
            /* Layer 1: Tight grey shadow for edge definition */
            0 4px 6px -1px rgba(0, 0, 0, 0.05),
            /* Layer 2: Wide blue shadow for lift and brand tint */
            0 25px 50px -12px rgba(37, 99, 235, 0.2);
        padding: 50px;
        max-width: 1200px;
        margin: 0 auto;
        overflow: visible;
    }

    /* ========================================
       EDITORIAL HEADER (Match Bookings)
       ======================================== */
    .editorial-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .editorial-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .editorial-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        letter-spacing: -2px;
        background: linear-gradient(to bottom, #1e293b, #475569);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        line-height: 1.1;
    }

    /* ========================================
       SCROLL WRAPPER
       ======================================== */
    .table-scroll-wrapper {
        max-height: 400px;
        overflow-y: auto;
        border-radius: 12px;
    }

    /* Custom Light Scrollbar */
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
    .payments-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* Sticky Header - BRAND BLUE STRIP */
    .payments-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .payments-table thead th {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #ffffff;
        padding: 16px 20px;
        text-align: left;
        background: linear-gradient(90deg, #1e3a8a 0%, #2563eb 100%);
        border-bottom: none;
    }

    .payments-table thead th:first-child {
        border-radius: 12px 0 0 0;
    }

    .payments-table thead th:last-child {
        border-radius: 0 12px 0 0;
    }

    .payments-table tbody tr {
        transition: background 0.3s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .payments-table tbody tr:hover {
        background: #f8fafc;
    }

    .payments-table tbody tr:last-child {
        border-bottom: none;
    }

    .payments-table tbody td {
        font-family: 'Montserrat', sans-serif;
        color: #334155;
        padding: 20px;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    /* Date styling */
    .payment-date {
        color: #64748b;
        font-size: 0.85rem;
    }

    /* Booking ID - Brand Blue */
    .payment-booking-id {
        color: #2563eb;
        font-weight: 700;
    }

    /* Payment Method */
    .payment-method {
        color: #475569;
    }

    .payment-method i {
        margin-right: 8px;
        color: #94a3b8;
    }

    /* Amount - Emerald Green */
    .payment-amount {
        color: #059669;
        font-weight: 700;
    }

    /* ========================================
       SUCCESS BADGE - GREEN PILL
       ======================================== */
    .payment-badge {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .payment-badge i {
        font-size: 0.6rem;
    }

    .payment-badge.pending {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border-color: rgba(245, 158, 11, 0.2);
    }

    .payment-badge.failed {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border-color: rgba(239, 68, 68, 0.2);
    }

    /* ========================================
       SOFT BLUE BUTTON
       ======================================== */
    .soft-blue-btn {
        background: rgba(37, 99, 235, 0.1);
        border: none;
        color: #2563eb;
        border-radius: 8px;
        padding: 8px 18px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .soft-blue-btn:hover {
        background: #2563eb;
        color: #ffffff;
        text-decoration: none;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .payments-empty {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .payments-empty i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #cbd5e1;
    }

    .payments-empty h4 {
        font-family: 'Montserrat', sans-serif;
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .payments-empty .btn-browse {
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        margin-top: 15px;
        display: inline-block;
        transition: all 0.2s ease;
    }

    .payments-empty .btn-browse:hover {
        background: #1d4ed8;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 768px) {
        .white-panel {
            margin: 0 15px;
            padding: 30px 20px;
            border-radius: 16px;
        }
        
        .payments-header {
            font-size: 1.25rem;
            letter-spacing: 1px;
            margin-bottom: 30px;
        }
        
        .payments-table thead {
            display: none;
        }
        
        .payments-table tbody tr {
            display: block;
            margin-bottom: 15px;
            background: #f8fafc;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #e2e8f0;
        }
        
        .payments-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .payments-table tbody td:last-child {
            border-bottom: none;
        }
        
        .payments-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 1px;
        }
    }
</style>

<!-- Clean Corporate Blue Payment History Wrapper -->
<div class="payments-corporate-wrapper">
    <div class="container">
        <!-- White Panel Container -->
        <div class="white-panel">
            <!-- Editorial Header -->
            <div class="editorial-header">
                <div class="editorial-subtitle">Your Transaction History</div>
                <h1 class="editorial-title">PAYMENT HISTORY</h1>
            </div>

            <!-- Table -->
            <?php if (!empty($payments)): ?>
            <!-- NOTE: For newest-first sorting, add ->order(['Payments.created' => 'DESC']) in PaymentsController::myPayments() -->
            <div class="table-scroll-wrapper">
                <table class="payments-table">
                    <thead>
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
                            <td class="payment-date" data-label="Date">
                                <?= h($payment->created->format('d M Y, h:i A')) ?>
                            </td>
                            <td data-label="Booking ID">
                                <span class="payment-booking-id">#<?= h($payment->booking_id) ?></span>
                            </td>
                            <td data-label="Method">
                                <span class="payment-method">
                                    <i class="fas fa-credit-card"></i>
                                    <?= ucfirst(str_replace('_', ' ', h($payment->payment_method))) ?>
                                </span>
                            </td>
                            <td data-label="Amount">
                                <span class="payment-amount">RM <?= number_format($payment->amount, 2) ?></span>
                            </td>
                            <td data-label="Status">
                                <span class="payment-badge">
                                    <i class="fas fa-check-circle"></i>Success
                                </span>
                            </td>
                            <td data-label="Receipt">
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>View',
                                    ['action' => 'view', $payment->id],
                                    ['class' => 'soft-blue-btn', 'escape' => false]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <!-- Empty State -->
            <div class="payments-empty">
                <i class="fas fa-file-invoice-dollar"></i>
                <h4>No Payment History</h4>
                <p>You haven't made any payments yet. Book a car to get started!</p>
                <?= $this->Html->link(
                    '<i class="fas fa-car me-2"></i>Browse Cars',
                    ['controller' => 'Cars', 'action' => 'myCars'],
                    ['class' => 'btn-browse', 'escape' => false]
                ) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>