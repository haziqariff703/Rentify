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
        <table id="invoicesTable" class="table datatable-styled">
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
                        <td data-order="<?= h($invoice->id) ?>"><code>#<?= h($invoice->id) ?></code></td>
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
                            <?= $this->Status->paymentBadge($invoice->status) ?>
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
                                    'class' => 'btn btn-sm btn-outline-danger delete-confirm',
                                    'escape' => false,
                                    'title' => 'Delete',
                                    'data-confirm-message' => __('Are you sure you want to delete invoice #{0}?', $invoice->id)
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
            var table = $('#invoicesTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search invoices...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ invoices",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [{
                    orderable: false,
                    targets: [6]
                }],
                order: [
                    [0, 'desc']
                ],
                initComplete: function() {
                    var api = this.api();
                    $('#invoicesTable thead th.filterable').each(function() {
                        var $th = $(this);
                        var columnIndex = $th.data('column');
                        var column = api.column(columnIndex);
                        var $dropdown = $th.find('.column-dropdown');
                        var $filterIcon = $th.find('.filter-icon');
                        $dropdown.append('<div class="filter-option" data-value="">All</div>');
                        column.data().unique().sort().each(function(d) {
                            var text = $('<div>').html(d).text().trim();
                            if (text) $dropdown.append('<div class="filter-option" data-value="' + text + '">' + text + '</div>');
                        });
                        $filterIcon.on('click', function(e) {
                            e.stopPropagation();
                            e.preventDefault();
                            var wasVisible = $dropdown.is(':visible');
                            $('.column-dropdown').hide();
                            if (!wasVisible) $dropdown.show();
                            return false;
                        });
                        $dropdown.on('click', '.filter-option', function(e) {
                            e.stopPropagation();
                            var val = $(this).data('value');
                            if (val) column.search(val, false, false).draw();
                            else column.search('').draw();
                            $dropdown.hide();
                            if (val) $filterIcon.addClass('filter-active');
                            else $filterIcon.removeClass('filter-active');
                        });
                    });
                    $(document).on('click', function(e) {
                        if (!$(e.target).closest('.column-dropdown, .filter-icon').length) $('.column-dropdown').hide();
                    });
                }
            });
        }
    });
</script>

<style>
    .invoice-number {
        background: #f1f5f9;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
    }
</style>