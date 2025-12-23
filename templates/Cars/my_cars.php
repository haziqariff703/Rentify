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
    
    .filter-header i { color: #6b7280; font-size: 1rem; }
    .filter-header h5 { font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 0; }
    
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
    
    .filter-accordion-toggle { font-size: 0.8rem; color: #9ca3af; }
    
    .filter-accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    
    .filter-accordion-content.expanded { max-height: 400px; }
    
    .filter-list { list-style: none; padding: 0; margin: 0; }
    
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
    
    .filter-list-item:hover { background: #f9fafb; color: #111827; }
    .filter-list-item.active { background: #eff6ff; color: #3b82f6; font-weight: 500; }
    .filter-list-item i { width: 24px; text-align: center; margin-right: 12px; font-size: 0.9rem; color: #9ca3af; }
    .filter-list-item.active i { color: #3b82f6; }

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
                                    <li class="filter-list-item" data-filter="Supercar" onclick="filterFleet('Supercar', this)">
                                        Supercars
                                    </li>
                                    <li class="filter-list-item" data-filter="SUV" onclick="filterFleet('SUV', this)">
                                        Luxury SUV
                                    </li>
                                    <li class="filter-list-item" data-filter="Sports" onclick="filterFleet('Sports', this)">
                                        Sports & GT
                                    </li>
                                    <li class="filter-list-item" data-filter="TheKing" onclick="filterFleet('TheKing', this)">
                                        The King
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fleet Grid - 3 Cards Per Row -->
            <div class="col-lg-10">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="fleetGrid">

                    <?php
                    // FULL DATABASE WITH REAL OFFICIAL LINKS
                    $fleet = [
                        // THE ORIGINALS
                        ['name' => 'Chevrolet Camaro', 'price' => 120, 'img' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'type' => 'Sports', 'category' => 'Sports', 'engine' => '2.0L Turbo', 'zero60' => '5.4s', 'color' => '#f97316', 'url' => 'https://www.chevrolet.com/performance/camaro'],
                        ['name' => 'BMW 5 Series', 'price' => 150, 'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'type' => 'Luxury', 'category' => 'Sports', 'engine' => '2.0L Diesel', 'zero60' => '7.2s', 'color' => '#3b82f6', 'url' => 'https://www.bmw.com/en/all-models/5-series.html'],
                        ['name' => 'Audi Q7', 'price' => 180, 'img' => 'audi-q7.jpg', 'type' => 'SUV', 'category' => 'SUV', 'engine' => '3.0L V6', 'zero60' => '5.9s', 'color' => '#0ea5e9', 'url' => 'https://www.audi.com/en/models/q7.html'],

                        // THE SUPERCARS
                        ['name' => 'Lamborghini Huracán', 'price' => 1200, 'img' => 'lambo-huracan.jpg', 'type' => 'Supercar', 'category' => 'Supercar', 'engine' => '5.2L V10', 'zero60' => '2.9s', 'color' => '#ef4444', 'url' => 'https://www.lamborghini.com/en-en/models/huracan'],
                        ['name' => 'Ferrari F8 Tributo', 'price' => 1350, 'img' => 'ferrari-f8.jpg', 'type' => 'Exotic', 'category' => 'Supercar', 'engine' => '3.9L V8 TT', 'zero60' => '2.9s', 'color' => '#dc2626', 'url' => 'https://www.ferrari.com/en-EN/auto/f8-tributo'],
                        ['name' => 'McLaren 720S', 'price' => 1400, 'img' => 'mclaren-720s.jpg', 'type' => 'Hyper', 'category' => 'Supercar', 'engine' => '4.0L V8 TT', 'zero60' => '2.8s', 'color' => '#f59e0b', 'url' => 'https://cars.mclaren.com/en/super-series/720s'],

                        // THE SPECIALS
                        ['name' => 'Porsche 911 GT3 RS', 'price' => 950, 'img' => 'porsche-gt3.jpg', 'type' => 'Track', 'category' => 'Sports', 'engine' => '4.0L Flat-6', 'zero60' => '3.0s', 'color' => '#64748b', 'url' => 'https://www.porsche.com/international/models/911/911-gt3-rs/'],
                        ['name' => 'Aston Martin DBS', 'price' => 1100, 'img' => 'aston-dbs.jpg', 'type' => 'GT', 'category' => 'Sports', 'engine' => '5.2L V12', 'zero60' => '3.2s', 'color' => '#0d9488', 'url' => 'https://www.astonmartin.com/en/models/dbs'],

                        // THE KING
                        ['name' => 'Perodua Myvi 2025', 'price' => 40, 'img' => 'myvi.jpg', 'type' => 'The King', 'category' => 'TheKing', 'engine' => '1.5L Inline-4', 'zero60' => 'Eventually', 'color' => '#fbbf24', 'url' => 'https://www.perodua.com.my/our-models/myvi.html']
                    ];
                    ?>

                    <?php foreach ($fleet as $car): ?>
                        <div class="col car-item" data-category="<?= $car['category'] ?>">
                            <div class="flip-card">
                                <div class="flip-card-inner">

                                    <!-- FRONT: Image + Name + Price -->
                                    <div class="flip-card-front shadow-sm">
                                        <?php
                                        // Handle both external URLs and local images
                                        if (strpos($car['img'], 'http') === 0): ?>
                                            <img src="<?= $car['img'] ?>" class="w-100 h-100 object-fit-cover" alt="<?= $car['name'] ?>">
                                        <?php else: ?>
                                            <?= $this->Html->image($car['img'], ['class' => 'w-100 h-100 object-fit-cover', 'alt' => $car['name']]) ?>
                                        <?php endif; ?>
                                        <div class="front-overlay">
                                            <span class="badge rounded-pill mb-2" style="background: <?= $car['color'] ?>"><?= $car['type'] ?></span>
                                            <h4 class="text-white fw-bold mb-0 text-shadow"><?= $car['name'] ?></h4>
                                            <div class="price-tag">$<?= $car['price'] ?> <small>/ day</small></div>
                                        </div>
                                    </div>

                                    <!-- BACK: Specs + Buttons -->
                                    <div class="flip-card-back shadow-lg">
                                        <h4 class="fw-bold mb-4 text-white"><?= $car['name'] ?></h4>

                                        <!-- Specs Grid -->
                                        <div class="specs-grid mb-4">
                                            <div class="spec-item">
                                                <i class="fas fa-tachometer-alt text-primary"></i>
                                                <span><?= $car['engine'] ?></span>
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-stopwatch text-primary"></i>
                                                <span><?= $car['zero60'] ?></span>
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-cogs text-primary"></i>
                                                <span>Auto</span>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="d-grid gap-3 w-100 px-4">
                                            <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'add']) ?>" class="btn btn-primary rounded-pill fw-bold">Book Now</a>
                                            <a href="<?= $car['url'] ?>" target="_blank" class="btn btn-outline-light rounded-pill btn-sm">Full Specs <i class="fas fa-external-link-alt ms-1" style="font-size: 0.8em;"></i></a>
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