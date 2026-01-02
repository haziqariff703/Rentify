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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS with cache-busting -->
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/components.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/shared.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/custom.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/crud.css') ?>?v=<?= time() ?>">

    <style>
        body {
            font-family: 'Syne', sans-serif;
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
    <main class="flex-grow-1 pt-5 container-fluid px-4 px-lg-5 mx-auto w-100" style="max-width: 1320px; position: relative;">
        <!-- Toast Container for Flash Messages (inside layout) -->
        <div class="toast-container position-absolute top-0 end-0 p-3" style="z-index: 10000;">
            <?= $this->Flash->render() ?>
        </div>
        <?= $this->fetch('content') ?>
    </main>

    <!-- Footer Element -->
    <?= $this->element('footer') ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>