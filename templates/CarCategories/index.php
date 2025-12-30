<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CarCategory> $carCategories
 */
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Car Categories') ?></h2>
            <p><?= __('Manage category policies and services') ?></p>
        </div>
        <?= $this->Html->link(
            __('New Category'),
            ['action' => 'add'],
            ['class' => 'btn-add', 'escape' => false]
        ) ?>
    </div>

    <!-- Categories DataTable -->
    <div class="table-responsive">
        <table id="categoriesTable" class="table table-striped table-hover">
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
                        <td>
                            <span class="text-muted description-cell">
                                <?= h($carCategory->description ? mb_substr($carCategory->description, 0, 40) . (mb_strlen($carCategory->description) > 40 ? '...' : '') : '—') ?>
                            </span>
                        </td>
                        <td>
                            <?php
                            $tierColors = ['basic' => 'secondary', 'standard' => 'info', 'premium' => 'warning'];
                            $tier = $carCategory->insurance_tier ?: 'basic';
                            ?>
                            <span class="badge bg-<?= $tierColors[$tier] ?? 'secondary' ?>">
                                <?= ucfirst($tier) ?>
                            </span>
                        </td>
                        <td class="text-success fw-bold">
                            RM <?= number_format((float)$carCategory->security_deposit, 2) ?>
                        </td>
                        <td>
                            <?php if ($carCategory->chauffeur_available): ?>
                                <span class="service-badge available">
                                    <i class="fas fa-check"></i> Available
                                </span>
                            <?php else: ?>
                                <span class="service-badge unavailable">
                                    <i class="fas fa-times"></i> No
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($carCategory->gps_available): ?>
                                <span class="service-badge available">
                                    <i class="fas fa-check"></i> Available
                                </span>
                            <?php else: ?>
                                <span class="service-badge unavailable">
                                    <i class="fas fa-times"></i> No
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <?= count($carCategory->cars ?? []) ?> cars
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $carCategory->id],
                                    ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-pen"></i>',
                                    ['action' => 'edit', $carCategory->id],
                                    ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false, 'title' => 'Edit']
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash"></i>',
                                    ['action' => 'delete', $carCategory->id],
                                    [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'escape' => false,
                                        'title' => 'Delete',
                                        'confirm' => __('Are you sure you want to delete {0}?', $carCategory->name)
                                    ]
                                ) ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Purple/Indigo Theme for Categories */
    .crud-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .crud-page-header h2 {
        margin: 0;
        color: #1e293b;
    }

    .crud-page-header p {
        margin: 4px 0 0;
        color: #64748b;
    }

    .btn-add {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        color: white;
    }

    /* DataTable Styling */
    #categoriesTable thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 14px 16px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        position: relative;
    }

    #categoriesTable thead th:first-child {
        border-radius: 10px 0 0 0;
    }

    #categoriesTable thead th:last-child {
        border-radius: 0 10px 0 0;
    }

    #categoriesTable tbody tr {
        transition: all 0.2s ease;
    }

    #categoriesTable tbody tr:hover {
        background: #eff6ff;
    }

    #categoriesTable tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Service Badges */
    .service-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .service-badge.available {
        background: #dcfce7;
        color: #166534;
    }

    .service-badge.unavailable {
        background: #f3f4f6;
        color: #6b7280;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
    }

    .action-buttons .btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    /* Filterable Headers */
    .filterable {
        cursor: pointer;
        user-select: none;
    }

    .filterable .filter-icon {
        margin-left: 6px;
        opacity: 0.7;
        font-size: 0.75rem;
    }

    .filterable:hover .filter-icon {
        opacity: 1;
    }

    .column-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        min-width: 150px;
        z-index: 100;
        display: none;
    }

    .column-dropdown.show {
        display: block;
    }

    .column-dropdown .dropdown-item {
        padding: 8px 16px;
        cursor: pointer;
        color: #1e293b;
        transition: background 0.2s;
    }

    .column-dropdown .dropdown-item:hover {
        background: #eff6ff;
    }

    .description-cell {
        font-size: 0.9rem;
    }

    /* DataTables Overrides */
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        if (typeof $.fn.DataTable !== 'undefined') {
            const table = $('#categoriesTable').DataTable({
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

            // Column filtering
            document.querySelectorAll('.filterable').forEach(header => {
                const columnIdx = parseInt(header.dataset.column);
                const dropdown = header.querySelector('.column-dropdown');

                const uniqueValues = new Set();
                table.column(columnIdx).data().each(val => {
                    const text = $('<div>').html(val).text().trim();
                    if (text && text !== '—') uniqueValues.add(text);
                });

                dropdown.innerHTML = '<div class="dropdown-item" data-value="">All</div>';
                uniqueValues.forEach(val => {
                    dropdown.innerHTML += `<div class="dropdown-item" data-value="${val}">${val}</div>`;
                });

                header.addEventListener('click', (e) => {
                    if (e.target.classList.contains('dropdown-item')) return;
                    document.querySelectorAll('.column-dropdown').forEach(d => {
                        if (d !== dropdown) d.classList.remove('show');
                    });
                    dropdown.classList.toggle('show');
                });

                dropdown.querySelectorAll('.dropdown-item').forEach(item => {
                    item.addEventListener('click', () => {
                        const value = item.dataset.value;
                        table.column(columnIdx).search(value).draw();
                        dropdown.classList.remove('show');
                    });
                });
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.filterable')) {
                    document.querySelectorAll('.column-dropdown').forEach(d => d.classList.remove('show'));
                }
            });
        }
    });
</script>