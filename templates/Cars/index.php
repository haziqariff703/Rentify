<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Car> $cars
 */
$identity = $this->request->getAttribute('authentication')->getIdentity();
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Available Cars for Rent') ?></h2>
            <p><?= __('Hover over a card to see car details') ?></p>
        </div>
        <?php if ($identity && $identity->role === 'admin'): ?>
            <?= $this->Html->link(
                '<i class="fas fa-plus me-2"></i>' . __('New Car'),
                ['action' => 'add'],
                ['class' => 'btn-add', 'escape' => false]
            ) ?>
        <?php endif; ?>
    </div>

    <!-- Flip Card Grid -->
    <div class="flip-card-grid">
        <?php foreach ($cars as $car): ?>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <!-- Front of Card -->
                    <div class="flip-card-front">
                        <?php if ($car->image): ?>
                            <img src="<?= $this->Url->webroot('img/' . $car->image) ?>"
                                class="card-image"
                                alt="<?= h($car->car_model) ?>">
                        <?php else: ?>
                            <div class="card-image-placeholder">
                                <i class="fas fa-car"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-content">
                            <div>
                                <span class="card-category">
                                    <?= $car->hasValue('category') ? h($car->category->name) : 'General' ?>
                                </span>
                                <h3 class="card-title"><?= h($car->brand) ?> <?= h($car->car_model) ?></h3>
                                <p class="card-subtitle"><?= h($car->year) ?> • <?= h($car->transmission) ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="card-price">
                                    RM<?= $this->Number->format($car->price_per_day) ?>
                                    <span>/day</span>
                                </div>
                                <div class="card-actions">
                                    <span class="card-action-btn" title="<?= h($car->status) ?>">
                                        <?php if ($car->status === 'available'): ?>
                                            <i class="fas fa-check-circle" style="color: #22c55e;"></i>
                                        <?php else: ?>
                                            <i class="fas fa-times-circle" style="color: #ef4444;"></i>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back of Card -->
                    <div class="flip-card-back">
                        <div class="back-header">
                            <h4 class="back-title"><?= h($car->brand) ?> <?= h($car->car_model) ?></h4>
                            <p class="back-subtitle"><?= h($car->year) ?> Model</p>
                        </div>

                        <div class="back-content">
                            <!-- Number Plate -->
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div>
                                    <p class="detail-label"><?= __('Number Plate') ?></p>
                                    <p class="detail-value"><?= h($car->plate_number) ?></p>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <p class="detail-label"><?= __('Status') ?></p>
                                    <span class="status-badge <?= h($car->status) ?>">
                                        <?= h(ucfirst($car->status)) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div>
                                    <p class="detail-label"><?= __('Category') ?></p>
                                    <p class="detail-value">
                                        <?= $car->hasValue('category') ? h($car->category->name) : 'General' ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Specs Row -->
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div>
                                    <p class="detail-label"><?= __('Specs') ?></p>
                                    <p class="detail-value">
                                        <?= h($car->transmission) ?> • <?= $this->Number->format($car->seats) ?> <?= __('Seats') ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="back-footer">
                            <?= $this->Html->link(
                                __('View Details'),
                                ['action' => 'view', $car->id],
                                ['class' => 'btn-view']
                            ) ?>
                        </div>

                        <?php if ($identity && $identity->role === 'admin'): ?>
                            <div class="admin-actions">
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit me-1"></i>' . __('Edit'),
                                    ['action' => 'edit', $car->id],
                                    ['class' => 'btn-admin btn-edit', 'escape' => false]
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash me-1"></i>' . __('Delete'),
                                    ['action' => 'delete', $car->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete {0}?', $car->brand . ' ' . $car->car_model),
                                        'class' => 'btn-admin btn-delete',
                                        'escape' => false
                                    ]
                                ) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="paginator mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first('<< ' . __('first'), ['class' => 'page-item']) ?>
                <?= $this->Paginator->prev('< ' . __('previous'), ['class' => 'page-item']) ?>
                <?= $this->Paginator->numbers(['class' => 'page-item']) ?>
                <?= $this->Paginator->next(__('next') . ' >', ['class' => 'page-item']) ?>
                <?= $this->Paginator->last(__('last') . ' >>', ['class' => 'page-item']) ?>
            </ul>
        </nav>
        <p class="text-center text-muted small mt-2">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
    </div>
</div>

<style>
    .page-item a {
        color: #3b82f6;
        text-decoration: none;
        padding: 0.5rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin: 0 2px;
        transition: all 0.2s;
    }

    .page-item a:hover {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }

    .page-item.active a {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }

    .page-item.disabled a {
        color: #94a3b8;
        pointer-events: none;
        background-color: #f8fafc;
        border-color: #e2e8f0;
    }
</style>