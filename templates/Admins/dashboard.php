<?php

/**
 * @var \App\View\AppView $this
 * @var int $totalCars
 * @var int $totalBookings
 * @var int $totalUsers
 * @var float $totalRevenue
 * @var iterable $recentBookings
 * @var array $revenueLabels
 * @var array $revenueData
 * @var array $carStatusLabels
 * @var array $carStatusCounts
 * @var int $pendingBookings
 * @var int $carsDueToday
 * @var iterable $topCars
 */
?>

<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: 1px solid rgba(255, 255, 255, 0.5);
        --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: var(--glass-border);
        box-shadow: var(--glass-shadow);
        border-radius: 20px;
        padding: 24px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.1);
    }

    .widget-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-value-lg {
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: -1px;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* FullCalendar Customization */
    #calendar {
        font-family: 'Inter', sans-serif;
    }

    .fc-theme-standard .fc-scrollgrid {
        border: none;
    }

    .fc-scroller {
        overflow-y: hidden !important;
    }

    .fc-daygrid-day-frame {
        min-height: 80px;
    }

    .fc-event {
        border-radius: 6px;
        border: none;
        padding: 2px 4px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
    }

    .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 700;
    }

    .fc-button {
        background: white !important;
        color: #64748b !important;
        border: 1px solid #e2e8f0 !important;
        font-weight: 600 !important;
        text-transform: capitalize !important;
        box-shadow: none !important;
    }

    .fc-button-active {
        background: #f1f5f9 !important;
        color: #0f172a !important;
    }

    .fc-button-primary {
        border-color: transparent !important;
    }

    /* Action Widget */
    .action-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }

    .action-item:last-child {
        border-bottom: none;
    }

    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 1.2rem;
    }

    .bg-soft-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .bg-soft-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .bg-soft-info {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    /* Top Cars */
    .car-leaderboard-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .car-thumb {
        width: 50px;
        height: 35px;
        border-radius: 6px;
        object-fit: cover;
        margin-right: 15px;
        background: #f1f5f9;
    }
</style>

<!-- Analytics Header -->
<?php
$hour = (int) date('H');
$greeting = match (true) {
    $hour < 12 => 'Good morning',
    $hour < 17 => 'Good afternoon',
    default => 'Good evening'
};
?>
<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold mb-1" style="color: #0f172a;">Dashboard Overview</h2>
        <p class="text-muted mb-0"><?= $greeting ?>, Admin! Here's what's happening today.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-white shadow-sm border">
            <i class="fas fa-filter me-2 text-muted"></i> Filter
        </button>
        <button class="btn btn-primary shadow-lg" style="background: var(--primary-gradient); border: none;">
            <i class="fas fa-plus me-2"></i> Quick Action
        </button>
    </div>
</div>

<!-- Stat Cards Row -->
<div class="row g-4 mb-5">
    <!-- Total Bookings -->
    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-10">
                <i class="fas fa-calendar-check fa-4x text-primary"></i>
            </div>
            <div class="mb-2 text-uppercase fw-bold text-muted small tracking-wider">Total Bookings</div>
            <div class="stat-value-lg"><?= number_format($totalBookings) ?></div>
            <div class="mt-2 text-success small fw-semibold">
                <i class="fas fa-arrow-up me-1"></i> +12% <span class="text-muted fw-normal">from last month</span>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-10">
                <i class="fas fa-wallet fa-4x text-success"></i>
            </div>
            <div class="mb-2 text-uppercase fw-bold text-muted small tracking-wider">Total Revenue</div>
            <div class="stat-value-lg" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                $<?= number_format($totalRevenue) ?>
            </div>
            <div class="mt-2 text-success small fw-semibold">
                <i class="fas fa-arrow-up me-1"></i> +8.5% <span class="text-muted fw-normal">from last month</span>
            </div>
        </div>
    </div>

    <!-- Active Fleet -->
    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-10">
                <i class="fas fa-car fa-4x text-info"></i>
            </div>
            <div class="mb-2 text-uppercase fw-bold text-muted small tracking-wider">Active Fleet</div>
            <div class="stat-value-lg" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <?= $availableCars + $currentlyRentedCars ?> <span class="fs-5 text-muted">/ <?= $totalCars ?></span>
            </div>
            <div class="mt-2 text-muted small">
                <?= $maintenanceCars ?> cars in maintenance
            </div>
        </div>
    </div>

    <!-- Users -->
    <div class="col-xl-3 col-md-6">
        <div class="glass-card h-100 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-3 opacity-10">
                <i class="fas fa-users fa-4x text-warning"></i>
            </div>
            <div class="mb-2 text-uppercase fw-bold text-muted small tracking-wider">Registered Users</div>
            <div class="stat-value-lg" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <?= number_format($totalUsers) ?>
            </div>
            <div class="mt-2 text-success small fw-semibold">
                <i class="fas fa-arrow-up me-1"></i> +24 <span class="text-muted fw-normal">new this week</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Dashboard Content -->
<div class="row g-4 mb-5">
    <!-- Left Column: Calendar (66%) -->
    <div class="col-xl-8">
        <div class="glass-card mb-5" style="margin-bottom: 60px;">
            <div class="widget-title">
                <div>
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    Booking Interactive Calendar
                </div>
            </div>
            <!-- FullCalendar Container -->
            <div id="calendar" style="height: 500px;"></div>
        </div>

        <!-- Highlight Chart (Revenue) -->
        <div class="glass-card">
            <div class="widget-title mb-3">
                <div>
                    <i class="fas fa-chart-area me-2 text-info"></i>
                    Revenue & Bookings Trend
                </div>
            </div>
            <div style="height: 300px;">
                <div id="highlightChart"></div>
            </div>
        </div>
    </div>

    <!-- Right Column: Action Center & Insights (33%) -->
    <div class="col-xl-4">
        <!-- Action Center -->
        <div class="glass-card mb-4">
            <div class="widget-title">
                <div>
                    <i class="fas fa-bolt me-2 text-warning"></i>
                    Action Center
                </div>
                <span class="badge bg-danger rounded-pill"><?= $pendingBookings + ($carsDueToday ?? 0) ?> New</span>
            </div>
            <div class="action-list">
                <!-- Pending Approvals -->
                <div class="action-item">
                    <div class="d-flex align-items-center">
                        <div class="action-icon bg-soft-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Pending Bookings</div>
                            <div class="small text-muted"><?= $pendingBookings ?> bookings waiting approval</div>
                        </div>
                    </div>
                    <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'index']) ?>" class="btn btn-sm btn-light border">Review</a>
                </div>

                <!-- Returns Due -->
                <div class="action-item">
                    <div class="d-flex align-items-center">
                        <div class="action-icon bg-soft-info">
                            <i class="fas fa-undo"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Returns Due Today</div>
                            <div class="small text-muted"><?= $carsDueToday ?? 0 ?> cars scheduled for return</div>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-light border">View</button>
                </div>

                <!-- Maintenance Alerts (Dynamic) -->
                <div class="action-item">
                    <div class="d-flex align-items-center">
                        <div class="action-icon bg-soft-danger">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Scheduled Maintenance</div>
                            <div class="small text-muted">
                                <?= $maintenanceCars ?> cars in maintenance,
                                <?= $scheduledMaintenances ?? 0 ?> scheduled
                            </div>
                        </div>
                    </div>
                    <a href="<?= $this->Url->build(['controller' => 'Maintenances', 'action' => 'index']) ?>"
                        class="btn btn-sm btn-light border">View</a>
                </div>

                <!-- Issue Reports from Reviews -->
                <?php if (($issueReviewsCount ?? 0) > 0): ?>
                    <div class="action-item">
                        <div class="d-flex align-items-center">
                            <div class="action-icon bg-soft-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Car Issues Reported</div>
                                <div class="small text-muted">
                                    <?= $issueReviewsCount ?> low-rating reviews to check
                                </div>
                            </div>
                        </div>
                        <a href="<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'index', '?' => ['issues' => 1]]) ?>"
                            class="btn btn-sm btn-warning text-white">Review</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Top Performing Cars -->
        <div class="glass-card mb-4">
            <div class="widget-title">
                <div>
                    <i class="fas fa-trophy me-2 text-success"></i>
                    Top Performing Cars
                </div>
            </div>
            <div class="leaderboard-list">
                <?php if (!empty($topCars)): ?>
                    <?php foreach ($topCars as $index => $car): ?>
                        <div class="car-leaderboard-item justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="fw-bold text-muted me-3">#<?= $index + 1 ?></div>
                                <!-- Thumbnail Placeholder or Actual Image -->
                                <?php if (!empty($car->car->image)): ?>
                                    <?= $this->Html->image('cars/' . h($car->car->image), ['class' => 'car-thumb']) ?>
                                <?php else: ?>
                                    <div class="car-thumb d-flex align-items-center justify-content-center text-muted small bg-light">
                                        <i class="fas fa-car"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="fw-bold text-dark small"><?= h($car->car_model) ?></div>
                                    <div class="text-muted" style="font-size: 0.75rem;"><?= h($car->booking_count) ?> bookings</div>
                                </div>
                            </div>
                            <div class="fw-bold text-success small">
                                $<?= number_format((float)$car->total_revenue) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center py-3">No revenue data yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mini Chart Widgets (Stacked) -->
        <div class="row g-3">
            <div class="col-6">
                <div class="glass-card p-3 d-flex flex-column h-100 justify-content-between">
                    <div class="small text-muted fw-bold mb-2">EARNINGS</div>
                    <div id="earningsChart"></div>
                </div>
            </div>
            <div class="col-6">
                <div class="glass-card p-3 d-flex flex-column h-100 justify-content-between">
                    <div class="small text-muted fw-bold mb-2">ORDERS</div>
                    <div id="ordersChart"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="glass-card p-3">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="small text-muted fw-bold">FLEET STATUS</div>
                        <div class="badge bg-light text-dark">Total: <?= $totalCars ?></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div id="fleetChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- FullCalendar Initialization ---
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            themeSystem: 'standard',
            height: 600,
            events: '<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'calendarData']) ?>', // Dynamic URL
            eventClick: function(info) {
                // Simple alert for now, can be a modal later
                alert('Booking: ' + info.event.title + '\nPrice: ' + info.event.extendedProps.price + '\nStatus: ' + info.event.extendedProps.status);
            }
        });
        calendar.render();

        // --- ApexCharts Initialization ---

        // 1. Highlight Chart (Revenue & Bookings Trend)
        // UX Improvements: Y-axis starts at 0, Bar for Revenue, Line for Bookings
        const highlightOptions = {
            series: [{
                name: 'Revenue (RM)',
                type: 'column', // Bar chart for revenue (shows volume better)
                data: <?= json_encode($revenueData ?? []) ?>
            }, {
                name: 'Bookings',
                type: 'line',
                data: <?= json_encode($bookingCountData ?? []) ?>
            }],
            chart: {
                type: 'line',
                height: 300,
                fontFamily: "'Inter', sans-serif",
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
                background: 'transparent'
            },
            colors: ['#6366f1', '#10b981'],
            stroke: {
                curve: 'straight', // Straight lines for honest data representation
                width: [0, 3] // 0 for bars, 3 for line
            },
            fill: {
                type: ['solid', 'solid'],
                opacity: [0.85, 1]
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '50%'
                }
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: [0, 5], // Show dots on the booking line
                colors: ['#6366f1', '#10b981'],
                strokeWidth: 2,
                strokeColors: '#fff',
                hover: {
                    size: 7
                }
            },
            xaxis: {
                categories: <?= json_encode($revenueLabels ?? []) ?>,
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        fontSize: '12px',
                        fontWeight: 500
                    }
                }
            },
            yaxis: [{
                    title: {
                        text: 'Revenue (RM)',
                        style: {
                            fontSize: '12px',
                            fontWeight: 600,
                            color: '#6366f1'
                        }
                    },
                    min: 0, // Force Y-axis to start at 0 for honest scale
                    labels: {
                        formatter: function(val) {
                            return 'RM ' + (val ? val.toLocaleString() : '0');
                        }
                    }
                },
                {
                    opposite: true,
                    title: {
                        text: 'Bookings',
                        style: {
                            fontSize: '12px',
                            fontWeight: 600,
                            color: '#10b981'
                        }
                    },
                    min: 0, // Force Y-axis to start at 0 for honest scale
                    labels: {
                        formatter: function(val) {
                            return Math.round(val);
                        }
                    }
                }
            ],
            grid: {
                borderColor: 'rgba(0,0,0,0.08)',
                strokeDashArray: 4,
                padding: {
                    top: 0,
                    bottom: 0
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontWeight: 600,
                markers: {
                    radius: 12
                }
            },
            tooltip: {
                theme: 'light',
                shared: true,
                intersect: false,
                y: {
                    formatter: function(val, {
                        seriesIndex
                    }) {
                        if (seriesIndex === 0) {
                            return 'RM ' + (val ? val.toLocaleString() : '0');
                        }
                        return val + ' bookings';
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#highlightChart"), highlightOptions).render();

        // 2. Orders Bar Chart
        const ordersOptions = {
            series: [{
                data: [65, 59, 80, 81, 56, 55, 40]
            }],
            chart: {
                type: 'bar',
                height: 60,
                sparkline: {
                    enabled: true
                }
            },
            colors: ['#6366f1'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '60%'
                }
            },
            tooltip: {
                theme: 'light',
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: () => ''
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#ordersChart"), ordersOptions).render();

        // 3. Earnings Sparkline
        const earningsOptions = {
            series: [{
                data: [30, 45, 35, 50, 40, 60, 55]
            }],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true
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
                    opacityFrom: 0.4,
                    opacityTo: 0
                }
            },
            tooltip: {
                theme: 'light',
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: () => '$'
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#earningsChart"), earningsOptions).render();

        // 4. Fleet Status Donut
        const fleetOptions = {
            series: <?= json_encode($carStatusCounts ?? []) ?>,
            chart: {
                type: 'donut',
                height: 160
            },
            labels: <?= json_encode($carStatusLabels ?? []) ?>,
            colors: ['#10b981', '#f59e0b', '#ef4444', '#6366f1'],
            legend: {
                show: false
            },
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
            dataLabels: {
                enabled: false
            },
            tooltip: {
                theme: 'light'
            }
        };
        new ApexCharts(document.querySelector("#fleetChart"), fleetOptions).render();
    });
</script>