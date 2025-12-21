<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;

class BookingsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $user = $this->Authentication->getIdentity();
        $action = $this->request->getParam('action');

        // Admin-only actions - Admin cannot create bookings
        $adminActions = ['index', 'edit', 'delete'];
        if (in_array($action, $adminActions)) {
            if (!$user || $user->role !== 'admin') {
                $this->Flash->error(__('You are not authorized to access this page.'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }
        }

        // Block admin from creating new bookings
        if ($action === 'add' && $user && $user->role === 'admin') {
            $this->Flash->error(__('Admins cannot create new bookings. Only customers can book cars.'));
            return $this->redirect(['action' => 'index']);
        }

        // Customer-only actions (must be logged in)
        $customerActions = ['myBookings', 'cancelBooking'];
        if (in_array($action, $customerActions)) {
            if (!$user) {
                $this->Flash->error(__('Please login to view your bookings.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        }

        // Use admin layout for admin users
        if ($user && $user->role === 'admin') {
            $this->viewBuilder()->setLayout('admin');
        }
    }

    /**
     * Index - Admin only: View ALL bookings
     */
    public function index()
    {
        $query = $this->Bookings->find()->contain(['Users', 'Cars', 'Invoices']);
        $bookings = $this->paginate($query);
        $this->set(compact('bookings'));
    }

    /**
     * My Bookings - Customer view: Only their own bookings
     */
    public function myBookings()
    {
        $userId = $this->Authentication->getIdentity()->getIdentifier();

        $query = $this->Bookings->find()
            ->where(['Bookings.user_id' => $userId])
            ->contain(['Cars', 'Invoices'])
            ->order(['Bookings.created' => 'DESC']);

        $bookings = $this->paginate($query);
        $this->set(compact('bookings'));
        // Uses default layout (not admin)
    }

    /**
     * View booking details
     * Owner OR Admin can view
     */
    public function view($id = null)
    {
        $booking = $this->Bookings->get($id, contain: ['Users', 'Cars', 'Invoices', 'Payments']);

        // Check ownership: either admin OR booking owner
        $user = $this->Authentication->getIdentity();
        if ($user) {
            $isAdmin = $user->role === 'admin';
            $isOwner = $user->getIdentifier() == $booking->user_id;

            if (!$isAdmin && !$isOwner) {
                $this->Flash->error(__('You are not authorized to view this booking.'));
                return $this->redirect(['action' => 'myBookings']);
            }
        }

        $this->set(compact('booking'));
    }

    /**
     * Cancel Booking - Customer can cancel before start date
     */
    public function cancelBooking($id = null)
    {
        $this->request->allowMethod(['post']);

        $booking = $this->Bookings->get($id);
        $user = $this->Authentication->getIdentity();

        // Verify ownership
        if ($user->getIdentifier() != $booking->user_id) {
            $this->Flash->error(__('You can only cancel your own bookings.'));
            return $this->redirect(['action' => 'myBookings']);
        }

        // Check if already cancelled/completed
        if (in_array($booking->booking_status, ['cancelled', 'refunded', 'completed'])) {
            $this->Flash->error(__('This booking cannot be cancelled.'));
            return $this->redirect(['action' => 'myBookings']);
        }

        // Check if before start date
        $today = FrozenDate::now();
        if ($booking->start_date && $booking->start_date->lte($today)) {
            $this->Flash->error(__('Cannot cancel a booking that has already started.'));
            return $this->redirect(['action' => 'myBookings']);
        }

        // Set status based on whether it was confirmed (needs refund) or pending
        if ($booking->booking_status === 'confirmed') {
            $booking->booking_status = 'refunded';
        } else {
            $booking->booking_status = 'cancelled';
        }

        // If car was rented, set it back to available
        if ($booking->car_id) {
            $car = $this->Bookings->Cars->get($booking->car_id);
            if ($car->status === 'rented') {
                $car->status = 'available';
                $this->Bookings->Cars->save($car);
            }
        }

        if ($this->Bookings->save($booking)) {
            $this->Flash->success(__('Your booking has been cancelled.'));
        } else {
            $this->Flash->error(__('Could not cancel the booking. Please try again.'));
        }

        return $this->redirect(['action' => 'myBookings']);
    }

    public function add($carId = null)
    {
        $booking = $this->Bookings->newEmptyEntity();

        if ($this->request->is('post')) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->getData());

            // 1. Calculate Price
            $startDate = $booking->start_date;
            $endDate   = $booking->end_date;

            if ($startDate && $endDate) {
                $days = $endDate->diffInDays($startDate);
                if ($days == 0) $days = 1;

                // Get Car Price
                $car = $this->Bookings->Cars->get($booking->car_id ?? $carId);
                $booking->total_price = $days * $car->price_per_day;
            }

            // 2. Set Default Data
            $booking->user_id = $this->Authentication->getIdentity()->getIdentifier();
            $booking->booking_status = 'pending';

            if ($this->Bookings->save($booking)) {

                // 3. AUTO-GENERATE INVOICE
                $invoicesTable = $this->fetchTable('Invoices');
                $invoice = $invoicesTable->newEmptyEntity();

                $invoice->booking_id = $booking->id;
                $invoice->invoice_number = 'INV-' . strtoupper(uniqid());
                $invoice->amount = $booking->total_price;
                $invoice->status = 'unpaid';

                $invoicesTable->save($invoice);

                $this->Flash->success(__('Booking saved! Please pay the invoice.'));

                // Redirect to the Invoice to pay
                return $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoice->id]);
            }
            $this->Flash->error(__('The booking could not be saved.'));
        }

        $users = $this->Bookings->Users->find('list')->all();
        $cars = $this->Bookings->Cars->find('list')->all();
        $this->set(compact('booking', 'users', 'cars', 'carId'));
    }

    /**
     * Edit method - Admin only
     */
    public function edit($id = null)
    {
        $booking = $this->Bookings->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->getData());
            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The booking has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The booking could not be saved. Please, try again.'));
        }
        $users = $this->Bookings->Users->find('list', limit: 200)->all();
        $cars = $this->Bookings->Cars->find('list', limit: 200)->all();
        $this->set(compact('booking', 'users', 'cars'));
    }

    /**
     * Delete method - Admin only
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $booking = $this->Bookings->get($id);
        if ($this->Bookings->delete($booking)) {
            $this->Flash->success(__('The booking has been deleted.'));
        } else {
            $this->Flash->error(__('The booking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
