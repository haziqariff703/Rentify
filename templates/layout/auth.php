<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/custom.css') ?>?v=<?= time() ?>">

    <!-- Components CSS -->
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/components.css') ?>?v=<?= time() ?>">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Force Navbar Dark Styling - Navy Background */
        .navbar,
        #navbar {
            background-color: #0f172a !important;
        }

        .navbar-brand {
            color: #ffffff !important;
        }

        .navbar-brand:hover {
            color: #3b82f6 !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
        }

        .nav-link:hover {
            color: #3b82f6 !important;
        }

        .btn-outline-light {
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }

        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: #ffffff !important;
        }

        /* Header Positioning */
        #navbar {
            position: relative !important;
            z-index: 1000;
        }

        /* Main Content Area */
        .auth-content-wrapper {
            flex: 1;
            position: relative;
            overflow: hidden;
            padding: 20px 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
        }

        /* Footer Enhanced Styling with Grain Texture */
        .site-footer {
            position: relative !important;
            z-index: 1000;
            margin-top: 0;
            padding: 80px 0 40px !important;
            overflow: hidden;
        }

        .site-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1;
        }

        .site-footer>* {
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

        /* Force Glassmorphism on Auth Sidebar */
        .glassmorphism-sidebar {
            background: rgba(15, 23, 42, 0.25) !important;
            backdrop-filter: blur(20px) saturate(180%) brightness(0.8) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) brightness(0.8) !important;
            z-index: 1050 !important;
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>

    <!-- Glassmorphism Sidebar - Conditional based on authentication -->
    <?php if ($this->request->getAttribute('identity')): ?>
        <?= $this->element('sidebar') ?>
    <?php else: ?>
        <?= $this->element('public_sidebar') ?>
    <?php endif; ?>

    <!-- Header -->
    <?= $this->element('header') ?>

    <!-- Flash Messages -->
    <?= $this->Flash->render() ?>

    <!-- Main Auth Content -->
    <div class="auth-content-wrapper">
        <?= $this->fetch('content') ?>
    </div>

    <!-- Footer -->
    <?= $this->element('footer') ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>