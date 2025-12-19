<?php
/**
 * Rentify Home Page - Bootstrap 5 Version
 */
$this->setLayout('home');
$this->assign('title', 'Welcome to Rentify');
?>

<!-- Hero Section -->
<section class="vh-85 position-relative d-flex align-items-center justify-content-center overflow-hidden" style="height: 85vh;">
    <!-- Background Image with Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100 z-0">
        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Hero Background" class="w-100 h-100 object-fit-cover" style="object-fit: cover;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-black opacity-60" style="opacity: 0.6;"></div>
    </div>

    <div class="position-relative z-10 text-center container" style="max-width: 900px;">
        <h1 class="display-3 fw-bold text-white mb-4 animate-fade-in-up">
            Drive Your <span class="text-primary">Dreams</span> Today
        </h1>
        <p class="lead text-light mb-5 mx-auto animate-fade-in-up" style="animation-delay: 0.2s; max-width: 700px;">
            Experience the thrill of the open road with our premium fleet of vehicles. Unmatched comfort, style, and performance await.
        </p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center animate-fade-in-up" style="animation-delay: 0.4s;">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg">
                Browse Fleet
            </a>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 shadow-lg">
                Join Now
            </a>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section id="about" class="py-5 bg-white">
    <div class="container py-5">
        <div class="row gy-5 align-items-center">
            <div class="col-lg-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary rounded-4 opacity-25" style="transform: rotate(3deg); z-index: 0;"></div>
                    <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="About Rentify" class="img-fluid rounded-4 shadow-lg position-relative z-1 w-100" style="height: 500px; object-fit: cover;">
                </div>
            </div>
            
            <div class="col-lg-6 animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="d-inline-block px-3 py-1 bg-primary-subtle text-primary fw-semibold rounded-pill small mb-3">About Us</div>
                <h2 class="display-5 fw-bold text-dark mb-4">We Are More Than Just A Car Rental Company</h2>
                <p class="text-secondary fs-5 mb-4">
                    At Rentify, we believe that the journey is just as important as the destination. We provide top-quality vehicles to ensure your travel is safe, comfortable, and stylish. Whether it's a business trip or a weekend getaway, we have the perfect ride for you.
                </p>
                
                <div class="row g-4">
                    <div class="col-sm-6 d-flex align-items-center gap-3">
                        <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                            <i class="fas fa-check text-success"></i>
                        </div>
                        <span class="fw-medium text-dark">Best Price Guarantee</span>
                    </div>
                    <div class="col-sm-6 d-flex align-items-center gap-3">
                         <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                            <i class="fas fa-headset text-success"></i>
                        </div>
                        <span class="fw-medium text-dark">24/7 Support</span>
                    </div>
                    <div class="col-sm-6 d-flex align-items-center gap-3">
                         <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                            <i class="fas fa-star text-success"></i>
                        </div>
                        <span class="fw-medium text-dark">Premium Models</span>
                    </div>
                    <div class="col-sm-6 d-flex align-items-center gap-3">
                         <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                            <i class="fas fa-calendar-check text-success"></i>
                        </div>
                        <span class="fw-medium text-dark">Easy Booking</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Fleet Preview -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5 animate-fade-in-up mx-auto" style="max-width: 800px;">
            <h2 class="display-5 fw-bold text-dark mb-3">Our Featured Fleet</h2>
            <p class="fs-5 text-secondary">Choose from our wide range of premium vehicles tailored to your needs.</p>
        </div>
        
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-6 col-lg-4 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="card border-0 shadow-sm h-100 overflow-hidden hover-shadow transition-all">
                    <div class="position-relative" style="height: 250px;">
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="w-100 h-100 object-fit-cover" alt="Sports Car">
                        <span class="position-absolute top-0 end-0 m-3 badge bg-white text-dark shadow-sm py-2 px-3 rounded-pill text-uppercase">Sports</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h4 fw-bold text-dark mb-2">Chevrolet Camaro</h3>
                        <div class="d-flex gap-3 text-muted small mb-4">
                            <span><i class="fas fa-cogs me-1"></i> Auto</span>
                            <span><i class="fas fa-user me-1"></i> 2 Seats</span>
                            <span><i class="fas fa-tachometer-alt me-1"></i> Fast</span>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="h3 fw-bold text-primary">$120</span>
                                <span class="text-muted small">/ day</span>
                            </div>
                            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-outline-secondary hover-primary">
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="col-md-6 col-lg-4 animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="card border-0 shadow-sm h-100 overflow-hidden hover-shadow transition-all">
                    <div class="position-relative" style="height: 250px;">
                        <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="w-100 h-100 object-fit-cover" alt="Luxury Sedan">
                         <span class="position-absolute top-0 end-0 m-3 badge bg-white text-dark shadow-sm py-2 px-3 rounded-pill text-uppercase">Luxury</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h4 fw-bold text-dark mb-2">BMW 5 Series</h3>
                        <div class="d-flex gap-3 text-muted small mb-4">
                            <span><i class="fas fa-cogs me-1"></i> Auto</span>
                            <span><i class="fas fa-user me-1"></i> 5 Seats</span>
                            <span><i class="fas fa-gas-pump me-1"></i> Diesel</span>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="h3 fw-bold text-primary">$150</span>
                                <span class="text-muted small">/ day</span>
                            </div>
                            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-outline-secondary hover-primary">
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="col-md-6 col-lg-4 animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="card border-0 shadow-sm h-100 overflow-hidden hover-shadow transition-all">
                    <div class="position-relative" style="height: 250px;">
                        <img src="https://images.unsplash.com/photo-1503376763036-066120622c74?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="w-100 h-100 object-fit-cover" alt="SUV">
                         <span class="position-absolute top-0 end-0 m-3 badge bg-white text-dark shadow-sm py-2 px-3 rounded-pill text-uppercase">SUV</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h4 fw-bold text-dark mb-2">Audi Q7</h3>
                        <div class="d-flex gap-3 text-muted small mb-4">
                            <span><i class="fas fa-cogs me-1"></i> Auto</span>
                            <span><i class="fas fa-user me-1"></i> 7 Seats</span>
                            <span><i class="fas fa-mountain me-1"></i> AWD</span>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <div>
                                <span class="h3 fw-bold text-primary">$180</span>
                                <span class="text-muted small">/ day</span>
                            </div>
                            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="btn btn-outline-secondary hover-primary">
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
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
        <div class="text-center mb-5 animate-fade-in-up mx-auto" style="max-width: 800px;">
            <h2 class="display-5 fw-bold text-dark mb-3">How It Works</h2>
            <p class="fs-5 text-secondary">Rent your dream car in 3 simple steps</p>
        </div>
        
        <div class="row g-5 text-center">
            <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="p-4 rounded-4 bg-light hover-shadow transition-all h-100 group-hover-scale">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-4 mb-4" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">1. Choose Date</h4>
                    <p class="text-secondary">Select your preferred pickup and return dates to check real-time availability.</p>
                </div>
            </div>
            
            <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="p-4 rounded-4 bg-light hover-shadow transition-all h-100 group-hover-scale">
                     <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-4 mb-4" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-car"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">2. Select Car</h4>
                    <p class="text-secondary">Browse our diverse fleet and choose the car that perfectly fits your journey.</p>
                </div>
            </div>
            
            <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="p-4 rounded-4 bg-light hover-shadow transition-all h-100 group-hover-scale">
                     <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-4 mb-4" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-key"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">3. Book & Go</h4>
                    <p class="text-secondary">Complete your secure booking and pick up your car. It's that simple!</p>
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