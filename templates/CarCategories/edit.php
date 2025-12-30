<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CarCategory $carCategory
 */
?>

<div class="category-edit-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2><?= __('Edit Category') ?></h2>
            <p class="text-muted"><?= h($carCategory->name) ?></p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-eye me-2"></i>' . __('View'),
                ['action' => 'view', $carCategory->id],
                ['class' => 'btn btn-outline-primary', 'escape' => false]
            ) ?>
            <?= $this->Form->postLink(
                '<i class="fas fa-trash me-2"></i>' . __('Delete'),
                ['action' => 'delete', $carCategory->id],
                ['confirm' => __('Are you sure you want to delete this category?'), 'class' => 'btn btn-outline-danger', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <?= $this->Form->create($carCategory) ?>

    <div class="cards-grid">
        <!-- Basic Information Card -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2"></i><?= __('Basic Information') ?></h5>
            </div>
            <div class="card-body">
                <?= $this->Form->control('name', [
                    'class' => 'form-control',
                    'label' => ['text' => 'Category Name', 'class' => 'form-label']
                ]) ?>
                <?= $this->Form->control('description', [
                    'type' => 'textarea',
                    'rows' => 4,
                    'class' => 'form-control',
                    'label' => ['text' => 'Description', 'class' => 'form-label']
                ]) ?>
            </div>
        </div>

        <!-- Financial Policy Card -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-coins me-2"></i><?= __('Financial Policy') ?></h5>
            </div>
            <div class="card-body">
                <?= $this->Form->control('security_deposit', [
                    'type' => 'number',
                    'step' => '0.01',
                    'min' => '0',
                    'class' => 'form-control',
                    'label' => ['text' => 'Security Deposit (RM)', 'class' => 'form-label']
                ]) ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= $this->Form->control('insurance_tier', [
                            'type' => 'select',
                            'options' => [
                                'basic' => 'Basic',
                                'standard' => 'Standard',
                                'premium' => 'Premium'
                            ],
                            'class' => 'form-select',
                            'label' => ['text' => 'Insurance Tier', 'class' => 'form-label']
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('insurance_daily_rate', [
                            'type' => 'number',
                            'step' => '0.01',
                            'min' => '0',
                            'class' => 'form-control',
                            'label' => ['text' => 'Insurance Rate (RM/day)', 'class' => 'form-label']
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Card -->
        <div class="form-card full-width">
            <div class="card-header">
                <h5><i class="fas fa-concierge-bell me-2"></i><?= __('Available Services') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="service-group">
                            <h6><i class="fas fa-user-tie me-2"></i>Chauffeur Service</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $this->Form->control('chauffeur_available', [
                                        'type' => 'checkbox',
                                        'label' => 'Available',
                                        'class' => 'form-check-input'
                                    ]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('chauffeur_daily_rate', [
                                        'type' => 'number',
                                        'step' => '0.01',
                                        'min' => '0',
                                        'class' => 'form-control',
                                        'label' => ['text' => 'Rate (RM/day)', 'class' => 'form-label']
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="service-group">
                            <h6><i class="fas fa-map-marker-alt me-2"></i>GPS Navigation</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $this->Form->control('gps_available', [
                                        'type' => 'checkbox',
                                        'label' => 'Available',
                                        'class' => 'form-check-input'
                                    ]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('gps_daily_rate', [
                                        'type' => 'number',
                                        'step' => '0.01',
                                        'min' => '0',
                                        'class' => 'form-control',
                                        'label' => ['text' => 'Rate (RM/day)', 'class' => 'form-label']
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="submit-section">
        <?= $this->Form->button(__('Save Changes'), [
            'class' => 'btn btn-primary btn-lg',
            'escape' => false
        ]) ?>
    </div>

    <?= $this->Form->end() ?>

    <!-- Cars in this Category (Read-only) -->
    <?php if (!empty($carCategory->cars)): ?>
        <div class="form-card mt-4">
            <div class="card-header">
                <h5>
                    <i class="fas fa-car me-2"></i><?= __('Cars Using This Category') ?>
                    <span class="badge bg-light text-dark ms-2"><?= count($carCategory->cars) ?></span>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Car</th>
                                <th>Plate</th>
                                <th>Price/Day</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carCategory->cars as $car): ?>
                                <tr>
                                    <td><strong><?= h($car->brand) ?> <?= h($car->car_model) ?></strong></td>
                                    <td><code><?= h($car->plate_number) ?></code></td>
                                    <td class="text-success">RM <?= number_format((float)$car->price_per_day, 2) ?></td>
                                    <td>
                                        <?php $statusColors = ['available' => 'success', 'maintenance' => 'warning']; ?>
                                        <span class="badge bg-<?= $statusColors[$car->status] ?? 'secondary' ?>">
                                            <?= ucfirst($car->status) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .category-edit-container {
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
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header h2 {
        margin: 0;
        color: #1e293b;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .form-card.full-width {
        grid-column: 1 / -1;
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

    .form-label {
        font-weight: 500;
        color: #475569;
        margin-bottom: 6px;
    }

    .form-control,
    .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .service-group {
        background: #f8fafc;
        padding: 16px;
        border-radius: 10px;
    }

    .service-group h6 {
        margin-bottom: 16px;
        color: #1e293b;
        font-weight: 600;
    }

    .submit-section {
        text-align: center;
        padding: 20px 0;
    }

    .submit-section .btn-lg {
        padding: 14px 40px;
        font-size: 1.1rem;
    }

    .table thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        font-weight: 600;
        color: #475569;
    }

    @media (max-width: 768px) {
        .cards-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>