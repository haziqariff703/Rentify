<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Review> $reviews
 * @var bool $showingIssues
 */
$showingIssues = $showingIssues ?? false;
?>

<div class="container py-4">
    <!-- Issue Filter Alert -->
    <?php if ($showingIssues): ?>
        <div class="alert alert-warning d-flex align-items-center justify-content-between mb-4" role="alert">
            <div>
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Showing Issue Reviews:</strong> Low-rating reviews (≤2 stars) that may indicate car problems.
            </div>
            <?= $this->Html->link(
                '<i class="fas fa-times me-1"></i> Clear Filter',
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary btn-sm', 'escape' => false]
            ) ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= $showingIssues ? __('Issue Reviews') : __('Reviews Management') ?></h2>
            <p><?= $showingIssues ? __('Reviews with potential car issues') : __('Manage customer reviews and ratings') ?></p>
        </div>
        <div class="header-actions-group">
            <?php if (!$showingIssues): ?>
                <?= $this->Html->link(
                    '<i class="fas fa-exclamation-triangle me-2"></i>' . __('Show Issues Only'),
                    ['action' => 'index', '?' => ['issues' => 1]],
                    ['class' => 'btn btn-outline-warning me-2', 'escape' => false]
                ) ?>
            <?php endif; ?>
            <?= $this->Html->link(
                '<i class="fas fa-plus me-2"></i>' . __('New Review'),
                ['action' => 'add'],
                ['class' => 'btn-add', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- Reviews DataTable -->
    <div class="table-responsive">
        <table id="reviewsTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="filterable" data-column="1">
                        <span class="th-text">Customer</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="2">
                        <span class="th-text">Car</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><code>#<?= h($review->id) ?></code></td>
                        <td><?= $review->hasValue('user') ? $this->Html->link($review->user->name, ['controller' => 'Users', 'action' => 'view', $review->user->id]) : '' ?>
                        </td>
                        <td><?= $review->hasValue('car') ? $this->Html->link($review->car->car_model, ['controller' => 'Cars', 'action' => 'view', $review->car->id]) : '' ?>
                        </td>
                        <td>
                            <span class="rating-stars">
                                <?php
                                $rating = $review->rating ?? 0;
                                for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?= $i <= $rating ? 'text-warning' : 'text-muted' ?>"></i>
                                <?php endfor; ?>
                                <span class="ms-1">(<?= $rating ?>)</span>
                            </span>
                        </td>
                        <td class="comment-cell">
                            <?= h(substr($review->comment ?? '', 0, 50)) ?> <?= strlen($review->comment ?? '') > 50 ? '...' : '' ?>
                        </td>
                        <td><?= $review->created ? $review->created->format('M d, Y') : '-' ?></td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $review->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $review->id],
                                ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $review->id],
                                [
                                    'class' => 'btn btn-sm btn-outline-danger delete-confirm',
                                    'escape' => false,
                                    'title' => 'Delete',
                                    'data-confirm-message' => __('Are you sure you want to delete review #{0}?', $review->id)
                                ]
                            ) ?>
                            <?php if (($review->rating ?? 5) <= 2 && $review->hasValue('car')): ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-tools"></i>',
                                    ['controller' => 'Maintenances', 'action' => 'add', '?' => ['car_id' => $review->car->id]],
                                    ['class' => 'btn btn-sm btn-danger', 'escape' => false, 'title' => 'Schedule Maintenance']
                                ) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- DataTables styling and initialization handled by shared files: datatables-custom.css and datatables-init.js -->