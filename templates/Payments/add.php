<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
$bookingId = $this->request->getQuery('booking_id');
$amount = $this->request->getQuery('amount');
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-lock"></i> Secure Payment</h4>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info">
                    <strong>Payment Simulation:</strong> No real money is deducted.
                </div>
                
                <h3 class="text-center mb-4 text-success">Total: RM <?= number_format((float)$amount, 2) ?></h3>

                <?= $this->Form->create($payment) ?>
                
                <?= $this->Form->hidden('booking_id', ['value' => $bookingId]) ?>
                <?= $this->Form->hidden('amount', ['value' => $amount]) ?>

                <div class="mb-3">
                    <label class="form-label fw-bold">Select Payment Method</label>
                    <?= $this->Form->select('payment_method', [
                        'card' => 'Credit / Debit Card',
                        'online_transfer' => 'Online Transfer (FPX)',
                        'cash' => 'Cash (Pay at Counter)'
                    ], ['class' => 'form-select', 'id' => 'payment-method']); ?>
                </div>

                <div id="card-section">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Card Number</label>
                        <?= $this->Form->text('card_number', [
                            'class' => 'form-control form-control-lg', 
                            'placeholder' => '0000-0000-0000-0000',
                            'id' => 'card-input', 
                            'maxLength' => 19
                        ]) ?>
                        <small class="text-muted">Test Code: <strong>4242-4242-4242-4242</strong></small>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Expiry</label>
                            <input type="text" 
                                   id="expiry-input" 
                                   class="form-control" 
                                   placeholder="MM/YY" 
                                   maxlength="5">
                        </div>
                        
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">CVV</label>
                            <input type="password" 
                                   id="cvv-input" 
                                   class="form-control" 
                                   placeholder="123" 
                                   maxlength="3">
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <?= $this->Form->button(__('Pay Now'), ['class' => 'btn btn-success btn-lg']) ?>
                    <?= $this->Html->link('Cancel', ['controller' => 'Invoices', 'action' => 'myInvoices'], ['class' => 'btn btn-light']) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const methodSelect = document.getElementById('payment-method');
    const cardSection = document.getElementById('card-section');
    const cardInput = document.getElementById('card-input');
    const expiryInput = document.getElementById('expiry-input');
    const cvvInput = document.getElementById('cvv-input');

    // 1. Auto-Add Dashes Logic (Card Number)
    cardInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); 
        let formattedValue = '';
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) formattedValue += '-';
            formattedValue += value[i];
        }
        e.target.value = formattedValue;
    });

    // 2. Expiry Date Logic (Auto-Slash MM/YY)
    expiryInput.addEventListener('input', function(e) {
        // Remove non-digit characters
        let value = e.target.value.replace(/\D/g, '');
        
        // Add slash after 2nd digit
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });

    // 3. CVV Logic (Strictly Numbers Only)
    cvvInput.addEventListener('input', function(e) {
        // Replace any non-digit with empty string immediately
        e.target.value = e.target.value.replace(/\D/g, '');
    });

    // 4. Toggle Card Section based on dropdown
    function toggleCard() {
        if (methodSelect.value === 'card') {
            cardSection.style.display = 'block';
            cardInput.setAttribute('required', 'required');
            expiryInput.setAttribute('required', 'required');
            cvvInput.setAttribute('required', 'required');
        } else {
            cardSection.style.display = 'none';
            cardInput.removeAttribute('required');
            expiryInput.removeAttribute('required');
            cvvInput.removeAttribute('required');
            
            // Clear inputs when hidden
            cardInput.value = '';
            expiryInput.value = '';
            cvvInput.value = '';
        }
    }

    methodSelect.addEventListener('change', toggleCard);
    toggleCard(); // Run on load
});
</script>