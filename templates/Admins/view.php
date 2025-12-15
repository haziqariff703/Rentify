<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin $admin
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Admin'), ['action' => 'edit', $admin->admin_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Admin'), ['action' => 'delete', $admin->admin_id], ['confirm' => __('Are you sure you want to delete # {0}?', $admin->admin_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Admins'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Admin'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="admins view content">
            <h3><?= h($admin->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($admin->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($admin->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($admin->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Avatar') ?></th>
                    <td><?= h($admin->avatar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Admin Id') ?></th>
                    <td><?= $this->Number->format($admin->admin_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($admin->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($admin->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>