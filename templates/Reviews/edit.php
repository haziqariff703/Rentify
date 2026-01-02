<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $cars
 */
?>

<div class="edit-review-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2><?= __('Edit Review') ?> #<?= h($review->id) ?></h2>
            <p class="text-muted"><?= __('Update review details') ?></p>
        </div>
        <div class="header-actions">
            <?= $this->Form->postLink(
                '<i class="fas fa-trash me-2"></i>' . __('Delete'),
                ['action' => 'delete', $review->id],
                [
                    'class' => 'btn btn-outline-danger delete-confirm',
                    'escape' => false,
                    'data-confirm-message' => __('Are you sure you want to delete this review?')
                ]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <div class="form-card">
        <div class="card-header">
            <h5><i class="fas fa-star me-2"></i><?= __('Review Information') ?></h5>
        </div>
        <div class="card-body">
            <?= $this->Form->create($review) ?>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-user me-2"></i><?= __('Customer') ?></label>
                    <?= $this->Form->control('user_id', ['options' => $users, 'label' => false, 'class' => 'form-control']) ?>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-car me-2"></i><?= __('Vehicle') ?></label>
                    <?= $this->Form->control('car_id', ['options' => $cars, 'label' => false, 'class' => 'form-control']) ?>
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-star me-2"></i><?= __('Rating') ?></label>
                <?= $this->Form->control('rating', ['label' => false, 'type' => 'number', 'min' => 1, 'max' => 5, 'class' => 'form-control']) ?>
                <small class="text-muted">Enter a rating from 1 to 5</small>
            </div>

            <div class="form-group">
                <label><i class="fas fa-comment me-2"></i><?= __('Comment') ?></label>
                <?= $this->Form->control('comment', ['label' => false, 'type' => 'textarea', 'rows' => 4, 'class' => 'form-control']) ?>
            </div>

            <div class="form-actions">
                <?= $this->Form->button('<i class="fas fa-save me-2"></i>' . __('Save Changes'), ['class' => 'btn btn-primary', 'escape' => false]) ?>
                <?= $this->Html->link('<i class="fas fa-times me-2"></i>' . __('Cancel'), ['action' => 'index'], ['class' => 'btn btn-outline-secondary', 'escape' => false]) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<style>
    .edit-review-container {
        max-width: 800px;
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
        margin: 4px 0 0;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
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
        padding: 24px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        font-weight: 500;
        color: #334155;
        margin-bottom: 8px;
    }

    .form-group label i {
        color: #3b82f6;
    }

    .form-group .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-group .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group small {
        display: block;
        margin-top: 6px;
        color: #64748b;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        margin-top: 10px;
    }

    @media (max-width: 576px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>