<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */
// Load Flatpickr CSS/JS
echo $this->Html->css('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
echo $this->Html->script('https://cdn.jsdelivr.net/npm/flatpickr');
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Book a Car</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($booking) ?>
                
                <div class="mb-3">
                    <label>Select Car</label>
                    <?= $this->Form->control('car_id', [
                        'options' => $cars, 
                        'empty' => 'Choose a car...',
                        'class' => 'form-select', 
                        'label' => false,
                        'id' => 'car-select',
                        'default' => $carId // Pre-select if passed from URL
                    ]); ?>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Start Date</label>
                        <?= $this->Form->text('start_date', ['class' => 'form-control datepicker', 'id' => 'start-date']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>End Date</label>
                        <?= $this->Form->text('end_date', ['class' => 'form-control datepicker', 'id' => 'end-date']); ?>
                    </div>
                </div>

                <?= $this->Form->button(__('Book Now'), ['class' => 'btn btn-primary w-100']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carSelect = document.getElementById('car-select');
    let pickerStart, pickerEnd;

    function initPickers(disabledDates = []) {
        const config = {
            dateFormat: "Y-m-d",
            minDate: "today",
            disable: disabledDates // The magic array of blocked dates
        };

        pickerStart = flatpickr("#start-date", config);
        pickerEnd = flatpickr("#end-date", config);
    }

    // Initial load
    initPickers();

    // Function to fetch dates when car changes
    function updateDates() {
        const carId = carSelect.value;
        if(carId) {
            fetch('<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'getBookedDates']) ?>/' + carId)
                .then(response => response.json())
                .then(data => {
                    // Destroy old pickers and rebuild with new blocked dates
                    pickerStart.destroy();
                    pickerEnd.destroy();
                    initPickers(data.dates); 
                });
        }
    }

    // Listen for changes
    carSelect.addEventListener('change', updateDates);
    
    // Run once on load if car is pre-selected
    if(carSelect.value) {
        updateDates();
    }
});
</script>