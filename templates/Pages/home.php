<?php
/**
 * Rentify Home Page - Bootstrap 5 Version
 */
$this->setLayout('home');
$this->assign('title', 'Welcome to Rentify');
?>

<!-- Hero Section with Video Background -->
<section class="hero-section position-relative d-flex align-items-center justify-content-center overflow-hidden" style="height: 100vh; min-height: 600px;">
    <!-- Background Video -->
    <div class="position-absolute top-0 start-0 w-100 h-100 z-0">
        <video autoplay muted loop playsinline class="w-100 h-100" style="object-fit: cover;">
            <source src="<?= $this->Url->webroot('video/7727416-hd_1920_1080_25fps.mp4') ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <!-- Navy Midnight Overlay -->
        <div class="video-overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(15, 23, 42, 0.6);"></div>
    </div>

    <!-- Hero Content -->
    <div class="position-relative z-10 text-center container d-flex flex-column justify-content-center align-items-center" style="max-width: 900px;">
        <h1 class="hero-headline animate-fade-in-up">
            Luxury Performance.<br><span class="hero-headline-accent">Everyday Value.</span>
        </h1>
        <p class="hero-subheadline animate-fade-in-up" style="animation-delay: 0.2s;">
            Premium Fleets for Your Every Destination.
        </p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center align-items-center animate-fade-in-up" style="animation-delay: 0.4s;">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="hero-btn-primary">
                <i class="bi bi-compass me-2"></i>Explore Now
            </a>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="hero-btn-outline">
                <i class="bi bi-person-plus me-2"></i>Join Now
            </a>
        </div>
    </div>

    <!-- Scroll Down Indicator -->
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 animate-bounce">
        <a href="#about" class="text-white text-decoration-none">
            <i class="bi bi-chevron-double-down fs-3"></i>
        </a>
    </div>
</section>

<!-- About Us Section - Executive Premium Design -->
<section id="about" class="about-executive-section">
    <div class="container">
        <div class="row gy-5 align-items-center">
            <!-- Left Column - Image -->
            <div class="col-lg-6">
                <div class="about-image-wrapper">
                    <?= $this->Html->image('about-us-hero.jpg', [
                        'alt' => 'Rentify Premium Fleet',
                        'class' => 'about-hero-image'
                    ]) ?>
                </div>
            </div>
            
            <!-- Right Column - Content -->
            <div class="col-lg-6">
                <div class="about-executive-content">
                    <!-- Eyebrow Label -->
                    <span class="about-eyebrow">Driven by Excellence</span>
                    
                    <!-- Main Title - Playfair Display -->
                    <h2 class="about-executive-title">Redefining Your Road Trip Experience</h2>
                    
                    <!-- Professional Paragraphs -->
                    <p class="about-executive-text">
                        At Rentify, we are committed to delivering an unparalleled driving experience. Our curated fleet 
                        features iconic vehicles like the powerful <strong>Chevrolet Camaro</strong>, the sophisticated 
                        <strong>BMW 5 Series</strong>, and the versatile <strong>Audi Q7</strong> — each meticulously 
                        maintained to ensure your journey is nothing short of exceptional.
                    </p>
                    <p class="about-executive-text">
                        Whether you're embarking on a business trip, a family vacation, or a weekend adventure, 
                        we provide the perfect blend of luxury, comfort, and performance. Our dedicated 
                        <strong>24-hour concierge and support service</strong> ensures complete peace of mind, 
                        day or night. Our dedication to quality and customer satisfaction sets us apart as your 
                        trusted partner on the road.
                    </p>
                    
                    <!-- Executive Trust Icons -->
                    <div class="executive-trust-row">
                        <div class="executive-trust-item">
                            <div class="executive-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <span class="executive-icon-label">Verified Fleet</span>
                        </div>
                        <div class="executive-trust-item">
                            <div class="executive-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <span class="executive-icon-label">24/7 Support</span>
                        </div>
                        <div class="executive-trust-item">
                            <div class="executive-icon">
                                <i class="bi bi-lock"></i>
                            </div>
                            <span class="executive-icon-label">Secure Booking</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Fleet Marquee -->
