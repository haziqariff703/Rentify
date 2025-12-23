<?php

/**
 * Add Review - Customer adds review after booking/payment
 */
$this->assign('title', 'Leave a Review');
?>

<style>
    .review-form-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .car-preview {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        color: white;
    }

    .car-preview-img {
        max-height: 150px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    }

    .review-form {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    /* Star Rating Input */
    .star-rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 8px;
    }

    .star-rating-input input {
        display: none;
    }

    .star-rating-input label {
        font-size: 2.5rem;
        color: #e2e8f0;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
    }

    .star-rating-input label:hover,
    .star-rating-input label:hover~label,
    .star-rating-input input:checked~label {
        color: #fbbf24;
        transform: scale(1.1);
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    textarea.form-control {
        min-height: 150px;
        resize: none;
    }
</style>

<section class="py-5">
    <div class="container">
        <div class="review-form-container">
            <!-- Car Preview -->
            <div class="car-preview text-center">
                <?php if ($booking->car->image): ?>
                    <?= $this->Html->image($booking->car->image, ['class' => 'car-preview-img mb-3', 'alt' => $booking->car->name]) ?>
                <?php else: ?>
                    <div class="car-preview-img bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3" style="height: 120px; width: 200px;">
                        <i class="fas fa-car fa-3x opacity-50"></i>
                    </div>
                <?php endif; ?>
                <h4 class="fw-bold mb-1"><?= h($booking->car->name) ?></h4>
                <p class="text-white-50 mb-0">
                    Booked: <?= $booking->start_date->format('M j') ?> - <?= $booking->end_date->format('M j, Y') ?>
                </p>
            </div>

            <!-- Review Form -->
            <div class="review-form">
                <h3 class="text-center mb-4">How was your experience?</h3>
                <p class="text-center text-muted mb-4">Your feedback helps us maintain our fleet and improve our service.</p>

                <?= $this->Form->create($review) ?>

                <!-- Star Rating -->
                <div class="mb-4">
                    <label class="form-label d-block text-center fw-bold mb-3">Rate Your Experience</label>
                    <div class="star-rating-input">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>" <?= $i == 5 ? 'checked' : '' ?>>
                            <label for="star<?= $i ?>"><i class="fas fa-star"></i></label>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Comment -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Your Review (Optional)</label>
                    <?= $this->Form->textarea('comment', [
                        'class' => 'form-control',
                        'placeholder' => 'Share your experience with this car. How was the condition? The comfort? Would you rent it again?',
                        'rows' => 5
                    ]) ?>
                </div>

                <!-- Submit -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                        <i class="fas fa-paper-plane me-2"></i>Submit Review
                    </button>
                    <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'myBookings']) ?>" class="btn btn-link text-muted">
                        Skip for now
                    </a>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>