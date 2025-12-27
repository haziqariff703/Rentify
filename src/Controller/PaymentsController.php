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

        // Actions that require login but not admin
        $userActions = ['myPayments', 'view', 'add'];
        if (in_array($action, $userActions)) {
            if (!$user) {
                $this->Flash->error(__('Please login to access this page.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        }

        // Admin-only actions
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

    /**
     * My Payments - For Users
     */
    public function myPayments()
    {
        $user = $this->Authentication->getIdentity();
        if (!$user) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $query = $this->Payments->find()
            ->contain(['Bookings' => ['Cars']])
            ->matching('Bookings', function ($q) use ($user) {
                return $q->where(['Bookings.user_id' => $user->id]);
            })
            ->order(['Payments.created' => 'DESC']);

        $payments = $this->paginate($query);
        $this->set(compact('payments'));
    }

    /**
     * Add Payment (Simulation)
     */
   public function add()
    {
        $payment = $this->Payments->newEmptyEntity();
        $bookingId = $this->request->getQuery('booking_id');
        $amount = $this->request->getQuery('amount');

        // Fetch Booking Details (Required for Order Summary)
        $booking = null;
        if ($bookingId) {
            $booking = $this->fetchTable('Bookings')->get($bookingId, [
                'contain' => ['Cars']
            ]);
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $payment = $this->Payments->patchEntity($payment, $data);
            $isValid = false;

            // --- PAYMENT METHOD LOGIC ---
            if ($data['payment_method'] === 'card') {
                // Card Logic
                $cardInput = str_replace(['-', ' '], '', $data['card_number'] ?? '');
                if (str_starts_with($cardInput, '4242') || strlen($cardInput) === 16) {
                    $isValid = true;
                } else {
                    $this->Flash->error(__('Card Declined. Use Test Code: 4242-4242-4242-4242'));
                }
            } elseif ($data['payment_method'] === 'online_transfer') {
                // --- NEW FPX LOGIC ---
                // Capture the selected bank name
                $bankName = $data['bank_name'] ?? '';
                
                if (!empty($bankName)) {
                    // Save specific bank: "online_transfer_maybank"
                    $cleanBankName = strtolower(str_replace(' ', '', $bankName));
                    $payment->payment_method = 'online_transfer_' . $cleanBankName;
                    $isValid = true;
                } else {
                    $this->Flash->error(__('Please select a bank to proceed.'));
                    $isValid = false;
                }
            } else {
                // Cash
                $isValid = true;
            }

            if ($isValid) {
                $payment->payment_date = date('Y-m-d H:i:s');
                $payment->payment_status = 'paid';

                if ($this->Payments->save($payment)) {
                    // Update Invoice
                    $invoicesTable = $this->fetchTable('Invoices');
                    $invoice = $invoicesTable->find()->where(['booking_id' => $payment->booking_id])->first();
                    if ($invoice) {
                        $invoice->status = 'paid';
                        $invoicesTable->save($invoice);
                    }

                    // Update Booking
                    $bookingsTable = $this->fetchTable('Bookings');
                    $bookingRec = $bookingsTable->get($payment->booking_id);
                    $bookingRec->booking_status = 'confirmed';
                    $bookingsTable->save($bookingRec);

                    $this->Flash->success(__('Payment Successful! Booking Confirmed.'));
                    return $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoice->id]);
                }
            }
        }

        if (!$bookingId && $payment->booking_id) {
            $bookingId = $payment->booking_id;
            $amount = $payment->amount;
        }
        
        // Pass $booking to view for summary
        $this->set(compact('payment', 'bookingId', 'amount', 'booking'));
    }
}
