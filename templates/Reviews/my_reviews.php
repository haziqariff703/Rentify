<?php
/**
 * My Reviews - Executive Brand Identity Edition
 * Dark Navy Header, Serif Fonts, Stacked Card List
 * @var \App\View\AppView $this
 */
$this->assign('title', 'My Reviews');
?>

<style>
    /* Google Fonts - Montserrat (Bold & Punchy) + Inter */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800;900&display=swap');

    /* ========================================
       PAGE WRAPPER
       ======================================== */
    .reviews-executive-wrapper {
        background-color: #f8fafc;
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
       METER HERO HEADER
       ======================================== */
    .meter-header {
        background-image:
            linear-gradient(to bottom, 
                rgba(15, 23, 42, 0.95) 0%,
                rgba(15, 23, 42, 0.90) 40%,
                rgba(15, 23, 42, 0.60) 100%),
            url('<?= $this->Url->image('my_meter.jpg') ?>');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        padding: 80px 0 100px;
        position: relative;
        text-align: center;
    }

    .header-eyebrow {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.25em;
        color: rgba(147, 197, 253, 0.6);
        margin-bottom: 12px;
    }

    .header-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 3rem;
        text-transform: uppercase;
        letter-spacing: -0.02em;
        color: #ffffff;
        margin: 0;
    }

    @media (min-width: 768px) {
        .header-title {
            font-size: 4.5rem;
        }
    }

    /* ========================================
       UNIFIED STATS CONTAINER
       ======================================== */
    .stats-container {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        max-width: 700px;
        margin: -4rem auto 40px;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        padding: 28px 0;
        position: relative;
        z-index: 10;
    }

    .stat-item {
        text-align: center;
        flex: 1;
    }

    .stat-divider {
        width: 1px;
        height: 50px;
        background-color: #e2e8f0;
    }

    .stat-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 2.5rem;
        font-weight: 900;
        color: #1e293b;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-value .star-icon {
        color: #f59e0b;
        margin-right: 6px;
    }

    .stat-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #94a3b8;
    }

    /* ========================================
       CONTENT SECTION
       ======================================== */
    .content-section {
        padding: 40px 0 60px;
        background-color: #f1f5f9;
        background-image: repeating-linear-gradient(
            135deg,
            transparent,
            transparent 10px,
            rgba(148, 163, 184, 0.05) 10px,
            rgba(148, 163, 184, 0.05) 11px
        );
    }

    /* ========================================
       REVIEW CARDS - STACKED LIST
       ======================================== */
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .review-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-color: transparent;
    }

    /* Car Thumbnail */
    .review-thumb {
        width: 100px;
        height: 70px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .review-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .review-thumb-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    /* Review Content */
    .review-content {
        flex: 1;
        min-width: 0;
    }

    .review-car-name {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .review-stars {
        color: #f59e0b;
        font-size: 1.1rem;
        margin-bottom: 8px;
    }

    .review-stars .empty {
        color: #e2e8f0;
    }

    .review-comment {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.9rem;
        font-style: italic;
        color: #64748b;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Review Meta & Actions */
    .review-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        flex-shrink: 0;
    }

    .review-date {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .btn-ghost {
        background: transparent;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-ghost:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .reviews-empty {
        text-align: center;
        padding: 80px 20px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .reviews-empty i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .reviews-empty h4 {
        font-family: 'Playfair Display', serif;
        color: #1e293b;
        font-weight: 600;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .reviews-empty p {
        font-family: 'Montserrat', sans-serif;
        color: #64748b;
        margin-bottom: 24px;
    }

    .btn-browse {
        background: #0f172a;
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        padding: 14px 28px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-browse:hover {
        background: #1e293b;
        color: #ffffff;
    }

    /* ========================================
       PAGINATION - MODERN PILL BUTTONS
       ======================================== */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        list-style: none;
        padding: 0;
        margin: 40px 0;
    }

    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .pagination li a:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.2);
    }

    .pagination li.active span,
    .pagination li.current span {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    .pagination li.disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
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

        .review-card {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .review-thumb {
            width: 100%;
            height: 150px;
        }

        .review-meta {
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
            align-items: center;
        }
    }
</style>

<!-- Executive Reviews Wrapper -->
<div class="reviews-executive-wrapper">

    <!-- Meter Hero Header -->
    <div class="meter-header">
        <div class="container">
            <div class="header-eyebrow">Your Feedback</div>
            <h1 class="header-title">My Reviews</h1>
        </div>
    </div>

    <!-- Unified Stats Container -->
    <div class="container">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-value"><?= $totalReviews ?></div>
                <div class="stat-label">Total Reviews</div>
            </div>

            <div class="stat-divider"></div>

            <div class="stat-item">
                <div class="stat-value">
                    <span class="star-icon">★</span><?= number_format($avgRating, 1) ?>
                </div>
                <div class="stat-label">Average Rating</div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="container">
            <?php if ($reviews->isEmpty()): ?>
                <!-- Empty State -->
                <div class="reviews-empty">
                    <i class="fas fa-star"></i>
                    <h4>No Reviews Yet</h4>
                    <p>You haven't left any reviews yet. Complete a booking to share your experience!</p>
                    <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn-browse">
                        <i class="fas fa-car"></i> Browse Cars
                    </a>
                </div>
            <?php else: ?>
                <!-- Reviews List -->
                <div class="reviews-list">
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <!-- Car Thumbnail -->
                            <div class="review-thumb">
                                <?php if ($review->car && $review->car->image): ?>
                                    <?= $this->Html->image($review->car->image, ['alt' => $review->car->name ?? 'Car']) ?>
                                <?php else: ?>
                                    <div class="review-thumb-placeholder">
                                        <i class="fas fa-car fa-2x"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Review Content -->
                            <div class="review-content">
                                <div class="review-car-name">
                                    <?= h($review->car->brand ?? '') ?> <?= h($review->car->car_model ?? $review->car->name ?? 'Unknown Car') ?>
                                </div>
                                <div class="review-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $review->rating): ?>
                                            <i class="fas fa-star"></i>
                                        <?php else: ?>
                                            <i class="fas fa-star empty"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="review-comment">
                                    "<?= h($review->comment ?? 'No comment') ?>"
                                </div>
                            </div>

                            <!-- Meta & Actions -->
                            <div class="review-meta">
                                <div class="review-date">
                                    <?= $review->created->format('d M Y') ?>
                                </div>
                                <a href="<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'carReviews', $review->car_id]) ?>" class="btn-ghost">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    <nav>
                        <ul class="pagination">
                            <?= $this->Paginator->prev('« Previous') ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('Next »') ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>