<section class="py-5 bg-light overflow-hidden">
    <div class="container text-center mb-5">
        <div class="fleet-subtitle">The Rentify Collection</div>
        <h2 class="fleet-title">Our Featured Fleet</h2>
        <p class="fleet-description">From executive sedans to high-performance sports cars, discover a curated selection of world-class vehicles designed for your ultimate driving pleasure.</p>
    </div>
    
    <!-- Marquee Container with Fade Masks -->
    <div class="marquee-container">
        <div class="marquee-track">
            <!-- Card 1: Chevrolet Camaro -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Chevrolet Camaro">
                    <span class="marquee-badge">Sports</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">Chevrolet Camaro</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 2 Seats</span>
                        <span><i class="fas fa-tachometer-alt"></i> Fast</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 120</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 2: BMW 5 Series -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="BMW 5 Series">
                    <span class="marquee-badge">Luxury</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">BMW 5 Series</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 5 Seats</span>
                        <span><i class="fas fa-gas-pump"></i> Diesel</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 150</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 3: Audi Q7 -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <?= $this->Html->image('audi-q7.jpg', ['class' => 'img-fluid object-fit-cover rounded-4', 'style' => 'height: 250px; width: 100%;', 'alt' => 'Audi Q7']) ?>
                    <span class="marquee-badge">SUV</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">Audi Q7</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 7 Seats</span>
                        <span><i class="fas fa-mountain"></i> AWD</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 180</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 4: Ferrari F8 Tributo -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <?= $this->Html->image('ferrari-f8.jpg', ['class' => 'img-fluid', 'alt' => 'Ferrari F8 Tributo']) ?>
                    <span class="marquee-badge">Supercar</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">Ferrari F8 Tributo</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 2 Seats</span>
                        <span><i class="fas fa-tachometer-alt"></i> V8</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 1,200</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 5: Lamborghini Huracán -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <?= $this->Html->image('lambo-huracan.jpg', ['class' => 'img-fluid', 'alt' => 'Lamborghini Huracán']) ?>
                    <span class="marquee-badge">Supercar</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">Lamborghini Huracán</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 2 Seats</span>
                        <span><i class="fas fa-tachometer-alt"></i> V10</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 1,500</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 6: McLaren 720S -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <?= $this->Html->image('mclaren-720s.jpg', ['class' => 'img-fluid', 'alt' => 'McLaren 720S']) ?>
                    <span class="marquee-badge">Supercar</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">McLaren 720S</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 2 Seats</span>
                        <span><i class="fas fa-tachometer-alt"></i> V8</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 1,400</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 7: Porsche 911 GT3 -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <?= $this->Html->image('porsche-gt3.jpg', ['class' => 'img-fluid', 'alt' => 'Porsche 911 GT3']) ?>
                    <span class="marquee-badge">Sports</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">Porsche 911 GT3</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Manual</span>
                        <span><i class="fas fa-user"></i> 2 Seats</span>
                        <span><i class="fas fa-tachometer-alt"></i> Flat-6</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 900</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 8: Aston Martin DBS -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <?= $this->Html->image('aston-dbs.jpg', ['class' => 'img-fluid', 'alt' => 'Aston Martin DBS']) ?>
                    <span class="marquee-badge">Luxury</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">Aston Martin DBS</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 4 Seats</span>
                        <span><i class="fas fa-tachometer-alt"></i> V12</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 800</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 9: Toyota Hilux -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <?= $this->Html->image('hilux.jpg', ['class' => 'img-fluid', 'alt' => 'Toyota Hilux']) ?>
                    <span class="marquee-badge">Truck</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">Toyota Hilux</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Manual</span>
                        <span><i class="fas fa-user"></i> 5 Seats</span>
                        <span><i class="fas fa-mountain"></i> 4WD</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 150</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- DUPLICATES FOR SEAMLESS LOOP -->
            
            <!-- Card 1: Chevrolet Camaro (Duplicate) -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Chevrolet Camaro">
                    <span class="marquee-badge">Sports</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">Chevrolet Camaro</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 2 Seats</span>
                        <span><i class="fas fa-tachometer-alt"></i> Fast</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 120</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 2: BMW 5 Series (Duplicate) -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="BMW 5 Series">
                    <span class="marquee-badge">Luxury</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">BMW 5 Series</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 5 Seats</span>
                        <span><i class="fas fa-gas-pump"></i> Diesel</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 150</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 3: Audi Q7 (Duplicate) -->
            <div class="marquee-card">
                <div class="marquee-card-img">
                    <?= $this->Html->image('audi-q7.jpg', ['class' => 'img-fluid', 'alt' => 'Audi Q7']) ?>
                    <span class="marquee-badge">SUV</span>
                </div>
                <div class="marquee-card-body">
                    <h3 class="marquee-card-title">Audi Q7</h3>
                    <div class="marquee-card-specs">
                        <span><i class="fas fa-cogs"></i> Auto</span>
                        <span><i class="fas fa-user"></i> 7 Seats</span>
                        <span><i class="fas fa-mountain"></i> AWD</span>
                    </div>
                    <div class="marquee-card-footer">
                        <div class="marquee-price"><span class="price">RM 180</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="text-center mt-5 animate-fade-in-up" style="animation-delay: 0.5s;">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg">
                View All Cars <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- How It Works - CORPORATE MINIMALIST WHITE ZIG-ZAG -->
