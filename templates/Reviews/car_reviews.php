<?php

/**
 * Car Reviews - Public view of all reviews for a car
 */
$this->assign('title', 'Reviews for ' . h($car->name));
?>

<style>
    .car-reviews-hero {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        padding: 60px 0;
        margin-bottom: 40px;
        border-radius: 0 0 30px 30px;
    }

    .car-image-hero {
        max-height: 200px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .rating-summary {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .big-rating {
        font-size: 3rem;
        font-weight: 700;
        color: #fbbf24;
    }

    .review-item {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
        border-left: 4px solid #3b82f6;
    }

    .reviewer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .star-rating {
        color: #fbbf24;
    }

    .star-rating .empty {
        color: #e2e8f0;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: #f8fafc;
        border-radius: 16px;
    }
</style>

<!-- Hero Section -->
<section class="car-reviews-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-center mb-4 mb-lg-0">
                <?php if ($car->image): ?>
                    <?= $this->Html->image($car->image, ['class' => 'car-image-hero img-fluid', 'alt' => $car->name]) ?>
                <?php else: ?>
                    <div class="car-image-hero bg-secondary d-flex align-items-center justify-content-center" style="height: 160px; width: 100%;">
                        <i class="fas fa-car text-white fa-4x opacity-50"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-5">
                <h1 class="display-6 fw-bold text-white mb-2"><?= h($car->name) ?></h1>
                <p class="text-white-50 mb-3"><?= h($car->brand ?? '') ?> <?= $car->year ?? '' ?></p>
                <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'view', $car->id]) ?>" class="btn btn-outline-light rounded-pill">
                    <i class="fas fa-info-circle me-2"></i>View Car Details
                </a>
            </div>
            <div class="col-lg-3">
                <div class="rating-summary text-center">
                    <div class="big-rating"><?= $avgRating ?></div>
                    <div class="star-rating mb-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= round($avgRating)): ?>
                                <i class="fas fa-star"></i>
                            <?php else: ?>
                                <i class="fas fa-star empty"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <div class="text-white-50"><?= $totalReviews ?> Review<?= $totalReviews != 1 ? 's' : '' ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews List -->
<section class="pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <?php if ($reviews->isEmpty()): ?>
                    <div class="empty-state">
                        <i class="fas fa-comments fa-4x text-secondary opacity-50 mb-4"></i>
                        <h4 class="text-secondary">No Reviews Yet</h4>
                        <p class="text-muted">Be the first to review this car after your booking!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item">
                            <div class="d-flex align-items-start">
                                <!-- Avatar -->
                                <div class="reviewer-avatar me-3">
                                    <?= strtoupper(substr($review->user->name ?? 'U', 0, 1)) ?>
                                </div>

                                <div class="flex-grow-1">
                                    <!-- Name & Rating -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold mb-0"><?= h($review->user->name ?? 'Anonymous') ?></h6>
                                        <div class="star-rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $review->rating): ?>
                                                    <i class="fas fa-star"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-star empty"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <!-- Comment -->
                                    <?php if ($review->comment): ?>
                                        <p class="text-secondary mb-2"><?= h($review->comment) ?></p>
                                    <?php endif; ?>

                                    <!-- Date -->
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?= $review->created->format('F j, Y') ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            <?= $this->Paginator->prev('« Previous') ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('Next »') ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>