<?php

declare(strict_types=1);

namespace App\Service;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\I18n\FrozenDate;
use DateTime;

/**
 * Service class for managing Admin Dashboard statistics and charts.
 *
 * Aggregates data from multiple tables (Cars, Bookings, Users, Payments,
 * CarCategories, Maintenances, Reviews) to provide a comprehensive
 * overview for the admin dashboard. Supports optional date range filtering.
 */
class AdminDashboardService
{
    use LocatorAwareTrait;

    /**
     * Get all statistics for the admin dashboard.
     *
     * Returns counts, comparisons, chart data, fleet status, and alerts.
     * Supports optional period filtering for time-sensitive metrics.
     *
     * @param string|null $period Filter period: 'today', 'week', 'month', 'quarter', or null for all time.
     * @return array Associative array containing all dashboard statistics and chart data.
     */
    public function getDashboardStats(?string $period = null): array
    {
        $carsTable = $this->fetchTable('Cars');
        $bookingsTable = $this->fetchTable('Bookings');
        $usersTable = $this->fetchTable('Users');
        $paymentsTable = $this->fetchTable('Payments');
        $carCategoriesTable = $this->fetchTable('CarCategories');
        $maintenancesTable = $this->fetchTable('Maintenances');
        $reviewsTable = $this->fetchTable('Reviews');

        // Calculate date range based on period filter
        $dateFilter = $this->getDateRangeForPeriod($period);
        $filterLabel = $this->getPeriodLabel($period);

        // Basic Counts (these are always total, not filtered)
        $totalCars = $carsTable->find()->count();
        $totalCategories = $carCategoriesTable->find()->count();
        $totalMaintenances = $maintenancesTable->find()->count();
        $totalReviews = $reviewsTable->find()->count();

        // Filtered Counts - filter by start_date (when the booking occurs)
        $bookingsQuery = $bookingsTable->find();
        if ($dateFilter) {
            $bookingsQuery->where(['Bookings.start_date >=' => $dateFilter['start']]);
            if ($dateFilter['end']) {
                $bookingsQuery->where(['Bookings.start_date <=' => $dateFilter['end']]);
            }
        }
        $totalBookings = $bookingsQuery->count();

        // Users - keep created date filter (when they registered)
        $usersQuery = $usersTable->find()->where(['role !=' => 'admin']);
        if ($dateFilter) {
            $usersQuery->where(['created >=' => $dateFilter['start']]);
            if ($dateFilter['end']) {
                $usersQuery->where(['created <=' => $dateFilter['end']]);
            }
        }
        $totalUsers = $usersQuery->count();

        // Total Revenue - filtered by booking start_date (consistent with chart)
        // For filtered periods, use bookings.total_price to match the chart data
        if ($dateFilter) {
            $revenueQuery = $bookingsTable->find();
            $revenueQuery->where(['start_date >=' => $dateFilter['start']]);
            if ($dateFilter['end']) {
                $revenueQuery->where(['start_date <=' => $dateFilter['end']]);
            }
            $totalRevenue = $revenueQuery->select(['total' => $revenueQuery->func()->sum('total_price')])->first();
        } else {
            // For "All Time", use payments table for actual collected revenue
            $revenueQuery = $paymentsTable->find();
            $totalRevenue = $revenueQuery->select(['total' => $revenueQuery->func()->sum('amount')])->first();
        }
        $totalRevenue = (float)($totalRevenue->total ?? 0);

        // Pending Bookings
        $pendingBookings = $bookingsTable->find()
            ->where(['booking_status' => 'pending'])
            ->count();

        // Pending Bookings List (for inline approvals)
        $pendingBookingsList = $bookingsTable->find()
            ->contain(['Cars', 'Users'])
            ->where(['booking_status' => 'pending'])
            ->order(['Bookings.created' => 'DESC'])
            ->limit(3)
            ->all();

        // Recent Bookings
        $recentBookings = $bookingsTable->find()
            ->contain(['Cars', 'Users'])
            ->order(['Bookings.created' => 'DESC'])
            ->limit(5)
            ->all();

        // Month-over-Month Comparison
        $comparisons = $this->getComparisons($bookingsTable, $paymentsTable, $usersTable);

        // Charts - pass the period for proper filtering
        $trends = $this->getRevenueAndBookingTrends($bookingsTable, $dateFilter, $period);
        $fleetStatus = $this->getFleetStatus($carsTable);
        $hourlyPulse = $this->getHourlyPulse($bookingsTable);

        // Fleet Tracking
        $availableCars = $carsTable->find()->where(['status' => 'available'])->count();
        $maintenanceCars = $carsTable->find()->where(['status' => 'maintenance'])->count();

        $today = new FrozenDate();
        $carsDueToday = $bookingsTable->find()
            ->where([
                'booking_status' => 'confirmed',
                'end_date' => $today
            ])
            ->count();

        $currentlyRentedCars = $bookingsTable->find()
            ->where([
                'booking_status' => 'confirmed',
                'start_date <=' => $today,
                'end_date >=' => $today
            ])
            ->count();

        // Top Performing Cars - pass dateFilter
        $topCars = $this->getTopCars($bookingsTable, $dateFilter);

        // Alerts
        $scheduledMaintenances = $maintenancesTable->find()
            ->where(['status' => 'scheduled'])
            ->count();

        $issueReviews = $reviewsTable->find()
            ->contain(['Cars', 'Users'])
            ->where(['Reviews.rating <=' => 2])
            ->order(['Reviews.created' => 'DESC'])
            ->limit(5)
            ->all();

        $issueReviewsCount = $reviewsTable->find()
            ->where(['Reviews.rating <=' => 2])
            ->count();

        return array_merge(
            compact(
                'totalCars',
                'totalBookings',
                'totalUsers',
                'totalRevenue',
                'recentBookings',
                'totalCategories',
                'totalMaintenances',
                'totalReviews',
                'pendingBookings',
                'pendingBookingsList',
                'availableCars',
                'maintenanceCars',
                'carsDueToday',
                'currentlyRentedCars',
                'topCars',
                'scheduledMaintenances',
                'issueReviews',
                'issueReviewsCount',
                'filterLabel'
            ),
            $comparisons,
            $trends,
            $fleetStatus,
            $hourlyPulse
        );
    }

