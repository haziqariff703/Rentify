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
            <?= $this->Html->link(__('Edit Car'), ['action' => 'edit', $car->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Car'), ['action' => 'delete', $car->id], ['confirm' => __('Are you sure you want to delete # {0}?', $car->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cars'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Car'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cars view content">
            <h3><?= h($car->car_model) ?></h3>
            <table>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= $car->hasValue('category') ? $this->Html->link($car->category->name, ['controller' => 'CarCategories', 'action' => 'view', $car->category->id]) : '' ?></td>
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
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($car->id) ?></td>
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
            <div class="related">
                <h4><?= __('Related Bookings') ?></h4>
                <?php if (!empty($car->bookings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Car Id') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Total Price') ?></th>
                            <th><?= __('Booking Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($car->bookings as $booking) : ?>
                        <tr>
                            <td><?= h($booking->id) ?></td>
                            <td><?= h($booking->user_id) ?></td>
                            <td><?= h($booking->car_id) ?></td>
                            <td><?= h($booking->start_date) ?></td>
                            <td><?= h($booking->end_date) ?></td>
                            <td><?= h($booking->total_price) ?></td>
                            <td><?= h($booking->booking_status) ?></td>
                            <td><?= h($booking->created) ?></td>
                            <td><?= h($booking->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Bookings', 'action' => 'view', $booking->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Bookings', 'action' => 'edit', $booking->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Bookings', 'action' => 'delete', $booking->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $booking->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Maintenances') ?></h4>
                <?php if (!empty($car->maintenances)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Car Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Cost') ?></th>
                            <th><?= __('Maintenance Date') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($car->maintenances as $maintenance) : ?>
                        <tr>
                            <td><?= h($maintenance->id) ?></td>
                            <td><?= h($maintenance->car_id) ?></td>
                            <td><?= h($maintenance->description) ?></td>
                            <td><?= h($maintenance->cost) ?></td>
                            <td><?= h($maintenance->maintenance_date) ?></td>
                            <td><?= h($maintenance->status) ?></td>
                            <td><?= h($maintenance->created) ?></td>
                            <td><?= h($maintenance->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Maintenances', 'action' => 'view', $maintenance->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Maintenances', 'action' => 'edit', $maintenance->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Maintenances', 'action' => 'delete', $maintenance->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $maintenance->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Reviews') ?></h4>
                <?php if (!empty($car->reviews)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Car Id') ?></th>
                            <th><?= __('Rating') ?></th>
                            <th><?= __('Comment') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($car->reviews as $review) : ?>
                        <tr>
                            <td><?= h($review->id) ?></td>
                            <td><?= h($review->user_id) ?></td>
                            <td><?= h($review->car_id) ?></td>
                            <td><?= h($review->rating) ?></td>
                            <td><?= h($review->comment) ?></td>
                            <td><?= h($review->created) ?></td>
                            <td><?= h($review->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Reviews', 'action' => 'view', $review->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Reviews', 'action' => 'edit', $review->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Reviews', 'action' => 'delete', $review->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $review->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>