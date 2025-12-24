<?php
/**
 * My Payment History - Dark Mode Premium Dashboard
 * @var \App\View\AppView $this
 */
$this->assign('title', 'My Payment History');
?>

<style>
    /* Google Fonts - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');

    /* ========================================
       FULL SCREEN CARBON BACKGROUND
       ======================================== */
    .payments-dark-wrapper {
        background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.95)), url('/img/carbon_background.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        min-height: 100vh;
        padding: 50px 0;
        /* FORCE FULL VIEWPORT WIDTH */
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* ========================================
       GLASS PANEL CONTAINER
       ======================================== */
    .glass-panel {
        background-color: rgba(30, 41, 59, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ========================================
       HEADER TYPOGRAPHY
       ======================================== */
    .payments-header {
        font-family: 'Montserrat', sans-serif;
        color: #ffffff;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-align: center;
        margin-bottom: 40px;
        font-size: 2rem;
    }

    .payments-header span {
        color: #4ade80;
    }

    /* ========================================
       DARK TABLE STYLING
       ======================================== */
    .dark-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .dark-table thead th {
        background: rgba(0, 0, 0, 0.2);
        color: #94a3b8;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        text-align: left;
    }

    .dark-table tbody tr {
        transition: background 0.3s ease;
    }

    .dark-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .dark-table tbody td {
        color: #ffffff;
        padding: 18px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    /* Amount Column - Neon Green */
    .amount-cell {
        color: #4ade80 !important;
        font-weight: 700;
        font-size: 1rem;
    }

    /* Status Badge - Glowing Pill */
    .status-badge {
        background: rgba(74, 222, 128, 0.1);
        color: #4ade80;
        border: 1px solid #4ade80;
        border-radius: 50px;
        padding: 6px 16px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .status-badge.pending {
        background: rgba(251, 191, 36, 0.1);
        color: #fbbf24;
        border-color: #fbbf24;
    }

    .status-badge.failed {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-color: #ef4444;
    }

    /* Ghost Button */
    .ghost-btn {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: #ffffff;
        border-radius: 6px;
        padding: 8px 18px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .ghost-btn:hover {
        background: #ffffff;
        color: #0f172a;
        border-color: #ffffff;
        text-decoration: none;
    }

    /* Booking ID styling */
    .booking-id {
        color: #60a5fa;
        font-weight: 600;
    }

    /* Payment Method */
    .payment-method {
        color: #cbd5e1;
    }

    /* Date styling */
    .date-cell {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #475569;
    }

    .empty-state h4 {
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        margin-bottom: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .glass-panel {
            margin: 0 15px;
            padding: 25px;
        }
        
        .payments-header {
            font-size: 1.5rem;
        }
        
        .dark-table thead {
            display: none;
        }
        
        .dark-table tbody tr {
            display: block;
            margin-bottom: 15px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 15px;
        }
        
        .dark-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .dark-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            font-size: 0.7rem;
        }
    }
</style>

<!-- Dark Mode Payment History Wrapper -->
<div class="payments-dark-wrapper">
    <div class="container">
        <!-- Glass Panel Container -->
        <div class="glass-panel">
            <!-- Header -->
            <h1 class="payments-header">
                <i class="fas fa-receipt me-3"></i>Payment <span>History</span>
            </h1>

            <!-- Table -->
            <?php if (!empty($payments)): ?>
            <div class="table-responsive">
                <table class="dark-table">
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
                            <td class="date-cell" data-label="Date">
                                <?= h($payment->created->format('d M Y, h:i A')) ?>
                            </td>
                            <td data-label="Booking ID">
                                <span class="booking-id">#<?= h($payment->booking_id) ?></span>
                            </td>
                            <td data-label="Method">
                                <span class="payment-method">
                                    <i class="fas fa-credit-card me-2"></i>
                                    <?= ucfirst(str_replace('_', ' ', h($payment->payment_method))) ?>
                                </span>
                            </td>
                            <td class="amount-cell" data-label="Amount">
                                RM <?= number_format($payment->amount, 2) ?>
                            </td>
                            <td data-label="Status">
                                <span class="status-badge">
                                    <i class="fas fa-check-circle me-1"></i>Success
                                </span>
                            </td>
                            <td data-label="Receipt">
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye me-1"></i>View',
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
            <div class="empty-state">
                <i class="fas fa-file-invoice-dollar"></i>
                <h4>No Payment History</h4>
                <p>You haven't made any payments yet. Book a car to get started!</p>
                <?= $this->Html->link(
                    '<i class="fas fa-car me-2"></i>Browse Cars',
                    ['controller' => 'Cars', 'action' => 'myCars'],
                    ['class' => 'ghost-btn', 'escape' => false]
                ) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>