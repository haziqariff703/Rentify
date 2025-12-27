<?php
/**
 * My Payment History - Clean Corporate Blue
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Payment> $payments
 */
$this->assign('title', 'My Payment History');
?>

<style>
    /* Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');

    .payments-corporate-wrapper {
        background-color: #f8fafc;
        background-image: repeating-linear-gradient(135deg, transparent, transparent 10px, rgba(148, 163, 184, 0.05) 10px, rgba(148, 163, 184, 0.05) 11px);
        min-height: 100vh;
        padding: 50px 0 80px;
        margin-top: -3rem;
    }

    .white-panel {
        background: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 25px 50px -12px rgba(37, 99, 235, 0.2);
        padding: 50px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header */
    .editorial-header { text-align: center; margin-bottom: 35px; }
    .editorial-subtitle { font-family: 'Montserrat', sans-serif; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 3px; color: #94a3b8; margin-bottom: 8px; }
    .editorial-title { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 2.5rem; letter-spacing: -2px; color: #1e293b; margin: 0; }

    /* Table */
    .table-scroll-wrapper { max-height: 400px; overflow-y: auto; border-radius: 12px; }
    .payments-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .payments-table thead { position: sticky; top: 0; z-index: 10; }
    
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
        border: none;
    }
    .payments-table thead th:first-child { border-radius: 12px 0 0 0; }
    .payments-table thead th:last-child { border-radius: 0 12px 0 0; }

    .payments-table tbody td {
        font-family: 'Montserrat', sans-serif;
        color: #334155;
        padding: 20px;
        font-size: 0.9rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .payments-table tbody tr:last-child td { border-bottom: none; }
    .payments-table tbody tr:hover { background: #f8fafc; }

    /* Method Badges */
    .method-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 8px;
    }
    .badge-card { background: #eff6ff; color: #1d4ed8; }
    .badge-fpx { background: #f3e8ff; color: #7e22ce; }
    .badge-cash { background: #ecfdf5; color: #047857; }
    .badge-unknown { background: #f1f5f9; color: #64748b; }

    /* Status Badge */
    .status-pill {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .status-success { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .status-refunded { background: rgba(99, 102, 241, 0.1); color: #6366f1; }
    .status-pending { background: rgba(245, 158, 11, 0.1); color: #d97706; }

    /* Buttons */
    .btn-view {
        background: rgba(37, 99, 235, 0.1);
        color: #2563eb;
        border-radius: 8px;
        padding: 8px 16px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-view:hover { background: #2563eb; color: white; }
</style>

<div class="payments-corporate-wrapper">
    <div class="container">
        <div class="white-panel">
            <div class="editorial-header">
                <div class="editorial-subtitle">Financial Records</div>
                <h1 class="editorial-title">PAYMENT HISTORY</h1>
            </div>

            <?php if (!empty($payments) && count($payments) > 0): ?>
            <div class="table-scroll-wrapper">
                <table class="payments-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Booking Ref</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                            <?php 
                                // --- ROBUST METHOD DETECTION ---
                                $raw = $payment->payment_method;
                                $display = 'Unknown Method';
                                $badgeClass = 'badge-unknown';
                                $icon = 'fa-question-circle';

                                if ($raw === 'card' || strpos($raw, 'card') !== false) {
                                    $display = 'Credit / Debit Card';
                                    $badgeClass = 'badge-card';
                                    $icon = 'fa-credit-card';
                                } 
                                // Check for ANY variation of online transfer
                                elseif ($raw === 'online_transfer' || strpos($raw, 'online_transfer') !== false) {
                                    // Try to get bank name
                                    $parts = explode('_', $raw);
                                    $bankName = isset($parts[2]) ? ucfirst($parts[2]) : 'Online Banking';
                                    
                                    // Fix specific names
                                    if(strtolower($bankName) == 'maybank2u') $bankName = 'Maybank2u';
                                    if(strtolower($bankName) == 'cimbclicks') $bankName = 'CIMB Clicks';
                                    if(strtolower($bankName) == 'rhbnow') $bankName = 'RHB Now';
                                    if(strtolower($bankName) == 'hongleong') $bankName = 'Hong Leong';
                                    if(strtolower($bankName) == 'publicbank') $bankName = 'Public Bank';
                                    if(strtolower($bankName) == 'amonline') $bankName = 'AmOnline';

                                    $display = 'FPX (' . $bankName . ')';
                                    $badgeClass = 'badge-fpx';
                                    $icon = 'fa-university';
                                } 
                                elseif ($raw === 'cash' || strpos($raw, 'cash') !== false) {
                                    $display = 'Cash at Counter';
                                    $badgeClass = 'badge-cash';
                                    $icon = 'fa-money-bill-wave';
                                }
                            ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: #1e293b;"><?= h($payment->created->format('d M Y')) ?></div>
                                    <div style="font-size: 0.75rem; color: #94a3b8;"><?= h($payment->created->format('h:i A')) ?></div>
                                </td>
                                <td style="font-family: 'Courier New'; font-weight: 700; color: #2563eb;">
                                    #<?= h($payment->booking_id) ?>
                                </td>
                                <td>
                                    <div class="method-badge <?= $badgeClass ?>">
                                        <i class="fas <?= $icon ?>"></i> <?= h($display) ?>
                                    </div>
                                </td>
                                <td style="font-weight: 700; color: #0f172a;">
                                    RM <?= number_format($payment->amount, 2) ?>
                                </td>
                                <td>
                                    <?php if ($payment->payment_status === 'paid'): ?>
                                        <span class="status-pill status-success"><i class="fas fa-check me-1"></i> Success</span>
                                    <?php elseif ($payment->payment_status === 'refunded'): ?>
                                        <span class="status-pill status-refunded"><i class="fas fa-undo me-1"></i> Refunded</span>
                                    <?php else: ?>
                                        <span class="status-pill status-pending">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $this->Html->link(
                                        '<i class="fas fa-eye me-1"></i> View',
                                        ['action' => 'view', $payment->id],
                                        ['class' => 'btn-view', 'escape' => false]
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div style="text-align: center; padding: 60px; color: #94a3b8;">
                <i class="fas fa-receipt fa-4x mb-3"></i>
                <h4>No transactions found</h4>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>