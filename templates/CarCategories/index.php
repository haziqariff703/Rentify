<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CarCategory> $carCategories
 */
?>

<style>
    .insurance-badge {
        font-size: 0.85rem !important;
        padding: 5px 12px !important;
        font-weight: 500 !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .cars-count-badge {
        font-size: 0.85rem !important;
        padding: 5px 12px !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
    }
</style>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Car Categories') ?></h2>
            <p><?= __('Manage category policies and services') ?></p>
        </div>
        <?= $this->Html->link(
            '<i class="fas fa-plus"></i> ' . __('New Category'),
            ['action' => 'add'],
            ['class' => 'btn-add', 'escape' => false]
        ) ?>
    </div>

    <!-- Categories DataTable -->
    <div class="table-responsive">
        <table id="carCategoriesTable" class="table datatable-styled">
            <thead>
                <tr>
                    <th class="filterable" data-column="0">
                        <span class="th-text">Name</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Description</th>
                    <th class="filterable" data-column="2">
                        <span class="th-text">Insurance</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Deposit</th>
                    <th class="filterable" data-column="4">
                        <span class="th-text">Chauffeur</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="5">
                        <span class="th-text">GPS</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Cars</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carCategories as $carCategory): ?>
                    <tr>
                        <td>
                            <strong><?= h($carCategory->name) ?></strong>
                        </td>
                        <td class="description-preview">
                            <span class="text-muted">
                                <?= h($carCategory->description ? mb_substr($carCategory->description, 0, 40) . (mb_strlen($carCategory->description) > 40 ? '...' : '') : '—') ?>
                            </span>
                        </td>
                        <td>
                            <?php
                            $tier = strtolower($carCategory->insurance_tier ?: 'basic');
                            $tierColors = ['basic' => 'secondary', 'standard' => 'info', 'premium' => 'warning'];
                            $tierColor = $tierColors[$tier] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?= $tierColor ?> insurance-badge">
                                <?= ucfirst($tier) ?>
                            </span>
                        </td>
                        <td class="price-cell">
                            RM <?= number_format((float)$carCategory->security_deposit, 2) ?>
                        </td>
                        <td>
                            <?php if ($carCategory->chauffeur_available): ?>
                                <span class="status-badge confirmed">
                                    <i class="fas fa-check"></i> Available
                                </span>
                            <?php else: ?>
                                <span class="status-badge cancelled">
                                    <i class="fas fa-times"></i> No
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($carCategory->gps_available): ?>
                                <span class="status-badge confirmed">
                                    <i class="fas fa-check"></i> Available
                                </span>
                            <?php else: ?>
                                <span class="status-badge cancelled">
                                    <i class="fas fa-times"></i> No
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark cars-count-badge">
                                <?= count($carCategory->cars ?? []) ?> cars
                            </span>
                        </td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $carCategory->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $carCategory->id],
                                ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $carCategory->id],
                                [
                                    'class' => 'btn btn-sm btn-outline-danger delete-confirm',
                                    'escape' => false,
                                    'title' => 'Delete',
                                    'data-confirm-message' => __('Are you sure you want to delete {0}?', $carCategory->name)
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        if (typeof $.fn.DataTable !== 'undefined') {
            const table = $('#carCategoriesTable').DataTable({
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search categories..."
                },
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });

            // Column filtering logic is simplified as it is now shared or handled similarly
            document.querySelectorAll('.filterable').forEach(header => {
                const columnIdx = parseInt(header.dataset.column);
                const dropdown = header.querySelector('.column-dropdown');
                const filterIcon = header.querySelector('.filter-icon');

                const uniqueValues = new Set();
                table.column(columnIdx).data().each(val => {
                    const text = $('<div>').html(val).text().trim();
                    if (text && text !== '—') uniqueValues.add(text);
                });

                dropdown.innerHTML = '<div class="filter-option" data-value="">All</div>';
                uniqueValues.forEach(val => {
                    dropdown.innerHTML += `<div class="filter-option" data-value="${val}">${val}</div>`;
                });

                filterIcon.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const wasVisible = dropdown.style.display === 'block';
                    document.querySelectorAll('.column-dropdown').forEach(d => d.style.display = 'none');
                    if (!wasVisible) dropdown.style.display = 'block';
                });

                dropdown.querySelectorAll('.filter-option').forEach(item => {
                    item.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const value = item.dataset.value;
                        table.column(columnIdx).search(value).draw();
                        dropdown.style.display = 'none';
                        if (value) filterIcon.classList.add('filter-active');
                        else filterIcon.classList.remove('filter-active');
                    });
                });
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.filterable')) {
                    document.querySelectorAll('.column-dropdown').forEach(d => d.style.display = 'none');
                }
            });
        }
    });
</script>