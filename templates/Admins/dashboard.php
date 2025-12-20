<?php
/**
 * @var \App\View\AppView $this
 * @var int $totalCars
 * @var int $totalBookings
 * @var int $totalUsers
 * @var float $totalRevenue
 * @var iterable $recentBookings
 */
?>
<div class="admin-dashboard py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="fw-bold text-dark"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Admin Dashboard</h1>
                <p class="text-secondary">Overview of system statistics and recent activity.</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary-subtle text-primary p-3 rounded-4 me-3">
                                <i class="fas fa-car fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold mb-0">Total Cars</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0"><?= number_format($totalCars) ?></h2>
                        <div class="mt-3">
                            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="text-decoration-none small">Manage Cars <i class="fas fa-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success-subtle text-success p-3 rounded-4 me-3">
                                <i class="fas fa-calendar-check fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold mb-0">Total Bookings</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0"><?= number_format($totalBookings) ?></h2>
                        <div class="mt-3">
                            <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'index']) ?>" class="text-decoration-none small text-success">Manage Bookings <i class="fas fa-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info-subtle text-info p-3 rounded-4 me-3">
                                <i class="fas fa-users fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold mb-0">Registered Users</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0"><?= number_format($totalUsers) ?></h2>
                        <div class="mt-3">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="text-decoration-none small text-info">Manage Users <i class="fas fa-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning-subtle text-warning p-3 rounded-4 me-3">
                                <i class="fas fa-dollar-sign fs-4 px-1"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold mb-0">Total Revenue</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0">$<?= number_format($totalRevenue, 2) ?></h2>
                        <div class="mt-3">
                            <a href="<?= $this->Url->build(['controller' => 'Payments', 'action' => 'index']) ?>" class="text-decoration-none small text-warning">View Payments <i class="fas fa-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary-subtle text-secondary p-3 rounded-4 me-3">
                                <i class="fas fa-tags fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold mb-0">Car Categories</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0"><?= number_format($totalCategories) ?></h2>
                        <div class="mt-3">
                            <a href="<?= $this->Url->build(['controller' => 'CarCategories', 'action' => 'index']) ?>" class="text-decoration-none small text-secondary">Manage Categories <i class="fas fa-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger-subtle text-danger p-3 rounded-4 me-3">
                                <i class="fas fa-tools fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold mb-0">Maintenance Logs</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0"><?= number_format($totalMaintenances) ?></h2>
                        <div class="mt-3">
                            <a href="<?= $this->Url->build(['controller' => 'Maintenances', 'action' => 'index']) ?>" class="text-decoration-none small text-danger">Manage Maintenance <i class="fas fa-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-purple-subtle text-purple p-3 rounded-4 me-3">
                                <i class="fas fa-star fs-4"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold mb-0">Customer Reviews</h6>
                        </div>
                        <h2 class="card-title fw-bold mb-0"><?= number_format($totalReviews) ?></h2>
                        <div class="mt-3">
                            <a href="<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'index']) ?>" class="text-decoration-none small text-purple">Moderate Reviews <i class="fas fa-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Bookings Table -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Recent Bookings</h5>
                            <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'index']) ?>" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">User</th>
                                        <th>Car</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-end pe-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentBookings as $booking): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark"><?= h($booking->user->name) ?></div>
                                            <div class="text-muted small"><?= h($booking->user->email) ?></div>
                                        </td>
                                        <td><?= h($booking->car->car_model) ?></td>
                                        <td>
                                            <?php
                                                $statusClass = 'bg-secondary';
                                                if ($booking->status === 'Confirmed') $statusClass = 'bg-success';
                                                if ($booking->status === 'Pending') $statusClass = 'bg-warning text-dark';
                                                if ($booking->status === 'Cancelled') $statusClass = 'bg-danger';
                                            ?>
                                            <span class="badge <?= $statusClass ?> rounded-pill"><?= h($booking->status) ?></span>
                                        </td>
                                        <td class="text-muted small"><?= $booking->created->format('M d, Y') ?></td>
                                        <td class="text-end pe-4 fw-bold">$<?= number_format($booking->total_price, 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <h5 class="fw-bold mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body px-4">
                        <div class="d-grid gap-3">
                            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'add']) ?>" class="btn btn-light text-start p-3 border rounded-3 d-flex align-items-center">
                                <div class="bg-primary text-white p-2 rounded-3 me-3">
                                    <i class="fas fa-plus fa-fw"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Add New Car</div>
                                    <div class="text-muted small">Expand your fleet</div>
                                </div>
                            </a>
                            <a href="<?= $this->Url->build(['controller' => 'CarCategories', 'action' => 'add']) ?>" class="btn btn-light text-start p-3 border rounded-3 d-flex align-items-center">
                                <div class="bg-info text-white p-2 rounded-3 me-3">
                                    <i class="fas fa-tags fa-fw"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Add Category</div>
                                    <div class="text-muted small">Manage car types</div>
                                </div>
                            </a>
                            <a href="<?= $this->Url->build(['controller' => 'Maintenances', 'action' => 'add']) ?>" class="btn btn-light text-start p-3 border rounded-3 d-flex align-items-center">
                                <div class="bg-warning text-white p-2 rounded-3 me-3">
                                    <i class="fas fa-tools fa-fw"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">New Maintenance</div>
                                    <div class="text-muted small">Log repair activity</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1); }
    .bg-info-subtle { background-color: rgba(13, 202, 240, 0.1); }
    .bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1); }
    .bg-secondary-subtle { background-color: rgba(108, 117, 125, 0.1); }
    .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.1); }
    .bg-purple-subtle { background-color: rgba(111, 66, 193, 0.1); }
    .text-purple { color: #6f42c1; }
</style>
