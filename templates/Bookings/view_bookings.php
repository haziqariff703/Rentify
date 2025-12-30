<?php

/**
 * User Booking View - Modern Interface (Separated Sections)
 * 
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */

// Location labels mapping
$locationLabels = [
    'airport' => 'Airport Terminal 1',
    'city' => 'City Center HQ',
    'north' => 'Northern Branch',
    'south' => 'Southern Outlet'
];

// Status styling
$statusConfig = [
    'pending' => ['class' => 'status-pending', 'icon' => 'fa-clock', 'label' => 'Pending Confirmation'],
    'confirmed' => ['class' => 'status-confirmed', 'icon' => 'fa-check-circle', 'label' => 'Confirmed'],
    'completed' => ['class' => 'status-completed', 'icon' => 'fa-flag-checkered', 'label' => 'Completed'],
    'cancelled' => ['class' => 'status-cancelled', 'icon' => 'fa-times-circle', 'label' => 'Cancelled'],
];

$currentStatus = $booking->display_status ?? 'pending';
$statusInfo = $statusConfig[$currentStatus] ?? $statusConfig['pending'];

// Calculate days
$days = 1;
if ($booking->start_date && $booking->end_date) {
    $days = $booking->end_date->diffInDays($booking->start_date);
    if ($days == 0) $days = 1;
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&display=swap');

    .booking-view-wrapper {
        font-family: 'Syne', sans-serif;
        min-height: 100vh;
        padding: 30px 0 60px;
        background: #f8fafc;
    }

    .booking-header {
        margin-bottom: 30px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 16px;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #3b82f6;
    }

    .booking-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px;
    }

    .booking-id {
        font-size: 0.9rem;
        color: #64748b;
    }

    /* Grid Layout - Two Columns */
    .booking-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
    }

    /* Section Cards */
    .section-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .section-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #94a3b8;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Car Card */
    .car-card {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .car-image {
        width: 160px;
        height: 110px;
        border-radius: 12px;
        object-fit: cover;
        background: #e2e8f0;
        flex-shrink: 0;
    }

    .car-info h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 6px;
    }

    .car-brand {
        font-size: 0.9rem;
        color: #64748b;
        margin: 0 0 12px;
    }

    .car-rate {
        font-size: 1.1rem;
        font-weight: 700;
        color: #3b82f6;
    }

    .car-rate span {
        font-size: 0.85rem;
        font-weight: 500;
        color: #94a3b8;
    }

    /* Status Banner */
    .status-banner {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .status-banner i {
        font-size: 1.25rem;
    }

    .status-banner.status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-banner.status-confirmed {
        background: #dcfce7;
        color: #166534;
    }

    .status-banner.status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-banner.status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-text {
        font-weight: 600;
        font-size: 0.95rem;
    }

    /* Date Row */
    .date-row {
        display: flex;
        gap: 16px;
        align-items: stretch;
    }

    .date-box {
        flex: 1;
        background: #f8fafc;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
    }

    .date-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .date-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
    }

    .date-arrow {
        display: flex;
        align-items: center;
        color: #cbd5e1;
        font-size: 1.25rem;
    }

    /* Info List */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        font-size: 0.9rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-label i {
        width: 18px;
        color: #94a3b8;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* Price Summary Card */
    .price-card {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: white;
        padding: 24px;
        border-radius: 16px;
    }

    .price-card .section-title {
        color: rgba(255, 255, 255, 0.6);
        border-bottom-color: rgba(255, 255, 255, 0.1);
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }

    .price-total {
        display: flex;
        justify-content: space-between;
        padding-top: 16px;
        margin-top: 12px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        font-size: 1.25rem;
        font-weight: 700;
        color: white;
    }

    /* Related Items */
    .related-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .related-item:last-child {
        margin-bottom: 0;
    }

    .related-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .related-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #e0e7ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .related-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1e293b;
    }

    .related-subtitle {
        font-size: 0.8rem;
        color: #64748b;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-paid {
        background: #dcfce7;
        color: #166534;
    }

    .badge-unpaid {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
        color: white;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid #e2e8f0;
        color: #64748b;
    }

    .btn-outline:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
    }

    .btn-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-danger:hover {
        background: #fecaca;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .booking-grid {
            grid-template-columns: 1fr;
        }

        .car-card {
            flex-direction: column;
            text-align: center;
        }

        .car-image {
            width: 100%;
            height: 180px;
        }
    }

    @media (max-width: 576px) {
        .date-row {
            flex-direction: column;
        }

        .date-arrow {
            transform: rotate(90deg);
            justify-content: center;
            padding: 8px 0;
        }
    }
</style>

