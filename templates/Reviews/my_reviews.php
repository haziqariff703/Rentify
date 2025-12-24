<?php
/**
 * My Reviews - Clean Corporate Blue
 * Matches my_invoices.php and my_payments.php design
 * @var \App\View\AppView $this
 */
$this->assign('title', 'My Reviews');
?>

<style>
    /* Google Fonts - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

    /* ========================================
       DIAGONAL MICRO-STRIPE BACKGROUND
       ======================================== */
    .reviews-corporate-wrapper {
        background-color: #f8fafc;
        background-image: repeating-linear-gradient(
            135deg,
            transparent,
            transparent 10px,
            rgba(148, 163, 184, 0.05) 10px,
            rgba(148, 163, 184, 0.05) 11px
        );
        background-attachment: fixed;
        min-height: 100vh;
        padding: 50px 0 80px;
        margin-top: -3rem;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* ========================================
       WHITE PANEL CONTAINER + DEEP LIFT SHADOW
       ======================================== */
    .white-panel {
        background: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        box-shadow:
            0 4px 6px -1px rgba(0, 0, 0, 0.05),
            0 25px 50px -12px rgba(37, 99, 235, 0.2);
        padding: 50px;
        max-width: 1200px;
        margin: 0 auto;
        overflow: visible;
    }

    /* ========================================
       EDITORIAL HEADER
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
       BRAND BLUE HERO WIDGET
       ======================================== */
    .hero-widget {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        border-radius: 20px;
        box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.4);
        margin-bottom: 40px;
        padding: 35px 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .hero-widget-left {
        display: flex;
        align-items: center;
        gap: 40px;
    }

    .hero-stat {
        text-align: center;
    }

    .hero-stat-number {
        font-family: 'Montserrat', sans-serif;
        font-size: 3rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
    }

    .hero-stat-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(255, 255, 255, 0.8);
        margin-top: 8px;
    }

    .hero-divider {
        width: 1px;
        height: 60px;
        background: rgba(255, 255, 255, 0.3);
    }

    /* ========================================
       SCROLL WRAPPER
       ======================================== */
    .table-scroll-wrapper {
        max-height: 450px;
        overflow-y: auto;
        border-radius: 12px;
    }

    .table-scroll-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* ========================================
       TABLE STYLING - LIGHT THEME
       ======================================== */
    .reviews-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .reviews-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .reviews-table thead tr {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    }

    .reviews-table th {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #ffffff;
        padding: 18px 20px;
        text-align: left;
        white-space: nowrap;
    }

    .reviews-table th:first-child {
        border-radius: 12px 0 0 12px;
    }

    .reviews-table th:last-child {
        border-radius: 0 12px 12px 0;
    }

    .reviews-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s ease;
    }

    .reviews-table tbody tr:hover {
        background: #f8fafc;
    }

    .reviews-table td {
        font-family: 'Montserrat', sans-serif;
        padding: 20px;
        vertical-align: middle;
        color: #475569;
        font-size: 0.9rem;
    }

    /* Car Cell */
    .car-cell {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .car-thumb {
        width: 60px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
    }

    .car-thumb-placeholder {
        width: 60px;
        height: 45px;
        border-radius: 8px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .car-thumb-placeholder i {
        color: #94a3b8;
        font-size: 1rem;
    }

    .car-name {
        font-weight: 600;
        color: #1e293b;
    }

    /* Rating Stars */
    .rating-stars {
        color: #f59e0b;
        font-size: 1rem;
    }

    .rating-stars .empty {
        color: #e2e8f0;
    }

    .rating-number {
        font-weight: 600;
        color: #1e293b;
        margin-left: 8px;
    }

    /* Comment Cell */
    .comment-text {
        max-width: 300px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #64748b;
        line-height: 1.5;
    }

    /* Date Cell */
    .date-text {
        color: #64748b;
        font-size: 0.85rem;
    }

    /* Action Button */
    .btn-view {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h4 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        color: #475569;
        margin-bottom: 10px;
    }

    .empty-state p {
        font-family: 'Montserrat', sans-serif;
        color: #94a3b8;
        margin-bottom: 24px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .white-panel {
            padding: 30px 20px;
            margin: 0 16px;
        }

        .hero-widget {
            flex-direction: column;
            gap: 20px;
            padding: 30px;
        }

        .hero-widget-left {
            gap: 30px;
        }

        .reviews-table th,
        .reviews-table td {
            padding: 14px 12px;
            font-size: 0.8rem;
        }
    }
</style>

<!-- Corporate Wrapper with Diagonal Stripes -->
<div class="reviews-corporate-wrapper">
    <div class="container">
        <div class="white-panel">
            
            <!-- Editorial Header -->
            <div class="editorial-header">
                <p class="editorial-subtitle">Your Feedback</p>
                <h1 class="editorial-title">MY REVIEWS</h1>
            </div>

            <!-- Hero Widget with Stats -->
            <div class="hero-widget">
                <div class="hero-widget-left">
                    <div class="hero-stat">
                        <div class="hero-stat-number"><?= $totalReviews ?></div>
                        <div class="hero-stat-label">Total Reviews</div>
                    </div>
                    <div class="hero-divider"></div>
                    <div class="hero-stat">
                        <div class="hero-stat-number"><?= $avgRating ?>★</div>
                        <div class="hero-stat-label">Avg Rating</div>
                    </div>
                </div>
            </div>

            <?php if ($reviews->isEmpty()): ?>
                <div class="empty-state">
                    <i class="fas fa-star"></i>
                    <h4>No Reviews Yet</h4>
                    <p>You haven't left any reviews yet. Complete a booking to share your experience!</p>
                    <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-car me-2"></i>Browse Cars
                    </a>
                </div>
            <?php else: ?>
                <!-- Scrollable Table -->
                <div class="table-scroll-wrapper">
                    <table class="reviews-table">
                        <thead>
                            <tr>
                                <th>Car</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reviews as $review): ?>
                                <tr>
                                    <!-- Car -->
                                    <td>
                                        <div class="car-cell">
                                            <?php if ($review->car && $review->car->image): ?>
                                                <?= $this->Html->image($review->car->image, ['class' => 'car-thumb', 'alt' => $review->car->name ?? 'Car']) ?>
                                            <?php else: ?>
                                                <div class="car-thumb-placeholder">
                                                    <i class="fas fa-car"></i>
                                                </div>
                                            <?php endif; ?>
                                            <span class="car-name"><?= h($review->car->name ?? 'Unknown Car') ?></span>
                                        </div>
                                    </td>

                                    <!-- Rating -->
                                    <td>
                                        <div class="rating-stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $review->rating): ?>
                                                    <i class="fas fa-star"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-star empty"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <span class="rating-number"><?= $review->rating ?>/5</span>
                                        </div>
                                    </td>

                                    <!-- Comment -->
                                    <td>
                                        <div class="comment-text">
                                            <?= h($review->comment ?? 'No comment') ?>
                                        </div>
                                    </td>

                                    <!-- Date -->
                                    <td>
                                        <span class="date-text"><?= $review->created->format('d M Y') ?></span>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <a href="<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'carReviews', $review->car_id]) ?>" class="btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4 pt-3">
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