    private function getComparisons($bookingsTable, $paymentsTable, $usersTable): array
    {
        $thisMonth = new FrozenDate('first day of this month');
        $lastMonth = new FrozenDate('first day of last month');
        $lastMonthEnd = new FrozenDate('last day of last month');
        $thisWeek = new FrozenDate('-7 days');

        // Bookings Growth
        $bookingsThisMonth = $bookingsTable->find()->where(['created >=' => $thisMonth])->count();
        $bookingsLastMonth = $bookingsTable->find()->where(['created >=' => $lastMonth, 'created <=' => $lastMonthEnd])->count();

        $bookingsChange = 0;
        if ($bookingsLastMonth > 0) {
            $bookingsChange = round((($bookingsThisMonth - $bookingsLastMonth) / $bookingsLastMonth) * 100, 1);
        } elseif ($bookingsThisMonth > 0) {
            $bookingsChange = 100;
        }

        // Revenue Growth
        $revThis = $paymentsTable->find()->select(['total' => $paymentsTable->find()->func()->sum('amount')])->where(['created >=' => $thisMonth])->first();
        $revLast = $paymentsTable->find()->select(['total' => $paymentsTable->find()->func()->sum('amount')])->where(['created >=' => $lastMonth, 'created <=' => $lastMonthEnd])->first();

        $revenueThisMonth = (float)($revThis->total ?? 0);
        $revenueLastMonth = (float)($revLast->total ?? 0);

        $revenueChange = 0;
        if ($revenueLastMonth > 0) {
            $revenueChange = round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1);
        } elseif ($revenueThisMonth > 0) {
            $revenueChange = 100;
        }

        // New Users
        $newUsersThisWeek = $usersTable->find()
            ->where(['role !=' => 'admin', 'created >=' => $thisWeek])
            ->count();

