<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $cars
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $booking->booking_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $booking->booking_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Bookings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookings form content">
            <?= $this->Form->create($booking) ?>
            <fieldset>
                <legend><?= __('Edit Booking') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('car_id', ['options' => $cars]);
                    echo $this->Form->control('start_date');
                    echo $this->Form->control('end_date');
                    echo $this->Form->control('total_price');
                    echo $this->Form->control('booking_status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
