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

<script>
    window.addEventListener('load', function() {
        if (typeof $ !== 'undefined' && typeof $.fn.dataTable !== 'undefined') {
            // Initialize DataTable
            var table = $('#carsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search cars...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ cars",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [{
                    orderable: false,
                    targets: [0, 8, 9]
                }],
                order: [
                    [1, 'asc']
                ],
                initComplete: function() {
                    var api = this.api();

                    // Build dropdown filters for filterable columns
                    $('#carsTable thead th.filterable').each(function() {
                        var $th = $(this);
                        var columnIndex = $th.data('column');
                        var column = api.column(columnIndex);
                        var $dropdown = $th.find('.column-dropdown');
                        var $filterIcon = $th.find('.filter-icon');

                        // Add "All" option
                        $dropdown.append('<div class="filter-option" data-value="">All</div>');

                        // Populate with unique values
                        column.data().unique().sort().each(function(d) {
                            var text = $('<div>').html(d).text().trim();
                            if (text) {
                                $dropdown.append('<div class="filter-option" data-value="' + text + '">' + text + '</div>');
                            }
                        });

                        // Toggle dropdown ONLY on filter icon click
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

                        // Apply filter on option click
                        $dropdown.on('click', '.filter-option', function(e) {
                            e.stopPropagation();
                            var val = $(this).data('value');

                            // Use contains search for better matching
                            if (val) {
                                column.search(val, false, false).draw();
                            } else {
                                column.search('').draw();
                            }
                            $dropdown.hide();

                            // Update icon to show active filter
                            if (val) {
                                $filterIcon.addClass('filter-active');
                            } else {
                                $filterIcon.removeClass('filter-active');
                            }
                        });
                    });

                    // Close dropdowns when clicking outside
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

    /* DataTables Custom Styling */
    #carsTable {
        font-size: 0.9rem;
        border-radius: 12px;
        border-collapse: separate;
        border-spacing: 0;
    }

    #carsTable thead {
        overflow: visible;
    }

    #carsTable_wrapper {
        padding: 10px 0;
        overflow: visible;
    }

    .table-responsive {
        overflow: visible !important;
    }

    /* Show entries gap fix */
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

    #carsTable thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 600;
        padding: 12px 16px;
        border: none;
    }

    /* Rounded corners for table */
    #carsTable thead th:first-child {
        border-top-left-radius: 12px;
    }

    #carsTable thead th:last-child {
        border-top-right-radius: 12px;
    }

    #carsTable tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    #carsTable tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    #carsTable tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    /* Car Thumbnail */
    .car-thumbnail {
        width: 70px;
        height: 45px;
        object-fit: cover;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .car-thumbnail-placeholder {
        width: 70px;
        height: 45px;
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 1.2rem;
    }

    /* Category Badge */
    .category-badge {
        background-color: #e0e7ff;
        color: #4338ca;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Price Cell */
    .price-cell {
        font-weight: 600;
        color: #059669;
    }

    /* Status Badge - Table Version */
    #carsTable .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    #carsTable .status-badge.available {
        background-color: #dcfce7;
        color: #166534;
    }

    #carsTable .status-badge.rented {
        background-color: #fef3c7;
        color: #92400e;
    }

    #carsTable .status-badge.maintenance {
        background-color: #fee2e2;
        color: #991b1b;
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
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* DataTables Length Select */
    .dataTables_length select {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 6px 12px;
        margin: 0 8px;
    }

    /* DataTables Pagination */
    .dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        margin: 0 2px !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        border-color: #3b82f6 !important;
        color: white !important;
    }

    .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #e0e7ff !important;
        border-color: #e0e7ff !important;
        color: #3b82f6 !important;
    }

    /* Header Filter Styling */
    #carsTable thead th.filterable {
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
        background: #f0f9ff;
        color: #1d4ed8;
    }

    .filter-option:first-child {
        font-weight: 600;
        color: #64748b;
    }

    /* DataTables sort icon spacing */
    #carsTable thead th.sorting::after,
    #carsTable thead th.sorting_asc::after,
    #carsTable thead th.sorting_desc::after {
        margin-left: 6px !important;
    }

    /* Booking Count Badge */
    .booking-count-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    .booking-count-badge.active {
        background-color: #fef3c7;
        color: #92400e;
    }

    .booking-count-badge.empty {
        background-color: #f1f5f9;
        color: #94a3b8;
    }
</style>