        return compact('bookingsChange', 'revenueChange', 'newUsersThisWeek');
    }

    private function getRevenueAndBookingTrends($bookingsTable, ?array $dateFilter = null, ?string $period = null): array
    {
        // Determine the appropriate date range for the chart
        if ($dateFilter && $period === 'today') {
            // For "today" - show hourly breakdown or just today's data point
            $start = $dateFilter['start'];
            $end = $dateFilter['end'];

            // Get today's totals as single data point
            $todayRevenue = $bookingsTable->find()
                ->select(['total' => $bookingsTable->find()->func()->sum('total_price')])
                ->where([
                    'start_date >=' => $start,
                    'start_date <=' => $end
                ])
                ->first();

            $todayBookings = $bookingsTable->find()
                ->where([
                    'start_date >=' => $start,
                    'start_date <=' => $end
                ])
                ->count();

            $revenueLabels = ['Today'];
            $revenueData = [(float)($todayRevenue->total ?? 0)];
            $bookingCountData = [$todayBookings];

            return compact('revenueLabels', 'revenueData', 'bookingCountData');
        } elseif ($dateFilter && in_array($period, ['week', 'month'])) {
            // For week/month - show daily breakdown
            $start = $dateFilter['start'];
            $end = $dateFilter['end'];

            // Revenue by day
            $revenueQuery = $bookingsTable->find();
            $revenueResults = $revenueQuery->select([
                'day_str' => $revenueQuery->newExpr("DATE_FORMAT(start_date, '%Y-%m-%d')"),
                'total' => $revenueQuery->func()->sum('total_price')
            ])
                ->where([
                    'start_date >=' => $start,
                    'start_date <=' => $end
                ])
                ->group('day_str')
                ->order(['day_str' => 'ASC'])
                ->all();

            $revenueByDay = [];
            foreach ($revenueResults as $row) {
                $revenueByDay[$row->day_str] = (float)$row->total;
            }

            // Bookings by day
            $bookingCountQuery = $bookingsTable->find();
            $bookingCountResults = $bookingCountQuery->select([
                'day_str' => $bookingCountQuery->newExpr("DATE_FORMAT(start_date, '%Y-%m-%d')"),
                'count' => $bookingCountQuery->func()->count('*')
            ])
                ->where([
                    'start_date >=' => $start,
                    'start_date <=' => $end
                ])
                ->group('day_str')
                ->order(['day_str' => 'ASC'])
                ->all();

            $bookingsByDay = [];
            foreach ($bookingCountResults as $row) {
                $bookingsByDay[$row->day_str] = (int)$row->count;
            }

            // Merge
            $allDays = array_unique(array_merge(array_keys($revenueByDay), array_keys($bookingsByDay)));
            sort($allDays);

            $revenueLabels = [];
            $revenueData = [];
            $bookingCountData = [];

            foreach ($allDays as $dayStr) {
                $dateObj = DateTime::createFromFormat('Y-m-d', $dayStr);
                $revenueLabels[] = $dateObj ? $dateObj->format('M j') : $dayStr;
                $revenueData[] = $revenueByDay[$dayStr] ?? 0;
                $bookingCountData[] = $bookingsByDay[$dayStr] ?? 0;
            }

            return compact('revenueLabels', 'revenueData', 'bookingCountData');
        } elseif ($dateFilter && $period === 'quarter') {
            // For quarter (Last 3 Months) - show monthly breakdown
            $start = $dateFilter['start'];
            $end = $dateFilter['end'];

            // Revenue by month
            $revenueQuery = $bookingsTable->find();
            $revenueResults = $revenueQuery->select([
                'month_str' => $revenueQuery->newExpr("DATE_FORMAT(start_date, '%Y-%m')"),
                'total' => $revenueQuery->func()->sum('total_price')
            ])
                ->where([
                    'start_date >=' => $start,
                    'start_date <=' => $end
                ])
                ->group('month_str')
                ->order(['month_str' => 'ASC'])
                ->all();

            $revenueByMonth = [];
            foreach ($revenueResults as $row) {
                $revenueByMonth[$row->month_str] = (float)$row->total;
            }

            // Bookings by month
            $bookingCountQuery = $bookingsTable->find();
            $bookingCountResults = $bookingCountQuery->select([
                'month_str' => $bookingCountQuery->newExpr("DATE_FORMAT(start_date, '%Y-%m')"),
                'count' => $bookingCountQuery->func()->count('*')
            ])
                ->where([
                    'start_date >=' => $start,
                    'start_date <=' => $end
                ])
                ->group('month_str')
                ->order(['month_str' => 'ASC'])
                ->all();

            $bookingsByMonth = [];
            foreach ($bookingCountResults as $row) {
                $bookingsByMonth[$row->month_str] = (int)$row->count;
            }

            // Merge
            $allMonths = array_unique(array_merge(array_keys($revenueByMonth), array_keys($bookingsByMonth)));
            sort($allMonths);

            $revenueLabels = [];
            $revenueData = [];
            $bookingCountData = [];

            foreach ($allMonths as $monthStr) {
                $dateObj = DateTime::createFromFormat('Y-m', $monthStr);
                $revenueLabels[] = $dateObj ? $dateObj->format('M Y') : $monthStr;
                $revenueData[] = $revenueByMonth[$monthStr] ?? 0;
                $bookingCountData[] = $bookingsByMonth[$monthStr] ?? 0;
            }

            return compact('revenueLabels', 'revenueData', 'bookingCountData');
        }

        // Default: last 6 months (no filter or unknown period)
        $sixMonthsAgo = new FrozenDate('-6 months');

        // Revenue by month
        $revenueQuery = $bookingsTable->find();
        $revenueResults = $revenueQuery->select([
            'month_str' => $revenueQuery->newExpr("DATE_FORMAT(start_date, '%Y-%m')"),
            'total' => $revenueQuery->func()->sum('total_price')
        ])
            ->where(['start_date >=' => $sixMonthsAgo])
            ->group('month_str')
            ->order(['month_str' => 'ASC'])
            ->all();

        $revenueByMonth = [];
        foreach ($revenueResults as $row) {
            $revenueByMonth[$row->month_str] = (float)$row->total;
        }

        // Bookings by month
        $bookingCountQuery = $bookingsTable->find();
        $bookingCountResults = $bookingCountQuery->select([
            'month_str' => $bookingCountQuery->newExpr("DATE_FORMAT(start_date, '%Y-%m')"),
            'count' => $bookingCountQuery->func()->count('*')
        ])
            ->where(['start_date >=' => $sixMonthsAgo])
            ->group('month_str')
            ->order(['month_str' => 'ASC'])
            ->all();

        $bookingsByMonth = [];
        foreach ($bookingCountResults as $row) {
            $bookingsByMonth[$row->month_str] = (int)$row->count;
        }

        // Merge
        $allMonths = array_unique(array_merge(array_keys($revenueByMonth), array_keys($bookingsByMonth)));
        sort($allMonths);

        $revenueLabels = [];
        $revenueData = [];
        $bookingCountData = [];

        foreach ($allMonths as $monthStr) {
            $dateObj = DateTime::createFromFormat('Y-m', $monthStr);
            $revenueLabels[] = $dateObj ? $dateObj->format('M Y') : $monthStr;
            $revenueData[] = $revenueByMonth[$monthStr] ?? 0;
            $bookingCountData[] = $bookingsByMonth[$monthStr] ?? 0;
        }

        return compact('revenueLabels', 'revenueData', 'bookingCountData');
    }

    private function getFleetStatus($carsTable): array
    {
        $carStatusQuery = $carsTable->find();
        $carStatusResults = $carStatusQuery->select([
            'status',
            'count' => $carStatusQuery->func()->count('*')
        ])
            ->group(['status'])
            ->all();

        $carStatusLabels = [];
        $carStatusCounts = [];

        foreach ($carStatusResults as $row) {
            $carStatusLabels[] = ucfirst($row->status ?? 'Available');
            $carStatusCounts[] = $row->count;
        }

        return compact('carStatusLabels', 'carStatusCounts');
    }

    private function getHourlyPulse($bookingsTable): array
    {
        $twentyFourHoursAgo = new DateTime('-24 hours');
        $hourlyBookingsQuery = $bookingsTable->find();
        $hourlyResults = $hourlyBookingsQuery->select([
            'hour' => $hourlyBookingsQuery->newExpr("DATE_FORMAT(created, '%H')"),
            'count' => $hourlyBookingsQuery->func()->count('*')
        ])
            ->where(['created >=' => $twentyFourHoursAgo])
            ->group('hour')
            ->order(['hour' => 'ASC'])
            ->all();

        $hourlyBookingStats = [];
        for ($i = 23; $i >= 0; $i--) {
            $h = (clone $twentyFourHoursAgo)->modify("+$i hours")->format('H');
            $hourlyBookingStats[$h] = 0;
        }

        foreach ($hourlyResults as $row) {
            $hourlyBookingStats[$row->hour] = (int)$row->count;
        }

        $hourlyBookingCounts = array_values($hourlyBookingStats);
        $hourlyBookingLabels = array_keys($hourlyBookingStats);

        return compact('hourlyBookingCounts', 'hourlyBookingLabels');
    }

    private function getTopCars($bookingsTable, ?array $dateFilter = null)
    {
        $topCars = $bookingsTable->find();
        $query = $topCars->select([
            'car_model' => 'Cars.car_model',
            'car_image' => 'Cars.image',
            'total_revenue' => $topCars->func()->sum('Bookings.total_price'),
            'booking_count' => $topCars->func()->count('Bookings.id')
        ])
            ->contain(['Cars'])
            ->where(['Bookings.booking_status IN' => ['confirmed', 'completed']]);

        // Apply date filter if provided
        if ($dateFilter) {
            $query->where(['Bookings.start_date >=' => $dateFilter['start']]);
            if ($dateFilter['end']) {
                $query->where(['Bookings.start_date <=' => $dateFilter['end']]);
            }
        }

        return $query
            ->group(['Bookings.car_id', 'Cars.car_model', 'Cars.image'])
            ->order(['total_revenue' => 'DESC'])
            ->limit(5)
            ->all();
    }

    /**
     * Get date range for a given period
     */
    private function getDateRangeForPeriod(?string $period): ?array
    {
        if (!$period) {
            return null;
        }

        $end = new FrozenDate();

        switch ($period) {
            case 'today':
                $start = new FrozenDate('today');
                break;
            case 'week':
                $start = new FrozenDate('-7 days');
                break;
            case 'month':
                $start = new FrozenDate('first day of this month');
                break;
            case 'quarter':
                $start = new FrozenDate('-3 months');
                break;
            default:
                return null;
        }

        return ['start' => $start, 'end' => $end];
    }

    /**
     * Get human-readable label for period
     */
    private function getPeriodLabel(?string $period): string
    {
        return match ($period) {
            'today' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'quarter' => 'Last 3 Months',
            default => 'All Time'
        };
    }
}
