<?php

/**
 * Book a Car - Executive Premium Checkout
 * Two-Column Layout with Dynamic Price Calculator
 * 
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */

// Load Flatpickr CSS/JS
echo $this->Html->css('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
echo $this->Html->script('https://cdn.jsdelivr.net/npm/flatpickr');
?>

<style>
    /* Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Montserrat:wght@400;500;600;700&display=swap');

    /* ========================================
       BOOKING PAGE - EXECUTIVE CHECKOUT
       ======================================== */
    .booking-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding: 40px 0 80px;
        margin-top: -2rem;
    }

    /* Two Column Grid */
    .booking-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Left Column - Form */
    .form-column {
        background: #ffffff;
        border-radius: 24px;
        padding: 48px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .form-header {
        margin-bottom: 40px;
    }

    .form-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.25rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 8px;
    }

    .form-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.95rem;
        color: #64748b;
        margin: 0;
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 32px;
    }

    .section-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #94a3b8;
        margin-bottom: 16px;
        display: block;
    }

    /* Custom Select */
    .custom-select {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        padding: 16px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        background: #ffffff;
        width: 100%;
        color: #0f172a;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .custom-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    /* Car Preview */
    .car-preview {
        background: #f8fafc;
        border-radius: 16px;
        padding: 24px;
        margin-top: 20px;
        display: none;
    }

    .car-preview.active {
        display: block;
    }

    .car-preview-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 16px;
    }

    .car-preview-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px;
    }

    .car-preview-price {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.9rem;
        color: #3b82f6;
        font-weight: 600;
    }

    /* Date Inputs */
    .date-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .date-input-group label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        display: block;
        margin-bottom: 8px;
    }

    .date-input {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        width: 100%;
        color: #0f172a;
        transition: all 0.2s ease;
    }

    .date-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    /* Location Dropdown */
    .location-select {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.95rem;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        width: 100%;
        color: #0f172a;
        background: #ffffff;
    }

    /* Add-ons */
    .addon-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .addon-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }

    .addon-item:hover {
        background: #f1f5f9;
    }

    .addon-item.selected {
        background: rgba(59, 130, 246, 0.05);
        border-color: #3b82f6;
    }

    .addon-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .addon-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 2px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .addon-item.selected .addon-checkbox {
        background: #3b82f6;
        border-color: #3b82f6;
    }

    .addon-item.selected .addon-checkbox::after {
        content: '✓';
        color: white;
        font-size: 12px;
        font-weight: bold;
    }

    .addon-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
    }

    .addon-price {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: #3b82f6;
    }

    /* ========================================
       RIGHT COLUMN - SUMMARY CARD
       ======================================== */
    .summary-column {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .summary-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .summary-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Car Thumbnail in Summary */
    .summary-car {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .summary-car-image {
        width: 80px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        background: #e2e8f0;
    }

    .summary-car-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        color: #0f172a;
    }

    .summary-car-empty {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        color: #94a3b8;
        font-style: italic;
    }

    /* Price Breakdown */
    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        font-family: 'Montserrat', sans-serif;
    }

    .price-label {
        font-size: 0.9rem;
        color: #64748b;
    }

    .price-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
    }

    .price-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 16px 0;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
    }

    .total-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .total-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
    }

    /* Confirm Button */
    .btn-confirm {
        display: block;
        width: 100%;
        padding: 18px;
        background: #0f172a;
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 24px;
    }

    .btn-confirm:hover {
        background: #1e293b;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.3);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .booking-grid {
            grid-template-columns: 1fr;
            padding: 0 20px;
        }

        .summary-column {
            position: relative;
            top: 0;
        }

        .form-column {
            padding: 32px 24px;
        }
    }
</style>

