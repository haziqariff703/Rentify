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

        $user = $this->Authentication->getIdentity();
        if (!$user || $user->role !== 'admin') {
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
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

        $revenueQuery = $paymentsTable->find();
        $revenueResults = $revenueQuery->select([
            'month_str' => $revenueQuery->newExpr("DATE_FORMAT(payment_date, '%Y-%m')"),
            'total' => $revenueQuery->func()->sum('amount')
        ])
            ->where(['payment_date >=' => $sixMonthsAgo])
            ->group('month_str')
            ->order(['month_str' => 'ASC'])
            ->all();

        $revenueLabels = [];
        $revenueData = [];

        foreach ($revenueResults as $row) {
            $dateObj = \DateTime::createFromFormat('Y-m', $row->month_str);
            $revenueLabels[] = $dateObj ? $dateObj->format('M Y') : $row->month_str;
            $revenueData[] = $row->total;
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

        // Fleet Tracking Data
        $availableCars = $carsTable->find()->where(['status' => 'available'])->count();
        $rentedCars = $carsTable->find()->where(['status' => 'rented'])->count();
        $maintenanceCars = $carsTable->find()->where(['status' => 'maintenance'])->count();

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
            'carStatusLabels',
            'carStatusCounts',
            'pendingBookings',
            'availableCars',
            'rentedCars',
            'maintenanceCars'
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
            // Update car status to "Rented"
            $car = $carsTable->get($booking->car_id);
            $car->status = 'rented';
            $carsTable->save($car);

            $this->Flash->success(__('Booking #{0} approved! Car status updated to Rented.', $id));
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
