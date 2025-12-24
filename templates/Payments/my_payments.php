<?php
/**
 * My Payment History - Obsidian Vault Financial Dashboard
 * @var \App\View\AppView $this
 */
$this->assign('title', 'My Payment History');
?>

<style>
    /* Google Fonts - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

    /* ========================================
       OBSIDIAN VAULT BACKGROUND
       Deep Radial Gradient Spotlight
       ======================================== */
    .obsidian-vault-wrapper {
        background: radial-gradient(circle at top center, #1e293b 0%, #020617 100%);
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
       GLASS VAULT PANEL
       ======================================== */
    .vault-panel {
        background: rgba(30, 41, 59, 0.4);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        padding: 50px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ========================================
       HEADER - MINIMALIST LUXURY
       ======================================== */
    .vault-header {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        text-align: center;
        margin-bottom: 50px;
        background: linear-gradient(to right, #f8fafc, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ========================================
       TABLE STYLING - CLEAN & AIRY
       ======================================== */
    .vault-table {
        width: 100%;
        border-collapse: collapse;
    }

    .vault-table thead th {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #64748b;
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .vault-table tbody tr {
        transition: background 0.3s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    }

    .vault-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .vault-table tbody tr:last-child {
        border-bottom: none;
    }

    .vault-table tbody td {
        font-family: 'Montserrat', sans-serif;
        color: #e2e8f0;
        padding: 20px;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    /* Date styling */
    .vault-date {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    /* Booking ID */
    .vault-booking-id {
        color: #60a5fa;
        font-weight: 600;
    }

    /* Payment Method */
    .vault-method {
        color: #cbd5e1;
    }

    .vault-method i {
        margin-right: 8px;
        color: #64748b;
    }

    /* Amount - Neon Green */
    .vault-amount {
        color: #4ade80;
        font-weight: 700;
        font-size: 0.95rem;
    }

    /* ========================================
       SUCCESS BADGE - MUTED EMERALD
       ======================================== */
    .vault-badge {
        background: rgba(16, 185, 129, 0.1);
        color: #34d399;
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

    .vault-badge i {
        font-size: 0.6rem;
    }

    .vault-badge.pending {
        background: rgba(251, 191, 36, 0.1);
        color: #fbbf24;
        border-color: rgba(251, 191, 36, 0.2);
    }

    .vault-badge.failed {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.2);
    }

    /* ========================================
       GHOST BUTTON
       ======================================== */
    .vault-ghost-btn {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.2);
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

    .vault-ghost-btn:hover {
        background: #ffffff;
        color: #0f172a;
        border-color: #ffffff;
        text-decoration: none;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .vault-empty {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .vault-empty i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #334155;
    }

    .vault-empty h4 {
        font-family: 'Montserrat', sans-serif;
        color: #e2e8f0;
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 768px) {
        .vault-panel {
            margin: 0 15px;
            padding: 30px 20px;
            border-radius: 16px;
        }
        
        .vault-header {
            font-size: 1.25rem;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }
        
        .vault-table thead {
            display: none;
        }
        
        .vault-table tbody tr {
            display: block;
            margin-bottom: 15px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 15px;
            border-bottom: none;
        }
        
        .vault-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }
        
        .vault-table tbody td:last-child {
            border-bottom: none;
        }
        
        .vault-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 1px;
        }
    }
</style>

<!-- Obsidian Vault Payment History Wrapper -->
<div class="obsidian-vault-wrapper">
    <div class="container">
        <!-- Glass Vault Panel -->
        <div class="vault-panel">
            <!-- Header - No Icon -->
            <h1 class="vault-header">Payment History</h1>

            <!-- Table -->
            <?php if (!empty($payments)): ?>
            <div class="table-responsive">
                <table class="vault-table">
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
                            <td class="vault-date" data-label="Date">
                                <?= h($payment->created->format('d M Y, h:i A')) ?>
                            </td>
                            <td data-label="Booking ID">
                                <span class="vault-booking-id">#<?= h($payment->booking_id) ?></span>
                            </td>
                            <td data-label="Method">
                                <span class="vault-method">
                                    <i class="fas fa-credit-card"></i>
                                    <?= ucfirst(str_replace('_', ' ', h($payment->payment_method))) ?>
                                </span>
                            </td>
                            <td data-label="Amount">
                                <span class="vault-amount">RM <?= number_format($payment->amount, 2) ?></span>
                            </td>
                            <td data-label="Status">
                                <span class="vault-badge">
                                    <i class="fas fa-check-circle"></i>Success
                                </span>
                            </td>
                            <td data-label="Receipt">
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>View',
                                    ['action' => 'view', $payment->id],
                                    ['class' => 'vault-ghost-btn', 'escape' => false]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <!-- Empty State -->
            <div class="vault-empty">
                <i class="fas fa-file-invoice-dollar"></i>
                <h4>No Payment History</h4>
                <p>You haven't made any payments yet. Book a car to get started!</p>
                <?= $this->Html->link(
                    '<i class="fas fa-car me-2"></i>Browse Cars',
                    ['controller' => 'Cars', 'action' => 'myCars'],
                    ['class' => 'vault-ghost-btn', 'escape' => false]
                ) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>