<div class="booking-wrapper">
    <div class="container">
        <div class="booking-grid">

            <!-- LEFT COLUMN: FORM -->
            <div class="form-column">
                <div class="form-header">
                    <h1 class="form-title">Secure Your Reservation</h1>
                    <p class="form-subtitle">Complete your booking in just a few steps</p>
                </div>

                <?= $this->Form->create($booking, ['id' => 'booking-form']) ?>

                <!-- Vehicle Selection -->
                <div class="form-section">
                    <span class="section-label">Select Your Vehicle</span>
                    <?= $this->Form->control('car_id', [
                        'options' => $cars,
                        'empty' => 'Choose a car...',
                        'class' => 'custom-select',
                        'label' => false,
                        'id' => 'car-select',
                        'default' => $carId
                    ]); ?>

                    <!-- Dynamic Car Preview -->
                    <div class="car-preview" id="car-preview">
                        <img src="" alt="" class="car-preview-image" id="car-preview-image">
                        <h4 class="car-preview-name" id="car-preview-name"></h4>
                        <p class="car-preview-price" id="car-preview-price"></p>
                    </div>
                </div>

                <!-- Date Selection -->
                <div class="form-section">
                    <span class="section-label">Rental Period</span>
                    <div class="date-grid">
                        <div class="date-input-group">
                            <label>Pick-up Date</label>
                            <?= $this->Form->text('start_date', [
                                'class' => 'date-input datepicker',
                                'id' => 'start-date',
                                'placeholder' => 'Select date'
                            ]); ?>
                        </div>
                        <div class="date-input-group">
                            <label>Return Date</label>
                            <?= $this->Form->text('end_date', [
                                'class' => 'date-input datepicker',
                                'id' => 'end-date',
                                'placeholder' => 'Select date'
                            ]); ?>
                        </div>
                    </div>
                </div>

                <!-- Pick-up Location -->
                <div class="form-section">
                    <span class="section-label">Pick-up Location</span>
                    <select class="location-select" id="pickup-location" name="pickup_location">
                        <option value="">Select location...</option>
                        <option value="airport">Airport Terminal 1</option>
                        <option value="city">City Center HQ</option>
                        <option value="north">Northern Branch</option>
                        <option value="south">Southern Outlet</option>
                    </select>
                </div>

                <!-- Add-ons -->
                <div class="form-section">
                    <span class="section-label">Optional Add-ons</span>
                    <div class="addon-list" id="addon-list">
                        <div class="addon-item" data-addon="chauffeur" data-price="0" style="display: none;">
                            <div class="addon-info">
                                <div class="addon-checkbox"></div>
                                <span class="addon-name">Chauffeur Service</span>
                            </div>
                            <span class="addon-price">+RM 0/day</span>
                        </div>
                        <div class="addon-item" data-addon="insurance" data-price="0">
                            <div class="addon-info">
                                <div class="addon-checkbox"></div>
                                <span class="addon-name">Full Coverage Insurance</span>
                            </div>
                            <span class="addon-price">+RM 0/day</span>
                        </div>
                        <div class="addon-item" data-addon="gps" data-price="0" style="display: none;">
                            <div class="addon-info">
                                <div class="addon-checkbox"></div>
                                <span class="addon-name">GPS Navigation</span>
                            </div>
                            <span class="addon-price">+RM 0/day</span>
                        </div>
                    </div>

                    <!-- Hidden inputs for form submission -->
                    <?= $this->Form->hidden('has_chauffeur', ['id' => 'has-chauffeur', 'value' => 0]) ?>
                    <?= $this->Form->hidden('has_gps', ['id' => 'has-gps', 'value' => 0]) ?>
                    <?= $this->Form->hidden('has_full_insurance', ['id' => 'has-insurance', 'value' => 0]) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>

            <!-- RIGHT COLUMN: SUMMARY -->
            <div class="summary-column">
                <div class="summary-card">
                    <h3 class="summary-title">Reservation Summary</h3>

                    <!-- Car Thumbnail -->
                    <div class="summary-car" id="summary-car">
                        <div class="summary-car-image" id="summary-car-thumb"></div>
                        <div>
                            <div class="summary-car-name" id="summary-car-name">Select a vehicle</div>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="price-breakdown">
                        <div class="price-row">
                            <span class="price-label">Daily Rate</span>
                            <span class="price-value" id="daily-rate">RM 0.00</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Duration</span>
                            <span class="price-value" id="duration">0 days</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Add-ons</span>
                            <span class="price-value" id="addons-total">RM 0.00</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Taxes & Fees (6%)</span>
                            <span class="price-value" id="taxes">RM 0.00</span>
                        </div>
                    </div>

                    <div class="price-divider"></div>

                    <div class="total-row">
                        <span class="total-label">Total</span>
                        <span class="total-value" id="total-price">RM 0.00</span>
                    </div>

                    <button type="submit" form="booking-form" class="btn-confirm">
                        Confirm Reservation
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    window.RentifyData = {
        getCarDetailsUrl: "<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'getCarDetails']) ?>",
        getBookedDatesUrl: "<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'getBookedDates']) ?>",
        imageBasePath: "<?= $this->Url->image('') ?>"
    };
</script>
<script src="<?= $this->Url->assetUrl('js/views/Bookings/add.js') ?>?v=<?= time() ?>"></script>