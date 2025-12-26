<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;

class BookingsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['getBookedDates', 'getCarDetails']); // Allow JS to fetch data

        // ... (Keep your existing Auth checks for admin/customer here) ...
        $user = $this->Authentication->getIdentity();
        $action = $this->request->getParam('action');

        // [Existing Admin/Customer Logic goes here - kept short for brevity]
        if ($action === 'index' && (!$user || $user->role !== 'admin')) {
            return $this->redirect(['action' => 'myBookings']);
        }
    }

    // --- NEW: API to get disabled dates for Flatpickr ---
    public function getBookedDates($carId = null)
    {
        $this->request->allowMethod(['get', 'ajax']);
        $this->viewBuilder()->setClassName('Json');

        $bookings = $this->Bookings->find()
            ->where([
                'car_id' => $carId,
                'booking_status IN' => ['confirmed', 'pending', 'completed'] // Block these
            ])
            ->select(['start_date', 'end_date'])
            ->all();

        $dates = [];
        foreach ($bookings as $booking) {
            // Flatpickr 'disable' accepts ranges like { from: '2025-01-01', to: '2025-01-05' }
            $dates[] = [
                'from' => $booking->start_date->format('Y-m-d'),
                'to'   => $booking->end_date->format('Y-m-d')
            ];
        }

        $this->set(compact('dates'));
        $this->viewBuilder()->setOption('serialize', ['dates']);
    }

    // --- API to get car details for dynamic preview ---
    public function getCarDetails($carId = null)
    {
        $this->request->allowMethod(['get', 'ajax']);
        
        $carsTable = $this->fetchTable('Cars');
        $car = $carsTable->get($carId);

        $data = [
            'id' => $car->id,
            'name' => $car->car_model,
            'image' => $car->image,
            'price_per_day' => $car->price_per_day
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    // --- UPDATED: Add Method with Overlap Check ---
    public function add($carId = null)
    {
        $booking = $this->Bookings->newEmptyEntity();

        if ($this->request->is('post')) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->getData());

            // 1. Validation: Overlap Check
            $exists = $this->Bookings->exists([
                'car_id' => $booking->car_id,
                'booking_status IN' => ['confirmed', 'pending'],
                'OR' => [
                    ['start_date <=' => $booking->end_date, 'end_date >=' => $booking->start_date]
                ]
            ]);

            if ($exists) {
                $this->Flash->error(__('This car is already booked for those dates. Please choose another date.'));
            } else {
                // 2. Calculate Price
                $startDate = $booking->start_date;
                $endDate   = $booking->end_date;
                $days = $endDate->diffInDays($startDate);
                if ($days == 0) $days = 1;

                $car = $this->Bookings->Cars->get($booking->car_id);
                $booking->total_price = $days * $car->price_per_day;

                $booking->user_id = $this->Authentication->getIdentity()->getIdentifier();
                $booking->booking_status = 'pending';

                if ($this->Bookings->save($booking)) {
                    // 3. Auto-Invoice
                    $invoicesTable = $this->fetchTable('Invoices');
                    $invoice = $invoicesTable->newEmptyEntity();
                    $invoice->booking_id = $booking->id;
                    $invoice->invoice_number = 'INV-' . strtoupper(uniqid());
                    $invoice->amount = $booking->total_price;
                    $invoice->status = 'unpaid';
                    $invoicesTable->save($invoice);

                    $this->Flash->success(__('Booking successful! Invoice generated.'));
                    return $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoice->id]);
                }
                $this->Flash->error(__('Unable to add booking.'));
            }
        }

        $users = $this->Bookings->Users->find('list')->all();
        $cars = $this->Bookings->Cars->find('list')->all();
        $this->set(compact('booking', 'users', 'cars', 'carId'));
    }

    /**
     * Index - Admin only: View ALL bookings
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');
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

    /**
     * Cancel Booking with Refund Logic
     */
    public function cancelBooking($id = null)
    {
        $this->request->allowMethod(['post']);

        // 1. Fetch Booking WITH Payments and Invoices to handle logic
        $booking = $this->Bookings->get($id, [
            'contain' => ['Payments', 'Invoices']
        ]);

        $user = $this->Authentication->getIdentity();

        // Verify ownership
        if ($user->getIdentifier() != $booking->user_id) {
            $this->Flash->error(__('You can only cancel your own bookings.'));
            return $this->redirect(['action' => 'myBookings']);
        }

        // Check if already cancelled
        if (in_array($booking->booking_status, ['cancelled', 'refunded', 'completed'])) {
            $this->Flash->error(__('This booking is already processed.'));
            return $this->redirect(['action' => 'myBookings']);
        }

        // Date Check (Standard PHP comparison as discussed)
        $today = FrozenDate::now();
        if ($booking->start_date && $booking->start_date <= $today) {
            $this->Flash->error(__('Cannot cancel a booking that has already started.'));
            return $this->redirect(['action' => 'myBookings']);
        }

        // --- STATUS UPDATE START ---
        $booking->booking_status = 'cancelled';
        $refundTriggered = false;

        // A. Handle Payments (Refund Logic)
        if (!empty($booking->payments)) {
            foreach ($booking->payments as $payment) {
                if ($payment->payment_status === 'paid') {
                    $payment->payment_status = 'refunded'; // Set to Refunded
                    $this->Bookings->Payments->save($payment);
                    $refundTriggered = true;
                }
            }
        }

        // B. Handle Invoices (Void Logic)
        if (!empty($booking->invoices)) {
            foreach ($booking->invoices as $invoice) {
                $invoice->status = 'cancelled'; // Void the invoice
                $this->Bookings->Invoices->save($invoice);
            }
        }

        // C. Note: Car status is no longer updated since availability is 
        //    determined dynamically from bookings, not a static status field.
        // --- STATUS UPDATE END ---

        if ($this->Bookings->save($booking)) {
            if ($refundTriggered) {
                $this->Flash->success(__('Booking cancelled. Payment has been marked as REFUNDED.'));
            } else {
                $this->Flash->success(__('Booking cancelled successfully.'));
            }
        } else {
            $this->Flash->error(__('Could not cancel. Please try again.'));
        }

        return $this->redirect(['action' => 'myBookings']);
    }
    /**
     * Calendar Data API
     * Returns JSON data for FullCalendar
     */
    public function calendarData()
    {
        $this->request->allowMethod(['get', 'ajax']);

        $bookings = $this->Bookings->find('all')
            ->contain(['Cars', 'Users'])
            ->all();

        $events = [];
        foreach ($bookings as $booking) {
            $color = match (strtolower($booking->booking_status)) {
                'confirmed' => '#22c55e', // Green
                'pending' => '#f59e0b',   // Orange
                'completed' => '#3b82f6', // Blue
                'cancelled' => '#ef4444', // Red
                default => '#6b7280'
            };

            $events[] = [
                'id' => $booking->id,
                'title' => $booking->car->car_model . ' (' . $booking->user->name . ')',
                'start' => $booking->start_date->format('Y-m-d'),
                'end' => $booking->end_date->modify('+1 day')->format('Y-m-d'),
                'color' => $color,
                'extendedProps' => [
                    'status' => ucfirst($booking->booking_status),
                    'price' => '$' . number_format((float)$booking->total_price, 2)
                ]
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($events));
    }
}
