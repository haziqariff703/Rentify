<?php
/**
 * View Payment - User Transaction Confirmation (Read-Only)
 * Shows payment details with car thumbnail and links to related documents
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 * @var \App\Model\Entity\Invoice|null $invoice
 */
$this->assign('title', 'Payment #' . $payment->id);
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800&display=swap');

    .payment-view-wrapper {
        background-color: #f8fafc;
        min-height: 100vh;
        padding: 40px 0;
    }

    .payment-header {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 32px;
    }

    .car-thumbnail {
        width: 100px;
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .car-thumbnail-placeholder {
        width: 100px;
        height: 70px;
        border-radius: 12px;
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.5rem;
    }

    .payment-header-info {
        flex: 1;
    }

    .payment-header-info .eyebrow {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #64748b;
        margin-bottom: 4px;
    }

    .payment-header-info .title {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .payment-header-info .car-name {
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        color: #475569;
    }

    .status-badge-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid #059669;
        padding: 8px 16px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .status-badge-pending {
        background-color: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid #d97706;
        padding: 8px 16px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .payment-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .payment-card-header {
        background: #1e293b;
        padding: 16px 24px;
    }

    .payment-card-header h6 {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
    }

    .payment-card-body {
        padding: 24px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
    }

    .detail-value {
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        color: #0f172a;
    }

    .detail-value.amount {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
    }

    .method-badge {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .link-button {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #3b82f6;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .link-button:hover {
        color: #1d4ed8;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 24px;
    }

    .btn-back {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #0f172a;
        color: #ffffff;
        padding: 14px 24px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back:hover {
        background: #1e293b;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .thank-you-footer {
        margin-top: 40px;
        padding-top: 32px;
        border-top: 1px solid #e2e8f0;
        text-align: center;
    }

    .thank-you-footer .message {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        font-weight: 500;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .thank-you-footer .support {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: #64748b;
    }

    .thank-you-footer .support a {
        color: #3b82f6;
        text-decoration: none;
    }

    .thank-you-footer .support a:hover {
        text-decoration: underline;
    }
</style>

<div class="payment-view-wrapper">
    <div class="container" style="max-width: 1100px;">

        <!-- Header with Car Thumbnail -->
        <div class="payment-header">
            <?php if ($payment->has('booking') && $payment->booking->has('car') && $payment->booking->car->image): ?>
                <?= $this->Html->image($payment->booking->car->image, [
                    'alt' => $payment->booking->car->brand . ' ' . $payment->booking->car->model,
                    'class' => 'car-thumbnail'
                ]) ?>
            <?php else: ?>
                <div class="car-thumbnail-placeholder">
                    <i class="fas fa-car"></i>
                </div>
            <?php endif; ?>

            <div class="payment-header-info">
                <div class="eyebrow">Transaction Confirmation</div>
                <h1 class="title">Payment #<?= h($payment->id) ?></h1>
                <?php if ($payment->has('booking') && $payment->booking->has('car')): ?>
                    <div class="car-name">
                        <?= h($payment->booking->car->brand) ?> <?= h($payment->booking->car->model) ?>
                        • Booking #<?= h($payment->booking->id) ?>
                        <?php if ($payment->booking->has('user')): ?>
                            • Paid by <?= h($payment->booking->user->name) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php
            $status = strtolower($payment->payment_status ?? '');
            $isPaid = ($status === 'paid' || $status === 'success');
            ?>
            <span class="<?= $isPaid ? 'status-badge-success' : 'status-badge-pending' ?>">
                <?= $isPaid ? '✓ Paid' : h(ucfirst($payment->payment_status ?? 'Pending')) ?>
            </span>
        </div>

        <div class="row g-4">
            <!-- Payment Details Card -->
            <div class="col-lg-6">
                <div class="payment-card h-100">
                    <div class="payment-card-header">
                        <h6>💳 Payment Details</h6>
                    </div>
                    <div class="payment-card-body">
                        <div class="detail-row">
                            <span class="detail-label">Amount</span>
                            <span class="detail-value amount">RM <?= number_format($payment->amount, 2) ?></span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Method</span>
                            <span class="method-badge">
                                <?php
                                $method = $payment->payment_method ?? 'N/A';
                                if (strpos($method, 'online_transfer') !== false) {
                                    $bank = str_replace('online_transfer_', '', $method);
                                    echo '🏦 ' . ucfirst($bank);
                                } elseif ($method === 'card') {
                                    echo '💳 Card';
                                } elseif ($method === 'cash') {
                                    echo '💵 Cash';
                                } else {
                                    echo h($method);
                                }
                                ?>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Processed</span>
                            <span class="detail-value">
                                <?= h($payment->created->format('d M Y, h:i A')) ?>
                            </span>
                        </div>

                        <?php if ($payment->has('booking')): ?>
                            <div class="detail-row">
                                <span class="detail-label">Booking</span>
                                <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'view', $payment->booking->id]) ?>" class="link-button">
                                    View Booking #<?= h($payment->booking->id) ?> <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Related Documents Card -->
            <div class="col-lg-6">
                <div class="payment-card h-100">
                    <div class="payment-card-header">
                        <h6>📄 Related Documents</h6>
                    </div>
                    <div class="payment-card-body">
                        <?php if ($invoice): ?>
                            <div class="detail-row">
                                <span class="detail-label">Invoice</span>
                                <a href="<?= $this->Url->build(['controller' => 'Invoices', 'action' => 'viewInvoices', $invoice->id]) ?>" class="link-button">
                                    View Invoice #<?= h($invoice->id) ?> <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="detail-row">
                                <span class="detail-label">Invoice</span>
                                <span class="detail-value text-muted">—</span>
                            </div>
                        <?php endif; ?>

                        <?php if ($payment->has('booking') && $payment->booking->has('car')): ?>
                            <div class="detail-row">
                                <span class="detail-label">Rental Period</span>
                                <span class="detail-value">
                                    <?= h($payment->booking->start_date->format('d M')) ?> - <?= h($payment->booking->end_date->format('d M Y')) ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="action-buttons">
                            <a href="<?= $this->Url->build(['action' => 'myPayments']) ?>" class="btn-back">
                                Back to Payment History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thank You Footer -->
        <div class="thank-you-footer">
            <p class="message">Thank you for choosing Rentify.</p>
            <p class="support">Questions? Contact us at <a href="mailto:support@rentify.com">support@rentify.com</a></p>
        </div>

    </div>
</div>
