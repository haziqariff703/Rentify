<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Maintenance> $maintenances
 */
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Maintenance Records') ?></h2>
            <p><?= __('Track vehicle maintenance and service history') ?></p>
        </div>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New Maintenance'),
            ['action' => 'add'],
            ['class' => 'btn-add', 'escape' => false]
        ) ?>
    </div>

    <!-- Maintenances DataTable -->
    <div class="table-responsive">
        <table id="maintenancesTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="filterable" data-column="1">
                        <span class="th-text">Car</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Cost</th>
                    <th>Date</th>
                    <th class="filterable" data-column="4">
                        <span class="th-text">Status</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($maintenances as $maintenance): ?>
                    <tr>
                        <td><?= $this->Number->format($maintenance->id) ?></td>
                        <td>
                            <?php if ($maintenance->hasValue('car')): ?>
                                <?= $this->Html->link(
                                    h($maintenance->car->brand . ' ' . $maintenance->car->car_model),
                                    ['controller' => 'Cars', 'action' => 'view', $maintenance->car->id],
                                    ['class' => 'text-decoration-none fw-semibold']
                                ) ?>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td class="price-cell">RM <?= $this->Number->format($maintenance->cost ?? 0) ?></td>
                        <td><?= h($maintenance->maintenance_date?->format('d M Y')) ?></td>
                        <td>
                            <span class="status-badge <?= h($maintenance->status) ?>">
                                <?= h(ucfirst($maintenance->status ?? 'pending')) ?>
                            </span>
                        </td>
                        <td>
                            <span class="description-preview" title="<?= h($maintenance->description) ?>">
                                <?= h(mb_substr($maintenance->description ?? '', 0, 30)) ?><?= strlen($maintenance->description ?? '') > 30 ? '...' : '' ?>
                            </span>
                        </td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $maintenance->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $maintenance->id],
                                ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $maintenance->id],
                                [
                                    'confirm' => __('Are you sure you want to delete maintenance #{0}?', $maintenance->id),
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'escape' => false,
                                    'title' => 'Delete'
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- DataTables styling and initialization handled by shared files: datatables-custom.css and datatables-init.js -->