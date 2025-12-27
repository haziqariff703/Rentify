<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Payment> $payments
 */
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Payments Management') ?></h2>
            <p><?= __('Track and manage all payment transactions') ?></p>
        </div>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New Payment'),
            ['action' => 'add'],
            ['class' => 'btn-add', 'escape' => false]
        ) ?>
    </div>

    <!-- Payments DataTable -->
    <div class="table-responsive">
        <table id="paymentsTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="filterable" data-column="1">
                        <span class="th-text">Booking</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Amount</th>
                    <th class="filterable" data-column="3">
                        <span class="th-text">Method</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Payment Date</th>
                    <th class="filterable" data-column="5">
                        <span class="th-text">Status</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><code>#<?= h($payment->id) ?></code></td>
                        <td>
                            <?php if ($payment->hasValue('booking')): ?>
                                <?= $this->Html->link('#' . $payment->booking->id, ['controller' => 'Bookings', 'action' => 'view', $payment->booking->id]) ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="price-cell">RM <?= $this->Number->format($payment->amount, ['places' => 2]) ?></td>
                        <td>
                            <?php
                            $method = strtolower($payment->payment_method ?? '');
                            $methodIcon = 'fa-university';
                            if (strpos($method, 'card') !== false || strpos($method, 'credit') !== false) {
                                $methodIcon = 'fa-credit-card';
                            } elseif (strpos($method, 'cash') !== false) {
                                $methodIcon = 'fa-money-bill-wave';
                            }
                            ?>
                            <span class="method-badge">
                                <i class="fas <?= $methodIcon ?> me-1"></i>
                                <?= h(ucfirst($payment->payment_method)) ?>
                            </span>
                        </td>
                        <td><?= $payment->payment_date ? (is_object($payment->payment_date) ? $payment->payment_date->format('M d, Y') : date('M d, Y', strtotime($payment->payment_date))) : '-' ?>
                        </td>
                        <td>
                            <?php
                            $status = strtolower($payment->payment_status ?? '');
                            $statusClass = 'pending';
                            if (in_array($status, ['completed', 'paid', 'success']))
                                $statusClass = 'completed';
                            elseif (in_array($status, ['failed', 'cancelled', 'rejected']))
                                $statusClass = 'cancelled';
                            ?>
                            <span
                                class="status-badge <?= $statusClass ?>"><?= h(ucfirst($payment->payment_status)) ?></span>
                        </td>
                        <td><?= $payment->created ? $payment->created->format('M d, Y') : '-' ?></td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $payment->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $payment->id],
                                ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $payment->id],
                                [
                                    'confirm' => __('Are you sure you want to delete payment #{0}?', $payment->id),
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
    window.addEventListener('load', function () {
        if (typeof $ !== 'undefined' && typeof $.fn.dataTable !== 'undefined') {
            var table = $('#paymentsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search payments...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ payments",
                    paginate: { first: "First", last: "Last", next: "Next", previous: "Previous" }
                },
                columnDefs: [{ orderable: false, targets: [7] }],
                order: [[0, 'desc']],
                initComplete: function () {
                    var api = this.api();
                    $('#paymentsTable thead th.filterable').each(function () {
                        var $th = $(this);
                        var columnIndex = $th.data('column');
                        var column = api.column(columnIndex);
                        var $dropdown = $th.find('.column-dropdown');
                        var $filterIcon = $th.find('.filter-icon');
                        $dropdown.append('<div class="filter-option" data-value="">All</div>');
                        column.data().unique().sort().each(function (d) {
                            var text = $('<div>').html(d).text().trim();
                            if (text) $dropdown.append('<div class="filter-option" data-value="' + text + '">' + text + '</div>');
                        });
                        $filterIcon.on('click', function (e) {
                            e.stopPropagation(); e.preventDefault();
                            var wasVisible = $dropdown.is(':visible');
                            $('.column-dropdown').hide();
                            if (!wasVisible) $dropdown.show();
                            return false;
                        });
                        $dropdown.on('click', '.filter-option', function (e) {
                            e.stopPropagation();
                            var val = $(this).data('value');
                            if (val) column.search(val, false, false).draw();
                            else column.search('').draw();
                            $dropdown.hide();
                            if (val) $filterIcon.addClass('filter-active');
                            else $filterIcon.removeClass('filter-active');
                        });
                    });
                    $(document).on('click', function (e) {
                        if (!$(e.target).closest('.column-dropdown, .filter-icon').length) $('.column-dropdown').hide();
                    });
                }
            });
        }
    });
</script>

<style>
    #paymentsTable {
        font-size: 0.9rem;
        border-radius: 12px;
        border-collapse: separate;
        border-spacing: 0;
    }

    #paymentsTable thead {
        overflow: visible;
    }

    #paymentsTable_wrapper {
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

    #paymentsTable thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 600;
        padding: 12px 16px;
        border: none;
    }

    #paymentsTable thead th:first-child {
        border-top-left-radius: 12px;
    }

    #paymentsTable thead th:last-child {
        border-top-right-radius: 12px;
    }

    #paymentsTable tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    #paymentsTable tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    #paymentsTable tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    .price-cell {
        font-weight: 600;
        color: #059669;
    }

    .method-badge {
        background-color: #e0e7ff;
        color: #4338ca;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    #paymentsTable .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    #paymentsTable .status-badge.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    #paymentsTable .status-badge.completed {
        background-color: #dcfce7;
        color: #166534;
    }

    #paymentsTable .status-badge.cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .actions-cell {
        white-space: nowrap;
    }

    .actions-cell .btn {
        margin: 0 2px;
    }

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

    #paymentsTable thead th.filterable {
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