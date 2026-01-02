/**
 * Admin Dashboard JavaScript
 * Handles FullCalendar and ApexCharts initialization.
 *
 * Requires:
 * - FullCalendar library
 * - ApexCharts library
 * - SweetAlert2 library
 * - window.RentifyData object with chart data from PHP
 *
 * @file webroot/js/views/Admins/dashboard.js
 */
document.addEventListener('DOMContentLoaded', function() {
    const data = window.RentifyData || {};

    // --- FullCalendar Initialization ---
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            themeSystem: 'standard',
            height: 600,
            events: data.calendarDataUrl || '',
            eventClick: function(info) {
                const event = info.event;
                const status = event.extendedProps.status || 'N/A';
                const price = event.extendedProps.price || '0.00';

                let icon = 'info';
                if (status.toLowerCase() === 'confirmed') icon = 'success';
                if (status.toLowerCase() === 'pending') icon = 'warning';
                if (status.toLowerCase() === 'cancelled') icon = 'error';

                Swal.fire({
                    title: `<div class="fw-bold text-dark mt-2">${event.title}</div>`,
                    html: `
                        <div class="text-start mt-3 p-3 rounded-4 bg-light shadow-inner">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small fw-bold uppercase">Rental Price:</span>
                                <span class="fw-bold text-indigo">RM ${price}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small fw-bold uppercase">Booking Status:</span>
                                <span class="badge rounded-pill bg-soft-${getBadgeColor(status)} text-${getBadgeColor(status)}">${status.toUpperCase()}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small fw-bold uppercase">Start Date:</span>
                                <span class="small fw-bold">${event.start.toLocaleDateString()}</span>
                            </div>
                        </div>
                    `,
                    icon: icon,
                    showCloseButton: true,
                    confirmButtonText: 'View Full Details',
                    confirmButtonColor: '#6366f1',
                    customClass: {
                        popup: 'glass-swal-popup',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = data.bookingViewUrl + '/' + event.id;
                    }
                });
            }
        });
        calendar.render();
    }

    // Helper function for badge colors
    function getBadgeColor(status) {
        status = status.toLowerCase();
        if (status === 'confirmed') return 'success';
        if (status === 'pending') return 'warning';
        if (status === 'cancelled') return 'danger';
        return 'info';
    }

    // --- ApexCharts Initialization ---

    // 1. Highlight Chart (Revenue & Bookings Trend)
    const highlightChartEl = document.querySelector("#highlightChart");
    if (highlightChartEl) {
        const highlightOptions = {
            series: [{
                name: 'Revenue (RM)',
                type: 'area',
                data: data.revenueData || []
            }, {
                name: 'Bookings',
                type: 'area',
                data: data.bookingCountData || []
            }],
            chart: {
                type: 'area',
                height: 320,
                fontFamily: "'Inter', sans-serif",
                toolbar: { show: false },
                zoom: { enabled: false },
            },
            colors: ['#6366f1', '#10b981'],
            stroke: {
                curve: 'smooth',
                width: [3, 3],
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                }
            },
            dataLabels: { enabled: false },
            markers: {
                size: [4, 4],
                colors: ['#6366f1', '#10b981'],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: { size: 7 }
            },
            xaxis: {
                categories: data.revenueLabels || [],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        fontSize: '13px',
                        fontWeight: 500,
                        colors: '#64748b'
                    }
                }
            },
            yaxis: [{
                title: {
                    text: 'Revenue',
                    style: { fontSize: '12px', fontWeight: 600, color: '#6366f1' }
                },
                min: 0,
                labels: {
                    style: { colors: '#64748b' },
                    formatter: (val) => 'RM ' + (val ? val.toLocaleString() : '0')
                }
            }, {
                opposite: true,
                title: {
                    text: 'Bookings',
                    style: { fontSize: '12px', fontWeight: 600, color: '#10b981' }
                },
                min: 0,
                labels: {
                    style: { colors: '#64748b' },
                    formatter: (val) => Math.round(val)
                }
            }],
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 5,
                padding: { top: 0, bottom: 0, left: 10, right: 10 }
            },
            legend: { show: false },
            tooltip: {
                theme: 'light',
                shared: true,
                intersect: false,
                y: {
                    formatter: function(val, { seriesIndex }) {
                        if (seriesIndex === 0) {
                            return 'RM ' + (val ? val.toLocaleString() : '0');
                        }
                        return val + ' bookings';
                    }
                }
            }
        };
        new ApexCharts(highlightChartEl, highlightOptions).render();
    }



    // 3. Live Activity Chart (Real-time scrolling)
    const liveActivityChartEl = document.querySelector("#liveActivityChart");
    if (liveActivityChartEl) {
        let liveData = [];
        for (let i = 0; i < 20; i++) {
            liveData.push(Math.floor(Math.random() * 40) + 20);
        }

        const liveActivityOptions = {
            series: [{
                name: 'Activity',
                data: liveData.slice()
            }],
            chart: {
                type: 'area',
                height: 60,
                sparkline: { enabled: true },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: { speed: 1000 }
                }
            },
            colors: ['#10b981'],
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            tooltip: { enabled: false }
        };

        const liveActivityChart = new ApexCharts(liveActivityChartEl, liveActivityOptions);
        liveActivityChart.render();

        // Real-time update every 2 seconds
        setInterval(function() {
            const newValue = Math.floor(Math.random() * 40) + 20;
            liveData.push(newValue);
            liveData.shift();
            liveActivityChart.updateSeries([{ data: liveData.slice() }]);
        }, 2000);
    }

    // 4. Fleet Status Donut
    const fleetChartEl = document.querySelector("#fleetChart");
    if (fleetChartEl) {
        const fleetOptions = {
            series: data.carStatusCounts || [],
            chart: {
                type: 'donut',
                height: 160
            },
            labels: data.carStatusLabels || [],
            colors: ['#10b981', '#f59e0b', '#ef4444', '#6366f1'],
            legend: { show: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                fontSize: '12px',
                                fontWeight: 600,
                                color: '#64748b'
                            }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            tooltip: { theme: 'light' }
        };
        new ApexCharts(fleetChartEl, fleetOptions).render();
    }
});
