<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Maintenance $maintenance
 * @var string[]|\Cake\Collection\CollectionInterface $cars
 */

$statusOptions = [
    'scheduled' => 'Scheduled',
    'completed' => 'Completed'
];
?>

<div class="edit-maintenance-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2><?= __('Edit Maintenance') ?></h2>
            <p class="text-muted">Record #<?= h($maintenance->id) ?></p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <?= $this->Form->create($maintenance, ['class' => 'edit-form']) ?>

    <div class="form-grid">
        <!-- Left Column: Maintenance Details -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-tools me-2"></i><?= __('Maintenance Details') ?></h5>
            </div>
            <div class="card-body">
                <table class="form-table">
                    <tr>
                        <th><?= __('Car') ?></th>
                        <td><?= $this->Form->control('car_id', [
                                'options' => $cars,
                                'empty' => '-- Select Car --',
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Start Date') ?></th>
                        <td><?= $this->Form->control('maintenance_date', [
                                'label' => false,
                                'class' => 'form-control',
                                'type' => 'date'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('End Date') ?></th>
                        <td><?= $this->Form->control('end_date', [
                                'label' => false,
                                'class' => 'form-control',
                                'type' => 'date'
                            ]) ?>
                            <small class="text-muted">Auto-set to today if completed and left blank.</small>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td><?= $this->Form->control('status', [
                                'options' => $statusOptions,
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Cost (RM)') ?></th>
                        <td><?= $this->Form->control('cost', [
                                'label' => false,
                                'class' => 'form-control',
                                'type' => 'number',
                                'step' => '0.01',
                                'min' => 0,
                                'placeholder' => '0.00'
                            ]) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Right Column: Description & Notes -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-clipboard-list me-2"></i><?= __('Description & Notes') ?></h5>
            </div>
            <div class="card-body">
                <?= $this->Form->control('description', [
                    'label' => false,
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'rows' => 8,
                    'placeholder' => 'Enter maintenance description, parts replaced, issues found, etc.'
                ]) ?>

                <div class="maintenance-info mt-3">
                    <div class="info-item">
                        <i class="fas fa-calendar-plus text-muted me-2"></i>
                        <span class="text-muted">Created:</span>
                        <strong><?= $maintenance->created ? $maintenance->created->format('M d, Y H:i') : '-' ?></strong>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar-check text-muted me-2"></i>
                        <span class="text-muted">Modified:</span>
                        <strong><?= $maintenance->modified ? $maintenance->modified->format('M d, Y H:i') : '-' ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <?= $this->Form->button(
            __('Save Changes'),
            ['class' => 'btn btn-primary btn-lg', 'escape' => false]
        ) ?>
    </div>

    <?= $this->Form->end() ?>

    <div class="form-actions mt-3">
        <?= $this->Form->postLink(
            '<i class="fas fa-trash me-2"></i>' . __('Delete'),
            ['action' => 'delete', $maintenance->id],
            [
                'class' => 'btn btn-outline-danger btn-lg delete-confirm',
                'escape' => false,
                'confirm' => __('Are you sure you want to delete this maintenance record?')
            ]
        ) ?>
    </div>
</div>

<style>
    .edit-maintenance-container {
        max-width: 1200px;
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
    }

    .page-header h2 {
        margin: 0;
        color: #1e293b;
    }

    .page-header .text-muted {
        margin: 5px 0 0;
        color: #64748b;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
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
    }

    .form-card .card-body {
        padding: 20px;
    }

    .form-table {
        width: 100%;
        border-collapse: collapse;
    }

    .form-table tr {
        border-bottom: 1px solid #f1f5f9;
    }

    .form-table tr:last-child {
        border-bottom: none;
    }

    .form-table th {
        text-align: left;
        padding: 12px 16px 12px 0;
        width: 140px;
        color: #475569;
        font-weight: 500;
        vertical-align: middle;
    }

    .form-table td {
        padding: 12px 0;
    }

    .form-table .form-control,
    .form-table .form-select {
        width: 100%;
    }

    .maintenance-info {
        background: #f8fafc;
        border-radius: 8px;
        padding: 16px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .form-actions {
        display: flex;
        gap: 16px;
        padding-top: 20px;
        border-top: 2px solid #e2e8f0;
    }

    .form-actions .btn-lg {
        padding: 12px 32px;
        font-size: 1rem;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }

    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>