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
        <h1 class="display-2 fw-bold text-white mb-4 animate-fade-in-up">
            Luxury Performance.<br><span class="text-primary">Everyday Value.</span>
        </h1>
        <p class="lead text-light mb-5 mx-auto animate-fade-in-up fs-4" style="animation-delay: 0.2s; max-width: 700px;">
            Premium Fleets for Your Every Destination.
        </p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center align-items-center animate-fade-in-up" style="animation-delay: 0.4s;">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg">
                <i class="bi bi-compass me-2"></i>Explore Now
            </a>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 shadow-lg">
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

<!-- About Us Section - Professional Design -->
<section id="about" class="about-section-custom py-5" style="background-color: #F8FAFC;">
    <div class="container py-5">
        <div class="row gy-5 align-items-center">
            <!-- Left Column - Image -->
            <div class="col-lg-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                <?= $this->Html->image('about-us-hero.jpg', [
                    'alt' => 'Rentify Premium Fleet',
                    'class' => 'img-fluid rounded-4 shadow-lg w-100',
                    'style' => 'height: 500px; object-fit: cover;'
                ]) ?>
            </div>
            
            <!-- Right Column - Content -->
            <div class="col-lg-6 animate-fade-in-up" style="animation-delay: 0.4s;">
                <!-- Blue Subtitle -->
                <span class="about-subtitle">DRIVEN BY EXCELLENCE</span>
                
                <!-- Montserrat Heading -->
                <h2 class="about-main-heading">Redefining Your Road Trip Experience</h2>
                
                <!-- Professional Paragraphs -->
                <p class="about-text">
                    At Rentify, we are committed to delivering an unparalleled driving experience. Our curated fleet 
                    features iconic vehicles like the powerful <strong>Chevrolet Camaro</strong>, the sophisticated 
                    <strong>BMW 5 Series</strong>, and the versatile <strong>Audi Q7</strong> — each meticulously 
                    maintained to ensure your journey is nothing short of exceptional.
                </p>
                <p class="about-text">
                    Whether you're embarking on a business trip, a family vacation, or a weekend adventure, 
                    we provide the perfect blend of luxury, comfort, and performance. Our dedication to quality 
                    and customer satisfaction sets us apart as your trusted partner on the road.
                </p>
                
                <!-- Trust Icons Row -->
                <div class="row g-4 mt-4">
                    <div class="col-4 text-center">
                        <div class="icon-box-sleek">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <span class="trust-icon-label fw-bold">Verified Fleet</span>
                    </div>
                    <div class="col-4 text-center">
                        <div class="icon-box-sleek">
                            <i class="bi bi-headset"></i>
                        </div>
                        <span class="trust-icon-label fw-bold">24/7 Support</span>
                    </div>
                    <div class="col-4 text-center">
                        <div class="icon-box-sleek">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <span class="trust-icon-label fw-bold">Secure Booking</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Fleet Marquee -->
<section class="py-5 bg-light overflow-hidden">
    <div class="container text-center mb-5">
        <div class="text-primary fw-bold mb-2" style="letter-spacing: 2px; font-size: 0.85rem; text-transform: uppercase;">The Rentify Collection</div>
        <h2 class="about-main-heading text-center">Our Featured Fleet</h2>
        <p class="text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem; margin-bottom: 50px;">From executive sedans to high-performance sports cars, discover a curated selection of world-class vehicles designed for your ultimate driving pleasure.</p>
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
                        <div class="marquee-price"><span class="price">$120</span><span class="period">/ day</span></div>
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
                        <div class="marquee-price"><span class="price">$150</span><span class="period">/ day</span></div>
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
                        <div class="marquee-price"><span class="price">$180</span><span class="period">/ day</span></div>
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
                        <div class="marquee-price"><span class="price">$120</span><span class="period">/ day</span></div>
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
                        <div class="marquee-price"><span class="price">$150</span><span class="period">/ day</span></div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-sm btn-primary rounded-pill">Details</a>
                    </div>
                </div>
            </div>
            
            <!-- Card 3: Audi Q7 (Duplicate) -->
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
                        <div class="marquee-price"><span class="price">$180</span><span class="period">/ day</span></div>
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

