<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $user = $this->Authentication->getIdentity();
        $action = $this->request->getParam('action');

        // Admin-only actions (edit, delete)
        $adminActions = ['index', 'edit', 'delete'];
        if (in_array($action, $adminActions)) {
            if (!$user || $user->role !== 'admin') {
                $this->Flash->error(__('You are not authorized to access this page.'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }
        }

        // Block admin from creating new payments - only customers can pay
        if ($action === 'add' && $user && $user->role === 'admin') {
            $this->Flash->error(__('Admins cannot make payments. Only customers can pay for bookings.'));
            return $this->redirect(['action' => 'index']);
        }

        // Use admin layout for admin users
        if ($user && $user->role === 'admin') {
            $this->viewBuilder()->setLayout('admin');
        }
    }

    /**
     * Index method
     */
    public function index()
    {
        $query = $this->Payments->find()->contain(['Bookings']);
        $payments = $this->paginate($query);
        $this->set(compact('payments'));
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, contain: ['Bookings']);
        $this->set(compact('payment'));
    }

    /**
     * Add method - Payment Simulation Logic
     */
    public function add()
    {
        $payment = $this->Payments->newEmptyEntity();

        // 1. Get Booking Data from URL (sent from the "Pay Now" button)
        $bookingId = $this->request->getQuery('booking_id');
        $amount = $this->request->getQuery('amount');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $payment = $this->Payments->patchEntity($payment, $data);

            // 2. SIMULATION LOGIC: Check Card Number
            $cardInput = str_replace(['-', ' '], '', $data['card_number'] ?? ''); // Remove dashes/spaces

            // Accept '4242...' OR any 16-digit number
            if (str_starts_with($cardInput, '4242') || strlen($cardInput) === 16) {

                $payment->payment_date = date('Y-m-d H:i:s');
                $payment->payment_status = 'paid'; // Set status to Paid

                if ($this->Payments->save($payment)) {

                    // A. Update INVOICE -> 'paid'
                    $invoicesTable = $this->fetchTable('Invoices');
                    $invoice = $invoicesTable->find()
                        ->where(['booking_id' => $payment->booking_id])
                        ->first();

                    if ($invoice) {
                        $invoice->status = 'paid'; // Matches your DB Enum
                        $invoicesTable->save($invoice);
                    }

                    // B. Update BOOKING -> 'confirmed'
                    $bookingsTable = $this->fetchTable('Bookings');
                    $booking = $bookingsTable->get($payment->booking_id);
                    $booking->booking_status = 'confirmed'; // Matches your DB Enum
                    $bookingsTable->save($booking);

                    $this->Flash->success(__('Payment Approved! Booking Confirmed.'));

                    // Redirect back to the Invoice so they can download the PDF
                    return $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoice->id]);
                }
            } else {
                $this->Flash->error(__('Payment Declined. Please use the test card: 4242-4242-4242-4242'));
            }
        }

        // Pass variables to the view (Critical for the form to work)
        // If the form was submitted but failed, we need to re-populate these
        if (!$bookingId && $payment->booking_id) {
            $bookingId = $payment->booking_id;
            $amount = $payment->amount;
        }

        $this->set(compact('payment', 'bookingId', 'amount'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        $bookings = $this->Payments->Bookings->find('list', limit: 200)->all();
        $this->set(compact('payment', 'bookings'));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
