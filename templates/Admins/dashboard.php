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
 */
?>

<!-- Analytics Header -->
<div class="analytics-header">
    <h2>Analytics</h2>
    <div class="date-filter">
        <button class="btn btn-light">
            <i class="fas fa-calendar me-2"></i>
            <?= date('M d, Y') ?>
        </button>
        <button class="btn btn-primary" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border: none;">
            <i class="fas fa-download me-2"></i>
            Export
        </button>
    </div>
</div>

<!-- Stat Cards Row -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-indicator blue"></span>
                <span class="stat-label">Total Cars</span>
            </div>
            <h3 class="stat-value"><?= number_format($totalCars) ?></h3>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-indicator green"></span>
                <span class="stat-label">Total Bookings</span>
            </div>
            <h3 class="stat-value"><?= number_format($totalBookings) ?></h3>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-indicator orange"></span>
                <span class="stat-label">Registered Users</span>
            </div>
            <h3 class="stat-value"><?= number_format($totalUsers) ?></h3>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-indicator purple"></span>
                <span class="stat-label">Total Revenue</span>
            </div>
            <h3 class="stat-value">$<?= number_format($totalRevenue, 2) ?></h3>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <!-- Main Chart - Highlight Section -->
    <div class="col-lg-8">
        <div class="highlight-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="widget-title mb-0">Highlight</h5>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #6366f1;"></span>
                        Revenue
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #22c55e;"></span>
                        Bookings
                    </div>
                </div>
            </div>
            <div style="height: 280px;">
                <div id="highlightChart"></div>
            </div>
        </div>
    </div>

    <!-- Side Widgets Column -->
    <div class="col-lg-4">
        <!-- Orders Widget -->
        <div class="side-widget">
            <div class="side-widget-header">
                <span class="side-widget-title">Orders</span>
                <span class="side-widget-value"><?= number_format($totalBookings) ?></span>
            </div>
            <div style="height: 60px;">
                <div id="ordersChart"></div>
            </div>
        </div>

        <!-- Earnings Widget -->
        <div class="side-widget">
            <div class="side-widget-header">
                <span class="side-widget-title">Earnings</span>
            </div>
            <div class="earnings-amount">$<?= number_format($totalRevenue, 2) ?></div>
            <div style="height: 50px; margin-top: 8px;">
                <div id="earningsChart"></div>
            </div>
        </div>

        <!-- Fleet Status Widget (Donut) -->
        <div class="side-widget">
            <div class="side-widget-header">
                <span class="side-widget-title">Fleet Status</span>
            </div>
            <div style="height: 120px; display: flex; align-items: center; justify-content: center;">
                <div id="fleetChart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings Table -->
<div class="data-table-card">
    <div class="data-table-header">
        <h5 class="widget-title mb-0">Recent Booking Activity</h5>
        <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'index']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
            View All
        </a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Car Model</th>
                <th>Date Range</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($recentBookings)): ?>
                <?php foreach ($recentBookings as $booking): ?>
                    <tr>
                        <td>
                            <div class="fw-semibold"><?= h($booking->user->name ?? 'Unknown User') ?></div>
                            <div class="text-muted small"><?= h($booking->user->email ?? '') ?></div>
                        </td>
                        <td><?= h($booking->car->car_model ?? 'Unknown Car') ?></td>
                        <td class="text-muted">
                            <?= $booking->start_date ? $booking->start_date->format('M d') : 'N/A' ?> -
                            <?= $booking->end_date ? $booking->end_date->format('M d, Y') : 'N/A' ?>
                        </td>
                        <td class="fw-semibold">$<?= number_format((float)$booking->total_price, 2) ?></td>
                        <td>
                            <?php
                            $status = $booking->booking_status ?? $booking->status ?? 'Pending';
                            $statusClass = match (strtolower($status)) {
                                'confirmed', 'completed' => 'confirmed',
                                'cancelled' => 'cancelled',
                                'pending' => 'pending',
                                default => 'pending'
                            };
                            ?>
                            <span class="status-badge <?= $statusClass ?>"><?= h(ucfirst($status)) ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No recent bookings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- ApexCharts Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Highlight Chart (Spline Area Chart for Revenue & Bookings)
        const highlightOptions = {
            series: [{
                name: 'Revenue',
                data: <?= json_encode($revenueData ?? []) ?>
            }, {
                name: 'Bookings',
                data: <?= json_encode(array_map(fn($v) => $v * 0.6, $revenueData ?? [])) ?>
            }],
            chart: {
                type: 'area',
                height: 280,
                fontFamily: "'Inter', sans-serif",
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            colors: ['#6366f1', '#22c55e'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            xaxis: {
                categories: <?= json_encode($revenueLabels ?? []) ?>,
                labels: {
                    style: {
                        colors: '#64748b',
                        fontFamily: "'Inter', sans-serif"
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#64748b',
                        fontFamily: "'Inter', sans-serif"
                    },
                    formatter: function(val) {
                        return '$' + val.toLocaleString();
                    }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 0
            },
            legend: {
                show: false
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val, opts) {
                        if (opts.seriesIndex === 0) {
                            return '$' + val.toLocaleString();
                        }
                        return val.toLocaleString() + ' bookings';
                    }
                }
            }
        };

        const highlightChart = new ApexCharts(document.querySelector("#highlightChart"), highlightOptions);
        highlightChart.render();

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
                    columnWidth: '60%',
                    borderRadius: 4
                }
            },
            tooltip: {
                theme: 'dark',
                fixed: {
                    enabled: false
                },
                y: {
                    title: {
                        formatter: function() {
                            return '';
                        }
                    }
                }
            }
        };

        const ordersChart = new ApexCharts(document.querySelector("#ordersChart"), ordersOptions);
        ordersChart.render();

        // 3. Earnings Sparkline (Area)
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
            colors: ['#22c55e'],
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0,
                    stops: [0, 100]
                }
            },
            tooltip: {
                theme: 'dark',
                fixed: {
                    enabled: false
                },
                y: {
                    title: {
                        formatter: function() {
                            return '$';
                        }
                    }
                }
            }
        };

        const earningsChart = new ApexCharts(document.querySelector("#earningsChart"), earningsOptions);
        earningsChart.render();

        // 4. Fleet Status Donut
        const fleetOptions = {
            series: <?= json_encode($carStatusCounts ?? []) ?>,
            chart: {
                type: 'donut',
                height: 120
            },
            labels: <?= json_encode($carStatusLabels ?? []) ?>,
            colors: ['#22c55e', '#f97316', '#ef4444', '#6366f1', '#64748b'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'right',
                fontSize: '11px',
                fontFamily: "'Inter', sans-serif",
                markers: {
                    width: 8,
                    height: 8,
                    radius: 12
                },
                itemMargin: {
                    vertical: 4
                }
            },
            stroke: {
                width: 0
            },
            tooltip: {
                theme: 'dark'
            }
        };

        const fleetChart = new ApexCharts(document.querySelector("#fleetChart"), fleetOptions);
        fleetChart.render();
    });
</script>