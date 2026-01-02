<?php

/**
 * Maintenance View - Standardized Layout
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Maintenance $maintenance
 */

$statusColors = [
    'scheduled' => ['bg' => '#fef3c7', 'text' => '#92400e'],
    'in_progress' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
    'completed' => ['bg' => '#dcfce7', 'text' => '#166534'],
    'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
];
$status = strtolower($maintenance->status ?? 'scheduled');
$currentStatus = $statusColors[$status] ?? ['bg' => '#e2e8f0', 'text' => '#475569'];
?>

<div class="view-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2>Maintenance #<?= h($maintenance->id) ?></h2>
            <p class="text-muted">
                <span class="status-badge" style="background: <?= $currentStatus['bg'] ?>; color: <?= $currentStatus['text'] ?>">
                    <?= h(ucfirst(str_replace('_', ' ', $maintenance->status))) ?>
                </span>
                <?php if ($maintenance->hasValue('car')): ?>
                    <span class="ms-2">
                        <i class="fas fa-car me-1"></i>
                        <?= $this->Html->link($maintenance->car->brand . ' ' . $maintenance->car->car_model, ['controller' => 'Cars', 'action' => 'view', $maintenance->car->id]) ?>
                    </span>
                <?php endif; ?>
            </p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-edit me-2"></i>' . __('Edit'),
                ['action' => 'edit', $maintenance->id],
                ['class' => 'btn btn-primary', 'escape' => false]
            ) ?>
            <?= $this->Form->postLink(
                '<i class="fas fa-trash me-2"></i>' . __('Delete'),
                ['action' => 'delete', $maintenance->id],
                [
                    'class' => 'btn btn-outline-danger delete-confirm',
                    'escape' => false,
                    'data-confirm-message' => __('Are you sure you want to delete this maintenance record?')
                ]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <div class="view-grid">
        <!-- Maintenance Details -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-tools me-2"></i><?= __('Maintenance Details') ?></h5>
            </div>
            <div class="card-body">
                <table class="view-table">
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><code>#<?= $this->Number->format($maintenance->id) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= __('Vehicle') ?></th>
                        <td>
                            <?php if ($maintenance->hasValue('car')): ?>
                                <?= $this->Html->link($maintenance->car->brand . ' ' . $maintenance->car->car_model, ['controller' => 'Cars', 'action' => 'view', $maintenance->car->id]) ?>
                                <br><small class="text-muted"><?= h($maintenance->car->plate_number) ?></small>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td>
                            <span class="status-badge" style="background: <?= $currentStatus['bg'] ?>; color: <?= $currentStatus['text'] ?>">
                                <?= h(ucfirst(str_replace('_', ' ', $maintenance->status))) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Cost') ?></th>
                        <td class="price-value">
                            <?= $maintenance->cost !== null ? 'RM ' . $this->Number->format($maintenance->cost, ['places' => 2]) : '—' ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Date Information -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-calendar-alt me-2"></i><?= __('Date Information') ?></h5>
            </div>
            <div class="card-body">
                <table class="view-table">
                    <tr>
                        <th><?= __('Maintenance Date') ?></th>
                        <td>
                            <?php if ($maintenance->maintenance_date): ?>
                                <?= is_object($maintenance->maintenance_date) ? $maintenance->maintenance_date->format('M d, Y') : date('M d, Y', strtotime($maintenance->maintenance_date)) ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($maintenance->created?->format('M d, Y, g:i A')) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($maintenance->modified?->format('M d, Y, g:i A')) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Description Card -->
        <div class="form-card full-width">
            <div class="card-header">
                <h5><i class="fas fa-align-left me-2"></i><?= __('Description') ?></h5>
            </div>
            <div class="card-body">
                <div class="comment-content">
                    <?php if ($maintenance->description): ?>
                        <?= $this->Text->autoParagraph(h($maintenance->description)) ?>
                    <?php else: ?>
                        <p class="text-muted text-center py-4"><i class="fas fa-comment-slash me-2"></i>No description provided</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>