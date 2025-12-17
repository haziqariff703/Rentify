<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Maintenance> $maintenances
 */
?>
<div class="maintenances index content">
    <?= $this->Html->link(__('New Maintenance'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Maintenances') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('car_id') ?></th>
                    <th><?= $this->Paginator->sort('cost') ?></th>
                    <th><?= $this->Paginator->sort('maintenance_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($maintenances as $maintenance): ?>
                <tr>
                    <td><?= $this->Number->format($maintenance->id) ?></td>
                    <td><?= $maintenance->hasValue('car') ? $this->Html->link($maintenance->car->car_model, ['controller' => 'Cars', 'action' => 'view', $maintenance->car->id]) : '' ?></td>
                    <td><?= $maintenance->cost === null ? '' : $this->Number->format($maintenance->cost) ?></td>
                    <td><?= h($maintenance->maintenance_date) ?></td>
                    <td><?= h($maintenance->status) ?></td>
                    <td><?= h($maintenance->created) ?></td>
                    <td><?= h($maintenance->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $maintenance->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $maintenance->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $maintenance->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $maintenance->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>