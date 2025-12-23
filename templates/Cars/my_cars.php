<?php

/**
 * Rentify Premium Fleet Catalog - 3D Flip Edition (Full 9 Cars)
 */
$this->assign('title', 'The Garage');
?>

<style>
    /* Google Fonts - Montserrat */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap');

    /* ========================================
   3D FLIP CARD CATALOG STYLES
   ======================================== */

    /* Apply Montserrat to entire page */
    .catalog-hero,
    .filter-card,
    .flip-card {
        font-family: 'Montserrat', sans-serif;
    }

    /* Hero Section - Transparent Ferrari Cutout */
    .catalog-hero {
        /* Deep dark background */
        background-color: #0d1117;
        /* Transparent Ferrari PNG on top */
        background-image: url('<?= $this->Url->image('ferrari-background.png') ?>');
        background-size: 80%;
        background-position: center bottom;
        background-repeat: no-repeat;
        /* More height to show the car */
        padding: 100px 0 180px;
        position: relative;
        /* Curved professional edges */
        border-radius: 30px;
        overflow: hidden;
        /* Clip content to curved corners */
        margin-bottom: 20px;
        /* Space before next section */
    }

    /* Subtle gradient for depth (optional) */
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

    /* ========================================
       CORPORATE FILTER SIDEBAR
       ======================================== */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
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

    .filter-list-item i {
        width: 24px;
        text-align: center;
        margin-right: 12px;
        font-size: 0.9rem;
        color: #9ca3af;
    }

    .filter-list-item.active i {
        color: #3b82f6;
    }

    /* 3D Flip Card */
    .flip-card {
        background-color: transparent;
        height: 350px;
        perspective: 1000px;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-style: preserve-3d;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border-radius: 24px;
        overflow: hidden;
    }

    /* Front Styling */
    .flip-card-front {
        background-color: #1e293b;
        /* Dark fallback if image fails */
        background-size: cover;
        background-position: center;
    }

    .front-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 20px;
        /* Premium Glassmorphism */
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        /* Glass Edge */
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        /* Inherit card's rounded corners at bottom */
        border-radius: 0 0 24px 24px;
        text-align: left;
        /* Ensure text is readable */
        color: white;
    }

    .price-tag {
        color: #3b82f6;
        font-weight: 800;
        font-size: 1.2rem;
        margin-top: 5px;
    }

    .text-shadow {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* Back Styling - Glassmorphism (Lighter) */
    .flip-card-back {
        /* Lighter semi-transparent background */
        background: rgba(30, 41, 59, 0.85) !important;

        /* The Glass Blur Effect */
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);

        /* Border to simulate glass edge */
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);

        /* Text & Orientation */
        color: white;
        transform: rotateY(180deg);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .specs-grid {
        display: flex;
        gap: 20px;
        justify-content: center;
        width: 100%;
    }

    .spec-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 0.9rem;
        color: #cbd5e1;
    }

    .spec-item i {
        font-size: 1.5rem;
        margin-bottom: 8px;
    }

    /* Hidden class for filtering */
    .car-hidden {
        display: none !important;
    }
</style>

<!-- Hero Section -->
<section class="catalog-hero">
    <div class="container text-center position-relative" style="z-index: 1;">
        <h1 class="display-4 mb-2" style="font-family: 'Montserrat', sans-serif; font-weight: 800; text-transform: uppercase; letter-spacing: 3px; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">The <span style="color: #ef4444;">Garage</span></h1>
        <p class="lead" style="font-family: 'Montserrat', sans-serif; font-weight: 400; letter-spacing: 1px; color: rgba(255,255,255,0.85); text-shadow: 0 2px 8px rgba(0,0,0,0.7);">Unveil the Engineering.</p>
    </div>
</section>

