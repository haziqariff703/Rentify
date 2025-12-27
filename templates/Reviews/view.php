<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
?>

<div class="view-review-container">
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

<style>
    .view-review-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header h2 {
        margin: 0;
        color: #1e293b;
    }

    .page-header .text-muted {
        margin: 8px 0 0;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .rating-stars i {
        font-size: 1rem;
        margin-right: 2px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .view-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 16px 20px;
    }

    .form-card .card-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .form-card .card-body {
        padding: 20px;
    }

    .view-table {
        width: 100%;
        border-collapse: collapse;
    }

    .view-table tr {
        border-bottom: 1px solid #f1f5f9;
    }

    .view-table tr:last-child {
        border-bottom: none;
    }

    .view-table th {
        text-align: left;
        padding: 12px 16px 12px 0;
        width: 100px;
        color: #64748b;
        font-weight: 500;
    }

    .view-table td {
        padding: 12px 0;
        color: #1e293b;
    }

    .rating-display {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .rating-display i {
        font-size: 0.9rem;
    }

    .rating-text {
        margin-left: 8px;
        font-weight: 600;
        color: #1e293b;
    }

    .comment-content {
        padding: 16px;
        background: #f8fafc;
        border-radius: 8px;
        min-height: 100px;
    }

    .comment-content p {
        margin: 0;
        line-height: 1.6;
        color: #334155;
    }

    @media (max-width: 768px) {
        .view-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>