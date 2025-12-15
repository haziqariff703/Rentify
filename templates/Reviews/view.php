<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Review'), ['action' => 'edit', $review->review_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Review'), ['action' => 'delete', $review->review_id], ['confirm' => __('Are you sure you want to delete # {0}?', $review->review_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Reviews'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Review'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reviews view content">
            <h3><?= h($review->review_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $review->hasValue('user') ? $this->Html->link($review->user->name, ['controller' => 'Users', 'action' => 'view', $review->user->user_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Car') ?></th>
                    <td><?= $review->hasValue('car') ? $this->Html->link($review->car->car_model, ['controller' => 'Cars', 'action' => 'view', $review->car->car_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Review Id') ?></th>
                    <td><?= $this->Number->format($review->review_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rating') ?></th>
                    <td><?= $review->rating === null ? '' : $this->Number->format($review->rating) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($review->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($review->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Comment') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($review->comment)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>