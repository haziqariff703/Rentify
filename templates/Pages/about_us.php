<?php
/**
 * About Us - Rentify Premium Car Rental
 * Uber-inspired Zig-Zag Layout with Luxury Automotive Styling
 * @var \App\View\AppView $this
 */
$this->assign('title', 'About Us');
?>

<style>
    /* Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800;900&display=swap');

    /* ========================================
       ABOUT US PAGE WRAPPER
       ======================================== */
    .about-wrapper {
        margin-top: -3rem;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* ========================================
       VIDEO HERO BANNER - UBER STYLE
       ======================================== */
    .video-hero {
        position: relative;
        width: 100%;
        height: 85vh;
        min-height: 600px;
        overflow: hidden;
    }

    .video-hero video {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        transform: translate(-50%, -50%);
        object-fit: cover;
        object-position: center bottom;
        z-index: 0;
    }

    .video-hero .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.1) 0%,
            rgba(0, 0, 0, 0.3) 70%,
            rgba(0, 0, 0, 0.5) 100%
        );
        z-index: 1;
    }

    .video-hero .hero-title-uber {
        position: absolute;
        bottom: 60px;
        left: 120px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 2.5rem;
        color: #ffffff;
        z-index: 2;
        margin: 0;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 768px) {
        .video-hero {
            height: 50vh;
            min-height: 350px;
        }
        
        .video-hero .hero-title-uber {
            bottom: 40px;
            left: 24px;
            font-size: 1.75rem;
        }
    }

    /* ========================================
       MISSION STATEMENT SECTION - UBER STYLE
       ======================================== */
    .mission-section {
        background: #ffffff;
        padding: 80px 120px;
    }

    .mission-content {
        max-width: 650px;
        margin: 0;
        text-align: left;
    }

    .mission-quote {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        color: #0f172a;
        margin-bottom: 24px;
        line-height: 1.4;
    }

    @media (min-width: 768px) {
        .mission-quote {
            font-size: 2.25rem;
        }
    }

    .mission-text {
        font-family: 'Inter', sans-serif;
        font-size: 1.1rem;
        line-height: 1.9;
        color: #64748b;
    }

    /* ========================================
       ZIG-ZAG CONTENT SECTIONS
       ======================================== */
    .content-section {
        padding: 80px 0;
    }

    .content-section.bg-gray {
        background-color: #f8fafc;
    }

    .content-section.bg-white {
        background-color: #ffffff;
    }

    .content-image {
        border-radius: 16px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .content-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #ef4444;
        margin-bottom: 12px;
    }

    .content-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        color: #0f172a;
        margin-bottom: 16px;
        line-height: 1.4;
    }

    @media (min-width: 768px) {
        .content-title {
            font-size: 2.25rem;
        }
    }

    .content-text {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        line-height: 1.8;
        color: #64748b;
        margin-bottom: 24px;
    }

    .btn-dark-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0f172a;
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 14px 28px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-dark-pill:hover {
        background: #1e293b;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.3);
    }

    .btn-outline-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        border: 2px solid #0f172a;
        color: #0f172a;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 12px 26px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-outline-pill:hover {
        background: #0f172a;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* ========================================
       TRUST STATS BAR - FOOTER
       ======================================== */
    .stats-bar {
        background-color: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 80px 0;
    }

    .stats-row {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 40px;
    }

    .stat-column {
        text-align: center;
        flex: 1;
        min-width: 200px;
        max-width: 300px;
    }

    .stat-divider {
        width: 1px;
        height: 60px;
        background-color: #e2e8f0;
        display: none;
    }

    @media (min-width: 768px) {
        .stat-divider {
            display: block;
        }
    }

    .stat-number {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 3rem;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 12px;
    }

    @media (min-width: 768px) {
        .stat-number {
            font-size: 4rem;
        }
    }

    .stat-number .text-red {
        color: #ef4444;
    }

    .stat-number .text-muted-small {
        color: #94a3b8;
        font-size: 0.6em;
    }

    .stat-bar-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #64748b;
    }
</style>

<!-- About Us Page Wrapper -->
<div class="about-wrapper">

    <!-- Video Hero Banner -->
    <section class="video-hero">
        <video autoplay muted loop playsinline>
            <source src="<?= $this->Url->build('/video/about_video.mp4') ?>" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <h1 class="hero-title-uber">About us</h1>
    </section>

    <!-- Mission Statement -->
    <section class="mission-section">
        <div class="mission-content">
            <h2 class="mission-quote">We don't just rent cars. We curate experiences.</h2>
            <p class="mission-text">
                Rentify was born from a simple obsession: the belief that the journey matters more than the destination. 
                We exist to bridge the gap between premium automotive engineering and everyday accessibility. 
                Whether it's a Proton for a quick errand or a sports car for a weekend escape, we ensure every mile counts.
            </p>
        </div>
    </section>

    <!-- Performance Section (Image Left, Text Right) -->
    <section class="content-section bg-gray">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <?= $this->Html->image('my_engine.jpg', [
                        'alt' => 'Engineering Excellence',
                        'class' => 'content-image'
                    ]) ?>
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <p class="content-label">Performance</p>
                    <h3 class="content-title">Uncompromising Standards</h3>
                    <p class="content-text">
                        Every vehicle in our garage undergoes a rigorous 150-point inspection before it reaches you. 
                        We believe that safety and performance are not optional extras—they are the standard. 
                        From tire pressure to engine diagnostics, nothing escapes our attention.
                    </p>
                    <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'myCars']) ?>" class="btn-dark-pill">
                        <i class="fas fa-car"></i> Browse Our Fleet
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Section (Text Left, Image Right) -->
    <section class="content-section bg-white">
        <div class="container">
            <div class="row align-items-center flex-lg-row-reverse">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <?= $this->Html->image('my_meter.jpg', [
                        'alt' => 'Transparent Service',
                        'class' => 'content-image'
                    ]) ?>
                </div>
                <div class="col-lg-6 pe-lg-5">
                    <p class="content-label">Transparency</p>
                    <h3 class="content-title">Honest Pricing. Always.</h3>
                    <p class="content-text">
                        No hidden fees. No surprise charges at the counter. Just clear, honest pricing that lets you 
                        focus on the road ahead. Our "Total Spend" dashboard puts you in complete control of your finances, 
                        with every transaction tracked in real-time.
                    </p>
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="btn-outline-pill">
                        <i class="fas fa-user-plus"></i> Join Rentify
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Stats Bar -->
    <section class="stats-bar">
        <div class="container">
            <div class="stats-row">
                <div class="stat-column">
                    <div class="stat-number">500<span class="text-red">+</span></div>
                    <p class="stat-bar-label">Premium Journeys</p>
                </div>

                <div class="stat-divider"></div>

                <div class="stat-column">
                    <div class="stat-number">100<span class="text-red">%</span></div>
                    <p class="stat-bar-label">Safety Record</p>
                </div>

                <div class="stat-divider"></div>

                <div class="stat-column">
                    <div class="stat-number">24<span class="text-muted-small">/</span>7</div>
                    <p class="stat-bar-label">Concierge Support</p>
                </div>
            </div>
        </div>
    </section>

</div>
