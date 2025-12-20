<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
// Get data passed from controller
$bookingId = $this->request->getQuery('booking_id');
$amount = $this->request->getQuery('amount');
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-credit-card"></i> Secure Payment Simulation</h4>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info">
                    <strong>Simulation Mode:</strong> No real money will be deducted.
                </div>
                
                <h3 class="text-center mb-4">Total: RM <?= number_format((float)$amount, 2) ?></h3>

                <?= $this->Form->create($payment) ?>
                
                <?= $this->Form->hidden('booking_id', ['value' => $bookingId]) ?>
                <?= $this->Form->hidden('amount', ['value' => $amount]) ?>
                <?= $this->Form->hidden('payment_method', ['value' => 'card']) ?>

                <div class="mb-3">
                    <label class="form-label fw-bold">Card Number</label>
                    <?= $this->Form->text('card_number', [
                        'class' => 'form-control form-control-lg', 
                        'placeholder' => 'Enter 4242-4242-4242-4242',
                        'required' => true,
                        'maxLength' => 19
                    ]) ?>
                    <small class="text-muted">Test Code: Enter <strong>4242-4242-4242-4242</strong> to succeed.</small>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label fw-bold">Expiry</label>
                        <input type="text" class="form-control" placeholder="MM/YY">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label fw-bold">CVV</label>
                        <input type="text" class="form-control" placeholder="123">
                    </div>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <?= $this->Form->button(__('Pay Now'), ['class' => 'btn btn-success btn-lg']) ?>
                    <?= $this->Html->link('Cancel', ['controller' => 'Invoices', 'action' => 'index'], ['class' => 'btn btn-light']) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>