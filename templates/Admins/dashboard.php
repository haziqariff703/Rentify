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

    /* Live Activity Pulse Animation */
    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        animation: pulse-animation 1.5s infinite ease-in-out;
    }

    @keyframes pulse-animation {
        0% {
            transform: scale(1);
            opacity: 1;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }

        50% {
            transform: scale(1.1);
            opacity: 0.8;
            box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
        }

        100% {
            transform: scale(1);
            opacity: 1;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    /* SweetAlert2 Glassmorphism */
    .glass-swal-popup {
        background: rgba(255, 255, 255, 0.8) !important;
        backdrop-filter: blur(15px) !important;
        -webkit-backdrop-filter: blur(15px) !important;
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1) !important;
        font-family: 'Inter', sans-serif !important;
    }

    .shadow-inner {
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
    }

    .bg-soft-success {
        background: rgba(16, 185, 129, 0.1) !important;
        color: #10b981 !important;
    }

    .bg-soft-warning {
        background: rgba(245, 158, 11, 0.1) !important;
        color: #f59e0b !important;
    }

    .bg-soft-danger {
        background: rgba(239, 68, 68, 0.1) !important;
        color: #ef4444 !important;
    }

    .bg-soft-info {
        background: rgba(59, 130, 246, 0.1) !important;
        color: #3b82f6 !important;
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
        <div class="glass-card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Performance Overview</h5>
                    <p class="text-muted small">Revenue and booking trends for the last 6 months</p>
                </div>
                <div class="d-flex gap-4">
                    <div class="text-end">
                        <div class="text-muted small fw-bold text-uppercase">Total Period Revenue</div>
                        <div class="fw-bold fs-5 text-indigo" style="color: #6366f1;">RM <?= number_format(array_sum($revenueData)) ?></div>
                    </div>
                    <div class="text-end border-start ps-4">
                        <div class="text-muted small fw-bold text-uppercase">Total Bookings</div>
                        <div class="fw-bold fs-5 text-emerald" style="color: #10b981;"><?= array_sum($bookingCountData) ?></div>
                    </div>
                </div>
            </div>
            <div style="height: 320px; margin-top: 10px;">
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
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="small text-muted fw-bold">LIVE ACTIVITY</div>
                        <span class="d-flex align-items-center">
                            <span class="pulse-dot me-1"></span>
                            <span class="text-success small fw-bold">LIVE</span>
                        </span>
                    </div>
                    <div id="liveActivityChart"></div>
                </div>
            </div>
            <div class="col-6">
                <div class="glass-card p-3 d-flex flex-column h-100 justify-content-between">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="small text-muted fw-bold">HOURLY PULSE</div>
                        <div class="text-muted small fw-bold">24H</div>
                    </div>
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
    window.RentifyData = {
        // URLs
        calendarDataUrl: "<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'calendarData']) ?>",
        bookingViewUrl: "<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'view']) ?>",
        // Chart Data
        revenueData: <?= json_encode($revenueData ?? []) ?>,
        revenueLabels: <?= json_encode($revenueLabels ?? []) ?>,
        bookingCountData: <?= json_encode($bookingCountData ?? []) ?>,
        hourlyBookingCounts: <?= json_encode($hourlyBookingCounts ?? []) ?>,
        hourlyBookingLabels: <?= json_encode($hourlyBookingLabels ?? []) ?>,
        carStatusCounts: <?= json_encode($carStatusCounts ?? []) ?>,
        carStatusLabels: <?= json_encode($carStatusLabels ?? []) ?>
    };
</script>
<script src="<?= $this->Url->assetUrl('js/views/Admins/dashboard.js') ?>?v=<?= time() ?>"></script>