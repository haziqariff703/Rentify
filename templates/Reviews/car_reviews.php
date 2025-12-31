<?php

/**
 * Car Reviews - Public view of all reviews for a car
 * Modern 2-column layout with rating summary sidebar
 */
$this->assign('title', 'Reviews for ' . h($car->name));
?>

<style>
    .reviews-page {
        background: #f8fafc;
        min-height: 100vh;
        padding: 40px 0;
    }

    /* Left Sidebar - Summary */
    .summary-sidebar {
        position: sticky;
        top: 100px;
    }

    .car-preview-card {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 20px;
        padding: 25px;
        color: white;
        margin-bottom: 20px;
        text-align: center;
    }

    .car-preview-img {
        max-height: 140px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        margin-bottom: 15px;
    }

    .summary-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .summary-card h5 {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
    }

    .big-score {
        font-size: 4rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1;
    }

    .big-stars {
        color: #10b981;
        font-size: 1.2rem;
    }

    .rating-count {
        font-size: 0.9rem;
        color: #10b981;
        margin-top: 5px;
    }

    /* Distribution Bars */
    .distribution-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }

    .distribution-label {
        width: 90px;
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }

    .distribution-bar {
        flex-grow: 1;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
        margin-right: 10px;
    }

    .distribution-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .distribution-fill.star-5 {
        background: #10b981;
    }

    .distribution-fill.star-4 {
        background: #22c55e;
    }

    .distribution-fill.star-3 {
        background: #eab308;
    }

    .distribution-fill.star-2 {
        background: #f97316;
    }

    .distribution-fill.star-1 {
        background: #ef4444;
    }

    .distribution-value {
        width: 30px;
        text-align: right;
        font-size: 0.85rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* Right Content - Reviews List */
    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .reviews-header h4 {
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .reviews-header span {
        color: #64748b;
        font-weight: 400;
    }

    .review-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        margin-bottom: 16px;
        border: 1px solid #f1f5f9;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .reviewer-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1rem;
    }

    .reviewer-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .reviewer-stars {
        color: #10b981;
        font-size: 0.85rem;
    }

    .review-date {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .review-comment {
        color: #475569;
        line-height: 1.7;
        margin: 0;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 16px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    /* Back Button */
    .back-btn {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s;
        margin-bottom: 20px;
    }

    .back-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    @media (max-width: 991px) {
        .summary-sidebar {
            position: relative;
            top: 0;
            margin-bottom: 30px;
        }
    }
</style>

<section class="reviews-page">
    <div class="container">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-lg-4">
                <div class="summary-sidebar">
                    <!-- Back Button -->
                    <a href="<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'myReviews']) ?>" class="back-btn">
                        <i class="fas fa-chevron-left"></i>
                    </a>

                    <!-- Car Preview -->
                    <div class="car-preview-card">
                        <?php if ($car->image): ?>
                            <?= $this->Html->image($car->image, ['class' => 'car-preview-img img-fluid', 'alt' => $car->name]) ?>
                        <?php else: ?>
                            <div class="car-preview-img bg-secondary d-flex align-items-center justify-content-center mx-auto" style="height: 100px; width: 160px;">
                                <i class="fas fa-car text-white fa-3x opacity-50"></i>
                            </div>
                        <?php endif; ?>
                        <h5 class="fw-bold mb-1"><?= h($car->name) ?></h5>
                        <p class="text-white-50 mb-0 small"><?= h($car->brand ?? '') ?> <?= $car->year ?? '' ?></p>
                    </div>

                    <!-- Summary Card -->
                    <div class="summary-card">
                        <h5>Reviews and ratings</h5>

                        <!-- Big Score -->
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="big-score"><?= number_format($avgRating, 1) ?></div>
                            <div>
                                <div class="big-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= round($avgRating)): ?>
                                            <i class="fas fa-star"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="rating-count">Based on <?= $totalReviews ?> rating<?= $totalReviews != 1 ? 's' : '' ?></div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <!-- Rating Distribution -->
                        <?php for ($star = 5; $star >= 1; $star--): ?>
                            <?php
                            $count = $ratingDistribution[$star] ?? 0;
                            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            ?>
                            <div class="distribution-item">
                                <div class="distribution-label"><?= $star ?> Star<?= $star != 1 ? 's' : '' ?></div>
                                <div class="distribution-bar">
                                    <div class="distribution-fill star-<?= $star ?>" style="width: <?= $percentage ?>%;"></div>
                                </div>
                                <div class="distribution-value"><?= $count ?></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Right Content - Reviews List -->
            <div class="col-lg-8">
                <div class="reviews-header">
                    <h4>Reviews <span><?= $totalReviews ?></span></h4>
                </div>

                <?php if ($reviews->isEmpty()): ?>
                    <div class="empty-state">
                        <i class="fas fa-comments d-block"></i>
                        <h5 class="text-secondary">No Reviews Yet</h5>
                        <p class="text-muted">Be the first to review this car after your booking!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar">
                                        <?= strtoupper(substr($review->user->name ?? 'U', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="reviewer-name"><?= h($review->user->name ?? 'Anonymous') ?></div>
                                        <div class="reviewer-stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $review->rating): ?>
                                                    <i class="fas fa-star"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-date"><?= $review->created->format('M j') ?></div>
                            </div>

                            <?php if ($review->comment): ?>
                                <p class="review-comment"><?= h($review->comment) ?></p>
                            <?php endif; ?>
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