<section class="how-it-works-section">
    <div class="container">
        <!-- Elegant Header -->
        <div class="text-center mb-5 pb-4">
            <div class="how-subtitle">The Executive Process</div>
            <h2 class="how-title">How It Works</h2>
        </div>
        
        <!-- Step 1: Secure Dates - Image LEFT, Text RIGHT -->
        <div class="zigzag-row">
            <div class="zigzag-image">
                <img src="<?= $this->Url->webroot('img/secure_dates.jpg') ?>" alt="Secure Dates">
            </div>
            <div class="zigzag-content">
                <div class="step-label">Step 01</div>
                <h3 class="step-title">Secure Dates</h3>
                <p class="step-text">Select your preferred timeline to view real-time availability.</p>
            </div>
        </div>
        
        <!-- Step 2: Select Vehicle - Image RIGHT, Text LEFT -->
        <div class="zigzag-row zigzag-reverse">
            <div class="zigzag-image">
                <img src="<?= $this->Url->webroot('img/select_vehicle.avif') ?>" alt="Select Vehicle">
            </div>
            <div class="zigzag-content">
                <div class="step-label">Step 02</div>
                <h3 class="step-title">Select Vehicle</h3>
                <p class="step-text">Choose from our curated fleet of performance engineering.</p>
            </div>
        </div>
        
        <!-- Step 3: Take Delivery - Image LEFT, Text RIGHT -->
        <div class="zigzag-row">
            <div class="zigzag-image">
                <img src="<?= $this->Url->webroot('img/take_delivery.jpg') ?>" alt="Take Delivery">
            </div>
            <div class="zigzag-content">
                <div class="step-label">Step 03</div>
                <h3 class="step-title">Take Delivery</h3>
                <p class="step-text">Confirm your reservation and collect your keys. Excellence delivered.</p>
            </div>
        </div>
        
        <!-- CTA Button -->
        <div class="text-center mt-5 pt-4">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="how-cta-btn">
                Explore the Collection
            </a>
        </div>
    </div>
</section>

<style>
/* ========================================
   HOW IT WORKS - CORPORATE MINIMALIST WHITE
   Zig-Zag Layout with Photography
   ======================================== */

/* Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Montserrat:wght@400;500;600;700&display=swap');

/* Section Container - Pure White */
.how-it-works-section {
    background: #ffffff;
    padding: 100px 0;
    position: relative;
}

/* Subtitle */
.how-subtitle {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 400;
    font-style: italic;
    letter-spacing: 3px;
    color: #94a3b8;
    text-transform: uppercase;
    margin-bottom: 12px;
}

/* Main Title - Serif for Elegance */
.how-title {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem;
    font-weight: 700;
    letter-spacing: -1px;
    color: #0f172a;
    margin: 0;
}

/* Zig-Zag Row */
.zigzag-row {
    display: flex;
    align-items: center;
    gap: 60px;
    margin-bottom: 80px;
}

.zigzag-row:last-of-type {
    margin-bottom: 0;
}

/* Reverse for alternating rows */
.zigzag-reverse {
    flex-direction: row-reverse;
}

/* Image Container */
.zigzag-image {
    flex: 1;
    max-width: 50%;
}

.zigzag-image img {
    width: 100%;
    height: 350px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 
        0 4px 6px -1px rgba(0, 0, 0, 0.05),
        0 20px 40px -12px rgba(0, 0, 0, 0.15);
    transition: transform 0.4s ease;
}

.zigzag-row:hover .zigzag-image img {
    transform: scale(1.02);
}

/* Content Container */
.zigzag-content {
    flex: 1;
    max-width: 50%;
    padding: 20px 0;
}

/* Step Label */
.step-label {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #b8860b;
    margin-bottom: 16px;
}

/* Step Title */
.step-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.25rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
}

/* Step Text */
.step-text {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.1rem;
    color: #64748b;
    line-height: 1.8;
    max-width: 400px;
    margin: 0;
}

/* CTA Button */
.how-cta-btn {
    display: inline-block;
    padding: 18px 48px;
    background: #0f172a;
    border: 2px solid #0f172a;
    border-radius: 50px;
    color: #ffffff;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    letter-spacing: 1px;
    text-decoration: none;
    text-transform: uppercase;
    transition: all 0.3s ease;
}

.how-cta-btn:hover {
    background: transparent;
    color: #0f172a;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 991px) {
    .how-it-works-section {
        padding: 60px 0;
    }
    
    .how-title {
        font-size: 2.5rem;
    }
    
    .zigzag-row,
    .zigzag-reverse {
        flex-direction: column;
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .zigzag-image,
    .zigzag-content {
        max-width: 100%;
    }
    
    .zigzag-image img {
        height: 280px;
    }
    
    .step-title {
        font-size: 1.75rem;
    }
    
    .step-text {
        max-width: 100%;
    }
    
    .how-cta-btn {
        padding: 14px 36px;
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .zigzag-image img {
        height: 220px;
    }
    
    .how-title {
        font-size: 2rem;
    }
}
</style>

<!-- Call To Action -->
<section class="py-5 bg-primary position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
    <div class="container position-relative z-1 py-5 text-center" style="max-width: 800px;">
        <h2 class="display-4 fw-bold text-white mb-4 animate-fade-in-up">Ready to Start Your Journey?</h2>
        <p class="lead text-white-50 mb-5 animate-fade-in-up" style="animation-delay: 0.2s;">Join thousands of satisfied customers who trust Rentify for their travel needs. Sign up today and get exclusive offers.</p>
        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="btn btn-light btn-lg rounded-pill px-5 py-3 shadow-lg text-primary fw-bold animate-fade-in-up" style="animation-delay: 0.4s;">
            Create Free Account
        </a>
    </div>
</section>

<style>
    .hover-shadow:hover { box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; transform: translateY(-5px); }
    .transition-all { transition: all 0.3s ease; }
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1); }
    .btn-outline-secondary.hover-primary:hover { background-color: var(--bs-primary); border-color: var(--bs-primary); color: white; }
</style>