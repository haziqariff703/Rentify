<?php

/**
 * My Bookings - High-End Corporate Edition
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
?>

<style>
    /* Google Fonts - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

    /* ========================================
       DIAGONAL MICRO-STRIPE BACKGROUND
       ======================================== */
    .bookings-corporate-wrapper {
        background-color: #f8fafc;
        background-image: repeating-linear-gradient(135deg,
                transparent,
                transparent 10px,
                rgba(148, 163, 184, 0.05) 10px,
                rgba(148, 163, 184, 0.05) 11px);
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
       EDITORIAL HEADER - COMPACT
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
       COMPOSITE TICKET CARD - COMPACT
       ======================================== */
    .composite-ticket {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 15px 40px -10px rgba(0, 0, 0, 0.08);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        margin-bottom: 20px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 180px;
    }

    .composite-ticket:hover {
        transform: translateY(-5px) scale(1.005);
        box-shadow: 0 30px 60px -12px rgba(37, 99, 235, 0.15);
    }

    .composite-ticket.cancelled {
        opacity: 0.65;
    }

    .composite-ticket.cancelled .ticket-image img {
        filter: grayscale(100%);
    }

    /* ========================================
       LEFT - IMAGE SECTION (30%) - COMPACT
       ======================================== */
    .ticket-image {
        width: 30%;
        min-width: 200px;
        position: relative;
        overflow: hidden;
    }

    .ticket-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Gradient Fade to White */
    .ticket-image::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 60px;
        height: 100%;
        background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
        pointer-events: none;
    }

    .ticket-image-placeholder {
        width: 100%;
        height: 100%;
        min-height: 180px;
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #94a3b8;
    }

    .ticket-image-placeholder i {
        font-size: 2rem;
        margin-bottom: 8px;
    }

    /* Refund Badge */
    .refund-overlay {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: rgba(245, 158, 11, 0.95);
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 8px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 2;
    }

    /* ========================================
       RIGHT - DETAILS SECTION (70%) - COMPACT
       ======================================== */
    .ticket-details {
        flex: 1;
        padding: 20px 25px 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Top Section: Car Info + Status */
    .ticket-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .ticket-car-info {
        flex: 1;
    }

    .ticket-car-name {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 1.4rem;
        letter-spacing: -0.5px;
        color: #0f172a;
        margin-bottom: 6px;
        line-height: 1.2;
    }

    /* Code Badge - Plate Number - COMPACT */
    .ticket-plate {
        font-family: 'Courier New', monospace;
        font-size: 0.7rem;
        font-weight: 600;
        color: #64748b;
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }

    /* Status Indicator - Minimalist */
    .ticket-status {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-text {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-text.confirmed {
        color: #065f46;
    }

    .status-text.pending {
        color: #92400e;
    }

    .status-text.completed {
        color: #1e40af;
    }

    .status-text.cancelled,
    .status-text.refunded {
        color: #991b1b;
    }

    /* Pulsing Dot */
    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
        animation: pulse-ring 2s infinite;
    }

    .status-dot.confirmed {
        background: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
    }

    .status-dot.pending {
        background: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.2);
    }

    .status-dot.completed {
        background: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
    }

    .status-dot.cancelled,
    .status-dot.refunded {
        background: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
    }

    @keyframes pulse-ring {
        0% {
            box-shadow: 0 0 0 0 currentColor;
            opacity: 1;
        }

        50% {
            box-shadow: 0 0 0 8px transparent;
            opacity: 0.5;
        }

        100% {
            box-shadow: 0 0 0 0 currentColor;
            opacity: 1;
        }
    }

    /* ========================================
       MIDDLE - DATES (WITH TEAR LINE) - COMPACT
       ======================================== */
    .ticket-dates {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 12px 0;
        border-top: 1px dashed #e2e8f0;
        border-bottom: 1px dashed #e2e8f0;
        margin-bottom: 12px;
    }

    .date-block {
        flex: 1;
    }

    .date-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.55rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        margin-bottom: 3px;
    }

    .date-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: #334155;
    }

    .date-divider {
        width: 1px;
        height: 35px;
        background: #e2e8f0;
    }

    /* ========================================
       BOTTOM - PRICE + ACTIONS - COMPACT
       ======================================== */
    .ticket-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .ticket-price {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.6rem;
        font-weight: 900;
        letter-spacing: -1px;
        color: #2563eb;
    }

    .ticket-price small {
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
    }

    .ticket-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Icon Button - COMPACT */
    .ticket-btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 1rem;
    }

    .ticket-btn-icon:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    /* Pay Button */
    .ticket-btn-pay {
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .ticket-btn-pay:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    /* Cancel Link */
    .ticket-cancel-link {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        color: #ef4444;
        text-decoration: none;
    }

    .ticket-cancel-link:hover {
        text-decoration: underline;
        color: #dc2626;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .bookings-empty {
        text-align: center;
        padding: 100px 20px;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.08);
    }

    .bookings-empty i {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 25px;
    }

    .bookings-empty h4 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .bookings-empty p {
        color: #64748b;
        margin-bottom: 25px;
    }

    .bookings-empty .btn-book {
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 14px;
        padding: 16px 36px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-block;
    }

    .bookings-empty .btn-book:hover {
        background: #1d4ed8;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 991px) {
        .composite-ticket {
            flex-direction: column;
        }

        .ticket-image {
            width: 100%;
            height: 220px;
        }

        .ticket-image::after {
            display: none;
        }

        .ticket-details {
            padding: 25px;
        }

        .editorial-title {
            font-size: 2.5rem;
        }

        .ticket-car-name {
            font-size: 1.5rem;
        }

        .ticket-price {
            font-size: 1.8rem;
        }

        .ticket-bottom {
            flex-direction: column;
            gap: 20px;
            align-items: flex-start;
        }

        .ticket-actions {
            width: 100%;
            justify-content: flex-start;
        }
    }

    @media (max-width: 576px) {
        .ticket-dates {
            flex-direction: column;
            gap: 20px;
            align-items: flex-start;
        }

        .date-divider {
            display: none;
        }

        .ticket-top {
            flex-direction: column;
            gap: 15px;
        }
    }

    /* Flash Messages */
    .flash-message {
        padding: 15px 20px;
        margin-bottom: 25px;
        border-radius: 12px;
        font-weight: 500;
    }