<!-- How It Works - EDITORIAL LUXURY EXECUTIVE PROCESS -->
<section class="executive-process-section position-relative overflow-hidden">
    <div class="container position-relative z-1">
        <!-- Elegant Header with Serif/Sans Pairing -->
        <div class="text-center mb-5 pb-4">
            <div class="executive-subtitle mb-3">The Executive Process</div>
            <h2 class="executive-title">How It <span class="metallic-text">Works</span></h2>
        </div>
        
        <!-- Flow Line Behind Cards (Desktop Only) -->
        <div class="flow-line d-none d-lg-block"></div>
        
        <!-- Steps Row -->
        <div class="row g-4 justify-content-center">
            <!-- Step 1: Secure Dates -->
            <div class="col-lg-4">
                <div class="crystal-card p-5 text-center h-100">
                    <div class="step-number">01</div>
                    <div class="executive-icon mb-4">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <h4 class="card-title-executive">Secure Dates</h4>
                    <p class="card-text-executive">Select your preferred timeline to view real-time availability.</p>
                </div>
            </div>
            
            <!-- Step 2: Select Vehicle -->
            <div class="col-lg-4">
                <div class="crystal-card p-5 text-center h-100">
                    <div class="step-number">02</div>
                    <div class="executive-icon mb-4">
                        <i class="far fa-gem"></i>
                    </div>
                    <h4 class="card-title-executive">Select Vehicle</h4>
                    <p class="card-text-executive">Choose from our curated fleet of performance engineering.</p>
                </div>
            </div>
            
            <!-- Step 3: Take Delivery -->
            <div class="col-lg-4">
                <div class="crystal-card p-5 text-center h-100">
                    <div class="step-number">03</div>
                    <div class="executive-icon mb-4">
                        <i class="far fa-compass"></i>
                    </div>
                    <h4 class="card-title-executive">Take Delivery</h4>
                    <p class="card-text-executive">Confirm your reservation and collect your keys. Excellence delivered.</p>
                </div>
            </div>
        </div>
        
        <!-- Ghost CTA Button -->
        <div class="text-center mt-5 pt-4">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="ghost-cta-btn">
                Explore the Collection
            </a>
        </div>
    </div>
</section>

<style>
/* ========================================
   EDITORIAL LUXURY EXECUTIVE PROCESS
   Vogue-Inspired / Centurion Aesthetic
   ======================================== */

/* Google Fonts - Montserrat + Playfair Display */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400;1,600&display=swap');

/* Section Container - Vignette Spotlight Background */
.executive-process-section {
    background: radial-gradient(circle at center, #1e293b 0%, #020617 100%);
    padding: 100px 0;
    position: relative;
}

/* Subtle Grain Overlay for Luxury Feel */
.executive-process-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.02'/%3E%3C/svg%3E");
    pointer-events: none;
    z-index: 0;
}

/* Subtitle - Playfair Display Italic Serif */
.executive-subtitle {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 400;
    font-style: italic;
    letter-spacing: 3px;
    background: linear-gradient(to right, #e2e8f0, #94a3b8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-transform: uppercase;
}

/* Main Title - Montserrat Bold */
.executive-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 3rem;
    font-weight: 700;
    letter-spacing: 2px;
    color: #e2e8f0;
    margin: 0;
}

.metallic-text {
    background: linear-gradient(to right, #e2e8f0, #94a3b8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Flow Line - Horizontal Connector */
.flow-line {
    position: absolute;
    top: 50%;
    left: 15%;
    right: 15%;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.12), transparent);
    z-index: 0;
    margin-top: 60px;
}

/* Crystal Glass Cards */
.crystal-card {
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    position: relative;
    z-index: 1;
    box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.02);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.crystal-card:hover {
    transform: translateY(-10px);
    border-color: #e2e8f0;
    box-shadow: 
        inset 0 0 20px rgba(255, 255, 255, 0.03),
        0 20px 40px -10px rgba(0, 0, 0, 0.5);
}

/* Step Number - Subtle */
.step-number {
    position: absolute;
    top: 20px;
    left: 24px;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 2px;
    color: rgba(255, 255, 255, 0.2);
}

/* Executive Icons - Large, Thin, White */
.executive-icon {
    font-size: 3rem;
    color: #ffffff;
    opacity: 0.9;
    transition: all 0.3s ease;
    line-height: 1;
}

.crystal-card:hover .executive-icon {
    opacity: 1;
    transform: scale(1.1);
}

/* Card Title */
.card-title-executive {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 16px;
    letter-spacing: 0.5px;
}

/* Card Text */
.card-text-executive {
    font-size: 0.95rem;
    color: #94a3b8;
    line-height: 1.7;
    margin: 0;
}

/* Ghost CTA Button */
.ghost-cta-btn {
    display: inline-block;
    padding: 16px 40px;
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.4);
    border-radius: 50px;
    color: #ffffff;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.9rem;
    font-weight: 500;
    letter-spacing: 1px;
    text-decoration: none;
    text-transform: uppercase;
    transition: all 0.3s ease;
}

.ghost-cta-btn:hover {
    background: #ffffff;
    color: #0f172a;
    border-color: #ffffff;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 991px) {
    .executive-process-section {
        padding: 60px 0;
    }
    
    .executive-title {
        font-size: 2rem;
    }
    
    .crystal-card {
        margin-bottom: 20px;
    }
    
    .ghost-cta-btn {
        padding: 14px 32px;
        font-size: 0.85rem;
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