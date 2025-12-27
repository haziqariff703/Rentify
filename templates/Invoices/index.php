<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Invoice> $invoices
 */
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Invoice Management') ?></h2>
            <p><?= __('Manage billing and invoices') ?></p>
        </div>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New Invoice'),
            ['action' => 'add'],
            ['class' => 'btn-add', 'escape' => false]
        ) ?>
    </div>

    <!-- Invoices DataTable -->
    <div class="table-responsive">
        <table id="invoicesTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="filterable" data-column="1">
                        <span class="th-text">Booking</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Invoice #</th>
                    <th>Amount</th>
                    <th class="filterable" data-column="4">
                        <span class="th-text">Status</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice): ?>
                    <tr>
                        <td><code>#<?= h($invoice->id) ?></code></td>
                        <td>
                            <?php if ($invoice->hasValue('booking')): ?>
                                <?= $this->Html->link('#' . $invoice->booking->id, ['controller' => 'Bookings', 'action' => 'view', $invoice->booking->id]) ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><code class="invoice-number"><?= h($invoice->invoice_number) ?></code></td>
                        <td class="price-cell">RM <?= $this->Number->format($invoice->amount, ['places' => 2]) ?></td>
                        <td>
                            <?php
                            $status = strtolower($invoice->status ?? '');
                            $statusClass = 'pending';
                            if (in_array($status, ['paid', 'completed']))
                                $statusClass = 'paid';
                            elseif (in_array($status, ['cancelled', 'voided']))
                                $statusClass = 'cancelled';
                            ?>
                            <span class="status-badge <?= $statusClass ?>"><?= h(ucfirst($invoice->status)) ?></span>
                        </td>
                        <td><?= $invoice->created ? $invoice->created->format('M d, Y') : '-' ?></td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $invoice->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $invoice->id],
                                ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $invoice->id],
                                [
                                    'confirm' => __('Are you sure you want to delete invoice #{0}?', $invoice->id),
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
            var table = $('#invoicesTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search invoices...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ invoices",
                    paginate: { first: "First", last: "Last", next: "Next", previous: "Previous" }
                },
                columnDefs: [{ orderable: false, targets: [6] }],
                order: [[0, 'desc']],
                initComplete: function () {
                    var api = this.api();
                    $('#invoicesTable thead th.filterable').each(function () {
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
    #invoicesTable {
        font-size: 0.9rem;
        border-radius: 12px;
        border-collapse: separate;
        border-spacing: 0;
    }

    #invoicesTable thead {
        overflow: visible;
    }

    #invoicesTable_wrapper {
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

    #invoicesTable thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 600;
        padding: 12px 16px;
        border: none;
    }

    #invoicesTable thead th:first-child {
        border-top-left-radius: 12px;
    }

    #invoicesTable thead th:last-child {
        border-top-right-radius: 12px;
    }

    #invoicesTable tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    #invoicesTable tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    #invoicesTable tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    .price-cell {
        font-weight: 600;
        color: #059669;
    }

    .invoice-number {
        background: #f1f5f9;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    #invoicesTable .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    #invoicesTable .status-badge.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    #invoicesTable .status-badge.paid {
        background-color: #dcfce7;
        color: #166534;
    }

    #invoicesTable .status-badge.cancelled {
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

    #invoicesTable thead th.filterable {
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