</style>

<!-- High-End Corporate Bookings Wrapper -->
<div class="bookings-corporate-wrapper">
    <div class="container">
        <!-- Editorial Header -->
        <div class="editorial-header">
            <div class="editorial-subtitle">Manage Your Trips</div>
            <h1 class="editorial-title">MY RESERVATIONS</h1>
        </div>

        <!-- Flash Messages -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <?= $this->Flash->render() ?>
            </div>
        </div>

        <?php if (!empty($bookings) && count($bookings) > 0): ?>
            <!-- Bookings List -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php foreach ($bookings as $booking): ?>
                        <?php
                        $isCancelled = in_array($booking->booking_status, ['cancelled', 'refunded']);
                        $cardClass = $isCancelled ? 'cancelled' : '';

                        // Check for Refund
                        $isRefunded = false;
                        if (!empty($booking->payments)) {
                            foreach ($booking->payments as $p) {
                                if ($p->payment_status === 'refunded') $isRefunded = true;
                            }
                        }

                        // Status class
                        $statusClass = match ($booking->booking_status) {
                            'pending' => 'pending',
                            'confirmed' => 'confirmed',
                            'completed' => 'completed',
                            'cancelled' => 'cancelled',
                            'refunded' => 'refunded',
                            default => 'pending'
                        };

                        $statusLabel = match ($booking->booking_status) {
                            'pending' => 'Pending',
                            'confirmed' => 'Confirmed',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                            'refunded' => 'Refunded',
                            default => ucfirst($booking->booking_status)
                        };
                        ?>

                        <!-- Composite Ticket Card -->
                        <div class="composite-ticket <?= $cardClass ?>">
                            <!-- Left - Image -->
                            <div class="ticket-image">
                                <?php if (!empty($booking->car->image) && file_exists(WWW_ROOT . 'img' . DS . $booking->car->image)): ?>
                                    <img src="<?= $this->Url->webroot('img/' . $booking->car->image) ?>" alt="Car">
                                <?php else: ?>
                                    <div class="ticket-image-placeholder">
                                        <i class="fas fa-car"></i>
                                        <span>No Image</span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($isRefunded): ?>
                                    <div class="refund-overlay">
                                        <i class="fas fa-money-bill-wave me-1"></i>Refund Processed
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Right - Details -->
                            <div class="ticket-details">
                                <!-- Top: Car Info + Status -->
                                <div class="ticket-top">
                                    <div class="ticket-car-info">
                                        <h3 class="ticket-car-name">
                                            <?= h($booking->car->brand ?? '') ?> <?= h($booking->car->car_model ?? 'Vehicle') ?>
                                        </h3>
                                        <span class="ticket-plate">
                                            <?= h($booking->car->plate_number ?? 'N/A') ?>
                                        </span>
                                    </div>
                                    <div class="ticket-status">
                                        <span class="status-dot <?= $statusClass ?>"></span>
                                        <span class="status-text <?= $statusClass ?>"><?= $statusLabel ?></span>
                                    </div>
                                </div>

                                <!-- Middle: Dates -->
                                <div class="ticket-dates">
                                    <div class="date-block">
                                        <div class="date-label">Pick Up</div>
                                        <div class="date-value">
                                            <?= $booking->start_date ? $booking->start_date->format('d M Y') : '-' ?>
                                        </div>
                                    </div>
                                    <div class="date-divider"></div>
                                    <div class="date-block">
                                        <div class="date-label">Return</div>
                                        <div class="date-value">
                                            <?= $booking->end_date ? $booking->end_date->format('d M Y') : '-' ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottom: Price + Actions -->
                                <div class="ticket-bottom">
                                    <div class="ticket-price">
                                        <small>RM</small> <?= number_format((float)$booking->total_price, 2) ?>
                                    </div>

                                    <div class="ticket-actions">
                                        <?= $this->Html->link(
                                            '<i class="fas fa-file-invoice"></i>',
                                            ['action' => 'viewBookings', $booking->id],
                                            ['class' => 'ticket-btn-icon', 'escape' => false, 'title' => 'View Booking']
                                        ) ?>

                                        <?php
                                        $unpaidInvoice = null;
                                        if (!empty($booking->invoices)) {
                                            foreach ($booking->invoices as $inv) {
                                                if ($inv->status === 'unpaid' && !$isCancelled) {
                                                    $unpaidInvoice = $inv;
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                        <?php if ($unpaidInvoice): ?>
                                            <?= $this->Html->link(
                                                'Pay Now',
                                                ['controller' => 'Invoices', 'action' => 'view', $unpaidInvoice->id],
                                                ['class' => 'ticket-btn-pay']
                                            ) ?>
                                        <?php endif; ?>

                                        <?php if (!$isCancelled && $booking->booking_status !== 'completed'): ?>
                                            <?php
                                            $today = date('Y-m-d');
                                            $startDate = $booking->start_date ? $booking->start_date->format('Y-m-d') : '';
                                            ?>
                                            <?php if ($startDate > $today): ?>
                                                <?= $this->Form->postLink(
                                                    'Cancel',
                                                    ['action' => 'cancelBooking', $booking->id],
                                                    [
                                                        'class' => 'ticket-cancel-link',
                                                        'confirm' => __('Are you sure? If you have paid, a refund request will be sent to the Admin.')
                                                    ]
                                                ) ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            <ul class="pagination"><?= $this->Paginator->numbers() ?></ul>
                        </nav>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Empty State -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bookings-empty">
                        <i class="fas fa-calendar-alt"></i>
                        <h4>No Reservations Yet</h4>
                        <p>You haven't made any bookings. Start your journey today!</p>
                        <?= $this->Html->link(
                            '<i class="fas fa-car me-2"></i>Browse Cars',
                            ['controller' => 'Cars', 'action' => 'index'],
                            ['class' => 'btn-book', 'escape' => false]
                        ) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>