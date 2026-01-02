<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
?>

<div class="view-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2>Review #<?= h($review->id) ?></h2>
            <p class="text-muted">
                <span class="rating-stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star <?= $i <= $review->rating ? 'text-warning' : 'text-muted' ?>"></i>
                    <?php endfor; ?>
                    <span class="ms-2">(<?= $review->rating ?>/5)</span>
                </span>
            </p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-edit me-2"></i>' . __('Edit'),
                ['action' => 'edit', $review->id],
                ['class' => 'btn btn-primary', 'escape' => false]
            ) ?>
            <?= $this->Form->postLink(
                '<i class="fas fa-trash me-2"></i>' . __('Delete'),
                ['action' => 'delete', $review->id],
                ['confirm' => __('Are you sure you want to delete this review?'), 'class' => 'btn btn-outline-danger', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <div class="view-grid">
        <!-- Review Details -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2"></i><?= __('Review Details') ?></h5>
            </div>
            <div class="card-body">
                <table class="view-table">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><code>#<?= $this->Number->format($review->id) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= __('Customer') ?></th>
                        <td>
                            <?php if ($review->hasValue('user')): ?>
                                <?= $this->Html->link($review->user->name, ['controller' => 'Users', 'action' => 'view', $review->user->id]) ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Vehicle') ?></th>
                        <td>
                            <?php if ($review->hasValue('car')): ?>
                                <?= $this->Html->link($review->car->brand . ' ' . $review->car->car_model, ['controller' => 'Cars', 'action' => 'view', $review->car->id]) ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Rating') ?></th>
                        <td>
                            <span class="rating-display">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?= $i <= $review->rating ? 'text-warning' : 'text-muted' ?>"></i>
                                <?php endfor; ?>
                                <span class="rating-text"><?= $review->rating ?>/5</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($review->created?->format('M d, Y, g:i A')) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($review->modified?->format('M d, Y, g:i A')) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Comment Card -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-comment me-2"></i><?= __('Comment') ?></h5>
            </div>
            <div class="card-body">
                <div class="comment-content">
                    <?php if ($review->comment): ?>
                        <p><?= nl2br(h($review->comment)) ?></p>
                    <?php else: ?>
                        <p class="text-muted text-center py-4"><i class="fas fa-comment-slash me-2"></i>No comment provided
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>