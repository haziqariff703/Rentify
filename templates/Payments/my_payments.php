<?php
/**
 * My Payment History - Executive Brand Identity Edition
 * Dark Navy Header, Stats Cards, Corporate Ledger Table
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Payment> $payments
 */
$this->assign('title', 'My Payment History');

// Calculate stats
$totalTransactions = 0;
$totalValuePaid = 0;

foreach ($payments as $payment) {
    $totalTransactions++;
    if ($payment->payment_status === 'paid') {
        $totalValuePaid += $payment->amount;
    }
}
?>

<style>
    /* Google Fonts - Montserrat (Bold & Punchy) + Inter */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800;900&display=swap');

    /* ========================================
       PAGE WRAPPER
       ======================================== */
    .payments-executive-wrapper {
        background-color: #f1f5f9;
        min-height: 100vh;
        margin-top: -3rem;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* ========================================
       ENGINE HERO HEADER
       ======================================== */
    .engine-header {
        background-image:
            linear-gradient(to bottom, 
                rgba(15, 23, 42, 0.95) 0%,
                rgba(15, 23, 42, 0.90) 40%,
                rgba(15, 23, 42, 0.60) 100%),
            url('<?= $this->Url->image('my_engine.jpg') ?>');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        padding: 80px 0 100px;
        position: relative;
        text-align: center;
    }

    .header-eyebrow {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.25em;
        color: rgba(147, 197, 253, 0.6);
        margin-bottom: 12px;
    }

    .header-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 3rem;
        text-transform: uppercase;
        letter-spacing: -0.02em;
        color: #ffffff;
        margin: 0;
    }

    @media (min-width: 768px) {
        .header-title {
            font-size: 4.5rem;
        }
    }

    /* ========================================
       UNIFIED STATS CONTAINER
       ======================================== */
    .stats-container {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        max-width: 700px;
        margin: -4rem auto 40px;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        padding: 28px 0;
        position: relative;
        z-index: 10;
    }

    .stat-item {
        text-align: center;
        flex: 1;
    }

    .stat-divider {
        width: 1px;
        height: 50px;
        background-color: #e2e8f0;
    }

    .stat-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 2.5rem;
        font-weight: 900;
        color: #1e293b;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-value.text-emerald {
        color: #059669;
    }

    .stat-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #94a3b8;
    }

    /* ========================================
       CONTENT SECTION
       ======================================== */
    .content-section {
        padding: 40px 0 60px;
    }

    /* ========================================
       LEDGER CARD
       ======================================== */
    .ledger-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-scroll-wrapper {
        max-height: 450px;
        overflow-y: auto;
    }

    .table-scroll-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    /* ========================================
       TABLE - CORPORATE LEDGER STYLE
       ======================================== */
    .payments-table {
        width: 100%;
        border-collapse: collapse;
    }

    .payments-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* WHITE HEADER - No Blue! */
    .payments-table thead th {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #64748b;
        padding: 18px 20px;
        text-align: left;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .payments-table tbody tr {
        transition: background 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .payments-table tbody tr:hover {
        background: #fafbfc;
    }

    .payments-table tbody tr:last-child {
        border-bottom: none;
    }

    .payments-table tbody td {
        font-family: 'Montserrat', sans-serif;
        color: #334155;
        padding: 18px 20px;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    /* Date & Time - Stacked */
    .date-cell {
        display: flex;
        flex-direction: column;
    }

    .date-primary {
        font-weight: 700;
        color: #0f172a;
    }

    .date-secondary {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 2px;
    }

    /* Booking Ref - Monospace */
    .ref-cell {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #64748b;
    }

    /* Amount - Monospace Bold */
    .amount-cell {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        font-size: 0.95rem;
        color: #0f172a;
    }

    /* Method Badge */
    .method-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        color: #475569;
    }

    .method-badge i {
        color: #64748b;
    }

    /* Status - Outline Style */
    .status-outline {
        padding: 5px 14px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: transparent;
    }

    .status-outline.success {
        border: 1.5px solid #10b981;
        color: #10b981;
    }

    .status-outline.refunded {
        border: 1.5px solid #8b5cf6;
        color: #8b5cf6;
    }

    .status-outline.pending {
        border: 1.5px solid #f59e0b;
        color: #f59e0b;
    }

    /* Action Button - Ghost */
    .btn-ghost {
        background: transparent;
        border: 1px solid #e2e8f0;
        color: #64748b;
        border-radius: 8px;
        padding: 8px 14px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-ghost:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    /* ========================================
       PAGINATION - MODERN PILL BUTTONS
       ======================================== */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        list-style: none;
        padding: 0;
        margin: 40px 0;
    }

    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .pagination li a:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.2);
    }

    .pagination li.active span,
    .pagination li.current span {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    .pagination li.disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .payments-empty {
        text-align: center;
        padding: 80px 20px;
    }

    .payments-empty i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .payments-empty h4 {
        font-family: 'Playfair Display', serif;
        color: #1e293b;
        font-weight: 600;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .payments-empty p {
        font-family: 'Montserrat', sans-serif;
        color: #64748b;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 768px) {
        .stats-cards {
            flex-direction: column;
            padding: 0 20px;
            gap: 16px;
        }

        .stat-card {
            min-width: 100%;
        }

        .header-title {
            font-size: 2rem;
        }

        .payments-table thead {
            display: none;
        }

        .payments-table tbody tr {
            display: block;
            margin: 15px;
            background: #ffffff;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .payments-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .payments-table tbody td:last-child {
            border-bottom: none;
        }

        .payments-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.6rem;
            letter-spacing: 1px;
        }
    }
</style>

<!-- Executive Payments Wrapper -->
<div class="payments-executive-wrapper">

    <!-- Engine Hero Header -->
    <div class="engine-header">
        <div class="container">
            <div class="header-eyebrow">Financial Records</div>
            <h1 class="header-title">Payment History</h1>
        </div>
    </div>

    <!-- Unified Stats Container -->
    <div class="container">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-value"><?= $totalTransactions ?></div>
                <div class="stat-label">Total Transactions</div>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <div class="stat-value text-emerald">
                    RM <?= number_format($totalValuePaid, 2) ?>
                </div>
                <div class="stat-label">Total Value Paid</div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="container">
            <?php if (!empty($payments) && count($payments) > 0): ?>
                <!-- Ledger Card -->
                <div class="ledger-card">
                    <div class="table-scroll-wrapper">
                        <table class="payments-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Ref</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment): ?>
                                    <?php 
                                        // Method detection
                                        $raw = $payment->payment_method;
                                        $display = 'Unknown';
                                        $icon = 'fa-question-circle';

                                        if ($raw === 'card' || strpos($raw, 'card') !== false) {
                                            $display = 'Credit/Debit Card';
                                            $icon = 'fa-credit-card';
                                        } elseif ($raw === 'online_transfer' || strpos($raw, 'online_transfer') !== false) {
                                            $parts = explode('_', $raw);
                                            $bankName = isset($parts[2]) ? ucfirst($parts[2]) : 'FPX';
                                            $display = 'FPX (' . $bankName . ')';
                                            $icon = 'fa-university';
                                        } elseif ($raw === 'cash' || strpos($raw, 'cash') !== false) {
                                            $display = 'Cash';
                                            $icon = 'fa-money-bill-wave';
                                        }
                                    ?>
                                    <tr>
                                        <td data-label="Date">
                                            <div class="date-cell">
                                                <span class="date-primary"><?= h($payment->created->format('d M Y')) ?></span>
                                                <span class="date-secondary"><?= h($payment->created->format('h:i A')) ?></span>
                                            </div>
                                        </td>
                                        <td data-label="Ref" class="ref-cell">
                                            #<?= h($payment->booking_id) ?>
                                        </td>
                                        <td data-label="Method">
                                            <div class="method-badge">
                                                <i class="fas <?= $icon ?>"></i> <?= h($display) ?>
                                            </div>
                                        </td>
                                        <td data-label="Amount" class="amount-cell">
                                            RM <?= number_format($payment->amount, 2) ?>
                                        </td>
                                        <td data-label="Status">
                                            <?php if ($payment->payment_status === 'paid'): ?>
                                                <span class="status-outline success">
                                                    <i class="fas fa-check"></i> Success
                                                </span>
                                            <?php elseif ($payment->payment_status === 'refunded'): ?>
                                                <span class="status-outline refunded">
                                                    <i class="fas fa-undo"></i> Refunded
                                                </span>
                                            <?php else: ?>
                                                <span class="status-outline pending">
                                                    <i class="fas fa-clock"></i> Pending
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td data-label="Action">
                                            <?= $this->Html->link(
                                                '<i class="fas fa-eye"></i> View',
                                                ['action' => 'viewPayment', $payment->id],
                                                ['class' => 'btn-ghost', 'escape' => false]
                                            ) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    <nav>
                        <ul class="pagination">
                            <?= $this->Paginator->prev('« Previous') ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('Next »') ?>
                        </ul>
                    </nav>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="ledger-card">
                    <div class="payments-empty">
                        <i class="fas fa-receipt"></i>
                        <h4>No Transactions Yet</h4>
                        <p>You haven't made any payments yet.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>