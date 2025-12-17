<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Maintenance $maintenance
 * @var string[]|\Cake\Collection\CollectionInterface $cars
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $maintenance->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $maintenance->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Maintenances'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="maintenances form content">
            <?= $this->Form->create($maintenance) ?>
            <fieldset>
                <legend><?= __('Edit Maintenance') ?></legend>
                <?php
                    echo $this->Form->control('car_id', ['options' => $cars]);
                    echo $this->Form->control('description');
                    echo $this->Form->control('cost');
                    echo $this->Form->control('maintenance_date', ['empty' => true]);
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
