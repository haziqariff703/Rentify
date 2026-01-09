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

    <!-- Empty State for No Unresolved Issues -->
    <?php
    $reviewsArray = is_array($reviews) ? $reviews : iterator_to_array($reviews);
    if ($showingIssues && empty($reviewsArray)):
    ?>
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-success fw-bold">All Issues Resolved!</h4>
            <p class="text-muted mb-4">Great job! There are no unresolved low-rating reviews at this time.</p>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to All Reviews'),
                ['action' => 'index'],
                ['class' => 'btn btn-primary', 'escape' => false]
            ) ?>
        </div>
    <?php else: ?>
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
                        <th>Maintenance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviewsArray as $review): ?>
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
                            <td class="text-center">
                                <?php if ($review->hasValue('car')): ?>
                                    <?php
                                    $status = strtolower($review->car->status ?? '');
                                    $isMaintenance = $status === 'maintenance';
                                    $hasResolvedIssue = false;

                                    // Check if there's a completed maintenance AFTER the review date
                                    if (!$isMaintenance && !empty($review->car->maintenances)) {
                                        foreach ($review->car->maintenances as $maintenance) {
                                            if ($maintenance->status === 'completed') {
                                                // Use end_date if available, otherwise fallback to modified date
                                                $completionDate = $maintenance->end_date ?? $maintenance->modified;
                                                if ($completionDate) {
                                                    // Compare Y-m-d strings to safely compare Date vs DateTime
                                                    if ($completionDate->format('Y-m-d') >= $review->created->format('Y-m-d')) {
                                                        $hasResolvedIssue = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>

                                    <?php if ($isMaintenance): ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fas fa-check-circle me-1"></i>Mark Done',
                                            ['controller' => 'Maintenances', 'action' => 'completeActive', $review->car->id],
                                            [
                                                'class' => 'btn btn-sm btn-success fw-bold',
                                                'escape' => false,
                                                'title' => 'Mark Maintenance as Completed',
                                                'confirm' => __('Mark maintenance for {0} as completed?', $review->car->car_model)
                                            ]
                                        ) ?>
                                    <?php elseif ($hasResolvedIssue && ($review->rating ?? 5) <= 2): ?>
                                        <span class="badge bg-soft-success text-success border border-success px-2 py-1">
                                            <i class="fas fa-check-double me-1"></i> Resolved
                                        </span>
                                    <?php elseif (($review->rating ?? 5) <= 2): ?>
                                        <?= $this->Html->link(
                                            '<i class="fas fa-tools"></i> Schedule',
                                            ['controller' => 'Maintenances', 'action' => 'add', '?' => ['car_id' => $review->car->id]],
                                            ['class' => 'btn btn-sm btn-danger', 'escape' => false, 'title' => 'Schedule Maintenance']
                                        ) ?>
                                    <?php else: ?>
                                        <span class="text-muted small"><i class="fas fa-check text-success"></i> OK</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
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
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<!-- DataTables styling and initialization handled by shared files: datatables-custom.css and datatables-init.js -->