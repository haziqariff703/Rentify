<?php
/**
 * My Bookings - Minimalist Corporate Boarding Pass
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
?>

<style>
    /* Google Fonts - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    /* ========================================
       PLATINUM DOT BACKGROUND
       ======================================== */
    .bookings-corporate-wrapper {
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
       PAGE HEADER
       ======================================== */
    .bookings-page-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .bookings-page-header h1 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 2.25rem;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .bookings-page-header p {
        font-family: 'Montserrat', sans-serif;
        color: #64748b;
        font-size: 0.95rem;
    }

    /* ========================================
       BOARDING PASS CARD
       ======================================== */
    .boarding-pass {
        background: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        transition: all 0.3s ease;
    }

    .boarding-pass:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -5px rgba(0, 0, 0, 0.1);
    }

    .boarding-pass.cancelled {
        opacity: 0.7;
    }

    .boarding-pass.cancelled .pass-image img {
        filter: grayscale(100%);
    }

    /* ========================================
       IMAGE SECTION (LEFT)
       ======================================== */
    .pass-image {
        width: 250px;
        min-width: 250px;
        position: relative;
        overflow: hidden;
    }

    .pass-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .pass-image-placeholder {
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

    .pass-image-placeholder i {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    /* ========================================
       CONTENT SECTION (RIGHT)
       ======================================== */
    .pass-content {
        flex: 1;
        padding: 30px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        gap: 30px;
    }

    /* Itinerary (Middle) */
    .pass-itinerary {
        flex: 1;
    }

    .pass-car-name {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .pass-plate {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 20px;
    }

    /* Timeline */
    .pass-timeline {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .timeline-item {
        text-align: left;
    }

    .timeline-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        margin-bottom: 4px;
    }

    .timeline-date {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
    }

    .timeline-divider {
        width: 1px;
        height: 40px;
        background: #e2e8f0;
    }

    /* ========================================
       ACTION ZONE (RIGHT)
       ======================================== */
    .pass-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: space-between;
        min-width: 160px;
    }

    /* Status Badge with Pulse */
    .pass-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pass-status.confirmed {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .pass-status.pending {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .pass-status.completed {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
    }

    .pass-status.cancelled,
    .pass-status.refunded {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    /* Pulse Dot */
    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
        100% { opacity: 1; transform: scale(1); }
    }

    /* Price */
    .pass-price {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #2563eb;
        margin: 15px 0;
    }

    .pass-price small {
        font-size: 0.9rem;
        font-weight: 500;
        color: #64748b;
    }

    /* Action Buttons */
    .pass-buttons {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }

    .pass-btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #f1f5f9;
        border: none;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pass-btn-icon:hover {
        background: #2563eb;
        color: #ffffff;
    }

    .pass-btn-pay {
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pass-btn-pay:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .pass-cancel-link {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        color: #ef4444;
        text-decoration: none;
        margin-top: 5px;
    }

    .pass-cancel-link:hover {
        text-decoration: underline;
        color: #dc2626;
    }

    /* Refund Badge */
    .refund-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(245, 158, 11, 0.9);
        color: #ffffff;
        padding: 6px 12px;
        border-radius: 8px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .bookings-empty {
        text-align: center;
        padding: 80px 20px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.05);
    }

    .bookings-empty i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .bookings-empty h4 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .bookings-empty p {
        color: #64748b;
        margin-bottom: 20px;
    }

    .bookings-empty .btn-book {
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 14px 30px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .bookings-empty .btn-book:hover {
        background: #1d4ed8;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 991px) {
        .boarding-pass {
            flex-direction: column;
        }

        .pass-image {
            width: 100%;
            height: 200px;
        }

        .pass-image img {
            border-radius: 20px 20px 0 0;
        }

        .pass-content {
            flex-direction: column;
            gap: 20px;
        }

        .pass-actions {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            min-width: auto;
        }

        .pass-buttons {
            flex-direction: row;
        }
    }

    @media (max-width: 576px) {
        .pass-timeline {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .timeline-divider {
            display: none;
        }

        .pass-price {
            font-size: 1.5rem;
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

<!-- Minimalist Corporate Bookings Wrapper -->
<div class="bookings-corporate-wrapper">
    <div class="container">
        <!-- Page Header -->
        <div class="bookings-page-header">
            <h1>My Reservations</h1>
            <p>Manage your trips and transactions</p>
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
                <div class="col-md-10">
                    <?php foreach ($bookings as $booking): ?>
                        <?php 
                            $isCancelled = in_array($booking->booking_status, ['cancelled', 'refunded']);
                            $cardClass = $isCancelled ? 'cancelled' : '';
                            
                            // Check for Refund
                            $isRefunded = false;
                            if (!empty($booking->payments)) {
                                foreach($booking->payments as $p) {
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

                        <!-- Boarding Pass Card -->
                        <div class="boarding-pass <?= $cardClass ?>">
                            <!-- Image Section -->
                            <div class="pass-image">
                                <?php if (!empty($booking->car->image) && file_exists(WWW_ROOT . 'img' . DS . $booking->car->image)): ?>
                                    <img src="<?= $this->Url->webroot('img/' . $booking->car->image) ?>" alt="Car">
                                <?php else: ?>
                                    <div class="pass-image-placeholder">
                                        <i class="fas fa-car"></i>
                                        <span>No Image</span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($isRefunded): ?>
                                    <div class="refund-badge">
                                        <i class="fas fa-money-bill-wave me-1"></i>Refund Processed
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Content Section -->
                            <div class="pass-content">
                                <!-- Itinerary -->
                                <div class="pass-itinerary">
                                    <h3 class="pass-car-name">
                                        <?= h($booking->car->brand ?? '') ?> <?= h($booking->car->car_model ?? 'Vehicle') ?>
                                    </h3>
                                    <div class="pass-plate">
                                        <?= h($booking->car->plate_number ?? 'N/A') ?>
                                    </div>

                                    <!-- Timeline -->
                                    <div class="pass-timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-label">Pick Up</div>
                                            <div class="timeline-date">
                                                <?= $booking->start_date ? $booking->start_date->format('d M Y') : '-' ?>
                                            </div>
                                        </div>
                                        <div class="timeline-divider"></div>
                                        <div class="timeline-item">
                                            <div class="timeline-label">Return</div>
                                            <div class="timeline-date">
                                                <?= $booking->end_date ? $booking->end_date->format('d M Y') : '-' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Zone -->
                                <div class="pass-actions">
                                    <!-- Status Badge -->
                                    <div class="pass-status <?= $statusClass ?>">
                                        <?php if ($statusClass === 'confirmed'): ?>
                                            <span class="pulse-dot"></span>
                                        <?php endif; ?>
                                        <?= $statusLabel ?>
                                    </div>

                                    <!-- Price -->
                                    <div class="pass-price">
                                        <small>RM</small> <?= number_format((float)$booking->total_price, 2) ?>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="pass-buttons">
                                        <?= $this->Html->link(
                                            '<i class="fas fa-file-invoice"></i>',
                                            ['action' => 'view', $booking->id],
                                            ['class' => 'pass-btn-icon', 'escape' => false, 'title' => 'View Receipt']
                                        ) ?>

                                        <?php
                                        $unpaidInvoice = null;
                                        if (!empty($booking->invoices)) {
                                            foreach ($booking->invoices as $inv) {
                                                if ($inv->status === 'unpaid' && !$isCancelled) {
                                                    $unpaidInvoice = $inv; break;
                                                }
                                            }
                                        }
                                        ?>
                                        <?php if ($unpaidInvoice): ?>
                                            <?= $this->Html->link(
                                                'Pay Now',
                                                ['controller' => 'Invoices', 'action' => 'view', $unpaidInvoice->id],
                                                ['class' => 'pass-btn-pay']
                                            ) ?>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!$isCancelled && $booking->booking_status !== 'completed'): ?>
                                        <?php 
                                            $today = date('Y-m-d');
                                            $startDate = $booking->start_date ? $booking->start_date->format('Y-m-d') : '';
                                        ?>
                                        <?php if ($startDate > $today): ?>
                                            <?= $this->Form->postLink(
                                                'Cancel Booking',
                                                ['action' => 'cancelBooking', $booking->id],
                                                [
                                                    'class' => 'pass-cancel-link',
                                                    'confirm' => __('Are you sure? If you have paid, a refund request will be sent to the Admin.')
                                                ]
                                            ) ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav><ul class="pagination"><?= $this->Paginator->numbers() ?></ul></nav>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Empty State -->
            <div class="row justify-content-center">
                <div class="col-md-8">
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