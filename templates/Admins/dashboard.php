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
                <canvas id="highlightChart"></canvas>
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
                <canvas id="ordersChart"></canvas>
            </div>
        </div>

        <!-- Earnings Widget -->
        <div class="side-widget">
            <div class="side-widget-header">
                <span class="side-widget-title">Earnings</span>
            </div>
            <div class="earnings-amount">$<?= number_format($totalRevenue, 2) ?></div>
            <div style="height: 50px; margin-top: 8px;">
                <canvas id="earningsChart"></canvas>
            </div>
        </div>

        <!-- Fleet Status Widget (Donut) -->
        <div class="side-widget">
            <div class="side-widget-header">
                <span class="side-widget-title">Fleet Status</span>
            </div>
            <div style="height: 120px; display: flex; align-items: center; justify-content: center;">
                <canvas id="fleetChart"></canvas>
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

<!-- Chart.js Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#64748b';

        // 1. Highlight Chart (Area Chart)
        const ctxHighlight = document.getElementById('highlightChart').getContext('2d');

        let gradientBlue = ctxHighlight.createLinearGradient(0, 0, 0, 280);
        gradientBlue.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
        gradientBlue.addColorStop(1, 'rgba(99, 102, 241, 0)');

        let gradientGreen = ctxHighlight.createLinearGradient(0, 0, 0, 280);
        gradientGreen.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
        gradientGreen.addColorStop(1, 'rgba(34, 197, 94, 0)');

        new Chart(ctxHighlight, {
            type: 'line',
            data: {
                labels: <?= json_encode($revenueLabels ?? []) ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?= json_encode($revenueData ?? []) ?>,
                    borderColor: '#6366f1',
                    backgroundColor: gradientBlue,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#6366f1'
                }, {
                    label: 'Bookings',
                    data: <?= json_encode(array_map(fn($v) => $v * 0.6, $revenueData ?? [])) ?>,
                    borderColor: '#22c55e',
                    backgroundColor: gradientGreen,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#22c55e'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        ticks: {
                            callback: (v) => '$' + v.toLocaleString()
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // 2. Orders Bar Chart
        const ctxOrders = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctxOrders, {
            type: 'bar',
            data: {
                labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
                datasets: [{
                    data: [65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: '#6366f1',
                    borderRadius: 4,
                    barThickness: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                }
            }
        });

        // 3. Earnings Sparkline
        const ctxEarnings = document.getElementById('earningsChart').getContext('2d');
        let earningsGradient = ctxEarnings.createLinearGradient(0, 0, 0, 50);
        earningsGradient.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
        earningsGradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

        new Chart(ctxEarnings, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: [30, 45, 35, 50, 40, 60, 55],
                    borderColor: '#22c55e',
                    backgroundColor: earningsGradient,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        display: false
                    }
                }
            }
        });

        // 4. Fleet Status Donut
        const ctxFleet = document.getElementById('fleetChart').getContext('2d');
        new Chart(ctxFleet, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($carStatusLabels ?? []) ?>,
                datasets: [{
                    data: <?= json_encode($carStatusCounts ?? []) ?>,
                    backgroundColor: ['#22c55e', '#f97316', '#ef4444', '#6366f1', '#64748b'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 6,
                            padding: 12,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>