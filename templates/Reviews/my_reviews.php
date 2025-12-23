<?php

/**
 * My Reviews - Customer view of their own reviews
 */
$this->assign('title', 'My Reviews');
?>

<style>
    .reviews-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
        padding: 60px 0;
        margin-bottom: 40px;
        border-radius: 0 0 30px 30px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #3b82f6;
    }

    .stat-label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .review-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        margin-bottom: 24px;
    }

    .review-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .review-car-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .review-content {
        padding: 20px;
    }

    .star-rating {
        color: #fbbf24;
        font-size: 1.2rem;
    }

    .star-rating .empty {
        color: #e2e8f0;
    }

    .review-date {
        font-size: 0.85rem;
        color: #94a3b8;
    }

    .review-comment {
        color: #475569;
        line-height: 1.6;
        margin-top: 12px;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }
</style>

<!-- Hero Section -->
<section class="reviews-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold text-white mb-3">My Reviews</h1>
                <p class="text-white-50">Your feedback helps us improve our fleet and service.</p>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-card">
                            <div class="stat-number"><?= $totalReviews ?></div>
                            <div class="stat-label">Total Reviews</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card">
                            <div class="stat-number"><?= $avgRating ?> <small style="font-size: 1rem;">★</small></div>
                            <div class="stat-label">Avg Rating Given</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews List -->
<section class="pb-5">
    <div class="container">
        <?php if ($reviews->isEmpty()): ?>
            <div class="empty-state">
                <i class="fas fa-star"></i>
                <h4 class="text-secondary">No Reviews Yet</h4>
                <p class="text-muted">You haven't left any reviews yet. After completing a booking, you can share your experience!</p>
                <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-car me-2"></i>Browse Cars
                </a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($reviews as $review): ?>
                    <div class="col-lg-6 col-xl-4">
                        <div class="review-card">
                            <!-- Car Image -->
                            <?php if ($review->car && $review->car->image): ?>
                                <?= $this->Html->image($review->car->image, ['class' => 'review-car-img', 'alt' => $review->car->name ?? 'Car']) ?>
                            <?php else: ?>
                                <div class="review-car-img bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="fas fa-car text-white fa-3x opacity-50"></i>
                                </div>
                            <?php endif; ?>

                            <div class="review-content">
                                <!-- Car Name -->
                                <h5 class="fw-bold mb-2">
                                    <?= h($review->car->name ?? 'Unknown Car') ?>
                                </h5>

                                <!-- Star Rating -->
                                <div class="star-rating mb-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $review->rating): ?>
                                            <i class="fas fa-star"></i>
                                        <?php else: ?>
                                            <i class="fas fa-star empty"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <span class="ms-2 text-dark fw-bold"><?= $review->rating ?>/5</span>
                                </div>

                                <!-- Comment -->
                                <?php if ($review->comment): ?>
                                    <p class="review-comment"><?= h($review->comment) ?></p>
                                <?php endif; ?>

                                <!-- Date -->
                                <div class="review-date mt-3">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?= $review->created->format('M j, Y') ?>
                                </div>

                                <!-- View Car Link -->
                                <div class="mt-3">
                                    <a href="<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'carReviews', $review->car_id]) ?>" class="btn btn-outline-primary btn-sm rounded-pill">
                                        <i class="fas fa-eye me-1"></i>View All Reviews for This Car
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

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
</section>