<?php
/**
 * Rentify Premium Fleet Catalog - 2-Column Grid Edition
 * Features: Responsive grid, fixed sidebar, uniform cards, no spotlight effect
 */
$this->assign('title', 'The Garage');
?>

<style>
    /* Google Fonts - Montserrat + Playfair Display */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700&display=swap');

    /* ========================================
       DASHBOARD LAYOUT - Fixed Height Container
       ======================================== */
    .platinum-studio-wrapper {
        background-color: #f8fafc;
        background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px);
        background-size: 24px 24px;
        height: 80vh;
        overflow: hidden;
        padding: 30px 0;
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
       2-COLUMN RESPONSIVE GRID
       ======================================== */
    .car-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        padding-bottom: 40px;
    }

    @media (min-width: 768px) {
        .car-grid {
            grid-template-columns: repeat(2, 1fr);
        }
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
       HERO SECTION - FERRARI BANNER
       ======================================== */
    .catalog-hero {
        background-color: #0d1117;
        background-image: url('<?= $this->Url->image('ferrari-background.png') ?>');
        background-size: 80%;
        background-position: center bottom;
        background-repeat: no-repeat;
        padding: 80px 0 140px;
        position: relative;
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 30px;
        margin-top: -3rem;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
        z-index: 10;
    }

    .catalog-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.3) 0%, transparent 50%, rgba(0, 0, 0, 0.5) 100%);
        z-index: 0;
        pointer-events: none;
    }

    .hero-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: white;
        text-shadow: 0 2px 10px rgba(0,0,0,0.8);
    }

    .hero-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-weight: 400;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.85);
        text-shadow: 0 2px 8px rgba(0,0,0,0.7);
    }

    /* ========================================
       FILTER SIDEBAR
       ======================================== */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        font-family: 'Montserrat', sans-serif;
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 15px;
    }

    .filter-header i {
        color: #6b7280;
        font-size: 1rem;
    }

    .filter-header h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .filter-accordion-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        cursor: pointer;
    }

    .filter-accordion-title {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
        margin: 0;
    }

    .filter-accordion-toggle {
        font-size: 0.8rem;
        color: #9ca3af;
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
        padding: 10px 12px;
        margin-bottom: 4px;
        cursor: pointer;
        color: #374151;
        font-size: 0.95rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .filter-list-item:hover {
        background: #f9fafb;
        color: #111827;
    }

    .filter-list-item.active {
        background: #eff6ff;
        color: #3b82f6;
        font-weight: 500;
    }

    /* ========================================
       GRID CAR CARDS - Luxury Physics
       ======================================== */
    .car-item {
        height: 100%;
    }

    .car-card {
        /* Studio Atmosphere - Vignette background */
        background: radial-gradient(circle at center, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
        /* Phantom Borders */
        border: 1px solid #f1f5f9;
        height: 100%;
        /* Hover transition */
        transition: transform 0.3s ease-out, box-shadow 0.3s ease-out, border-color 0.3s ease-out;
    }

    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        /* Phantom border disappears on hover */
        border-color: transparent;
    }

    /* Car Image - 16:9 Aspect Ratio with Inner Shadow */
    .car-image-container {
        width: 100%;
        aspect-ratio: 16 / 9;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
        border-radius: 16px 16px 0 0;
    }

    /* Inner shadow overlay for image blend */
    .car-image-container::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40px;
        background: linear-gradient(to bottom, transparent, rgba(248, 250, 252, 0.5));
        pointer-events: none;
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

    /* Availability Badge - Corner */
    .availability-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 5;
    }

    .badge-available {
        background: rgba(34, 197, 94, 0.95);
        color: white;
    }

    .badge-maintenance {
        background: rgba(239, 68, 68, 0.95);
        color: white;
    }

    /* Special Badges - Top Right */
    .special-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
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

    /* Car Details */
    .car-details {
        flex: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    .car-category {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        width: fit-content;
    }

    .car-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px;
    }

    /* Serif Price Tag - Playfair Display */
    .car-price {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        font-weight: 500;
        color: #0f172a;
        margin-bottom: 12px;
    }

    .car-price small {
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        color: #94a3b8;
        font-size: 0.7rem;
    }

    /* Specs Row */
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
        font-size: 0.75rem;
        color: #64748b;
    }

    .spec-item i {
        color: #94a3b8;
        font-size: 0.8rem;
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

<!-- Hero Section - Ferrari Banner -->
<section class="catalog-hero">
    <div class="container text-center position-relative" style="z-index: 1;">
        <h1 class="display-5 mb-2 hero-title">The <span style="color: #ef4444;">Garage</span></h1>
        <p class="lead hero-subtitle">Unveil the Engineering.</p>
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
                        <i class="fas fa-filter"></i>
                        <h5>Filter</h5>
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
                                    <span class="me-2">📋</span> All Cars
                                </li>
                                <li class="filter-list-item" onclick="filterAvailability('available', this)">
                                    <span class="me-2">🟢</span> Available
                                </li>
                                <li class="filter-list-item" onclick="filterAvailability('maintenance', this)">
                                    <span class="me-2">🔴</span> Maintenance
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

                <div class="car-grid">
                    <?php foreach ($cars as $car): ?>
                        <div class="car-item" data-category="<?= h($car->category ? $car->category->name : 'Uncategorized') ?>" data-availability="<?= h($car->availability) ?>">
                            <div class="car-card">
                                
                                <!-- Car Image -->
                                <div class="car-image-container">
                                    <?php if ($car->image): ?>
                                        <?= $this->Html->image($car->image, ['class' => 'car-image', 'alt' => $car->car_model]) ?>
                                    <?php else: ?>
                                        <div class="car-image d-flex align-items-center justify-content-center bg-secondary">
                                            <i class="fas fa-car fa-3x text-white opacity-50"></i>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Availability Badge -->
                                    <?php if ($car->availability === 'maintenance'): ?>
                                        <span class="availability-badge badge-maintenance">🔴 Maintenance</span>
                                    <?php else: ?>
                                        <span class="availability-badge badge-available">🟢 Available</span>
                                    <?php endif; ?>

                                    <!-- Special Badges -->
                                    <?php if ($car->price_per_day >= 300): ?>
                                        <span class="special-badge badge-hot">🔥 Premium</span>
                                    <?php elseif ($car->id % 3 === 0): ?>
                                        <span class="special-badge badge-top-rated">⭐ Top Rated</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Car Details -->
                                <div class="car-details">
                                    <span class="car-category" style="background: <?= h($car->badge_color ?: '#3b82f6') ?>20; color: <?= h($car->badge_color ?: '#3b82f6') ?>;">
                                        <?= h($car->category ? $car->category->name : 'Car') ?>
                                    </span>
                                    
                                    <h3 class="car-name"><?= h($car->brand . ' ' . $car->car_model) ?></h3>
                                    <div class="car-price">
                                        RM <?= number_format($car->price_per_day, 2) ?>
                                        <small>/ day</small>
                                    </div>

                                    <!-- Specs -->
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

                                    <!-- Actions -->
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
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Car Details Modal -->
<div id="carModal" class="car-modal" onclick="closeModalOutside(event)">
    <div class="car-modal-content">
        <button class="car-modal-close" onclick="closeCarModal()">&times;</button>
        <div class="car-modal-body">
            <div class="car-modal-image" id="modalImage"></div>
            <div class="car-modal-details">
                <span class="badge rounded-pill mb-2" id="modalBadge">Category</span>
                <h2 class="car-modal-title" id="modalTitle">Car Name</h2>
                <div class="car-modal-price" id="modalPrice">RM 0 / day</div>

                <div class="car-modal-specs">
                    <div class="spec-row">
                        <i class="fas fa-tachometer-alt"></i>
                        <span id="modalEngine">Engine</span>
                    </div>
                    <div class="spec-row">
                        <i class="fas fa-stopwatch"></i>
                        <span id="modalZeroSixty">0-60</span>
                    </div>
                    <div class="spec-row">
                        <i class="fas fa-cogs"></i>
                        <span id="modalTransmission">Transmission</span>
                    </div>
                    <div class="spec-row">
                        <i class="fas fa-chair"></i>
                        <span id="modalSeats">Seats</span>
                    </div>
                    <div class="spec-row">
                        <i class="fas fa-calendar"></i>
                        <span id="modalYear">Year</span>
                    </div>
                </div>

                <div class="car-modal-actions">
                    <a href="#" id="modalBookBtn" class="btn btn-primary rounded-pill fw-bold">Book This Car</a>
                    <a href="#" id="modalReviewBtn" class="btn btn-outline-secondary rounded-pill">View Reviews</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modal Styles */
    .car-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .car-modal.show {
        display: flex;
    }

    .car-modal-content {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        max-width: 800px;
        width: 90%;
        max-height: 90vh;
        overflow: hidden;
        position: relative;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .car-modal-close {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 2rem;
        background: none;
        border: none;
        cursor: pointer;
        color: #64748b;
        z-index: 10;
    }

    .car-modal-close:hover {
        color: #ef4444;
    }

    .car-modal-body {
        display: flex;
        flex-direction: column;
    }

    @media (min-width: 768px) {
        .car-modal-body {
            flex-direction: row;
        }
    }

    .car-modal-image {
        flex: 1;
        min-height: 250px;
        background-size: cover;
        background-position: center;
        background-color: #1e293b;
    }

    .car-modal-details {
        flex: 1;
        padding: 30px;
        font-family: 'Montserrat', sans-serif;
    }

    .car-modal-title {
        font-weight: 800;
        font-size: 1.8rem;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .car-modal-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #3b82f6;
        margin-bottom: 20px;
    }

    .car-modal-specs {
        display: grid;
        gap: 12px;
        margin-bottom: 25px;
    }

    .spec-row {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #475569;
    }

    .spec-row i {
        width: 24px;
        color: #3b82f6;
    }

    .car-modal-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    @media (min-width: 768px) {
        .car-modal-actions {
            flex-direction: row;
        }
    }
</style>

<!-- Cars Data for Modal -->
<script>
    const carsData = <?= json_encode(array_map(function($car) {
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
            'badge_color' => $car->badge_color,
            'category' => $car->category ? $car->category->name : 'Car',
            'availability' => $car->availability
        ];
    }, $cars)) ?>;

    const imageBasePath = '<?= $this->Url->image('') ?>';
    const bookingUrl = '<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'add']) ?>';
    const reviewsBaseUrl = '<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'carReviews']) ?>';

    function showCarModal(carId) {
        const car = carsData.find(c => c.id === carId);
        if (!car) return;

        document.getElementById('modalTitle').textContent = car.brand + ' ' + car.car_model;
        document.getElementById('modalPrice').textContent = 'RM ' + parseFloat(car.price_per_day).toFixed(2) + ' / day';
        document.getElementById('modalEngine').textContent = car.engine || 'N/A';
        document.getElementById('modalZeroSixty').textContent = car.zero_to_sixty || 'N/A';
        document.getElementById('modalTransmission').textContent = car.transmission || 'Auto';
        document.getElementById('modalSeats').textContent = (car.seats || 'N/A') + ' Seats';
        document.getElementById('modalYear').textContent = car.year || 'N/A';

        const badge = document.getElementById('modalBadge');
        badge.textContent = car.category;
        badge.style.background = car.badge_color || '#3b82f6';

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