<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>

<div class="container py-4">
    <!-- Page Header -->
    <div class="crud-page-header">
        <div>
            <h2><?= __('User Management') ?></h2>
            <p><?= __('Manage system users and their roles') ?></p>
        </div>
        <?= $this->Html->link(
            '<i class="fas fa-plus me-2"></i>' . __('New User'),
            ['action' => 'add'],
            ['class' => 'btn-add', 'escape' => false]
        ) ?>
    </div>

    <!-- Users DataTable -->
    <div class="table-responsive">
        <table id="usersTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th class="filterable" data-column="1">
                        <span class="th-text">Name</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>IC Number</th>
                    <th class="filterable" data-column="5">
                        <span class="th-text">Role</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th class="filterable" data-column="6">
                        <span class="th-text">Joined</span>
                        <i class="fas fa-filter filter-icon"></i>
                        <div class="column-dropdown"></div>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <?php if (!empty($user->avatar)): ?>
                                <img src="<?= $this->Url->webroot('img/' . h($user->avatar)) ?>"
                                    class="user-avatar"
                                    alt="<?= h($user->name) ?>">
                            <?php else: ?>
                                <div class="user-avatar-placeholder">
                                    <?= strtoupper(substr($user->name ?? $user->email, 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?= h($user->name) ?></td>
                        <td>
                            <a href="mailto:<?= h($user->email) ?>" class="text-decoration-none">
                                <?= h($user->email) ?>
                            </a>
                        </td>
                        <td><?= h($user->phone) ?></td>
                        <td>
                            <code class="ic-masked"><?= h($user->ic_number ? substr($user->ic_number, 0, 6) . '****' : '-') ?></code>
                        </td>
                        <td>
                            <span class="role-badge <?= h($user->role) ?>">
                                <?= h(ucfirst($user->role)) ?>
                            </span>
                        </td>
                        <td data-order="<?= $user->created?->format('Y-m-d') ?>">
                            <span class="date-display"><?= h($user->created?->format('d M Y')) ?></span>
                            <span class="month-hidden" style="display:none;"><?= h($user->created?->format('F Y')) ?></span>
                        </td>
                        <td class="actions-cell">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $user->id],
                                ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false, 'title' => 'View']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $user->id],
                                ['class' => 'btn btn-sm btn-outline-warning', 'escape' => false, 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $user->id],
                                [
                                    'confirm' => __('Are you sure you want to delete {0}?', $user->name ?? $user->email),
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
            var table = $('#usersTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search users...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ users",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [{
                    orderable: false,
                    targets: [0, 7]
                }],
                order: [
                    [6, 'desc']
                ],
                initComplete: function() {
                    var api = this.api();

                    $('#usersTable thead th.filterable').each(function() {
                        var $th = $(this);
                        var columnIndex = $th.data('column');
                        var column = api.column(columnIndex);
                        var $dropdown = $th.find('.column-dropdown');
                        var $filterIcon = $th.find('.filter-icon');

                        $dropdown.append('<div class="filter-option" data-value="">All</div>');

                        // Special handling for month filter (column 6)
                        if (columnIndex === 6) {
                            // Get unique months from the hidden span
                            var months = [];
                            $('#usersTable tbody tr').each(function() {
                                var monthText = $(this).find('.month-hidden').text().trim();
                                if (monthText && months.indexOf(monthText) === -1) {
                                    months.push(monthText);
                                }
                            });
                            months.sort().reverse().forEach(function(month) {
                                $dropdown.append('<div class="filter-option" data-value="' + month + '">' + month + '</div>');
                            });
                        } else {
                            column.data().unique().sort().each(function(d) {
                                var text = $('<div>').html(d).text().trim();
                                if (text) {
                                    $dropdown.append('<div class="filter-option" data-value="' + text + '">' + text + '</div>');
                                }
                            });
                        }

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
    /* DataTables Custom Styling for Users */
    #usersTable {
        font-size: 0.9rem;
        border-radius: 12px;
        border-collapse: separate;
        border-spacing: 0;
    }

    #usersTable thead {
        overflow: visible;
    }

    #usersTable_wrapper {
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

    #usersTable thead th {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 600;
        padding: 12px 16px;
        border: none;
    }

    #usersTable thead th:first-child {
        border-top-left-radius: 12px;
    }

    #usersTable thead th:last-child {
        border-top-right-radius: 12px;
    }

    #usersTable tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    #usersTable tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    #usersTable tbody tr:hover {
        background-color: #f5f3ff !important;
    }

    /* User Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .user-avatar-placeholder {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1rem;
    }

    /* Role Badge */
    .role-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-badge.admin {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .role-badge.user,
    .role-badge.customer {
        background-color: #dbeafe;
        color: #1e40af;
    }

    /* IC Masked */
    .ic-masked {
        font-size: 0.85rem;
        background-color: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
    }

    /* Date Display */
    .date-display {
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
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }

    /* DataTables Pagination */
    .dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        margin: 0 2px !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important;
        border-color: #8b5cf6 !important;
        color: white !important;
    }

    .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #f5f3ff !important;
        border-color: #f5f3ff !important;
        color: #7c3aed !important;
    }

    /* Filter Dropdown Styles */
    #usersTable thead th.filterable {
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
        background: #f5f3ff;
        color: #7c3aed;
    }

    .filter-option:first-child {
        font-weight: 600;
        color: #64748b;
    }
</style>