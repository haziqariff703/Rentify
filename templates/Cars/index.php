<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Car> $cars
 */
?>
<div class="cars index content">
    <?= $this->Html->link(__('New Car'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cars') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('category_id') ?></th>
                    <th><?= $this->Paginator->sort('car_model') ?></th>
                    <th><?= $this->Paginator->sort('plate_number') ?></th>
                    <th><?= $this->Paginator->sort('brand') ?></th>
                    <th><?= $this->Paginator->sort('year') ?></th>
                    <th><?= $this->Paginator->sort('price_per_day') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('image') ?></th>
                    <th><?= $this->Paginator->sort('transmission') ?></th>
                    <th><?= $this->Paginator->sort('seats') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?= $this->Number->format($car->id) ?></td>
                    <td><?= $car->hasValue('category') ? $this->Html->link($car->category->name, ['controller' => 'CarCategories', 'action' => 'view', $car->category->id]) : '' ?></td>
                    <td><?= h($car->car_model) ?></td>
                    <td><?= h($car->plate_number) ?></td>
                    <td><?= h($car->brand) ?></td>
                    <td><?= $car->year === null ? '' : $this->Number->format($car->year) ?></td>
                    <td><?= $car->price_per_day === null ? '' : $this->Number->format($car->price_per_day) ?></td>
                    <td><?= h($car->status) ?></td>
                    <td><?= h($car->image) ?></td>
                    <td><?= h($car->transmission) ?></td>
                    <td><?= $this->Number->format($car->seats) ?></td>
                    <td><?= h($car->created) ?></td>
                    <td><?= h($car->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $car->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $car->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $car->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $car->id),
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