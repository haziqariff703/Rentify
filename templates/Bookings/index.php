<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */

// Check if admin
$identity = $this->request->getAttribute('identity');
$isAdmin = $identity && $identity->role === 'admin';
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Booking Management') ?></h2>
            <p><?= __('Manage all customer bookings') ?></p>
        </div>
        <?php if (!$isAdmin): ?>
            <?= $this->Html->link(
                '<i class="fas fa-plus me-2"></i>' . __('New Booking'),
                ['action' => 'add'],
                ['class' => 'btn-add', 'escape' => false]
            ) ?>
        <?php endif; ?>
    </div>

    <!-- Bookings DataTable -->
    <div class="table-responsive">
        <table id="bookingsTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="filterable" data-column="1">
                        <span class="th-text">Customer</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="2">
                        <span class="th-text">Car</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Price</th>
                    <th class="filterable" data-column="6">
                        <span class="th-text">Status</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Actions</th>
                    <?php if ($isAdmin): ?>
                        <th>Approval</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><code>#<?= h($booking->id) ?></code></td>
                        <td><?= $booking->hasValue('user') ? $this->Html->link($booking->user->name, ['controller' => 'Users', 'action' => 'view', $booking->user->id]) : '' ?></td>
                        <td><?= $booking->hasValue('car') ? $this->Html->link($booking->car->brand . ' ' . $booking->car->car_model, ['controller' => 'Cars', 'action' => 'view', $booking->car->id]) : '' ?></td>
                        <td><?= h($booking->start_date?->format('M d, Y')) ?></td>
                        <td><?= h($booking->end_date?->format('M d, Y')) ?></td>
                        <td class="price-cell">RM <?= $booking->total_price === null ? '0' : $this->Number->format($booking->total_price) ?></td>
                        <td>
                            <?php
                            $statusClass = match ($booking->booking_status) {
                                'pending' => 'pending',
                                'confirmed' => 'confirmed',
                                'cancelled' => 'cancelled',
                                'completed' => 'completed',
                                default => 'default'
                            };
                            ?>
                            <span class="status-badge <?= $statusClass ?>"><?= ucfirst(h($booking->booking_status)) ?></span>
                        </td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $booking->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?php if ($isAdmin): ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit"></i>',
                                    ['action' => 'edit', $booking->id],
                                    ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash"></i>',
                                    ['action' => 'delete', $booking->id],
                                    [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'escape' => false,
                                        'title' => 'Delete',
                                        'confirm' => __('Are you sure you want to delete booking #{0}?', $booking->id),
                                    ]
                                ) ?>
                            <?php endif; ?>
                        </td>
                        <?php if ($isAdmin): ?>
                            <td class="actions-cell">
                                <?php if ($booking->booking_status === 'pending'): ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fas fa-check"></i> Approve',
                                        ['controller' => 'Admins', 'action' => 'approveBooking', $booking->id],
                                        [
                                            'class' => 'btn btn-sm btn-success',
                                            'escape' => false,
                                            'confirm' => __('Approve booking #{0}? This will mark the car as Rented.', $booking->id),
                                        ]
                                    ) ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fas fa-times"></i> Reject',
                                        ['controller' => 'Admins', 'action' => 'rejectBooking', $booking->id],
                                        [
                                            'class' => 'btn btn-sm btn-danger',
                                            'escape' => false,
                                            'confirm' => __('Reject booking #{0}?', $booking->id),
                                        ]
                                    ) ?>
                                <?php elseif ($booking->booking_status === 'confirmed'): ?>
                                    <span class="text-success"><i class="fas fa-check-circle"></i> Approved</span>
                                <?php elseif ($booking->booking_status === 'cancelled'): ?>
                                    <span class="text-danger"><i class="fas fa-times-circle"></i> Rejected</span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        if (typeof $ !== 'undefined' && typeof $.fn.dataTable !== 'undefined') {
            // Determine if we have an approval column (admin view)
            var hasApprovalColumn = $('#bookingsTable thead th').length > 8;
            var nonSortableCols = hasApprovalColumn ? [7, 8] : [7];

            // Initialize DataTable
            var table = $('#bookingsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search bookings...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ bookings",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [{
                    orderable: false,
                    targets: nonSortableCols
                }],
                order: [
                    [0, 'desc']
                ],
                initComplete: function() {
                    var api = this.api();

                    // Build dropdown filters for filterable columns
                    $('#bookingsTable thead th.filterable').each(function() {
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
    /* DataTables Custom Styling */
    #bookingsTable {
        font-size: 0.9rem;
        border-radius: 12px;
        border-collapse: separate;
        border-spacing: 0;
    }

    #bookingsTable thead {
        overflow: visible;
    }

    #bookingsTable_wrapper {
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

    #bookingsTable thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 600;
        padding: 12px 16px;
        border: none;
    }

    /* Rounded corners for table */
    #bookingsTable thead th:first-child {
        border-top-left-radius: 12px;
    }

    #bookingsTable thead th:last-child {
        border-top-right-radius: 12px;
    }

    #bookingsTable tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    #bookingsTable tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    #bookingsTable tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    /* Price Cell */
    .price-cell {
        font-weight: 600;
        color: #059669;
    }

    /* Status Badge - Table Version */
    #bookingsTable .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    #bookingsTable .status-badge.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    #bookingsTable .status-badge.confirmed {
        background-color: #dcfce7;
        color: #166534;
    }

    #bookingsTable .status-badge.completed {
        background-color: #e0e7ff;
        color: #4338ca;
    }

    #bookingsTable .status-badge.cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    #bookingsTable .status-badge.default {
        background-color: #e2e8f0;
        color: #475569;
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
    #bookingsTable thead th.filterable {
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
    #bookingsTable thead th.sorting::after,
    #bookingsTable thead th.sorting_asc::after,
    #bookingsTable thead th.sorting_desc::after {
        margin-left: 6px !important;
    }

    /* Page Header (matching Cars) */
    .crud-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .crud-page-header h2 {
        margin: 0 0 4px 0;
        color: #1e293b;
    }

    .crud-page-header p {
        margin: 0;
        color: #64748b;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        color: white;
    }
</style>