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

<!-- How It Works -->
<section class="py-5 bg-white position-relative overflow-hidden">
    <div class="container position-relative z-1 py-5">
        <!-- Header with Typography Sync -->
        <div class="text-center mb-5">
            <div class="text-primary fw-bold mb-2" style="letter-spacing: 2px; font-size: 0.85rem; text-transform: uppercase;">Simple Process</div>
            <h2 class="about-main-heading text-center">Rent Your Dream Car in 3 Simple Steps</h2>
        </div>
        
        <!-- Steps Row with Connecting Lines -->
        <div class="row g-4 text-center position-relative hiw-steps-row">
            <!-- Connecting Line (Desktop Only) -->
            <div class="hiw-connecting-line d-none d-md-block"></div>
            
            <!-- Step 1: Choose Date -->
            <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="hiw-step-card p-4 rounded-4 bg-light shadow-sm h-100">
                    <span class="hiw-step-badge">STEP 01</span>
                    <div class="hiw-icon-circle mx-auto mb-4">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: #0F172A;">Choose Date</h4>
                    <p class="text-muted" style="color: #64748B !important;">Select your preferred pickup and return dates to check real-time availability.</p>
                </div>
            </div>
            
            <!-- Step 2: Select Car -->
            <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="hiw-step-card p-4 rounded-4 bg-light shadow-sm h-100">
                    <span class="hiw-step-badge">STEP 02</span>
                    <div class="hiw-icon-circle mx-auto mb-4">
                        <i class="fas fa-car"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: #0F172A;">Select Car</h4>
                    <p class="text-muted" style="color: #64748B !important;">Browse our diverse fleet and choose the car that perfectly fits your journey.</p>
                </div>
            </div>
            
            <!-- Step 3: Drive Away -->
            <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.6s;">
                <div class="hiw-step-card p-4 rounded-4 bg-light shadow-sm h-100">
                    <span class="hiw-step-badge">STEP 03</span>
                    <div class="hiw-icon-circle mx-auto mb-4">
                        <i class="fas fa-key"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: #0F172A;">Drive Away</h4>
                    <p class="text-muted" style="color: #64748B !important;">Complete your secure booking and pick up your car. It's that simple!</p>
                </div>
            </div>
        </div>
    </div>
</section>

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