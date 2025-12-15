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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $carCategory->car_category_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $carCategory->car_category_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Car Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="carCategories form content">
            <?= $this->Form->create($carCategory) ?>
            <fieldset>
                <legend><?= __('Edit Car Category') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
