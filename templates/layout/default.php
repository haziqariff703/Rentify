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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">

    <!-- CSS with cache-busting -->
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/components.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/shared.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $this->Url->assetUrl('css/custom.css') ?>?v=<?= time() ?>">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class=" bg-light text-dark d-flex flex-column min-vh-100 position-relative pb-4">

    <!-- Glassmorphism Sidebar - Conditional based on authentication -->
    <?php if ($this->request->getAttribute('identity')): ?>
        <?= $this->element('sidebar') ?>
    <?php else: ?>
        <?= $this->element('public_sidebar') ?>
    <?php endif; ?>

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