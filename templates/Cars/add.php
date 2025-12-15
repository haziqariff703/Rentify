<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Car $car
 * @var \Cake\Collection\CollectionInterface|string[] $carCategories
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Cars'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cars form content">
            <?= $this->Form->create($car) ?>
            <fieldset>
                <legend><?= __('Add Car') ?></legend>
                <?php
                    echo $this->Form->control('car_category_id', ['options' => $carCategories, 'empty' => true]);
                    echo $this->Form->control('car_model');
                    echo $this->Form->control('plate_number');
                    echo $this->Form->control('brand');
                    echo $this->Form->control('year');
                    echo $this->Form->control('price_per_day');
                    echo $this->Form->control('status');
                    echo $this->Form->control('image');
                    echo $this->Form->control('transmission');
                    echo $this->Form->control('seats');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
