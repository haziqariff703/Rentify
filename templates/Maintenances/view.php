<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Maintenance $maintenance
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Maintenance'), ['action' => 'edit', $maintenance->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Maintenance'), ['action' => 'delete', $maintenance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $maintenance->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Maintenances'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Maintenance'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="maintenances view content">
            <h3><?= h($maintenance->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Car') ?></th>
                    <td><?= $maintenance->hasValue('car') ? $this->Html->link($maintenance->car->car_model, ['controller' => 'Cars', 'action' => 'view', $maintenance->car->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($maintenance->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($maintenance->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cost') ?></th>
                    <td><?= $maintenance->cost === null ? '' : $this->Number->format($maintenance->cost) ?></td>
                </tr>
                <tr>
                    <th><?= __('Maintenance Date') ?></th>
                    <td><?= h($maintenance->maintenance_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($maintenance->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($maintenance->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($maintenance->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>