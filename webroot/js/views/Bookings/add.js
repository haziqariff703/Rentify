/**
 * Bookings Add Form JavaScript
 * Handles dynamic car selection, date pickers, add-ons, and price calculation.
 *
 * Requires:
 * - Flatpickr library
 * - window.RentifyData object with URLs and image base path
 *
 * @file webroot/js/views/Bookings/add.js
 */
document.addEventListener('DOMContentLoaded', function() {
    const data = window.RentifyData || {};
    
    const carSelect = document.getElementById('car-select');
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const carPreview = document.getElementById('car-preview');
    const addonItems = document.querySelectorAll('.addon-item');

    // Guard clause
    if (!carSelect || !startDateInput || !endDateInput) {
        return;
    }

    let pickerStart, pickerEnd;
    let selectedCar = null;
    let categoryServices = null;

    // Initialize Flatpickr with Linked Date Logic
    function initPickers(disabledDates = []) {
        pickerStart = flatpickr("#start-date", {
            dateFormat: "Y-m-d",
            minDate: "today",
            disable: disabledDates,
            onChange: function(selectedDates, dateStr, instance) {
                pickerEnd.set('minDate', dateStr);
                if (endDateInput.value && endDateInput.value < dateStr) {
                    pickerEnd.clear();
                    document.getElementById('duration').textContent = '0 days';
                }
                updatePriceCalculation();
            }
        });

        pickerEnd = flatpickr("#end-date", {
            dateFormat: "Y-m-d",
            minDate: "today",
            disable: disabledDates,
            onChange: updatePriceCalculation
        });
    }

    initPickers();

    // Fetch car details when selection changes
    carSelect.addEventListener('change', function() {
        const carId = this.value;
        if (!carId) {
            if (carPreview) carPreview.classList.remove('active');
            selectedCar = null;
            categoryServices = null;
            updateSummary();
            resetAddons();
            return;
        }

        fetch(data.getCarDetailsUrl + '/' + carId)
            .then(response => response.json())
            .then(carData => {
                selectedCar = carData;
                categoryServices = {
                    chauffeur_available: carData.chauffeur_available,
                    chauffeur_daily_rate: parseFloat(carData.chauffeur_daily_rate) || 0,
                    gps_available: carData.gps_available,
                    gps_daily_rate: parseFloat(carData.gps_daily_rate) || 0,
                    insurance_daily_rate: parseFloat(carData.insurance_daily_rate) || 0,
                    security_deposit: parseFloat(carData.security_deposit) || 0
                };

                // Update car preview
                const previewImage = document.getElementById('car-preview-image');
                const previewName = document.getElementById('car-preview-name');
                const previewPrice = document.getElementById('car-preview-price');
                
                if (previewImage) previewImage.src = data.imageBasePath + carData.image;
                if (previewName) previewName.textContent = (carData.brand || '') + ' ' + carData.name;
                if (previewPrice) previewPrice.textContent = 'RM ' + parseFloat(carData.price_per_day).toFixed(2) + '/day';
                if (carPreview) carPreview.classList.add('active');

                // Update summary
                const summaryThumb = document.getElementById('summary-car-thumb');
                const summaryName = document.getElementById('summary-car-name');
                const dailyRateEl = document.getElementById('daily-rate');
                
                if (summaryThumb) {
                    summaryThumb.style.backgroundImage = 'url(' + data.imageBasePath + carData.image + ')';
                    summaryThumb.style.backgroundSize = 'cover';
                    summaryThumb.style.backgroundPosition = 'center';
                }
                if (summaryName) summaryName.textContent = (carData.brand || '') + ' ' + carData.name;
                if (dailyRateEl) dailyRateEl.textContent = 'RM ' + parseFloat(carData.price_per_day).toFixed(2);

                // Update add-ons visibility and prices
                updateAddonsDisplay();
                updatePriceCalculation();
            })
            .catch(err => console.error('Error fetching car:', err));

        fetch(data.getBookedDatesUrl + '/' + carId)
            .then(response => response.json())
            .then(bookedData => {
                const currentStart = startDateInput.value;
                const currentEnd = endDateInput.value;

                pickerStart.destroy();
                pickerEnd.destroy();
                initPickers(bookedData.dates);

                if (currentStart) pickerStart.setDate(currentStart);
                if (currentEnd) pickerEnd.setDate(currentEnd);
            });
    });

    // Update add-ons display based on category services
    function updateAddonsDisplay() {
        if (!categoryServices) return;

        const chauffeurItem = document.querySelector('[data-addon="chauffeur"]');
        const gpsItem = document.querySelector('[data-addon="gps"]');
        const insuranceItem = document.querySelector('[data-addon="insurance"]');

        // Chauffeur
        if (chauffeurItem) {
            if (categoryServices.chauffeur_available) {
                chauffeurItem.style.display = 'flex';
                chauffeurItem.dataset.price = categoryServices.chauffeur_daily_rate;
                chauffeurItem.querySelector('.addon-price').textContent = '+RM ' + categoryServices.chauffeur_daily_rate.toFixed(2) + '/day';
            } else {
                chauffeurItem.style.display = 'none';
                chauffeurItem.classList.remove('selected');
                document.getElementById('has-chauffeur').value = '0';
            }
        }

        // GPS
        if (gpsItem) {
            if (categoryServices.gps_available) {
                gpsItem.style.display = 'flex';
                gpsItem.dataset.price = categoryServices.gps_daily_rate;
                gpsItem.querySelector('.addon-price').textContent = '+RM ' + categoryServices.gps_daily_rate.toFixed(2) + '/day';
            } else {
                gpsItem.style.display = 'none';
                gpsItem.classList.remove('selected');
                document.getElementById('has-gps').value = '0';
            }
        }

        // Insurance (always available)
        if (insuranceItem) {
            insuranceItem.style.display = 'flex';
            insuranceItem.dataset.price = categoryServices.insurance_daily_rate;
            insuranceItem.querySelector('.addon-price').textContent = '+RM ' + categoryServices.insurance_daily_rate.toFixed(2) + '/day';
        }
    }

    function resetAddons() {
        addonItems.forEach(item => {
            item.classList.remove('selected');
            item.style.display = 'none';
        });
        const hasChauffeur = document.getElementById('has-chauffeur');
        const hasGps = document.getElementById('has-gps');
        const hasInsurance = document.getElementById('has-insurance');
        if (hasChauffeur) hasChauffeur.value = '0';
        if (hasGps) hasGps.value = '0';
        if (hasInsurance) hasInsurance.value = '0';
    }

    // Add-on selection handlers
    addonItems.forEach(item => {
        item.addEventListener('click', function() {
            this.classList.toggle('selected');

            const addon = this.dataset.addon;
            const isSelected = this.classList.contains('selected');

            if (addon === 'chauffeur') {
                document.getElementById('has-chauffeur').value = isSelected ? '1' : '0';
            } else if (addon === 'gps') {
                document.getElementById('has-gps').value = isSelected ? '1' : '0';
            } else if (addon === 'insurance') {
                document.getElementById('has-insurance').value = isSelected ? '1' : '0';
            }

            updatePriceCalculation();
        });
    });

    // Price calculation
    function updatePriceCalculation() {
        if (!selectedCar) {
            resetSummary();
            return;
        }

        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        let days = 0;
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const diffTime = end - start;
            days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            if (days < 1) days = 1;
        }

        let addonsPerDay = 0;
        document.querySelectorAll('.addon-item.selected').forEach(item => {
            addonsPerDay += parseFloat(item.dataset.price) || 0;
        });

        const dailyRate = parseFloat(selectedCar.price_per_day);
        const subtotal = dailyRate * days;
        const addonsTotal = addonsPerDay * days;
        const taxes = (subtotal + addonsTotal) * 0.06;
        const total = subtotal + addonsTotal + taxes;

        const durationEl = document.getElementById('duration');
        const addonsTotalEl = document.getElementById('addons-total');
        const taxesEl = document.getElementById('taxes');
        const totalPriceEl = document.getElementById('total-price');

        if (durationEl) durationEl.textContent = days + (days === 1 ? ' day' : ' days');
        if (addonsTotalEl) addonsTotalEl.textContent = 'RM ' + addonsTotal.toFixed(2);
        if (taxesEl) taxesEl.textContent = 'RM ' + taxes.toFixed(2);
        if (totalPriceEl) totalPriceEl.textContent = 'RM ' + total.toFixed(2);
    }

    function resetSummary() {
        const dailyRateEl = document.getElementById('daily-rate');
        const durationEl = document.getElementById('duration');
        const addonsTotalEl = document.getElementById('addons-total');
        const taxesEl = document.getElementById('taxes');
        const totalPriceEl = document.getElementById('total-price');

        if (dailyRateEl) dailyRateEl.textContent = 'RM 0.00';
        if (durationEl) durationEl.textContent = '0 days';
        if (addonsTotalEl) addonsTotalEl.textContent = 'RM 0.00';
        if (taxesEl) taxesEl.textContent = 'RM 0.00';
        if (totalPriceEl) totalPriceEl.textContent = 'RM 0.00';
    }

    function updateSummary() {
        const summaryName = document.getElementById('summary-car-name');
        const summaryThumb = document.getElementById('summary-car-thumb');
        if (summaryName) summaryName.textContent = 'Select a vehicle';
        if (summaryThumb) summaryThumb.style.backgroundImage = '';
        resetSummary();
    }

    // Trigger change if car is pre-selected
    if (carSelect.value) {
        carSelect.dispatchEvent(new Event('change'));
    }
});
