<?php

/**
 * Rentify Premium Fleet Catalog - 2-Column Grid Edition
 * Features: Responsive grid, fixed sidebar, uniform cards, no spotlight effect
 */
$this->assign('title', 'The Garage');
?>

<style>
    /* Google Fonts - Montserrat (Bold & Punchy) + Inter (Readable Body) */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800;900&display=swap');

    /* ========================================
       DASHBOARD LAYOUT - Full Width Container
       ======================================== */
    .platinum-studio-wrapper {
        background-color: #f8fafc;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        padding: 30px 48px;
        min-height: 80vh;
    }

    /* Dashboard Row - 25% / 75% Split */
    .dashboard-row {
        display: flex;
        height: 100%;
        gap: 24px;
    }

    /* ========================================
       FIXED SIDEBAR - 25% Width
       ======================================== */
    .sidebar-column {
        width: 25%;
        min-width: 220px;
        max-width: 280px;
        flex-shrink: 0;
        height: 100%;
        overflow-y: auto;
        position: relative;
    }

    /* ========================================
       SCROLLABLE CAR GRID - 75% Width
       ======================================== */
    .content-column {
        flex: 1;
        height: 80vh;
        max-height: 800px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 8px;
    }

    /* Polished Thin Scrollbar */
    .content-column::-webkit-scrollbar {
        width: 6px;
    }

    .content-column::-webkit-scrollbar-track {
        background: transparent;
        border-radius: 10px;
    }

    .content-column::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .content-column::-webkit-scrollbar-thumb:hover {
        background: #334155;
    }

    /* ========================================
       SINGLE-COLUMN CARD STACK
       ======================================== */
    .car-list {
        display: flex;
        flex-direction: column;
        gap: 24px;
        padding-bottom: 40px;
    }

    /* ========================================
       UTILITY CONTROL BAR
       ======================================== */
    .utility-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding: 0 4px;
    }

    .utility-bar-left {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
    }

    .utility-bar-left .count {
        font-weight: 700;
        color: #0f172a;
    }

    .utility-bar-right {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .utility-bar-right:hover {
        color: #0f172a;
    }

    .utility-bar-right i {
        font-size: 0.7rem;
    }

    /* ========================================
       HERO SECTION - FULL WIDTH FLEET BANNER
       ======================================== */
    .fleet-banner {
        background-image:
            linear-gradient(to bottom,
                rgba(15, 23, 42, 0.95) 0%,
                rgba(15, 23, 42, 0.90) 40%,
                rgba(15, 23, 42, 0.60) 100%),
            url('<?= $this->Url->image('ferrari-background.png') ?>');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;

        /* Full Width Edge-to-Edge */
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        margin-top: -3rem;

        padding: 100px 0 120px;
        text-align: center;
        color: white;
        margin-bottom: 40px;
    }

    .fleet-eyebrow {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        color: rgba(147, 197, 253, 0.7);
        margin-bottom: 16px;
    }

    .fleet-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 3.5rem;
        text-transform: uppercase;
        letter-spacing: -0.02em;
        color: #ffffff;
        margin: 0;
        line-height: 1;
    }

    @media (min-width: 768px) {
        .fleet-title {
            font-size: 5rem;
        }
    }

    .fleet-title .text-red {
        color: #ef4444;
        text-shadow: 0 0 40px rgba(239, 68, 68, 0.4);
    }

    /* ========================================
       FILTER SIDEBAR - Bold High-Contrast
       ======================================== */
    .filter-card {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        font-family: 'Montserrat', sans-serif;
    }

    .filter-header {
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 16px;
    }

    .filter-header h5 {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #000000;
        margin: 0;
    }

    .filter-header i {
        display: none;
    }

    .filter-accordion-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        cursor: pointer;
    }

    .filter-accordion-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #000000;
        margin: 0;
    }

    .filter-accordion-toggle {
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
    }

    .filter-accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .filter-accordion-content.expanded {
        max-height: 400px;
    }

    .filter-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .filter-list-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        cursor: pointer;
        color: #1e293b;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .filter-list-item:hover {
        color: #000000;
    }

    .filter-list-item.active {
        color: #000000;
        font-weight: 700;
    }

    .filter-list-item.active::before {
        content: '';
        width: 10px;
        height: 10px;
        background: #000000;
        border-radius: 2px;
        margin-right: 12px;
    }

    /* ========================================
       HORIZONTAL CAR CARDS - Premium Layout
       ======================================== */
    .car-item {
        width: 100%;
    }

    .car-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
        border: 1px solid #e2e8f0;
        border-top: 4px solid var(--car-theme, #0f172a);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }

    @media (min-width: 768px) {
        .car-card {
            flex-direction: row;
            min-height: 220px;
        }
    }

    .car-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px color-mix(in srgb, var(--car-theme, #0f172a) 25%, transparent);
    }

    /* Car Image Section - 40% Width */
    .car-image-container {
        width: 100%;
        height: 200px;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .car-image-container {
            width: 40%;
            height: auto;
            min-height: 220px;
        }
    }

    .car-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .car-card:hover .car-image {
        transform: scale(1.05);
    }

    /* Availability Badge - SOLID Bold Style */
    .availability-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 5;
    }

    .badge-available {
        background: #059669;
        color: #ffffff;
    }

    .badge-maintenance {
        background: #dc2626;
        color: #ffffff;
    }

    /* Special Badges - Top Right */
    .special-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        z-index: 5;
    }

    .badge-hot {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .badge-top-rated {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    /* Car Details Section - 60% Width */
    .car-details {
        flex: 1;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    @media (min-width: 768px) {
        .car-details {
            width: 60%;
        }
    }

    /* Car Category - HIDDEN */
    .car-category {
        display: none;
    }

    /* Car Name - ExtraBold */
    .car-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 8px;
    }

    /* Reviews Stars */
    .car-reviews {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 16px;
    }

    .car-reviews .stars {
        color: #f59e0b;
        font-size: 0.85rem;
    }

    .car-reviews .count {
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        color: #64748b;
    }

    /* Bold Punchy Price Tag - Balanced */
    .car-price {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.15rem;
        font-weight: 800;
        color: #1e3a5f;
        margin-bottom: 12px;
    }

    .car-price small {
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        color: #94a3b8;
        font-size: 0.7rem;
    }

    /* Specs Row - Readable Inter */
    .car-specs {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
    }

    .spec-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        color: #475569;
    }

    .spec-item i {
        color: #64748b;
        font-size: 0.85rem;
    }

    /* Footer: Price + Actions */
    .car-footer {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    @media (min-width: 768px) {
        .car-footer {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    /* Action Row */
    .car-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
    }

    .btn-book {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.2s ease;
        border: none;
        flex: 1;
        text-align: center;
    }

    .btn-book:hover {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: #ffffff;
    }

    .btn-book:disabled,
    .btn-book.disabled {
        background: #cbd5e1;
        cursor: not-allowed;
    }

    .btn-specs {
        background: transparent;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 10px 14px;
        border-radius: 8px;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .btn-specs:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #cbd5e1;
    }

    /* Hidden class for filtering */
    .car-hidden {
        display: none !important;
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 768px) {
        .dashboard-row {
            flex-direction: column;
        }

        .sidebar-column {
            width: 100%;
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .content-column {
            height: 60vh;
        }
    }
</style>

<!-- Full Width Fleet Banner -->
<section class="fleet-banner">
    <div class="container text-center">
        <p class="fleet-eyebrow">Unveil the Engineering</p>
        <h1 class="fleet-title">THE <span class="text-red">GARAGE</span></h1>
    </div>
</section>

<!-- Main Content - Dashboard Layout -->
<section class="platinum-studio-wrapper">
    <div class="container-fluid px-4">
        <div class="dashboard-row">

            <!-- Filter Sidebar (25% Width) -->
            <div class="sidebar-column">
                <div class="filter-card">
                    <div class="filter-header">
                        <h5>Refine Search</h5>
                    </div>
                    <div class="filter-accordion">
                        <div class="filter-accordion-header" onclick="toggleAccordion(this)">
                            <span class="filter-accordion-title">Vehicle Class</span>
                            <i class="fas fa-plus filter-accordion-toggle"></i>
                        </div>
                        <div class="filter-accordion-content">
                            <ul class="filter-list">
                                <li class="filter-list-item active" data-filter="all" onclick="filterFleet('all', this)">
                                    <i class="fas fa-th-large me-2"></i> All Vehicles
                                </li>
                                <?php foreach ($categories as $category): ?>
                                    <li class="filter-list-item" data-filter="<?= h($category->name) ?>" onclick="filterFleet('<?= h($category->name) ?>', this)">
                                        <?= h($category->name) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Availability Filter -->
                    <div class="filter-accordion" style="margin-top: 16px; border-top: 1px solid #e5e7eb; padding-top: 16px;">
                        <div class="filter-accordion-header" onclick="toggleAccordion(this)">
                            <span class="filter-accordion-title">Availability</span>
                            <i class="fas fa-plus filter-accordion-toggle"></i>
                        </div>
                        <div class="filter-accordion-content">
                            <ul class="filter-list">
                                <li class="filter-list-item active" onclick="filterAvailability('all', this)">
                                    All Cars
                                </li>
                                <li class="filter-list-item" onclick="filterAvailability('available', this)">
                                    Available
                                </li>
                                <li class="filter-list-item" onclick="filterAvailability('maintenance', this)">
                                    Maintenance
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fleet Grid - 2 Column Responsive -->
            <div class="content-column">
                <!-- Utility Control Bar -->
                <div class="utility-bar">
                    <div class="utility-bar-left">
                        Showing <span class="count"><?= count($cars) ?></span> Premium Vehicles
                    </div>
                    <div class="utility-bar-right">
                        Sort by: Price (Low to High) <i class="fas fa-chevron-down"></i>
                    </div>
                </div>

                <div class="car-list">
                    <?php foreach ($cars as $car): ?>
                        <div class="car-item" data-category="<?= h($car->category ? $car->category->name : 'Uncategorized') ?>" data-availability="<?= h($car->availability) ?>">
                            <?php
                            // Get color from category (single source of truth)
                            $themeColor = h($car->category->badge_color ?? '#0f172a');
                            ?>
                            <div class="car-card" style="--car-theme: <?= $themeColor ?>;">

                                <!-- Car Image - 40% Width -->
                                <div class="car-image-container">
                                    <?php if ($car->image): ?>
                                        <?= $this->Html->image($car->image, ['class' => 'car-image', 'alt' => $car->car_model]) ?>
                                    <?php else: ?>
                                        <div class="car-image d-flex align-items-center justify-content-center bg-secondary" style="height:100%;">
                                            <i class="fas fa-car fa-3x text-white opacity-50"></i>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Availability Badge -->
                                    <?php if ($car->availability === 'maintenance'): ?>
                                        <span class="availability-badge badge-maintenance">Maintenance</span>
                                    <?php else: ?>
                                        <span class="availability-badge badge-available">Available</span>
                                    <?php endif; ?>

                                    <!-- Special Badges -->
                                    <?php if ($car->price_per_day >= 300): ?>
                                        <span class="special-badge badge-hot">Premium</span>
                                    <?php elseif ($car->id % 3 === 0): ?>
                                        <span class="special-badge badge-top-rated">Top Rated</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Car Details - 60% Width -->
                                <div class="car-details">
                                    <!-- Header: Name + Reviews -->
                                    <div class="car-header">
                                        <h3 class="car-name"><?= h($car->brand . ' ' . $car->car_model) ?></h3>
                                        <div class="car-reviews">
                                            <?php
                                            // Calculate average rating from reviews
                                            $reviewCount = count($car->reviews ?? []);
                                            $avgRating = 0;
                                            if ($reviewCount > 0) {
                                                $totalRating = array_sum(array_column($car->reviews, 'rating'));
                                                $avgRating = $totalRating / $reviewCount;
                                            }
                                            ?>
                                            <span class="stars">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($avgRating >= $i): ?>
                                                        <i class="fas fa-star"></i>
                                                    <?php elseif ($avgRating >= $i - 0.5): ?>
                                                        <i class="fas fa-star-half-alt"></i>
                                                    <?php else: ?>
                                                        <i class="far fa-star"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </span>
                                            <span class="count">(<?= $reviewCount ?> reviews)</span>
                                        </div>
                                    </div>

                                    <!-- Specs Row -->
                                    <div class="car-specs">
                                        <div class="spec-item">
                                            <i class="fas fa-cogs"></i>
                                            <span><?= h($car->transmission ?: 'Auto') ?></span>
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-user-friends"></i>
                                            <span><?= h($car->seats ?: '5') ?> Seats</span>
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-gas-pump"></i>
                                            <span><?= h($car->fuel_type ?: 'Petrol') ?></span>
                                        </div>
                                    </div>

                                    <!-- Footer: Price + Actions -->
                                    <div class="car-footer">
                                        <div class="car-price">
                                            RM <?= number_format($car->price_per_day, 2) ?>
                                            <small>/ day</small>
                                        </div>
                                        <div class="car-actions">
                                            <?php if ($car->availability !== 'maintenance'): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'add', $car->id]) ?>" class="btn-book">
                                                    Book Now
                                                </a>
                                            <?php else: ?>
                                                <button class="btn-book disabled" disabled>
                                                    Maintenance
                                                </button>
                                            <?php endif; ?>
                                            <button type="button" class="btn-specs" onclick="showCarModal(<?= $car->id ?>)">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium Spec Sheet Modal -->
<div id="carModal" class="spec-modal" onclick="closeModalOutside(event)">
    <div class="spec-modal-content">
        <!-- Close Button -->
        <button class="spec-modal-close" onclick="closeCarModal()">
            <i class="fas fa-times"></i>
        </button>

        <!-- Modal Body: 50/50 Split -->
        <div class="spec-modal-body">
            <!-- Left: Full-Height Image -->
            <div class="spec-modal-image" id="modalImage"></div>

            <!-- Right: Details -->
            <div class="spec-modal-details">
                <!-- Header -->
                <div class="spec-header">
                    <h2 class="spec-title" id="modalTitle">Car Name</h2>
                    <div class="spec-reviews">
                        <span class="stars" id="modalStars"></span>
                        <span class="count" id="modalReviewCount">(0 reviews)</span>
                    </div>
                    <!-- Badges -->
                    <div class="spec-badges" id="modalBadges">
                        <span class="spec-badge" id="modalBadge">Category</span>
                    </div>
                </div>

                <!-- 2x2 Specs Grid -->
                <div class="spec-grid">
                    <div class="spec-card">
                        <div class="spec-label">ENGINE</div>
                        <div class="spec-value" id="modalEngine">1.3L</div>
                    </div>
                    <div class="spec-card">
                        <div class="spec-label">0-100 KM/H</div>
                        <div class="spec-value" id="modalZeroSixty">11s</div>
                    </div>
                    <div class="spec-card">
                        <div class="spec-label">SEATS</div>
                        <div class="spec-value" id="modalSeats">4</div>
                    </div>
                    <div class="spec-card">
                        <div class="spec-label">YEAR</div>
                        <div class="spec-value" id="modalYear">2020</div>
                    </div>
                </div>

                <!-- Footer: Price + Actions -->
                <div class="spec-footer">
                    <div class="spec-price">
                        <span class="price-amount" id="modalPrice">RM 120.00</span>
                        <span class="price-unit">/ day</span>
                    </div>
                    <a href="#" id="modalBookBtn" class="spec-book-btn">
                        Book This Car
                    </a>
                    <a href="#" id="modalReviewBtn" class="spec-review-link">
                        Read Full Reviews →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ========================================
       PREMIUM SPEC SHEET MODAL
       ======================================== */
    .spec-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(10px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .spec-modal.show {
        display: flex;
    }

    .spec-modal-content {
        background: #ffffff;
        border-radius: 24px;
        max-width: 960px;
        width: 100%;
        max-height: 90vh;
        overflow: hidden;
        position: relative;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
    }

    .spec-modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 50%;
        cursor: pointer;
        color: #64748b;
        font-size: 1.2rem;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .spec-modal-close:hover {
        background: #ffffff;
        color: #ef4444;
        transform: scale(1.1);
    }

    /* Modal Body: 50/50 Split */
    .spec-modal-body {
        display: flex;
        flex-direction: column;
        min-height: 500px;
    }

    @media (min-width: 768px) {
        .spec-modal-body {
            flex-direction: row;
        }
    }

    /* Left: Full-Height Image */
    .spec-modal-image {
        width: 100%;
        height: 280px;
        background-size: cover;
        background-position: center;
        background-color: #1e293b;
    }

    @media (min-width: 768px) {
        .spec-modal-image {
            width: 50%;
            height: auto;
            min-height: 500px;
        }
    }

    /* Right: Details */
    .spec-modal-details {
        width: 100%;
        padding: 32px;
        display: flex;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
    }

    @media (min-width: 768px) {
        .spec-modal-details {
            width: 50%;
            padding: 40px;
        }
    }

    /* Header */
    .spec-header {
        margin-bottom: 24px;
    }

    .spec-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        color: #0f172a;
        margin: 0 0 8px;
    }

    .spec-reviews {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .spec-reviews .stars {
        color: #f59e0b;
        font-size: 0.9rem;
    }

    .spec-reviews .count {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: #64748b;
    }

    .spec-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .spec-badge {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 6px 12px;
        border-radius: 20px;
    }

    /* 2x2 Specs Grid */
    .spec-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 24px;
    }

    .spec-card {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
    }

    .spec-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
        margin-bottom: 4px;
    }

    .spec-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
    }

    /* Footer: Price + Actions */
    .spec-footer {
        margin-top: auto;
    }

    .spec-price {
        margin-bottom: 16px;
    }

    .price-amount {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 2.5rem;
        color: #1e3a5f;
    }

    .price-unit {
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        font-size: 1rem;
        color: #94a3b8;
    }

    .spec-book-btn {
        display: block;
        width: 100%;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        text-align: center;
        text-decoration: none;
        padding: 18px 24px;
        border-radius: 14px;
        transition: all 0.3s ease;
    }

    .spec-book-btn:hover {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.3);
    }

    .spec-review-link {
        display: block;
        text-align: center;
        margin-top: 16px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .spec-review-link:hover {
        color: #0f172a;
    }
</style>

<!-- Cars Data for Modal -->
<script>
    const carsData = <?= json_encode(array_map(function ($car) {
                            // Calculate average rating
                            $reviewCount = count($car->reviews ?? []);
                            $avgRating = 0;
                            if ($reviewCount > 0) {
                                $totalRating = array_sum(array_column($car->reviews, 'rating'));
                                $avgRating = round($totalRating / $reviewCount, 1);
                            }
                            return [
                                'id' => $car->id,
                                'brand' => $car->brand,
                                'car_model' => $car->car_model,
                                'price_per_day' => $car->price_per_day,
                                'image' => $car->image,
                                'engine' => $car->engine,
                                'zero_to_sixty' => $car->zero_to_sixty,
                                'transmission' => $car->transmission,
                                'seats' => $car->seats,
                                'year' => $car->year,
                                'badge_color' => $car->category ? $car->category->badge_color : '#0f172a',
                                'category' => $car->category ? $car->category->name : 'Car',
                                'availability' => $car->availability,
                                'avgRating' => $avgRating,
                                'reviewCount' => $reviewCount
                            ];
                        }, $cars)) ?>;

    const imageBasePath = '<?= $this->Url->image('') ?>';
    const bookingUrl = '<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'add']) ?>';
    const reviewsBaseUrl = '<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'carReviews']) ?>';

    function showCarModal(carId) {
        const car = carsData.find(c => c.id === carId);
        if (!car) return;

        document.getElementById('modalTitle').textContent = car.brand + ' ' + car.car_model;
        document.getElementById('modalPrice').textContent = 'RM ' + parseFloat(car.price_per_day).toFixed(2);
        document.getElementById('modalEngine').textContent = car.engine || 'N/A';
        document.getElementById('modalZeroSixty').textContent = car.zero_to_sixty || 'N/A';
        document.getElementById('modalSeats').textContent = car.seats || 'N/A';
        document.getElementById('modalYear').textContent = car.year || 'N/A';

        // Render dynamic stars
        const starsContainer = document.getElementById('modalStars');
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            if (car.avgRating >= i) {
                starsHtml += '<i class="fas fa-star"></i>';
            } else if (car.avgRating >= i - 0.5) {
                starsHtml += '<i class="fas fa-star-half-alt"></i>';
            } else {
                starsHtml += '<i class="far fa-star"></i>';
            }
        }
        starsContainer.innerHTML = starsHtml;
        document.getElementById('modalReviewCount').textContent = '(' + car.reviewCount + ' reviews)';

        const badge = document.getElementById('modalBadge');
        badge.textContent = car.category;

        const imageDiv = document.getElementById('modalImage');
        if (car.image) {
            imageDiv.style.backgroundImage = 'url(' + imageBasePath + car.image + ')';
        } else {
            imageDiv.style.backgroundImage = 'none';
        }

        const bookBtn = document.getElementById('modalBookBtn');
        if (car.availability === 'available') {
            bookBtn.href = bookingUrl + '/' + carId;
            bookBtn.classList.remove('disabled');
            bookBtn.textContent = 'Book This Car';
        } else {
            bookBtn.href = '#';
            bookBtn.classList.add('disabled');
            bookBtn.textContent = 'Under Maintenance';
        }

        document.getElementById('modalReviewBtn').href = reviewsBaseUrl + '/' + carId;
        document.getElementById('carModal').classList.add('show');
    }

    function closeCarModal() {
        document.getElementById('carModal').classList.remove('show');
    }

    function closeModalOutside(event) {
        if (event.target.id === 'carModal') {
            closeCarModal();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeCarModal();
    });
