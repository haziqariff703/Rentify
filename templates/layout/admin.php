<?php

/**
 * Rentify Admin Layout (with Header, Sidebar, Footer)
 * Used for admin dashboard and management pages
 */
$cakeDescription = 'Rentify - Admin Panel';
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

    <!-- Admin CSS -->
    <?= $this->Html->css('components') ?>
    <?= $this->Html->css('sidebar') ?>
    <?= $this->Html->css('dashboard') ?>
    <?= $this->Html->css('custom') ?>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            padding-top: 70px;
            /* Space for fixed navbar */
        }

        /* Adjust sidebar to start below navbar */
        .admin-sidebar {
            top: 70px;
            height: calc(100vh - 70px);
        }

        /* Admin content wrapper - includes main + footer */
        .admin-content-wrapper {
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 70px);
        }

        /* Main content takes available space */
        .admin-main {
            flex: 1;
            margin-left: 0;
            /* Override the default margin since wrapper handles it */
            padding: 24px 32px;
        }

        /* Footer inside admin area */
        .admin-content-wrapper .site-footer {
            margin-left: 0;
            /* No extra margin needed, wrapper handles it */
        }

        @media (max-width: 1200px) {
            .admin-content-wrapper {
                margin-left: 0;
            }

            .admin-main {
                padding: 16px;
            }
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class="bg-light text-dark">
    <!-- Header -->
    <?= $this->element('header') ?>

    <!-- Sidebar (fixed position) -->
    <?= $this->element('sidebar') ?>

    <!-- Content Wrapper (main + footer) -->
    <div class="admin-content-wrapper">
        <!-- Main Content -->
        <main class="admin-main">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </main>

        <!-- Footer -->
        <?= $this->element('footer') ?>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>