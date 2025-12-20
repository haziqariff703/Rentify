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

        // Additional Stats for Admin Workflow
        $carCategoriesTable = $this->fetchTable('CarCategories');
        $maintenancesTable = $this->fetchTable('Maintenances');
        $reviewsTable = $this->fetchTable('Reviews');

        $totalCategories = $carCategoriesTable->find()->count();
        $totalMaintenances = $maintenancesTable->find()->count();
        $totalReviews = $reviewsTable->find()->count();

        $this->set(compact('totalCars', 'totalBookings', 'totalUsers', 'totalRevenue', 'recentBookings', 'totalCategories', 'totalMaintenances', 'totalReviews'));
    }
}