<div class="booking-view-wrapper">
    <div class="container">
        <!-- Header -->
        <div class="booking-header">
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left"></i> Back to My Bookings',
                ['action' => 'myBookings'],
                ['class' => 'back-link', 'escape' => false]
            ) ?>
            <h1 class="booking-title">Booking Details</h1>
            <p class="booking-id">Reference #<?= h($booking->id) ?> • Created <?= h($booking->created?->format('M d, Y')) ?></p>
        </div>

        <div class="booking-grid">
            <!-- LEFT COLUMN -->
            <div class="left-column">
                <!-- Status Banner -->
                <div class="status-banner <?= $statusInfo['class'] ?>">
                    <i class="fas <?= $statusInfo['icon'] ?>"></i>
                    <span class="status-text"><?= $statusInfo['label'] ?></span>
                </div>

                <!-- Car Section -->
                <div class="section-card">
                    <div class="section-title">Vehicle</div>
                    <div class="car-card">
                        <?php if ($booking->car && $booking->car->image): ?>
                            <?= $this->Html->image($booking->car->image, [
                                'class' => 'car-image',
                                'alt' => $booking->car->car_model
                            ]) ?>
                        <?php else: ?>
                            <div class="car-image" style="display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                <i class="fas fa-car fa-2x"></i>
                            </div>
                        <?php endif; ?>
                        <div class="car-info">
                            <?php if ($booking->car): ?>
                                <h3><?= h($booking->car->car_model) ?></h3>
                                <p class="car-brand"><?= h($booking->car->brand) ?></p>
                                <div class="car-rate">
                                    RM <?= $this->Number->format($booking->car->price_per_day) ?>
                                    <span>/day</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Rental Period Section -->
                <div class="section-card">
                    <div class="section-title">Rental Period</div>
                    <div class="date-row">
                        <div class="date-box">
                            <div class="date-label">Pick-up</div>
                            <div class="date-value"><?= h($booking->start_date?->format('D, M d, Y')) ?></div>
                        </div>
                        <div class="date-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <div class="date-box">
                            <div class="date-label">Return</div>
                            <div class="date-value"><?= h($booking->end_date?->format('D, M d, Y')) ?></div>
                        </div>
                    </div>
                </div>

                <!-- Booking Details Section -->
                <div class="section-card">
                    <div class="section-title">Booking Information</div>
                    <div class="info-list">
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-map-marker-alt"></i> Pick-up Location</span>
                            <span class="info-value">
                                <?php
                                $locationCode = $booking->pickup_location;
                                echo h($locationLabels[$locationCode] ?? ($locationCode ? ucfirst($locationCode) : 'Not specified'));
                                ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-calendar-alt"></i> Duration</span>
                            <span class="info-value"><?= $days ?> <?= $days == 1 ? 'day' : 'days' ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-clock"></i> Booked On</span>
                            <span class="info-value"><?= h($booking->created?->format('M d, Y, g:i A')) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Invoices Section -->
                <?php if (!empty($booking->invoices)): ?>
                    <div class="section-card">
                        <div class="section-title">Invoices</div>
                        <?php foreach ($booking->invoices as $invoice): ?>
                            <div class="related-item">
                                <div class="related-info">
                                    <div class="related-icon">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div>
                                        <div class="related-title"><?= h($invoice->invoice_number) ?></div>
                                        <div class="related-subtitle">RM <?= $this->Number->format($invoice->amount) ?></div>
                                    </div>
                                </div>
                                <?php
                                $invBadgeClass = match ($invoice->status) {
                                    'paid' => 'badge-paid',
                                    'unpaid' => 'badge-unpaid',
                                    'cancelled' => 'badge-cancelled',
                                    default => 'badge-unpaid'
                                };
                                ?>
                                <span class="badge <?= $invBadgeClass ?>"><?= ucfirst(h($invoice->status)) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Payments Section -->
                <?php if (!empty($booking->payments)): ?>
                    <div class="section-card">
                        <div class="section-title">Payments</div>
                        <?php foreach ($booking->payments as $payment): ?>
                            <div class="related-item">
                                <div class="related-info">
                                    <div class="related-icon" style="background: #dcfce7; color: #166534;">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div>
                                        <div class="related-title">RM <?= $this->Number->format($payment->amount) ?></div>
                                        <div class="related-subtitle"><?= h($payment->payment_method) ?> • <?= h($payment->payment_date?->format('M d, Y')) ?></div>
                                    </div>
                                </div>
                                <?php
                                $payBadgeClass = match ($payment->payment_status) {
                                    'paid' => 'badge-paid',
                                    'pending' => 'badge-unpaid',
                                    'refunded' => 'badge-cancelled',
                                    default => 'badge-unpaid'
                                };
                                ?>
                                <span class="badge <?= $payBadgeClass ?>"><?= ucfirst(h($payment->payment_status)) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- RIGHT COLUMN - Sticky Sidebar -->
            <div class="right-column">
                <!-- Price Summary -->
                <div class="price-card">
                    <div class="section-title">Price Summary</div>
                    <?php
                    $dailyRate = $booking->car ? (float)$booking->car->price_per_day : 0;
                    $subtotal = $dailyRate * $days;
                    $total = (float)$booking->total_price;
                    $tax = $total - $subtotal;
                    if ($tax < 0) $tax = 0;
                    ?>
                    <div class="price-row">
                        <span>RM <?= $this->Number->format($dailyRate) ?> × <?= $days ?> days</span>
                        <span>RM <?= $this->Number->format($subtotal) ?></span>
                    </div>
                    <?php if ($tax > 0): ?>
                        <div class="price-row">
                            <span>Taxes & Fees</span>
                            <span>RM <?= $this->Number->format($tax) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="price-total">
                        <span>Total</span>
                        <span>RM <?= $this->Number->format($total) ?></span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <?php if (!empty($booking->invoices)): ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-file-invoice"></i> View Invoice',
                            ['controller' => 'Invoices', 'action' => 'viewInvoices', $booking->invoices[0]->id],
                            ['class' => 'btn-action btn-primary', 'escape' => false]
                        ) ?>
                    <?php endif; ?>

                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left"></i> Back to Bookings',
                        ['action' => 'myBookings'],
                        ['class' => 'btn-action btn-outline', 'escape' => false]
                    ) ?>

                    <?php if ($booking->display_status === 'pending' || $booking->display_status === 'confirmed'): ?>
                        <?= $this->Form->postLink(
                            '<i class="fas fa-times"></i> Cancel Booking',
                            ['action' => 'cancelBooking', $booking->id],
                            [
                                'class' => 'btn-action btn-danger',
                                'escape' => false,
                                'confirm' => __('Are you sure you want to cancel this booking?')
                            ]
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>