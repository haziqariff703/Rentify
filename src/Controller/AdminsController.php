<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Admins Controller
 *
 * Handling admin-only dashboard, booking approval, and fleet management.
 */
class AdminsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // All actions in this controller require admin role
        $redirect = $this->requireAdmin();
        if ($redirect) {
            return $redirect;
        }
    }

    /**
     * Dashboard method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function dashboard()
    {
        $this->viewBuilder()->setLayout('admin');

        // Fetch some basic statistics for the dashboard
        $carsTable = $this->fetchTable('Cars');
        $bookingsTable = $this->fetchTable('Bookings');
        $usersTable = $this->fetchTable('Users');
        $paymentsTable = $this->fetchTable('Payments');

        $totalCars = $carsTable->find()->count();
        $totalBookings = $bookingsTable->find()->count();
        $totalUsers = $usersTable->find('all')->where(['role !=' => 'admin'])->count();

        // Calculate total revenue safely
        $query = $paymentsTable->find();
        $totalRevenue = $query->select(['total' => $query->func()->sum('amount')])->first();
        $totalRevenue = $totalRevenue->total ?? 0;

        $recentBookings = $bookingsTable->find('all')
            ->contain(['Cars', 'Users'])
            ->order(['Bookings.created' => 'DESC'])
            ->limit(5)
            ->all();

        // Additional Stats for Admin Workflow
        $carCategoriesTable = $this->fetchTable('CarCategories');
        $maintenancesTable = $this->fetchTable('Maintenances');
        $reviewsTable = $this->fetchTable('Reviews');

        $totalCategories = $carCategoriesTable->find()->count();
        $totalMaintenances = $maintenancesTable->find()->count();
        $totalReviews = $reviewsTable->find()->count();

        // Pending Bookings Count (for approval workflow)
        $pendingBookings = $bookingsTable->find()
            ->where(['booking_status' => 'pending'])
            ->count();

        // --- Chart Data: Revenue Trends (Last 6 Months) ---
        $sixMonthsAgo = new \Cake\I18n\FrozenDate('-6 months');

        // Get revenue by month (based on booking start_date for consistency with booking counts)
        $revenueQuery = $bookingsTable->find();
        $revenueResults = $revenueQuery->select([
            'month_str' => $revenueQuery->newExpr("DATE_FORMAT(start_date, '%Y-%m')"),
            'total' => $revenueQuery->func()->sum('total_price')
        ])
            ->where(['start_date >=' => $sixMonthsAgo])
            ->group('month_str')
            ->order(['month_str' => 'ASC'])
            ->all();

        // Build revenue lookup by month
        $revenueByMonth = [];
        foreach ($revenueResults as $row) {
            $revenueByMonth[$row->month_str] = (float)$row->total;
        }

        // --- Chart Data: Booking Counts (Last 6 Months) ---
        // Count by start_date so bookings appear in the month the rental begins
        $bookingCountQuery = $bookingsTable->find();
        $bookingCountResults = $bookingCountQuery->select([
            'month_str' => $bookingCountQuery->newExpr("DATE_FORMAT(start_date, '%Y-%m')"),
            'count' => $bookingCountQuery->func()->count('*')
        ])
            ->where(['start_date >=' => $sixMonthsAgo])
            ->group('month_str')
            ->order(['month_str' => 'ASC'])
            ->all();

        // Build booking lookup by month
        $bookingsByMonth = [];
        foreach ($bookingCountResults as $row) {
            $bookingsByMonth[$row->month_str] = (int)$row->count;
        }

        // --- Combine all months from both datasets ---
        $allMonths = array_unique(array_merge(
            array_keys($revenueByMonth),
            array_keys($bookingsByMonth)
        ));
        sort($allMonths);

        // Build aligned arrays
        $revenueLabels = [];
        $revenueData = [];
        $bookingCountData = [];

        foreach ($allMonths as $monthStr) {
            $dateObj = \DateTime::createFromFormat('Y-m', $monthStr);
            $revenueLabels[] = $dateObj ? $dateObj->format('M Y') : $monthStr;
            $revenueData[] = $revenueByMonth[$monthStr] ?? 0;
            $bookingCountData[] = $bookingsByMonth[$monthStr] ?? 0;
        }

        // --- Chart Data: Fleet Status ---
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
            $carStatusLabels[] = ucfirst($row->status);
            $carStatusCounts[] = $row->count;
        }

        // --- Fleet Tracking Data ---
        $availableCars = $carsTable->find()->where(['status' => 'available'])->count();
        $maintenanceCars = $carsTable->find()->where(['status' => 'maintenance'])->count();

        // Cars Due for Return Today
        $today = new \Cake\I18n\Date();
        $carsDueToday = $bookingsTable->find()
            ->where([
                'booking_status' => 'confirmed',
                'end_date' => $today
            ])
            ->count();

        // Calculate currently rented cars
        $currentlyRentedCars = $bookingsTable->find()
            ->where([
                'booking_status' => 'confirmed',
                'start_date <=' => $today,
                'end_date >=' => $today
            ])
            ->count();

        // --- Top Performing Cars (Revenue Leaderboard) ---
        // Basic query: sum total_price group by car_id
        $topCars = $bookingsTable->find();
        $topCars = $topCars->select([
            'car_model' => 'Cars.car_model',
            'car_image' => 'Cars.image',
            'total_revenue' => $topCars->func()->sum('Bookings.total_price'),
            'booking_count' => $topCars->func()->count('Bookings.id')
        ])
            ->contain(['Cars'])
            ->where(['Bookings.booking_status IN' => ['confirmed', 'completed']])
            ->group(['Bookings.car_id', 'Cars.car_model', 'Cars.image'])
            ->order(['total_revenue' => 'DESC'])
            ->limit(5)
            ->all();

        // --- Maintenance Alerts (Dynamic) ---
        $scheduledMaintenances = $maintenancesTable->find()
            ->where(['status' => 'scheduled'])
            ->count();

        // --- Issue Reviews (Low ratings that may need attention) ---
        $issueReviews = $reviewsTable->find()
            ->contain(['Cars', 'Users'])
            ->where(['Reviews.rating <=' => 2])
            ->order(['Reviews.created' => 'DESC'])
            ->limit(5)
            ->all();

        $issueReviewsCount = $reviewsTable->find()
            ->where(['Reviews.rating <=' => 2])
            ->count();

        // --- Chart Data: Hourly Booking Pulse (Last 24 Hours) ---
        $twentyFourHoursAgo = new \DateTime('-24 hours');
        $hourlyBookingsQuery = $bookingsTable->find();
        $hourlyResults = $hourlyBookingsQuery->select([
            'hour' => $hourlyBookingsQuery->newExpr("DATE_FORMAT(created, '%H')"),
            'count' => $hourlyBookingsQuery->func()->count('*')
        ])
            ->where(['created >=' => $twentyFourHoursAgo])
            ->group('hour')
            ->order(['hour' => 'ASC'])
            ->all();

        // Initialize 24 hours with 0
        $hourlyBookingStats = [];
        $currentHour = (int)date('H');
        for ($i = 23; $i >= 0; $i--) {
            $h = (clone $twentyFourHoursAgo)->modify("+$i hours")->format('H');
            $hourlyBookingStats[$h] = 0;
        }

        foreach ($hourlyResults as $row) {
            $hourlyBookingStats[$row->hour] = (int)$row->count;
        }
        $hourlyBookingCounts = array_values($hourlyBookingStats);
        $hourlyBookingLabels = array_keys($hourlyBookingStats);

        $this->set(compact(
            'totalCars',
            'totalBookings',
            'totalUsers',
            'totalRevenue',
            'recentBookings',
            'totalCategories',
            'totalMaintenances',
            'totalReviews',
            'revenueLabels',
            'revenueData',
            'bookingCountData',
            'carStatusLabels',
            'carStatusCounts',
            'pendingBookings',
            'availableCars',
            'currentlyRentedCars',
            'maintenanceCars',
            'carsDueToday',
            'topCars',
            'scheduledMaintenances',
            'issueReviews',
            'issueReviewsCount',
            'hourlyBookingCounts',
            'hourlyBookingLabels'
        ));
    }

    /**
     * Approve Booking - Admin only
     * Checks for double-booking and updates car status to "Rented"
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects back.
     */
    public function approveBooking($id = null)
    {
        $this->request->allowMethod(['post']);

        $bookingsTable = $this->fetchTable('Bookings');
        $carsTable = $this->fetchTable('Cars');

        $booking = $bookingsTable->get($id, contain: ['Cars']);

        // Check for double-booking (same car, overlapping dates)
        $conflictingBookings = $bookingsTable->find()
            ->where([
                'car_id' => $booking->car_id,
                'id !=' => $booking->id,
                'booking_status' => 'confirmed',
                'OR' => [
                    // New booking starts during existing booking
                    [
                        'start_date <=' => $booking->start_date,
                        'end_date >=' => $booking->start_date,
                    ],
                    // New booking ends during existing booking
                    [
                        'start_date <=' => $booking->end_date,
                        'end_date >=' => $booking->end_date,
                    ],
                    // New booking completely contains existing booking
                    [
                        'start_date >=' => $booking->start_date,
                        'end_date <=' => $booking->end_date,
                    ],
                ]
            ])
            ->count();

        if ($conflictingBookings > 0) {
            $this->Flash->error(__('Cannot approve: This car is already booked for the selected dates (Double-booking prevented).'));
            return $this->redirect($this->referer(['action' => 'dashboard']));
        }

        // Approve the booking
        $booking->booking_status = 'confirmed';

        if ($bookingsTable->save($booking)) {
            $this->Flash->success(__('Booking #{0} approved!', $id));
        } else {
            $this->Flash->error(__('Could not approve the booking. Please try again.'));
        }

        return $this->redirect($this->referer(['action' => 'dashboard']));
    }

    /**
     * Reject Booking - Admin only
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects back.
     */
    public function rejectBooking($id = null)
    {
        $this->request->allowMethod(['post']);

        $bookingsTable = $this->fetchTable('Bookings');
        $booking = $bookingsTable->get($id);

        $booking->booking_status = 'cancelled';

        if ($bookingsTable->save($booking)) {
            $this->Flash->success(__('Booking #{0} has been rejected.', $id));
        } else {
            $this->Flash->error(__('Could not reject the booking. Please try again.'));
        }

        return $this->redirect($this->referer(['action' => 'dashboard']));
    }
}