</script>

<script>
    // Toggle Accordion
    function toggleAccordion(header) {
        var content = header.nextElementSibling;
        var icon = header.querySelector('.filter-accordion-toggle');

        content.classList.toggle('expanded');

        if (content.classList.contains('expanded')) {
            icon.classList.remove('fa-plus');
            icon.classList.add('fa-minus');
        } else {
            icon.classList.remove('fa-minus');
            icon.classList.add('fa-plus');
        }
    }

    // Filter Fleet by Category
    function filterFleet(category, clickedItem) {
        var cards = document.querySelectorAll('.car-item');

        cards.forEach(function(card) {
            if (category === 'all') {
                card.classList.remove('car-hidden');
            } else {
                if (card.dataset.category === category) {
                    card.classList.remove('car-hidden');
                } else {
                    card.classList.add('car-hidden');
                }
            }
        });

        // Update active state
        var items = clickedItem.parentElement.querySelectorAll('.filter-list-item');
        items.forEach(function(item) {
            item.classList.remove('active');
        });
        clickedItem.classList.add('active');
    }

    // Filter by Availability
    function filterAvailability(status, clickedItem) {
        var cards = document.querySelectorAll('.car-item');

        cards.forEach(function(card) {
            if (status === 'all') {
                card.classList.remove('car-hidden');
            } else {
                if (card.dataset.availability === status) {
                    card.classList.remove('car-hidden');
                } else {
                    card.classList.add('car-hidden');
                }
            }
        });

        // Update active state
        var items = clickedItem.parentElement.querySelectorAll('.filter-list-item');
        items.forEach(function(item) {
            item.classList.remove('active');
        });
        clickedItem.classList.add('active');
    }
</script>