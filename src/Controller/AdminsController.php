<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Admins Controller
 *
 * Handling admin-only dashboard and statistics.
 */
class AdminsController extends AppController
{
    /**
     * Dashboard action
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function dashboard()
    {
        $this->viewBuilder()->setLayout('default');
        
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

        $this->set(compact('totalCars', 'totalBookings', 'totalUsers', 'totalRevenue', 'recentBookings'));
    }
}
