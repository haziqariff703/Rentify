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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@527&display=swap" rel="stylesheet">

    <!-- DataTables CSS with Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- Admin CSS with cache-busting -->
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/components.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/sidebar.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/dashboard.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/shared.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/custom.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/crud.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/datatables-custom.css') ?>?v=<?= time() ?>">

    <style>
        body {
            font-family: 'Syne', sans-serif;
            background-color: #f8fafc;
        }

        /* Admin content wrapper - includes main + footer */
        .admin-content-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

<body>
    <!-- Header -->
    <?= $this->element('header') ?>

    <!-- Sidebar (fixed position) -->
    <?= $this->element('sidebar') ?>

    <!-- Content Wrapper (main only) -->
    <div class="admin-content-wrapper">
        <!-- Main Content -->
        <main class="admin-main">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </main>
    </div>

    <!-- Footer (full width, outside wrapper) -->
    <?= $this->element('footer') ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS with Bootstrap 5 -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <!-- DataTables Custom Initialization -->
    <script src="<?= $this->Url->assetUrl('js/datatables-init.js') ?>?v=<?= time() ?>"></script>
</body>

</html>