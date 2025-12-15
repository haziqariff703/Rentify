<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Car $car
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Car'), ['action' => 'edit', $car->car_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Car'), ['action' => 'delete', $car->car_id], ['confirm' => __('Are you sure you want to delete # {0}?', $car->car_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cars'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Car'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cars view content">
            <h3><?= h($car->car_model) ?></h3>
            <table>
                <tr>
                    <th><?= __('Car Category') ?></th>
                    <td><?= $car->hasValue('car_category') ? $this->Html->link($car->car_category->name, ['controller' => 'CarCategories', 'action' => 'view', $car->car_category->car_category_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Car Model') ?></th>
                    <td><?= h($car->car_model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Plate Number') ?></th>
                    <td><?= h($car->plate_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Brand') ?></th>
                    <td><?= h($car->brand) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($car->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image') ?></th>
                    <td><?= h($car->image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Transmission') ?></th>
                    <td><?= h($car->transmission) ?></td>
                </tr>
                <tr>
                    <th><?= __('Car Id') ?></th>
                    <td><?= $this->Number->format($car->car_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Year') ?></th>
                    <td><?= $car->year === null ? '' : $this->Number->format($car->year) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price Per Day') ?></th>
                    <td><?= $car->price_per_day === null ? '' : $this->Number->format($car->price_per_day) ?></td>
                </tr>
                <tr>
                    <th><?= __('Seats') ?></th>
                    <td><?= $this->Number->format($car->seats) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($car->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($car->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>