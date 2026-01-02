<?php

/**
 * Professional Payment Gateway
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 * @var \App\Model\Entity\Booking $booking
 */
$bookingId = $this->request->getQuery('booking_id');
$amount = $this->request->getQuery('amount');

// --- REVERSE CALCULATOR (To show breakdown) ---
$subtotal = 0;
$tax = 0;
$addons = 0;
$days = 0;
$baseCost = 0;
if ($booking && $booking->car) {
    $days = $booking->end_date->diffInDays($booking->start_date) ?: 1;
    $baseCost = $booking->car->price_per_day * $days;
    $preTaxTotal = $amount / 1.06;
    $addons = max(0, $preTaxTotal - $baseCost);
    $tax = $amount - $preTaxTotal;
}
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="payment-wrapper">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">

            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-white p-4 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-lock text-primary me-2"></i>Secure Checkout</h5>
                    </div>

                    <div class="card-body p-4">
                        <?= $this->Form->create($payment, ['id' => 'paymentForm']) ?>
                        <?= $this->Form->hidden('booking_id', ['value' => $bookingId]) ?>
                        <?= $this->Form->hidden('amount', ['value' => $amount]) ?>

                        <label class="form-label fw-bold text-muted small text-uppercase mb-3">Choose Payment Method</label>
                        <div class="payment-tabs mb-4">
                            <input type="radio" name="payment_method" id="method_card" value="card" checked class="btn-check">
                            <label class="payment-tab" for="method_card">
                                <i class="fas fa-credit-card fa-lg mb-2"></i>
                                <span>Credit Card</span>
                            </label>

                            <input type="radio" name="payment_method" id="method_fpx" value="online_transfer" class="btn-check">
                            <label class="payment-tab" for="method_fpx">
                                <i class="fas fa-university fa-lg mb-2"></i>
                                <span>Online Banking</span>
                            </label>

                            <input type="radio" name="payment_method" id="method_cash" value="cash" class="btn-check">
                            <label class="payment-tab" for="method_cash">
                                <i class="fas fa-money-bill-wave fa-lg mb-2"></i>
                                <span>Cash / Counter</span>
                            </label>
                        </div>

                        <div id="section_card" class="payment-section">
                            <div class="bg-light p-4 rounded-3 border">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">CARD NUMBER</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-credit-card text-muted"></i></span>
                                        <input type="text" name="card_number" id="card_number" class="form-control border-start-0 ps-0" placeholder="0000 0000 0000 0000" maxlength="19">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted">EXPIRY</label>
                                        <input type="text" id="expiry" class="form-control" placeholder="MM/YY" maxlength="5">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-muted">CVV</label>
                                        <input type="password" id="cvv" class="form-control" placeholder="123" maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="section_fpx" class="payment-section" style="display:none;">
                            <div class="alert alert-warning border-0 d-flex align-items-center mb-3">
                                <i class="fas fa-shield-alt me-2"></i> Secure FPX Transfer (Simulation)
                            </div>
                            <input type="hidden" name="bank_name" id="bank_name">
                            <label class="form-label small fw-bold text-muted mb-2">SELECT YOUR BANK</label>

                            <div class="bank-grid">
                                <div class="bank-option" onclick="selectBank(this, 'Maybank2u')">
                                    <div class="bank-logo">Maybank2u</div>
                                </div>
                                <div class="bank-option" onclick="selectBank(this, 'CIMB Clicks')">
                                    <div class="bank-logo" style="color: #ed1c24;">CIMB Clicks</div>
                                </div>
                                <div class="bank-option" onclick="selectBank(this, 'Public Bank')">
                                    <div class="bank-logo" style="color: #d32f2f;">Public Bank</div>
                                </div>
                                <div class="bank-option" onclick="selectBank(this, 'RHB Now')">
                                    <div class="bank-logo" style="color: #0067b1;">RHB Now</div>
                                </div>
                                <div class="bank-option" onclick="selectBank(this, 'AmOnline')">
                                    <div class="bank-logo" style="color: #ed1c24;">AmOnline</div>
                                </div>
                                <div class="bank-option" onclick="selectBank(this, 'Hong Leong')">
                                    <div class="bank-logo" style="color: #004d88;">Hong Leong</div>
                                </div>
                            </div>
                            <small class="text-danger mt-2 d-block" id="bank-error" style="display:none;">* Please select a bank</small>
                        </div>

                        <div id="section_cash" class="payment-section" style="display:none;">
                            <div class="text-center py-4 bg-light rounded-3 border">
                                <div class="mb-3">
                                    <i class="fas fa-store fa-3x text-success"></i>
                                </div>
                                <h6 class="fw-bold">Pay at Counter</h6>
                                <p class="text-muted small mb-0 px-4">
                                    Please present your Booking ID <strong>#<?= $bookingId ?></strong> at the Rentify counter to complete payment.
                                </p>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <?= $this->Form->button('Confirm Payment RM ' . number_format($amount, 2), ['class' => 'btn btn-primary btn-lg fw-bold py-3 shadow-sm']) ?>
                        </div>

                        <?= $this->Form->end() ?>

                        <div class="text-center mt-3">
                            <?= $this->Html->link('Cancel Transaction', ['controller' => 'Invoices', 'action' => 'myInvoices'], ['class' => 'text-muted text-decoration-none small']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0 rounded-4 bg-white">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-muted text-uppercase mb-4">Order Summary</h6>

                        <?php if ($booking): ?>
                            <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
                                <div class="car-image-wrapper rounded-3 overflow-hidden" style="width: 80px; height: 60px; flex-shrink: 0;">
                                    <?php if (!empty($booking->car->image)): ?>
                                        <img src="<?= $this->Url->webroot('img/' . h($booking->car->image)) ?>"
                                            alt="<?= h($booking->car->brand ?? '') ?> <?= h($booking->car->car_model ?? 'Vehicle') ?>"
                                            class="car-booking-image w-100 h-100"
                                            style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center w-100 h-100">
                                            <i class="fas fa-car fa-lg text-secondary"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="ms-3">
                                    <h6 class="fw-bold mb-0 text-dark"><?= h($booking->car->brand ?? '') ?> <?= h($booking->car->car_model ?? 'Vehicle') ?></h6>
                                    <small class="text-muted"><?= $days ?> Day Rental</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Car Rental</span>
                                <span class="fw-semibold">RM <?= number_format($baseCost, 2) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Add-ons</span>
                                <span class="fw-semibold">RM <?= number_format($addons, 2) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Service Tax (6%)</span>
                                <span class="fw-semibold text-danger">RM <?= number_format($tax, 2) ?></span>
                            </div>

                            <div class="d-flex justify-content-between pt-3 border-top">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-primary">RM <?= number_format($amount, 2) ?></span>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-3">Summary Unavailable</div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-primary">RM <?= number_format($amount, 2) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-light p-3 text-center rounded-bottom-4">
                        <small class="text-muted"><i class="fas fa-lock me-1"></i> 256-bit SSL Encrypted Payment</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f3f4f6;
        font-family: 'Inter', sans-serif;
    }

    .payment-tabs {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
    }

    .payment-tab {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 600;
        color: #6b7280;
    }

    .btn-check:checked+.payment-tab {
        border-color: #2563eb;
        background-color: #eff6ff;
        color: #2563eb;
    }

    /* Bank Grid for FPX */
    .bank-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .bank-option {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 15px 5px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
    }

    .bank-option:hover {
        background-color: #f9fafb;
        border-color: #d1d5db;
    }

    .bank-option.selected {
        border-color: #2563eb;
        background-color: #eff6ff;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .bank-logo {
        font-weight: 800;
        font-size: 0.8rem;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
</style>

<script>
    // 1. Payment Method Switching
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Hide all sections
            document.getElementById('section_card').style.display = 'none';
            document.getElementById('section_fpx').style.display = 'none';
            document.getElementById('section_cash').style.display = 'none';

            // Show selected
            if (this.value === 'card') document.getElementById('section_card').style.display = 'block';
            if (this.value === 'online_transfer') document.getElementById('section_fpx').style.display = 'block';
            if (this.value === 'cash') document.getElementById('section_cash').style.display = 'block';
        });
    });

    // 2. Bank Selection Logic
    function selectBank(element, bankName) {
        // Remove active class from all
        document.querySelectorAll('.bank-option').forEach(el => el.classList.remove('selected'));
        // Add to clicked
        element.classList.add('selected');
        // Set Hidden Input
        document.getElementById('bank_name').value = bankName;
    }

    // 3. Card Formatting
    const cardInput = document.getElementById('card_number');
    if (cardInput) {
        cardInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) formattedValue += ' ';
                formattedValue += value[i];
            }
            e.target.value = formattedValue;
        });
    }

    const expiryInput = document.getElementById('expiry');
    if (expiryInput) {
        expiryInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) value = value.substring(0, 2) + '/' + value.substring(2, 4);
            e.target.value = value;
        });
    }
</script>