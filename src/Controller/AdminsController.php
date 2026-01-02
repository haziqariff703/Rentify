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

        // Use AdminDashboardService to fetch all stats
        // Get period filter from URL query string
        $period = $this->request->getQuery('period');

        $dashboardService = new \App\Service\AdminDashboardService();
        $stats = $dashboardService->getDashboardStats($period);

        $this->set($stats);
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
