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
        $this->loadModel('Cars');
        $this->loadModel('Bookings');
        $this->loadModel('Users');
        $this->loadModel('Payments');

        $totalCars = $this->Cars->find()->count();
        $totalBookings = $this->Bookings->find()->count();
        $totalUsers = $this->Users->find('all')->where(['role !=' => 'admin'])->count();
        
        $totalRevenue = $this->Payments->find();
        $totalRevenue = $totalRevenue->select(['total' => $totalRevenue->func()->sum('amount')])->first()->total ?? 0;

        $recentBookings = $this->Bookings->find('all')
            ->contain(['Cars', 'Users'])
            ->order(['Bookings.created' => 'DESC'])
            ->limit(5)
            ->all();

        $this->set(compact('totalCars', 'totalBookings', 'totalUsers', 'totalRevenue', 'recentBookings'));
    }
}
