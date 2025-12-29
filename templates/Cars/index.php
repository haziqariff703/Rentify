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
            <h2><?= __('Car Fleet Management') ?></h2>
            <p><?= __('Manage your vehicle inventory') ?></p>
        </div>
        <?php if ($identity && $identity->role === 'admin'): ?>
            <?= $this->Html->link(
                '<i class="fas fa-plus me-2"></i>' . __('New Car'),
                ['action' => 'add'],
                ['class' => 'btn-add', 'escape' => false]
            ) ?>
        <?php endif; ?>
    </div>

    <!-- Cars DataTable -->
    <div class="table-responsive">
        <table id="carsTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Image</th>
                    <th class="filterable" data-column="1">
                        <span class="th-text">Brand</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="2">
                        <span class="th-text">Model</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="3">
                        <span class="th-text">Year</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="4">
                        <span class="th-text">Plate</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="5">
                        <span class="th-text">Category</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Price/Day</th>
                    <th class="filterable" data-column="7">
                        <span class="th-text">Status</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Active Bookings</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car): ?>
                    <tr>
                        <td>
                            <?php if ($car->image): ?>
                                <img src="<?= $this->Url->webroot('img/' . $car->image) ?>"
                                    class="car-thumbnail"
                                    alt="<?= h($car->car_model) ?>">
                            <?php else: ?>
                                <div class="car-thumbnail-placeholder">
                                    <i class="fas fa-car"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?= h($car->brand) ?></td>
                        <td><?= h($car->car_model) ?></td>
                        <td><?= h($car->year) ?></td>
                        <td><code><?= h($car->plate_number) ?></code></td>
                        <td>
                            <span class="category-badge">
                                <?= $car->hasValue('category') ? h($car->category->name) : 'General' ?>
                            </span>
                        </td>
                        <td class="price-cell">RM <?= $this->Number->format($car->price_per_day) ?></td>
                        <td>
                            <span class="status-badge <?= h($car->status) ?>">
                                <?= h(ucfirst($car->status)) ?>
                            </span>
                        </td>
                        <td>
                            <?php
                            $activeBookings = array_filter($car->bookings ?? [], function ($b) {
                                return in_array($b->booking_status, ['pending', 'confirmed']);
                            });
                            $count = count($activeBookings);
                            ?>
                            <?php if ($count > 0): ?>
                                <span class="booking-count-badge active" title="<?= $count ?> active booking(s)">
                                    <i class="fas fa-calendar-check me-1"></i><?= $count ?>
                                </span>
                            <?php else: ?>
                                <span class="booking-count-badge empty">None</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $car->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $car->id],
                                ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $car->id],
                                [
                                    'confirm' => __('Are you sure you want to delete {0}?', $car->brand . ' ' . $car->car_model),
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