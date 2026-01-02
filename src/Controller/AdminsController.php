<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Admins Controller
 *
 * Handles admin-only functionality including the dashboard,
 * booking approval/rejection, and fleet management.
 * All actions require admin role authentication.
 */
class AdminsController extends AppController
{
    /**
     * BookingService instance for booking lifecycle operations.
     *
     * @var \App\Service\BookingService
     */
    protected $BookingService;

    /**
     * Initialize controller components and services.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->BookingService = new \App\Service\BookingService();
    }

    /**
     * Before filter callback - enforces admin access.
     *
     * @param \Cake\Event\EventInterface $event The event object.
     * @return \Cake\Http\Response|null|void Redirects non-admins.
     */
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
     * Admin Dashboard - displays key business metrics and charts.
     *
     * Uses AdminDashboardService to aggregate statistics from
     * Cars, Bookings, Users, Payments, Maintenances, and Reviews.
     * Supports optional period filtering via query parameter.
     *
     * @return void
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
     * Approve a pending booking (Admin only).
     *
     * Delegates to BookingService which performs a final double-booking
     * check before confirming the booking.
     *
     * @param string|null $id The booking ID to approve.
     * @return \Cake\Http\Response|null Redirects back to referring page.
     */
    public function approveBooking($id = null)
    {
        $this->request->allowMethod(['post']);
        $result = $this->BookingService->approveBooking((int)$id);

        if ($result['success']) {
            $this->Flash->success($result['message']);
        } else {
            $this->Flash->error($result['message']);
        }

        return $this->redirect($this->referer(['action' => 'dashboard']));
    }

    /**
     * Reject a pending booking (Admin only).
     *
     * Delegates to BookingService which sets the booking status to 'cancelled'.
     *
     * @param string|null $id The booking ID to reject.
     * @return \Cake\Http\Response|null Redirects back to referring page.
     */
    public function rejectBooking($id = null)
    {
        $this->request->allowMethod(['post']);

        if ($this->BookingService->rejectBooking((int)$id)) {
            $this->Flash->success(__('Booking #{0} has been rejected.', $id));
        } else {
            $this->Flash->error(__('Could not reject the booking. Please try again.'));
        }

        return $this->redirect($this->referer(['action' => 'dashboard']));
    }
}
