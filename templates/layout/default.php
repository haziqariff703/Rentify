<?php

/**
 * Rentify Default Layout (Bootstrap 5 CSS)
 */
$cakeDescription = 'Rentify - Premium Car Rental';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js>

    <!-- Custom CSS -->
    <?= $this->Html->css('components') ?>
    <?= $this->Html->css('custom') ?>

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Footer Enhanced Styling with Grain Texture */
        .site-footer {
            padding: 80px 0 40px !important;
            position: relative;
            overflow: hidden;
        }

        .site-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url(" data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg' %3E%3Cfilter id='noiseFilter' %3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch' /%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05' /%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 1;
        }

        .site-footer> * {
    position: relative;
    z-index: 2;
    }

    .site-footer .footer-description {
    font-size: 15px !important;
    line-height: 1.8 !important;
    margin-bottom: 24px !important;
    }

    .site-footer .footer-social {
    display: flex;
    gap: 12px;
    margin-top: 20px;
    }

    .site-footer .footer-heading {
    font-size: 14px !important;
    margin-bottom: 24px !important;
    letter-spacing: 0.8px !important;
    }

    .site-footer .footer-links li {
    margin-bottom: 14px !important;
    }

    .site-footer .footer-links a {
    font-size: 15px !important;
    }

    .site-footer .footer-contact li {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    font-size: 15px !important;
    }

    .site-footer .footer-contact li i {
    width: 20px;
    font-size: 16px;
    color: #3b82f6;
    }

    .site-footer .social-icon {
    width: 44px !important;
    height: 44px !important;
    border-radius: 12px !important;
    font-size: 16px;
    }

    .site-footer .footer-bottom {
    margin-top: 60px !important;
    padding-top: 30px !important;
    gap: 20px !important;
    }

    .site-footer .footer-bottom p {
    font-size: 14px !important;
    }

    .site-footer .footer-bottom-links {
    display: flex;
    gap: 24px;
    }

    .site-footer .footer-bottom a {
    font-size: 14px !important;
    }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class=" bg-light text-dark d-flex flex-column min-vh-100 position-relative pb-4">

    <!-- Glassmorphism Sidebar -->
    <?= $this->element('sidebar') ?>

    <!-- Header Element -->
    <?= $this->element('header') ?>

    <!-- Main Content -->
    <main class="flex-grow-1 pt-5 container-fluid px-4 px-lg-5 mx-auto w-100" style="max-width: 1320px;">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <!-- Footer Element -->
    <?= $this->element('footer') ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>