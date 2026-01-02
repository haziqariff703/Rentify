<?php

/**
 * Booking Edit - Admin Interface (Following Cars/edit.php Layout)
 * 
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $cars
 */

$statusOptions = [
    'pending' => 'Pending',
    'confirmed' => 'Confirmed',
    'completed' => 'Completed',
    'cancelled' => 'Cancelled'
];

$locationOptions = [
    'airport' => 'Airport Terminal 1',
    'city' => 'City Center HQ',
    'north' => 'Northern Branch',
    'south' => 'Southern Outlet'
];
?>

<div class="edit-booking-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2><?= __('Edit Booking') ?></h2>
            <p class="text-muted">Booking #<?= h($booking->id) ?> • Created <?= h($booking->created?->format('M d, Y')) ?></p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-eye me-2"></i>' . __('View Booking'),
                ['action' => 'view', $booking->id],
                ['class' => 'btn btn-outline-primary', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <?= $this->Form->create($booking, ['class' => 'edit-form']) ?>

    <div class="form-grid">
        <!-- Left Column: Customer & Vehicle -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-user me-2"></i><?= __('Customer & Vehicle') ?></h5>
            </div>
            <div class="card-body">
                <table class="form-table">
                    <tr>
                        <th><?= __('Customer') ?></th>
                        <td><?= $this->Form->control('user_id', [
                                'options' => $users,
                                'empty' => '-- Select Customer --',
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Vehicle') ?></th>
                        <td><?= $this->Form->control('car_id', [
                                'options' => $cars,
                                'empty' => '-- Select Vehicle --',
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td><?= $this->Form->control('booking_status', [
                                'options' => $statusOptions,
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Right Column: Rental Period -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-calendar-alt me-2"></i><?= __('Rental Period') ?></h5>
            </div>
            <div class="card-body">
                <table class="form-table">
                    <tr>
                        <th><?= __('Pick-up Date') ?></th>
                        <td><?= $this->Form->control('start_date', [
                                'label' => false,
                                'class' => 'form-control',
                                'type' => 'date'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Return Date') ?></th>
                        <td><?= $this->Form->control('end_date', [
                                'label' => false,
                                'class' => 'form-control',
                                'type' => 'date'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Pick-up Location') ?></th>
                        <td><?= $this->Form->control('pickup_location', [
                                'options' => $locationOptions,
                                'empty' => '-- Select Location --',
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Full Width: Pricing -->
        <div class="form-card full-width">
            <div class="card-header">
                <h5><i class="fas fa-money-bill-wave me-2"></i><?= __('Pricing') ?></h5>
            </div>
            <div class="card-body">
                <div class="pricing-section">
                    <div class="pricing-info">
                        <p class="pricing-hint">
                            <i class="fas fa-info-circle me-2"></i>
                            The total price is calculated based on the daily rate and rental duration.
                            You can manually override it below if needed.
                        </p>
                    </div>
                    <div class="pricing-input">
                        <label class="pricing-label"><?= __('Total Price (RM)') ?></label>
                        <?= $this->Form->control('total_price', [
                            'label' => false,
                            'class' => 'form-control form-control-lg price-input',
                            'type' => 'number',
                            'step' => '0.01',
                            'min' => 0
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <?= $this->Form->button(
            __('Save Changes'),
            ['class' => 'btn btn-primary btn-lg', 'escape' => false]
        ) ?>
        <?= $this->Form->postLink(
            __('Delete Booking'),
            ['action' => 'delete', $booking->id],
            [
                'class' => 'btn btn-outline-danger btn-lg delete-confirm',
                'escape' => false,
                'data-confirm-message' => __('Are you sure you want to delete this booking?')
            ]
        ) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .edit-booking-container {
        font-family: 'Inter', sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header h2 {
        margin: 0;
        color: #1e293b;
    }

    .page-header .text-muted {
        margin: 5px 0 0;
        color: #64748b;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .form-card.full-width {
        grid-column: 1 / -1;
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 16px 20px;
    }

    .form-card .card-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .form-card .card-body {
        padding: 20px;
    }

    .form-table {
        width: 100%;
        border-collapse: collapse;
    }

    .form-table tr {
        border-bottom: 1px solid #f1f5f9;
    }

    .form-table tr:last-child {
        border-bottom: none;
    }

    .form-table th {
        text-align: left;
        padding: 14px 16px 14px 0;
        width: 140px;
        color: #475569;
        font-weight: 500;
        vertical-align: middle;
    }

    .form-table td {
        padding: 14px 0;
    }

    .form-table .form-control,
    .form-table .form-select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-table .form-control:focus,
    .form-table .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        outline: none;
    }

    /* Pricing Section */
    .pricing-section {
        display: flex;
        gap: 40px;
        align-items: center;
        flex-wrap: wrap;
    }

    .pricing-info {
        flex: 1;
        min-width: 300px;
    }

    .pricing-hint {
        margin: 0;
        padding: 16px 20px;
        background: #f0f9ff;
        border-left: 4px solid #3b82f6;
        border-radius: 0 8px 8px 0;
        color: #0369a1;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .pricing-input {
        flex: 0 0 300px;
    }

    .pricing-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
    }

    .price-input {
        font-size: 1.5rem !important;
        font-weight: 700;
        color: #059669;
        padding: 16px 20px !important;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 16px;
        padding-top: 20px;
        border-top: 2px solid #e2e8f0;
    }

    .form-actions .btn-lg {
        padding: 14px 32px;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        border-radius: 10px;
    }

    .form-actions .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
    }

    .form-actions .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .pricing-section {
            flex-direction: column;
            align-items: stretch;
        }

        .pricing-input {
            flex: 0 0 auto;
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn-lg {
            width: 100%;
            justify-content: center;
        }
    }
</style>