<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Review> $reviews
 */
?>
<div class="reviews index content">
    <?= $this->Html->link(__('New Review'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reviews') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('review_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('car_id') ?></th>
                    <th><?= $this->Paginator->sort('rating') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?= $this->Number->format($review->review_id) ?></td>
                    <td><?= $review->hasValue('user') ? $this->Html->link($review->user->name, ['controller' => 'Users', 'action' => 'view', $review->user->user_id]) : '' ?></td>
                    <td><?= $review->hasValue('car') ? $this->Html->link($review->car->car_model, ['controller' => 'Cars', 'action' => 'view', $review->car->car_id]) : '' ?></td>
                    <td><?= $review->rating === null ? '' : $this->Number->format($review->rating) ?></td>
                    <td><?= h($review->created) ?></td>
                    <td><?= h($review->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $review->review_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $review->review_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $review->review_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $review->review_id),
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