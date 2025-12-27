<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 * @var \Cake\Collection\CollectionInterface|string[] $bookings
 */
?>

<div class="add-invoice-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2><?= __('New Invoice') ?></h2>
            <p class="text-muted"><?= __('Create a new invoice') ?></p>
        </div>
        <div class="header-actions">
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-2"></i>' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <div class="form-card">
        <div class="card-header">
            <h5><i class="fas fa-file-invoice me-2"></i><?= __('Invoice Information') ?></h5>
        </div>
        <div class="card-body">
            <?= $this->Form->create($invoice) ?>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-calendar-check me-2"></i><?= __('Booking') ?></label>
                    <?= $this->Form->control('booking_id', ['options' => $bookings, 'label' => false, 'class' => 'form-control']) ?>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-hashtag me-2"></i><?= __('Invoice Number') ?></label>
                    <?= $this->Form->control('invoice_number', ['label' => false, 'class' => 'form-control', 'placeholder' => 'e.g. INV-2024-001']) ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-dollar-sign me-2"></i><?= __('Amount') ?></label>
                    <?= $this->Form->control('amount', ['label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control', 'placeholder' => '0.00']) ?>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-check-circle me-2"></i><?= __('Status') ?></label>
                    <?= $this->Form->control('status', ['label' => false, 'class' => 'form-control', 'placeholder' => 'e.g. unpaid, paid']) ?>
                </div>
            </div>

            <div class="form-actions">
                <?= $this->Form->button('<i class="fas fa-save me-2"></i>' . __('Create Invoice'), ['class' => 'btn btn-primary', 'escape' => false]) ?>
                <?= $this->Html->link('<i class="fas fa-times me-2"></i>' . __('Cancel'), ['action' => 'index'], ['class' => 'btn btn-outline-secondary', 'escape' => false]) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<style>
    .add-invoice-container {
        max-width: 800px;
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
        margin: 4px 0 0;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
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
        padding: 24px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        font-weight: 500;
        color: #334155;
        margin-bottom: 8px;
    }

    .form-group label i {
        color: #3b82f6;
    }

    .form-group .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-group .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        margin-top: 10px;
    }

    @media (max-width: 576px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>