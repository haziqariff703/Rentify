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

<script>
    window.addEventListener('load', function() {
        if (typeof $ !== 'undefined' && typeof $.fn.dataTable !== 'undefined') {
            var table = $('#maintenancesTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search maintenance records...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [{
                    orderable: false,
                    targets: [5, 6]
                }],
                order: [
                    [3, 'desc']
                ],
                initComplete: function() {
                    var api = this.api();

                    $('#maintenancesTable thead th.filterable').each(function() {
                        var $th = $(this);
                        var columnIndex = $th.data('column');
                        var column = api.column(columnIndex);
                        var $dropdown = $th.find('.column-dropdown');
                        var $filterIcon = $th.find('.filter-icon');

                        $dropdown.append('<div class="filter-option" data-value="">All</div>');

                        column.data().unique().sort().each(function(d) {
                            var text = $('<div>').html(d).text().trim();
                            if (text) {
                                $dropdown.append('<div class="filter-option" data-value="' + text + '">' + text + '</div>');
                            }
                        });

                        $filterIcon.on('click', function(e) {
                            e.stopPropagation();
                            e.preventDefault();
                            var wasVisible = $dropdown.is(':visible');
                            $('.column-dropdown').hide();
                            if (!wasVisible) {
                                $dropdown.show();
                            }
                            return false;
                        });

                        $dropdown.on('click', '.filter-option', function(e) {
                            e.stopPropagation();
                            var val = $(this).data('value');

                            if (val) {
                                column.search(val, false, false).draw();
                            } else {
                                column.search('').draw();
                            }
                            $dropdown.hide();

                            if (val) {
                                $filterIcon.addClass('filter-active');
                            } else {
                                $filterIcon.removeClass('filter-active');
                            }
                        });
                    });

                    $(document).on('click', function(e) {
                        if (!$(e.target).closest('.column-dropdown, .filter-icon').length) {
                            $('.column-dropdown').hide();
                        }
                    });
                }
            });
        }
    });
</script>

<style>
    /* DataTables Custom Styling for Maintenances */
    #maintenancesTable {
        font-size: 0.9rem;
        border-radius: 12px;
        border-collapse: separate;
        border-spacing: 0;
    }

    #maintenancesTable thead {
        overflow: visible;
    }

    #maintenancesTable_wrapper {
        padding: 10px 0;
        overflow: visible;
    }

    .table-responsive {
        overflow: visible !important;
    }

    .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dataTables_length select {
        min-width: 70px;
        padding: 6px 12px;
        margin: 0 10px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }

    #maintenancesTable thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 600;
        padding: 12px 16px;
        border: none;
    }

    #maintenancesTable thead th:first-child {
        border-top-left-radius: 12px;
    }

    #maintenancesTable thead th:last-child {
        border-top-right-radius: 12px;
    }

    #maintenancesTable tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    #maintenancesTable tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    #maintenancesTable tbody tr:hover {
        background-color: #fffbeb !important;
    }

    /* Price Cell */
    .price-cell {
        font-weight: 600;
        color: #dc2626;
    }

    /* Status Badge */
    #maintenancesTable .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    #maintenancesTable .status-badge.completed {
        background-color: #dcfce7;
        color: #166534;
    }

    #maintenancesTable .status-badge.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    #maintenancesTable .status-badge.in_progress,
    #maintenancesTable .status-badge.in-progress {
        background-color: #dbeafe;
        color: #1e40af;
    }

    /* Description Preview */
    .description-preview {
        color: #64748b;
        font-size: 0.85rem;
    }

    /* Actions Cell */
    .actions-cell {
        white-space: nowrap;
    }

    .actions-cell .btn {
        margin: 0 2px;
    }

    /* DataTables Search Box */
    .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 16px;
        margin-left: 8px;
    }

    .dataTables_filter input:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    /* DataTables Pagination */
    .dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        margin: 0 2px !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        border-color: #f59e0b !important;
        color: white !important;
    }

    .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #fef3c7 !important;
        border-color: #fef3c7 !important;
        color: #92400e !important;
    }

    /* Filter Dropdown Styles */
    #maintenancesTable thead th.filterable {
        position: relative;
    }

    .th-text {
        margin-right: 8px;
    }

    .filter-icon {
        font-size: 0.7rem;
        opacity: 0.5;
        cursor: pointer;
        padding: 4px 6px;
        border-radius: 4px;
        transition: all 0.2s;
        margin-left: 8px;
    }

    .filter-icon:hover {
        opacity: 1;
        background: rgba(255, 255, 255, 0.2);
    }

    .filter-icon.filter-active {
        opacity: 1;
        color: #fbbf24;
        background: rgba(255, 255, 255, 0.2);
    }

    .column-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 150px;
        max-height: 250px;
        overflow-y: auto;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        margin-top: 4px;
    }

    .filter-option {
        padding: 10px 14px;
        cursor: pointer;
        font-size: 0.85rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }

    .filter-option:last-child {
        border-bottom: none;
    }

    .filter-option:hover {
        background: #fffbeb;
        color: #92400e;
    }

    .filter-option:first-child {
        font-weight: 600;
        color: #64748b;
    }
</style>