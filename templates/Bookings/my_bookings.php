<?php

/**
 * My Bookings - Executive Brand Identity Edition
 * Dark Navy Header, Stats Cards, Active vs History Split
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */

// Split bookings into Active and History
$activeStatuses = ['pending', 'confirmed', 'active'];
$historyStatuses = ['cancelled', 'refunded', 'completed', 'rejected'];

$activeBookings = [];
$historyBookings = [];

foreach ($bookings as $booking) {
    $status = strtolower($booking->display_status);
    if (in_array($status, $activeStatuses)) {
        $activeBookings[] = $booking;
    } elseif (in_array($status, $historyStatuses)) {
        $historyBookings[] = $booking;
    }
}
?>

<style>
    /* Google Fonts - Montserrat (Bold & Punchy) + Inter */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800;900&display=swap');

    /* ========================================
       PAGE WRAPPER
       ======================================== */
    .bookings-executive-wrapper {
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
       MIDNIGHT HEADER - McLaren Textured
       ======================================== */
    .midnight-header {
        background-image:
            linear-gradient(to bottom,
                rgba(15, 23, 42, 0.95) 0%,
                rgba(15, 23, 42, 0.90) 40%,
                rgba(15, 23, 42, 0.60) 100%),
            url('<?= $this->Url->image('my_mclaren.jpg') ?>');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        padding: 80px 0 100px;
        position: relative;
    }

    .header-eyebrow {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.25em;
        color: rgba(147, 197, 253, 0.4);
        margin-bottom: 12px;
        text-align: center;
    }

    .header-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 3rem;
        text-transform: uppercase;
        letter-spacing: -0.02em;
        color: #ffffff;
        margin: 0;
        text-align: center;
    }

    @media (min-width: 768px) {
        .header-title {
            font-size: 4.5rem;
        }
    }

    /* ========================================
       FLOATING STATS CARDS - 3D Pop
       ======================================== */
    .stats-cards {
        display: flex;
        justify-content: center;
        gap: 0;
        margin-top: -4rem;
        position: relative;
        z-index: 10;
    }

    .stats-container {
        background: #ffffff;
        border-radius: 20px;
        display: flex;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        overflow: hidden;
    }

    .stat-card {
        padding: 28px 48px;
        text-align: center;
        border-right: 1px solid #f1f5f9;
    }

    .stat-card:last-child {
        border-right: none;
    }

    .stat-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 3rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #94a3b8;
    }

    /* ========================================
       CONTENT SECTION
       ======================================== */
    .content-section {
        padding: 40px 0 60px;
    }

    /* ========================================
       SEARCH & FILTER BAR
       ======================================== */
    .controls-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        gap: 16px;
    }

    .search-input {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 18px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        width: 300px;
        color: #334155;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #0f172a;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
    }

    .search-input::placeholder {
        color: #94a3b8;
    }

    .filter-select {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 18px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        color: #334155;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    /* ========================================
       SECTION HEADER
       ======================================== */
    .section-header {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #64748b;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-header i {
        color: #94a3b8;
    }

    /* ========================================
       COMPOSITE TICKET CARD (Active Bookings)
       ======================================== */
    .composite-ticket {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        min-height: 180px;
    }

    .composite-ticket:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    /* Left - Image Section */
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

    /* Right - Details Section */
    .ticket-details {
        flex: 1;
        padding: 20px 25px 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

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

    /* Status Indicator */
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
        color: #059669;
    }

    .status-text.pending {
        color: #d97706;
    }

    .status-text.completed {
        color: #2563eb;
    }

    .status-text.cancelled,
    .status-text.refunded {
        color: #dc2626;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
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

    /* Dates Section */
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

    /* Bottom: Price + Actions */
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
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    .ticket-btn-pay {
        background: #0f172a;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .ticket-btn-pay:hover {
        background: #1e293b;
        color: #ffffff;
    }

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
       HISTORY SECTION - COMPACT LEDGER
       ======================================== */
    .history-section {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        margin-top: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .history-header {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #64748b;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Compact Ledger Row */
    .history-row {
        display: grid;
        grid-template-columns: 100px 100px 1fr 100px 100px;
        padding: 14px 0;
        border-bottom: 1px solid #f8fafc;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        align-items: center;
        transition: background 0.2s ease;
    }

    .history-row:hover {
        background: #fafbfc;
    }

    .history-row:last-child {
        border-bottom: none;
    }

    .history-date {
        color: #64748b;
        font-size: 0.8rem;
    }

    .history-ref {
        font-family: 'Courier New', monospace;
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .history-car {
        font-weight: 600;
        color: #0f172a;
    }

    .history-price {
        font-family: 'Courier New', monospace;
        color: #475569;
        font-weight: 500;
    }

    /* Status Pills - Outline Style */
    .status-pill {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
        background: transparent;
    }

    .status-pill.cancelled,
    .status-pill.rejected,
    .status-pill.refunded {
        border: 1.5px solid #ef4444;
        color: #ef4444;
    }

    .status-pill.completed {
        border: 1.5px solid #10b981;
        color: #10b981;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .bookings-empty {
        text-align: center;
        padding: 100px 20px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .bookings-empty i {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 25px;
    }

    .bookings-empty h4 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .bookings-empty p {
        font-family: 'Montserrat', sans-serif;
        color: #64748b;
        margin-bottom: 25px;
    }

    .btn-book {
        background: #0f172a;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 16px 32px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-book:hover {
        background: #1e293b;
        color: #ffffff;
    }

    .no-active-message {
        text-align: center;
        padding: 50px 20px;
        color: #94a3b8;
        font-family: 'Montserrat', sans-serif;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .no-active-message i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        display: block;
        color: #10b981;
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

        .controls-bar {
            flex-direction: column;
        }

        .search-input {
            width: 100%;
        }

        .history-row {
            grid-template-columns: 1fr 80px 90px;
            gap: 8px;
        }

        .history-date,
        .history-ref {
            display: none;
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
</style>

<!-- Executive Bookings Wrapper -->
<div class="bookings-executive-wrapper">

    <!-- Midnight Header - McLaren Textured -->
    <div class="midnight-header">
        <div class="container">
            <div class="header-eyebrow">Manage Your Journeys</div>
            <h1 class="header-title">My Reservations</h1>
        </div>
    </div>

    <!-- Floating Stats Cards -->
    <div class="container">
        <div class="stats-cards">
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-value"><?= count($activeBookings) ?></div>
                    <div class="stat-label">Upcoming Trips</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= count($historyBookings) ?></div>
                    <div class="stat-label">Total History</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="container">
            <!-- Flash Messages -->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10">
                    <?= $this->Flash->render() ?>
                </div>
            </div>

            <?php if (!empty($bookings) && count($bookings) > 0): ?>
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <!-- Search & Filter Bar -->
                        <div class="controls-bar">
                            <input type="text" class="search-input" placeholder="🔍  Search by car name or ref..." id="bookingSearch" onkeyup="filterBookings()">
                            <select class="filter-select" id="statusFilter" onchange="filterBookings()">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <!-- ========================================
                             SECTION 1: UPCOMING JOURNEYS (Active)
                             ======================================== -->
                        <?php if (!empty($activeBookings)): ?>
                            <div class="section-header">
                                <i class="fas fa-plane-departure"></i> Upcoming Journeys
                            </div>

                            <?php foreach ($activeBookings as $booking): ?>
                                <?php
                                $isCancelled = in_array($booking->display_status, ['cancelled', 'refunded']);

                                $statusClass = match ($booking->display_status) {
                                    'pending' => 'pending',
                                    'confirmed' => 'confirmed',
                                    'active' => 'confirmed',
                                    default => 'pending'
                                };

                                $statusLabel = match ($booking->display_status) {
                                    'pending' => 'Pending',
                                    'confirmed' => 'Confirmed',
                                    'active' => 'Active',
                                    default => ucfirst($booking->display_status)
                                };
                                ?>

                                <!-- Composite Ticket Card -->
                                <div class="composite-ticket booking-row" data-status="<?= strtolower($booking->display_status) ?>">
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
                                    </div>

                                    <!-- Right - Details -->
                                    <div class="ticket-details">
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
                                                        ['controller' => 'Invoices', 'action' => 'viewInvoices', $unpaidInvoice->id],
                                                        ['class' => 'ticket-btn-pay']
                                                    ) ?>
                                                <?php endif; ?>

                                                <?php if ($booking->booking_status !== 'completed'): ?>
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
                        <?php else: ?>
                            <div class="no-active-message">
                                <i class="fas fa-check-circle"></i>
                                No upcoming bookings at the moment.
                            </div>
                        <?php endif; ?>


                        <!-- ========================================
                             SECTION 2: TRANSACTION HISTORY
                             ======================================== -->
                        <?php if (!empty($historyBookings)): ?>
                            <div class="history-section">
                                <div class="history-header">
                                    <i class="fas fa-history"></i> Past & Cancelled Bookings
                                </div>

                                <?php foreach ($historyBookings as $booking): ?>
                                    <?php
                                    $statusClass = match ($booking->booking_status) {
                                        'completed' => 'completed',
                                        'cancelled' => 'cancelled',
                                        'refunded' => 'refunded',
                                        'rejected' => 'rejected',
                                        default => 'cancelled'
                                    };

                                    $statusLabel = match ($booking->booking_status) {
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                        'refunded' => 'Refunded',
                                        'rejected' => 'Rejected',
                                        default => ucfirst($booking->booking_status)
                                    };
                                    ?>
                                    <div class="history-row booking-row" data-status="<?= strtolower($booking->booking_status) ?>">
                                        <div class="history-date">
                                            <?= $booking->start_date ? $booking->start_date->format('M d, Y') : '-' ?>
                                        </div>
                                        <div class="history-ref">
                                            #<?= h($booking->car->plate_number ?? 'N/A') ?>
                                        </div>
                                        <div class="history-car">
                                            <?= h(($booking->car->brand ?? '') . ' ' . ($booking->car->car_model ?? 'Vehicle')) ?>
                                        </div>
                                        <div class="history-price">
                                            RM <?= number_format((float)$booking->total_price, 2) ?>
                                        </div>
                                        <div>
                                            <span class="status-pill <?= $statusClass ?>"><?= $statusLabel ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

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
                                'Browse Cars',
                                ['controller' => 'Cars', 'action' => 'index'],
                                ['class' => 'btn-book', 'escape' => false]
                            ) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Simple search and filter
    function filterBookings() {
        const searchInput = document.getElementById('bookingSearch');
        const statusFilter = document.getElementById('statusFilter');
        const filter = searchInput.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        const rows = document.querySelectorAll('.booking-row');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const rowStatus = row.getAttribute('data-status');

            const matchesSearch = text.includes(filter);
            const matchesStatus = status === '' || rowStatus === status;

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }
</script>