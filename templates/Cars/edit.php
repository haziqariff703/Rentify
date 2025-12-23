<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Car $car
 * @var string[]|\Cake\Collection\CollectionInterface $categories
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $car->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $car->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Cars'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cars form content">
            <?= $this->Form->create($car) ?>
            <fieldset>
                <legend><?= __('Edit Car') ?></legend>
                <?php
                echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true]);
                echo $this->Form->control('car_model');
                echo $this->Form->control('plate_number');
                echo $this->Form->control('brand');
                echo $this->Form->control('year');
                echo $this->Form->control('price_per_day');
                echo $this->Form->control('status');
                echo $this->Form->control('image', ['label' => 'Image Filename', 'placeholder' => 'e.g. ferrari-f8.jpg']);
                echo $this->Form->control('transmission');
                echo $this->Form->control('seats');
                echo $this->Form->control('engine', ['placeholder' => 'e.g. 5.2L V10']);
                echo $this->Form->control('zero_to_sixty', ['label' => '0-60 Time', 'placeholder' => 'e.g. 2.9s']);
                echo $this->Form->control('badge_color', ['label' => 'Badge Color (Hex)', 'placeholder' => 'e.g. #ef4444']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>