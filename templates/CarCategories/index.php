<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CarCategory> $carCategories
 */
?>
<div class="carCategories index content">
    <?= $this->Html->link(__('New Car Category'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Car Categories') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('car_category_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carCategories as $carCategory): ?>
                <tr>
                    <td><?= $this->Number->format($carCategory->car_category_id) ?></td>
                    <td><?= h($carCategory->name) ?></td>
                    <td><?= h($carCategory->created) ?></td>
                    <td><?= h($carCategory->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $carCategory->car_category_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $carCategory->car_category_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $carCategory->car_category_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $carCategory->car_category_id),
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