<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;

/**
 * Bookings Controller
 *
 * Handles booking creation, viewing, editing, and cancellation.
 * Provides API endpoints for Flatpickr date blocking and car details.
 *
 * @property \App\Model\Table\BookingsTable $Bookings
 */
class BookingsController extends AppController
{
    /**
     * BookingService instance for business logic.
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

        // Unlock dynamic form fields that are modified by JavaScript
        // These fields are added/changed dynamically in the booking form
        if ($this->components()->has('FormProtection')) {
            $this->FormProtection->setConfig('unlockedFields', [
                'pickup_location',
                'has_chauffeur',
                'has_gps',
                'has_full_insurance',
            ]);
        }
    }

    /**
     * Before filter callback.
     *
     * Allows unauthenticated access to API endpoints.
     * Redirects non-admins from index to myBookings.
     *
     * @param \Cake\Event\EventInterface $event The event object.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['getBookedDates', 'getCarDetails']);

        $user = $this->Authentication->getIdentity();
        $action = $this->request->getParam('action');

        if ($action === 'index' && (!$user || $user->role !== 'admin')) {
            return $this->redirect(['action' => 'myBookings']);
        }
    }

    /**
     * API endpoint: Get booked dates for a car (for Flatpickr date blocking).
     *
     * Returns an array of date ranges that are unavailable for booking.
     *
     * @param int|null $carId The car ID to check.
     * @return void Renders JSON response.
     */
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

    /**
     * API endpoint: Get car details for dynamic booking preview.
     *
     * Returns car info and category service options (chauffeur, GPS, insurance).
     *
     * @param int|null $carId The car ID to fetch details for.
     * @return \Cake\Http\Response JSON response with car data.
     */
    public function getCarDetails($carId = null)
    {
        $this->request->allowMethod(['get', 'ajax']);

        $carsTable = $this->fetchTable('Cars');
        $car = $carsTable->get($carId, contain: ['Categories']);

        $category = $car->category;

        $data = [
            'id' => $car->id,
            'name' => $car->car_model,
            'brand' => $car->brand,
            'image' => $car->image,
            'price_per_day' => $car->price_per_day,
            // Category service data
            'chauffeur_available' => $category->chauffeur_available ?? false,
            'chauffeur_daily_rate' => $category->chauffeur_daily_rate ?? 0,
            'gps_available' => $category->gps_available ?? false,
            'gps_daily_rate' => $category->gps_daily_rate ?? 0,
            'insurance_daily_rate' => $category->insurance_daily_rate ?? 0,
            'security_deposit' => $category->security_deposit ?? 0,
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    /**
     * Create a new booking.
     *
     * Delegates to BookingService for validation, pricing, and invoice generation.
     *
     * @param int|null $carId Optional pre-selected car ID.
     * @return \Cake\Http\Response|null|void Redirects on success.
     */
    public function add($carId = null)
    {
        $booking = $this->Bookings->newEmptyEntity();

        if ($this->request->is('post')) {
            $userId = (int)$this->Authentication->getIdentity()->getIdentifier();
            $booking = $this->BookingService->createBooking($this->request->getData(), $userId);

            if ($booking) {
                $this->Flash->success(__('Booking successful! Invoice generated (incl. 6% Tax).'));

                // Find the invoice created for this booking
                $invoicesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Invoices');
                $invoice = $invoicesTable->find()
                    ->where(['booking_id' => $booking->id])
                    ->first();

                if ($invoice) {
                    return $this->redirect(['controller' => 'Invoices', 'action' => 'viewInvoices', $invoice->id]);
                }

                // Fallback to myBookings if invoice not found
                return $this->redirect(['action' => 'myBookings']);
            }
            $this->Flash->error(__('Unable to add booking. This car might be unavailable for those dates.'));
        }

        $users = $this->Bookings->Users->find('list')->all();
        $cars = $this->Bookings->Cars->find('list')->all();
        $this->set(compact('booking', 'users', 'cars', 'carId'));
    }

    /**
     * Index - Admin only: View all bookings.
     *
     * Displays a paginated list of all bookings with user, car, and invoice data.
     *
     * @return void
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');
        $query = $this->Bookings->find()->contain(['Users', 'Cars', 'Invoices']);
        $bookings = $this->paginate($query);
        $this->set(compact('bookings'));
    }

    /**
     * My Bookings - Customer view: Only their own bookings.
     *
     * Auto-completes past bookings and displays the current user's booking history.
     *
     * @return void
     */
    public function myBookings()
    {
        $userId = (int)$this->Authentication->getIdentity()->getIdentifier();

        // Auto-complete bookings that have passed their end date
        $this->BookingService->autoCompletePastBookings($userId);

        $query = $this->Bookings->find()
            ->where(['Bookings.user_id' => $userId])
            ->contain(['Cars', 'Invoices'])
            ->order(['Bookings.created' => 'DESC']);

        $bookings = $this->paginate($query);
        $this->set(compact('bookings'));
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
     * User-facing booking view (modern UI)
     * Only the booking owner can view
     */
    public function viewBookings($id = null)
    {
        $booking = $this->Bookings->get($id, contain: ['Users', 'Cars', 'Invoices', 'Payments']);

        // Check ownership: only booking owner can view
        $user = $this->Authentication->getIdentity();
        if (!$user || $user->getIdentifier() != $booking->user_id) {
            $this->Flash->error(__('You are not authorized to view this booking.'));
            return $this->redirect(['action' => 'myBookings']);
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
        $userId = (int)$this->Authentication->getIdentity()->getIdentifier();
        $isAdmin = $this->request->getAttribute('identity')->role === 'admin';

        $result = $this->BookingService->cancelBooking((int)$id, $userId, $isAdmin);

        if ($result['success']) {
            $this->Flash->success($result['message']);
        } else {
            $this->Flash->error($result['message']);
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
