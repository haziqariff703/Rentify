<?php
/**
 * My Payment History - High Contrast: White Background + Dark Table
 * @var \App\View\AppView $this
 */
$this->assign('title', 'My Payment History');
?>

<style>
    /* Google Fonts - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

    /* ========================================
       PLATINUM DOT BACKGROUND (WHITE PAGE)
       ======================================== */
    .payments-platinum-wrapper {
        background-color: #f8fafc;
        background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px);
        background-size: 24px 24px;
        min-height: 100vh;
        padding: 40px 0 60px;
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
       OBSIDIAN DARK TABLE CONTAINER
       (Floating on White Background)
       ======================================== */
    .obsidian-panel {
        background: radial-gradient(circle at top center, #1e293b 0%, #020617 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
        padding: 50px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ========================================
       HEADER - SILVER/WHITE GRADIENT
       ======================================== */
    .payments-header {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        text-align: center;
        margin-bottom: 50px;
        background: linear-gradient(to right, #f8fafc, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ========================================
       TABLE STYLING - DARK THEME
       ======================================== */
    .table-scroll-wrapper {
        max-height: 400px;
        overflow-y: auto;
        border-radius: 12px;
    }

    /* Custom Dark Scrollbar */
    .table-scroll-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 3px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .payments-table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Sticky Header */
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
        color: #94a3b8;
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        background: #020617;
    }

    .payments-table tbody tr {
        transition: background 0.3s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .payments-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.03);
    }

    .payments-table tbody tr:last-child {
        border-bottom: none;
    }

    .payments-table tbody td {
        font-family: 'Montserrat', sans-serif;
        color: #f8fafc;
        padding: 20px;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    /* Date styling */
    .payment-date {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    /* Booking ID */
    .payment-booking-id {
        color: #60a5fa;
        font-weight: 600;
    }

    /* Payment Method */
    .payment-method {
        color: #cbd5e1;
    }

    .payment-method i {
        margin-right: 8px;
        color: #64748b;
    }

    /* Amount - Emerald Green */
    .payment-amount {
        color: #4ade80;
        font-weight: 700;
        font-size: 0.95rem;
    }

    /* ========================================
       SUCCESS BADGE - GREEN PILL
       ======================================== */
    .payment-badge {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
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
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .payment-badge.failed {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.3);
    }

    /* ========================================
       GHOST WHITE BUTTON
       ======================================== */
    .ghost-btn {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #ffffff;
        border-radius: 8px;
        padding: 8px 18px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .ghost-btn:hover {
        background: #ffffff;
        color: #0f172a;
        border-color: #ffffff;
        text-decoration: none;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .payments-empty {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .payments-empty i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #475569;
    }

    .payments-empty h4 {
        font-family: 'Montserrat', sans-serif;
        color: #f8fafc;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .payments-empty .btn-browse {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #ffffff;
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
        background: #ffffff;
        color: #0f172a;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 768px) {
        .obsidian-panel {
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
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .payments-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
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

<!-- Platinum Background + Dark Table -->
<div class="payments-platinum-wrapper">
    <div class="container">
        <!-- Obsidian Dark Panel -->
        <div class="obsidian-panel">
            <!-- Header - Silver Gradient -->
            <h1 class="payments-header">Payment History</h1>

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
                                    ['class' => 'ghost-btn', 'escape' => false]
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