<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CarCategory $carCategory
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Car Category'), ['action' => 'edit', $carCategory->car_category_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Car Category'), ['action' => 'delete', $carCategory->car_category_id], ['confirm' => __('Are you sure you want to delete # {0}?', $carCategory->car_category_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Car Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Car Category'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="carCategories view content">
            <h3><?= h($carCategory->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($carCategory->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Car Category Id') ?></th>
                    <td><?= $this->Number->format($carCategory->car_category_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($carCategory->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($carCategory->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($carCategory->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>