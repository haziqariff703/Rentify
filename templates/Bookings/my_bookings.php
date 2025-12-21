<?php

/**
 * My Bookings - Customer View
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
?>

<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2">My Bookings</h2>
        <p class="text-muted">Track your rental history and manage your reservations</p>
    </div>

    <?= $this->Flash->render() ?>

    <?php if (!empty($bookings) && count($bookings) > 0): ?>
        <div class="row g-4">
            <?php foreach ($bookings as $booking): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                        <!-- Car Image -->
                        <div class="position-relative" style="height: 160px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <?php if ($booking->car && $booking->car->image): ?>
                                <img src="<?= $this->Url->webroot('img/' . $booking->car->image) ?>"
                                    class="w-100 h-100" style="object-fit: cover;"
                                    alt="<?= h($booking->car->car_model ?? 'Car') ?>">
                            <?php else: ?>
                                <div class="h-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-car fa-3x text-white opacity-50"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Status Badge -->
                            <?php
                            $statusConfig = match ($booking->booking_status) {
                                'pending' => ['bg' => 'warning', 'text' => 'dark', 'icon' => 'clock'],
                                'confirmed' => ['bg' => 'success', 'text' => 'white', 'icon' => 'check-circle'],
                                'completed' => ['bg' => 'info', 'text' => 'white', 'icon' => 'flag-checkered'],
                                'cancelled' => ['bg' => 'danger', 'text' => 'white', 'icon' => 'times-circle'],
                                'refunded' => ['bg' => 'secondary', 'text' => 'white', 'icon' => 'undo'],
                                default => ['bg' => 'secondary', 'text' => 'white', 'icon' => 'question']
                            };
                            ?>
                            <span class="position-absolute top-0 end-0 m-2 badge bg-<?= $statusConfig['bg'] ?> text-<?= $statusConfig['text'] ?>">
                                <i class="fas fa-<?= $statusConfig['icon'] ?> me-1"></i>
                                <?= ucfirst(h($booking->booking_status)) ?>
                            </span>
                        </div>

                        <div class="card-body p-4">
                            <!-- Car Info -->
                            <h5 class="fw-bold mb-2">
                                <?= h($booking->car->brand ?? '') ?> <?= h($booking->car->car_model ?? 'Unknown Car') ?>
                            </h5>

                            <!-- Dates -->
                            <div class="d-flex align-items-center text-muted mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>
                                    <?= $booking->start_date ? $booking->start_date->format('M d') : 'N/A' ?>
                                    -
                                    <?= $booking->end_date ? $booking->end_date->format('M d, Y') : 'N/A' ?>
                                </span>
                            </div>

                            <!-- Price -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Total Price</span>
                                <span class="h5 fw-bold mb-0" style="color: #6366f1;">
                                    RM <?= number_format((float)$booking->total_price, 2) ?>
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye me-2"></i>View Details',
                                    ['action' => 'view', $booking->id],
                                    ['class' => 'btn btn-outline-primary', 'escape' => false]
                                ) ?>

                                <?php if ($booking->booking_status === 'pending' || $booking->booking_status === 'confirmed'): ?>
                                    <?php
                                    // Check if booking can be cancelled (before start date)
                                    $today = new \Cake\I18n\FrozenDate();
                                    $canCancel = $booking->start_date && $booking->start_date > $today;
                                    ?>
                                    <?php if ($canCancel): ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fas fa-times me-2"></i>Cancel Booking',
                                            ['action' => 'cancelBooking', $booking->id],
                                            [
                                                'class' => 'btn btn-outline-danger',
                                                'escape' => false,
                                                'confirm' => __('Are you sure you want to cancel this booking?')
                                            ]
                                        ) ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php
                                // Show Pay Now button if unpaid invoice exists
                                $unpaidInvoice = null;
                                if (!empty($booking->invoices)) {
                                    foreach ($booking->invoices as $inv) {
                                        if ($inv->status === 'unpaid') {
                                            $unpaidInvoice = $inv;
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <?php if ($unpaidInvoice): ?>
                                    <?= $this->Html->link(
                                        '<i class="fas fa-credit-card me-2"></i>Pay Now',
                                        ['controller' => 'Invoices', 'action' => 'view', $unpaidInvoice->id],
                                        ['class' => 'btn btn-success', 'escape' => false]
                                    ) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            <nav>
                <ul class="pagination">
                    <?= $this->Paginator->first('« First') ?>
                    <?= $this->Paginator->prev('‹ Prev') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('Next ›') ?>
                    <?= $this->Paginator->last('Last »') ?>
                </ul>
            </nav>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-calendar-times fa-5x text-muted opacity-25"></i>
            </div>
            <h4 class="text-muted mb-3">No Bookings Yet</h4>
            <p class="text-muted mb-4">You haven't made any car reservations yet. Browse our fleet to get started!</p>
            <?= $this->Html->link(
                '<i class="fas fa-car me-2"></i>Browse Cars',
                ['controller' => 'Cars', 'action' => 'index'],
                ['class' => 'btn btn-lg text-white px-5', 'style' => 'background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 12px;', 'escape' => false]
            ) ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .pagination .page-link {
        color: #6366f1;
        border: 1px solid #e2e8f0;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: #6366f1;
    }
</style>