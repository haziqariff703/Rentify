<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CarCategory $carCategory
 */
?>

<div class="view-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2><?= h($carCategory->name) ?></h2>
            <p class="text-muted">
                <span class="badge bg-primary me-2"><?= count($carCategory->cars) ?> Cars</span>
                <?= h($carCategory->description) ?: 'No description' ?>
            </p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-edit me-2"></i>' . __('Edit'),
                ['action' => 'edit', $carCategory->id],
                ['class' => 'btn btn-primary', 'escape' => false]
            ) ?>
            <?= $this->Form->postLink(
                '<i class="fas fa-trash me-2"></i>' . __('Delete'),
                ['action' => 'delete', $carCategory->id],
                [
                    'class' => 'btn btn-outline-danger delete-confirm',
                    'escape' => false,
                    'data-confirm-message' => __('Are you sure you want to delete this category?')
                ]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- Policy & Services Cards Grid -->
    <div class="cards-grid">
        <!-- Financial Policy Card -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-coins me-2"></i><?= __('Financial Policy') ?></h5>
            </div>
            <div class="card-body">
                <div class="policy-item">
                    <div class="policy-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="policy-content">
                        <span class="policy-label">Security Deposit</span>
                        <span class="policy-value text-success">RM <?= number_format((float)$carCategory->security_deposit, 2) ?></span>
                    </div>
                </div>
                <div class="policy-item">
                    <div class="policy-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="policy-content">
                        <span class="policy-label">Insurance Tier</span>
                        <span class="policy-value">
                            <?php
                            $tierColors = ['basic' => 'secondary', 'standard' => 'info', 'premium' => 'warning'];
                            $tier = $carCategory->insurance_tier ?: 'basic';
                            ?>
                            <span class="badge bg-<?= $tierColors[$tier] ?? 'secondary' ?>">
                                <?= ucfirst($tier) ?>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="policy-item">
                    <div class="policy-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="policy-content">
                        <span class="policy-label">Full Insurance Rate</span>
                        <span class="policy-value">RM <?= number_format((float)$carCategory->insurance_daily_rate, 2) ?>/day</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Card -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-concierge-bell me-2"></i><?= __('Available Services') ?></h5>
            </div>
            <div class="card-body">
                <div class="service-item <?= $carCategory->chauffeur_available ? 'available' : 'unavailable' ?>">
                    <div class="service-icon">
                        <?php if ($carCategory->chauffeur_available): ?>
                            <i class="fas fa-check-circle text-success"></i>
                        <?php else: ?>
                            <i class="fas fa-times-circle text-muted"></i>
                        <?php endif; ?>
                    </div>
                    <div class="service-content">
                        <span class="service-label">Chauffeur Service</span>
                        <?php if ($carCategory->chauffeur_available): ?>
                            <span class="service-rate">RM <?= number_format((float)$carCategory->chauffeur_daily_rate, 2) ?>/day</span>
                        <?php else: ?>
                            <span class="service-rate text-muted">Not Available</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="service-item <?= $carCategory->gps_available ? 'available' : 'unavailable' ?>">
                    <div class="service-icon">
                        <?php if ($carCategory->gps_available): ?>
                            <i class="fas fa-check-circle text-success"></i>
                        <?php else: ?>
                            <i class="fas fa-times-circle text-muted"></i>
                        <?php endif; ?>
                    </div>
                    <div class="service-content">
                        <span class="service-label">GPS Navigation</span>
                        <?php if ($carCategory->gps_available): ?>
                            <span class="service-rate">RM <?= number_format((float)$carCategory->gps_daily_rate, 2) ?>/day</span>
                        <?php else: ?>
                            <span class="service-rate text-muted">Not Available</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cars in this Category -->
    <div class="form-card full-width">
        <div class="card-header">
            <h5>
                <i class="fas fa-car me-2"></i><?= __('Cars in this Category') ?>
                <span class="badge bg-light text-dark ms-2"><?= count($carCategory->cars) ?></span>
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($carCategory->cars)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Car</th>
                                <th>Plate</th>
                                <th>Price/Day</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carCategory->cars as $car): ?>
                                <tr>
                                    <td>
                                        <?php if ($car->image): ?>
                                            <img src="<?= $this->Url->webroot('img/cars/' . $car->image) ?>"
                                                alt="<?= h($car->car_model) ?>"
                                                class="car-thumb">
                                        <?php else: ?>
                                            <div class="car-thumb-placeholder">
                                                <i class="fas fa-car"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= h($car->brand) ?> <?= h($car->car_model) ?></strong>
                                        <br><small class="text-muted"><?= $car->year ?> • <?= $car->seats ?> seats</small>
                                    </td>
                                    <td><code><?= h($car->plate_number) ?></code></td>
                                    <td class="text-success fw-bold">RM <?= number_format((float)$car->price_per_day, 2) ?></td>
                                    <td>
                                        <?php $statusColors = ['available' => 'success', 'maintenance' => 'warning']; ?>
                                        <span class="badge bg-<?= $statusColors[$car->status] ?? 'secondary' ?>">
                                            <?= ucfirst($car->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= $this->Html->link(
                                            '<i class="fas fa-eye"></i>',
                                            ['controller' => 'Cars', 'action' => 'view', $car->id],
                                            ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]
                                        ) ?>
                                        <?= $this->Html->link(
                                            '<i class="fas fa-pen"></i>',
                                            ['controller' => 'Cars', 'action' => 'edit', $car->id],
                                            ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-car-side"></i>
                    <p>No cars in this category yet.</p>
                    <?= $this->Html->link(
                        '<i class="fas fa-plus me-2"></i>Add a Car',
                        ['controller' => 'Cars', 'action' => 'add'],
                        ['class' => 'btn btn-primary', 'escape' => false]
                    ) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Metadata Footer -->
    <div class="metadata-footer">
        <i class="far fa-clock me-1"></i>
        Created: <?= $carCategory->created->format('d M Y, h:i A') ?> |
        Modified: <?= $carCategory->modified->format('d M Y, h:i A') ?>
    </div>
</div>

<style>
    /* CarCategories-specific styles (not in global .view-container) */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }

    .policy-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 8px;
        background: #f8fafc;
        margin-bottom: 12px;
    }

    .policy-item:last-child {
        margin-bottom: 0;
    }

    .policy-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 16px;
    }

    .policy-content {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .policy-label {
        font-weight: 500;
        color: #475569;
    }

    .policy-value {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .service-item {
        display: flex;
        align-items: center;
        padding: 16px;
        border-radius: 10px;
        margin-bottom: 12px;
        border: 2px solid #e2e8f0;
    }

    .service-item:last-child {
        margin-bottom: 0;
    }

    .service-item.available {
        border-color: #10b981;
        background: #ecfdf5;
    }

    .service-item.unavailable {
        border-color: #e2e8f0;
        background: #f9fafb;
    }

    .service-icon {
        font-size: 1.5rem;
        margin-right: 16px;
    }

    .service-content {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .service-label {
        font-weight: 600;
        color: #1e293b;
    }

    .service-rate {
        font-weight: 500;
        color: #059669;
    }

    .car-thumb {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
    }

    .car-thumb-placeholder {
        width: 60px;
        height: 40px;
        background: #e2e8f0;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
    }

    .metadata-footer {
        margin-top: 24px;
        text-align: center;
        color: #64748b;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .cards-grid {
            grid-template-columns: 1fr;
        }

        .policy-content,
        .service-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
    }
</style>