<!-- Main Content - FULL WIDTH -->
<section class="py-5" style="background-color: #f3f4f6; background-image: radial-gradient(#d1d5db 1px, transparent 1px); background-size: 20px 20px;">
    <div class="container-fluid px-3">
        <div class="row">
            <!-- Filter Sidebar - Corporate Accordion -->
            <div class="col-lg-2 mb-4">
                <div class="sticky-top" style="top: 100px; z-index: 10;">
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
                                        <i class="fas fa-th-large"></i> All Vehicles
                                    </li>
                                    <?php foreach ($categories as $category): ?>
                                        <li class="filter-list-item" data-filter="<?= h($category->name) ?>" onclick="filterFleet('<?= h($category->name) ?>', this)">
                                            <?= h($category->name) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fleet Grid - 3 Cards Per Row -->
            <div class="col-lg-10">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="fleetGrid">


                    <?php foreach ($cars as $car): ?>
                        <div class="col car-item" data-category="<?= h($car->category ? $car->category->name : 'Uncategorized') ?>">
                            <div class="flip-card">
                                <div class="flip-card-inner">

                                    <!-- FRONT: Image + Name + Price -->
                                    <div class="flip-card-front shadow-sm">
                                        <?php if ($car->image): ?>
                                            <?= $this->Html->image($car->image, ['class' => 'w-100 h-100 object-fit-cover', 'alt' => $car->car_model]) ?>
                                        <?php else: ?>
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary">
                                                <i class="fas fa-car fa-4x text-white opacity-50"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="front-overlay">
                                            <span class="badge rounded-pill mb-2" style="background: <?= h($car->badge_color ?: '#3b82f6') ?>"><?= h($car->category ? $car->category->name : 'Car') ?></span>
                                            <h4 class="text-white fw-bold mb-0 text-shadow"><?= h($car->brand . ' ' . $car->car_model) ?></h4>
                                            <div class="price-tag">$<?= h($car->price_per_day) ?> <small>/ day</small></div>
                                        </div>
                                    </div>

                                    <!-- BACK: Specs + Buttons -->
                                    <div class="flip-card-back shadow-lg">
                                        <h4 class="fw-bold mb-4 text-white"><?= h($car->brand . ' ' . $car->car_model) ?></h4>

                                        <!-- Specs Grid -->
                                        <div class="specs-grid mb-4">
                                            <div class="spec-item">
                                                <i class="fas fa-tachometer-alt text-primary"></i>
                                                <span><?= h($car->engine ?: 'N/A') ?></span>
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-stopwatch text-primary"></i>
                                                <span><?= h($car->zero_to_sixty ?: 'N/A') ?></span>
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-cogs text-primary"></i>
                                                <span><?= h($car->transmission ?: 'Auto') ?></span>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="d-grid gap-3 w-100 px-4">
                                            <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'add']) ?>" class="btn btn-primary rounded-pill fw-bold">Book Now</a>
                                            <button type="button" class="btn btn-outline-light rounded-pill btn-sm" onclick="showCarModal(<?= $car->id ?>)">Full Specs <i class="fas fa-info-circle ms-1"></i></button>
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

<!-- Car Details Modal -->
<div id="carModal" class="car-modal" onclick="closeModalOutside(event)">
    <div class="car-modal-content">
        <button class="car-modal-close" onclick="closeCarModal()">&times;</button>
        <div class="car-modal-body">
            <div class="car-modal-image" id="modalImage"></div>
            <div class="car-modal-details">
                <span class="badge rounded-pill mb-2" id="modalBadge">Category</span>
                <h2 class="car-modal-title" id="modalTitle">Car Name</h2>
                <div class="car-modal-price" id="modalPrice">$0 / day</div>

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
    /* Car Details Modal Styles */
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
        background: rgba(255, 255, 255, 0.95);
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
    }

    .car-modal-title {
        font-family: 'Montserrat', sans-serif;
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
    const carsData = <?= json_encode(array_map(function ($car) {
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
                                'category' => $car->category ? $car->category->name : 'Car'
                            ];
                        }, $cars->toArray())) ?>;

    const imageBasePath = '<?= $this->Url->image('') ?>';
    const bookingUrl = '<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'add']) ?>';
    const reviewsBaseUrl = '<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'carReviews']) ?>';

    function showCarModal(carId) {
        const car = carsData.find(c => c.id === carId);
        if (!car) return;

        document.getElementById('modalTitle').textContent = car.brand + ' ' + car.car_model;
        document.getElementById('modalPrice').textContent = '$' + car.price_per_day + ' / day';
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

        document.getElementById('modalBookBtn').href = bookingUrl;
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

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeCarModal();
    });
</script>

<script>
    // Toggle Accordion (expand/collapse with +/- icon)
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

        var items = document.querySelectorAll('.filter-list-item');
        items.forEach(function(item) {
            item.classList.remove('active');
        });

        clickedItem.classList.add('active');
    }
</script>