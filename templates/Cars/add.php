<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Car $car
 * @var string[]|\Cake\Collection\CollectionInterface $categories
 */

$statusOptions = [
    'available' => 'Available',
    'maintenance' => 'Maintenance'
];

$transmissionOptions = [
    'Automatic' => 'Automatic',
    'Manual' => 'Manual'
];
?>

<div class="edit-car-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2><i class="fas fa-plus-circle me-2"></i><?= __('Add New Car') ?></h2>
            <p class="text-muted">Add a new vehicle to your fleet</p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <?= $this->Form->create($car, ['type' => 'file', 'class' => 'edit-form']) ?>

    <div class="form-grid">
        <!-- Left Column: Car Details -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-car me-2"></i><?= __('Car Information') ?></h5>
            </div>
            <div class="card-body">
                <table class="form-table">
                    <tr>
                        <th><?= __('Category') ?></th>
                        <td><?= $this->Form->control('category_id', [
                                'options' => $categories,
                                'empty' => '-- Select Category --',
                                'label' => false,
                                'class' => 'form-select'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Brand') ?></th>
                        <td><?= $this->Form->control('brand', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'e.g. Toyota',
                                'required' => true
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Model') ?></th>
                        <td><?= $this->Form->control('car_model', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'e.g. Camry',
                                'required' => true
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Year') ?></th>
                        <td><?= $this->Form->control('year', [
                                'label' => false,
                                'class' => 'form-control',
                                'type' => 'number',
                                'min' => 1990,
                                'max' => date('Y') + 1,
                                'value' => date('Y')
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Plate Number') ?></th>
                        <td><?= $this->Form->control('plate_number', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'e.g. ABC 1234',
                                'required' => true
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Price/Day (RM)') ?></th>
                        <td><?= $this->Form->control('price_per_day', [
                                'label' => false,
                                'class' => 'form-control',
                                'type' => 'number',
                                'step' => '0.01',
                                'min' => 0,
                                'placeholder' => 'e.g. 150.00'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td><?= $this->Form->control('status', [
                                'options' => $statusOptions,
                                'label' => false,
                                'class' => 'form-select',
                                'default' => 'available'
                            ]) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Right Column: Specs & Image -->
        <div class="form-card">
            <div class="card-header">
                <h5><i class="fas fa-cogs me-2"></i><?= __('Specifications') ?></h5>
            </div>
            <div class="card-body">
                <table class="form-table">
                    <tr>
                        <th><?= __('Transmission') ?></th>
                        <td><?= $this->Form->control('transmission', [
                                'options' => $transmissionOptions,
                                'label' => false,
                                'class' => 'form-select',
                                'default' => 'Automatic'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Seats') ?></th>
                        <td><?= $this->Form->control('seats', [
                                'label' => false,
                                'class' => 'form-control',
                                'type' => 'number',
                                'min' => 1,
                                'max' => 12,
                                'value' => 5
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Engine') ?></th>
                        <td><?= $this->Form->control('engine', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'e.g. 2.5L V6'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('0-60 Time') ?></th>
                        <td><?= $this->Form->control('zero_to_sixty', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'e.g. 5.8s'
                            ]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Badge Color') ?></th>
                        <td>
                            <div class="color-picker-wrapper">
                                <?= $this->Form->control('badge_color', [
                                    'label' => false,
                                    'type' => 'color',
                                    'class' => 'form-control form-control-color',
                                    'value' => '#3b82f6'
                                ]) ?>
                                <span class="color-preview" style="background: #3b82f6"></span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Full Width: Image Upload -->
        <div class="form-card full-width">
            <div class="card-header">
                <h5><i class="fas fa-image me-2"></i><?= __('Car Image') ?></h5>
            </div>
            <div class="card-body">
                <div class="image-upload-section">
                    <!-- Image Preview -->
                    <div class="current-image">
                        <div class="no-image" id="imagePreview">
                            <i class="fas fa-car"></i>
                            <p>No image selected</p>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="upload-controls">
                        <label class="file-upload-btn">
                            <i class="fas fa-upload me-2"></i><?= __('Choose Image') ?>
                            <?= $this->Form->control('image_file', [
                                'type' => 'file',
                                'label' => false,
                                'class' => 'file-input',
                                'accept' => 'image/*',
                                'id' => 'imageInput'
                            ]) ?>
                        </label>
                        <p class="upload-hint">Supported: JPG, PNG, GIF (max 5MB)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <?= $this->Form->button(
            __('Add Car'),
            ['class' => 'btn btn-success btn-lg', 'escape' => false]
        ) ?>
        <?= $this->Html->link(
            __('Cancel'),
            ['action' => 'index'],
            ['class' => 'btn btn-outline-secondary btn-lg', 'escape' => false]
        ) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<script src="<?= $this->Url->assetUrl('js/views/Cars/form.js') ?>?v=<?= time() ?>"></script>

<style>
    .edit-car-container {
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
    }

    .page-header h2 {
        margin: 0;
        color: #1e293b;
    }

    .page-header .text-muted {
        margin: 5px 0 0;
        color: #64748b;
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
        padding: 12px 16px 12px 0;
        width: 140px;
        color: #475569;
        font-weight: 500;
        vertical-align: middle;
    }

    .form-table td {
        padding: 12px 0;
    }

    .form-table .form-control,
    .form-table .form-select {
        width: 100%;
    }

    /* Color Picker */
    .color-picker-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-control-color {
        width: 60px !important;
        height: 40px;
        padding: 4px;
        cursor: pointer;
    }

    .color-preview {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 2px solid #e2e8f0;
    }

    /* Image Upload */
    .image-upload-section {
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

    .current-image {
        flex: 0 0 300px;
    }

    .current-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
    }

    .current-image .no-image {
        width: 100%;
        height: 200px;
        background: #f8fafc;
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .current-image .no-image i {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .upload-controls {
        flex: 1;
    }

    .file-upload-btn {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .file-upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .file-input {
        display: none;
    }

    .upload-hint {
        margin-top: 12px;
        font-size: 0.85rem;
        color: #64748b;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 16px;
        padding-top: 20px;
        border-top: 2px solid #e2e8f0;
    }

    .form-actions .btn-lg {
        padding: 12px 32px;
        font-size: 1rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .image-upload-section {
            flex-direction: column;
        }

        .current-image {
            flex: 0 0 auto;
            width: 100%;
        }
    }
</style>