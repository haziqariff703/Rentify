<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Review> $reviews
 */
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('Reviews Management') ?></h2>
            <p><?= __('Manage customer reviews and ratings') ?></p>
        </div>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New Review'),
            ['action' => 'add'],
            ['class' => 'btn-add', 'escape' => false]
        ) ?>
    </div>

    <!-- Reviews DataTable -->
    <div class="table-responsive">
        <table id="reviewsTable" class="table table-striped table-hover">
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
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><code>#<?= h($review->id) ?></code></td>
                        <td><?= $review->hasValue('user') ? $this->Html->link($review->user->name, ['controller' => 'Users', 'action' => 'view', $review->user->id]) : '' ?>
                        </td>
                        <td><?= $review->hasValue('car') ? $this->Html->link($review->car->car_model, ['controller' => 'Cars', 'action' => 'view', $review->car->id]) : '' ?>
                        </td>
                        <td>
                            <span class="rating-stars">
                                <?php
                                $rating = $review->rating ?? 0;
                                for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?= $i <= $rating ? 'text-warning' : 'text-muted' ?>"></i>
                                <?php endfor; ?>
                                <span class="ms-1">(<?= $rating ?>)</span>
                            </span>
                        </td>
                        <td class="comment-cell">
                            <?= h(substr($review->comment ?? '', 0, 50)) ?>    <?= strlen($review->comment ?? '') > 50 ? '...' : '' ?>
                        </td>
                        <td><?= $review->created ? $review->created->format('M d, Y') : '-' ?></td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $review->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $review->id],
                                ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $review->id],
                                [
                                    'confirm' => __('Are you sure you want to delete review #{0}?', $review->id),
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
            var table = $('#reviewsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search reviews...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ reviews",
                    paginate: { first: "First", last: "Last", next: "Next", previous: "Previous" }
                },
                columnDefs: [{ orderable: false, targets: [6] }],
                order: [[0, 'desc']],
                initComplete: function () {
                    var api = this.api();
                    $('#reviewsTable thead th.filterable').each(function () {
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
    #reviewsTable {
        font-size: 0.9rem;
        border-radius: 12px;
        border-collapse: separate;
        border-spacing: 0;
    }

    #reviewsTable thead {
        overflow: visible;
    }

    #reviewsTable_wrapper {
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

    #reviewsTable thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 600;
        padding: 12px 16px;
        border: none;
    }

    #reviewsTable thead th:first-child {
        border-top-left-radius: 12px;
    }

    #reviewsTable thead th:last-child {
        border-top-right-radius: 12px;
    }

    #reviewsTable tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    #reviewsTable tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    #reviewsTable tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    .rating-stars {
        display: inline-flex;
        align-items: center;
        gap: 2px;
        font-size: 0.85rem;
    }

    .rating-stars .fa-star {
        font-size: 0.75rem;
    }

    .comment-cell {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #64748b;
        font-size: 0.85rem;
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

    #reviewsTable thead th.filterable {
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