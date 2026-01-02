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
                                    'class' => 'btn btn-sm btn-outline-danger delete-confirm',
                                    'escape' => false,
                                    'title' => 'Delete',
                                    'data-confirm-message' => __('Are you sure you want to delete {0}?', $user->name)
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- DataTables styling and initialization handled by shared files: datatables-custom.css and datatables-init.js -->