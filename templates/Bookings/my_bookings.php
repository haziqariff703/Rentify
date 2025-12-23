<?php
/**
 * My Bookings - Professional Edition
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
?>

<style>
    /* Flash Message Styling */
    .message {
        padding: 15px 20px;
        margin-bottom: 25px;
        border-radius: 12px;
        font-weight: 500;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid transparent;
        animation: slideDown 0.5s ease-out;
    }
    .message.success {
        background-color: #d1e7dd;
        color: #0f5132;
        border-color: #badbcc;
    }
    .message.error {
        background-color: #f8d7da;
        color: #842029;
        border-color: #f5c2c7;
    }
    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Card Styling */
    .booking-card {
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .booking-card.cancelled {
        opacity: 0.75;
        background-color: #f9f9f9;
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2">My Reservations</h2>
        <p class="text-muted">Manage your trips and transactions</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <?= $this->Flash->render() ?>
        </div>
    </div>

    <?php if (!empty($bookings) && count($bookings) > 0): ?>
        <div class="row g-4">
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
                ?>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 booking-card <?= $cardClass ?>" style="border-radius: 16px; overflow: hidden;">
                        
                        <div class="position-relative" style="height: 200px; background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);">
                            <?php if (!empty($booking->car->image) && file_exists(WWW_ROOT . 'img' . DS . $booking->car->image)): ?>
                                <img src="<?= $this->Url->webroot('img/' . $booking->car->image) ?>" 
                                     class="w-100 h-100" style="object-fit: cover; <?= $isCancelled ? 'filter: grayscale(100%);' : '' ?>"
                                     alt="Car">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center flex-column text-muted">
                                    <i class="fas fa-car fa-3x mb-2 opacity-50"></i>
                                    <span class="small fw-bold">Image Unavailable</span>
                                </div>
                            <?php endif; ?>

                            <?php
                            $statusConfig = match ($booking->booking_status) {
                                'pending' => ['bg' => 'warning', 'text' => 'dark', 'label' => 'Pending Payment'],
                                'confirmed' => ['bg' => 'success', 'text' => 'white', 'label' => 'Confirmed'],
                                'completed' => ['bg' => 'info', 'text' => 'white', 'label' => 'Completed'],
                                'cancelled' => ['bg' => 'danger', 'text' => 'white', 'label' => 'Cancelled'],
                                'refunded' => ['bg' => 'dark', 'text' => 'white', 'label' => 'Refunded'],
                                default => ['bg' => 'secondary', 'text' => 'white', 'label' => $booking->booking_status]
                            };
                            ?>
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-<?= $statusConfig['bg'] ?> text-<?= $statusConfig['text'] ?> shadow-sm px-3 py-2 rounded-pill">
                                    <?= h($statusConfig['label']) ?>
                                </span>
                            </div>

                             <?php if ($isRefunded): ?>
                                <div class="position-absolute bottom-0 start-0 m-3">
                                    <span class="badge bg-warning text-dark shadow-sm px-3 py-2 rounded-pill">
                                        <i class="fas fa-money-bill-wave me-1"></i> Refund Processed
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-1">
                                <?= h($booking->car->brand ?? '') ?> <?= h($booking->car->car_model ?? 'Vehicle') ?>
                            </h5>
                            <p class="text-muted small mb-3">Plate: <?= h($booking->car->plate_number ?? 'N/A') ?></p>

                            <div class="d-flex justify-content-between mb-3 bg-light p-3 rounded-3">
                                <div>
                                    <small class="text-uppercase text-muted" style="font-size: 0.7rem;">Pick-up</small>
                                    <div class="fw-bold"><?= $booking->start_date ? $booking->start_date->format('d M') : '-' ?></div>
                                </div>
                                <div class="text-end">
                                    <small class="text-uppercase text-muted" style="font-size: 0.7rem;">Return</small>
                                    <div class="fw-bold"><?= $booking->end_date ? $booking->end_date->format('d M, Y') : '-' ?></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="text-muted">Total Amount</span>
                                <span class="h4 fw-bold mb-0 text-primary">
                                    RM <?= number_format((float)$booking->total_price, 2) ?>
                                </span>
                            </div>

                            <div class="d-grid gap-2">
                                <?= $this->Html->link('View Receipt', ['action' => 'view', $booking->id], ['class' => 'btn btn-outline-primary']) ?>

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
                                                'class' => 'btn btn-outline-danger',
                                                'confirm' => __('Are you sure? If you have paid, a refund request will be sent to the Admin.')
                                            ]
                                        ) ?>
                                    <?php endif; ?>
                                <?php endif; ?>

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
                                        ['class' => 'btn btn-success fw-bold shadow-sm']
                                    ) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="d-flex justify-content-center mt-5">
            <nav><ul class="pagination"><?= $this->Paginator->numbers() ?></ul></nav>
        </div>

    <?php else: ?>
        <div class="text-center py-5">
            <h4 class="text-muted">No reservations found.</h4>
            <?= $this->Html->link('Book a Car', ['controller' => 'Cars', 'action' => 'index'], ['class' => 'btn btn-primary mt-3']) ?>
        </div>
    <?php endif; ?>
</div>