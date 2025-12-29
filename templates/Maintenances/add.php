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

<div class="add-maintenance-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2><?= __('Schedule New Maintenance') ?></h2>
            <p class="text-muted"><?= __('Create a maintenance schedule for a vehicle') ?></p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <?= $this->Form->create($maintenance, ['class' => 'add-form']) ?>

    <div class="form-grid">
        <!-- Left Column: Maintenance Details -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-tools me-2"></i><?= __('Maintenance Details') ?></h5>
            </div>
            <div class="card-body">
                <table class="form-table">
                    <tr>
                        <th><?= __('Car') ?> <span class="text-danger">*</span></th>
                        <td><?= $this->Form->control('car_id', [
                                'options' => $cars,
                                'empty' => '-- Select Car --',
                                'label' => false,
                                'class' => 'form-select',
                                'required' => true
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Scheduled Date') ?> <span class="text-danger">*</span></th>
                        <td><?= $this->Form->control('maintenance_date', [
                                'label' => false,
                                'class' => 'form-control',
                                'type' => 'date',
                                'value' => date('Y-m-d'),
                                'required' => true
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td><?= $this->Form->control('status', [
                                'options' => $statusOptions,
                                'default' => 'scheduled',
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Estimated Cost (RM)') ?></th>
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
                    'placeholder' => 'Enter maintenance description, planned work, parts to be replaced, etc.'
                ]) ?>

                <div class="info-box mt-3">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    <span>When saved with <strong>Scheduled</strong> status, the car will automatically be marked as <strong>Under Maintenance</strong>.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <?= $this->Form->button(
            __('Schedule Maintenance'),
            ['class' => 'btn btn-primary btn-lg', 'escape' => false]
        ) ?>
        <?= $this->Html->link(
            __('Cancel'),
            ['action' => 'index'],
            ['class' => 'btn btn-outline-secondary btn-lg']
        ) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<style>
    .add-maintenance-container {
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
        width: 150px;
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

    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 0.9rem;
        color: #1e40af;
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

    .text-danger {
        color: #dc2626;
    }

    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>