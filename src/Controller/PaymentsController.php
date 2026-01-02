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
    /**
     * Initialize controller - unlock dynamic payment form fields.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // Unlock dynamic form fields that are shown/hidden by JavaScript
        if ($this->components()->has('FormProtection')) {
            $this->FormProtection->setConfig('unlockedFields', [
                'payment_method',
                'bank_name',
                'card_number',
                'card_expiry',
                'card_cvv',
            ]);
        }
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $action = $this->request->getParam('action');

        // Actions that require login but not admin
        $userActions = ['myPayments', 'view', 'add'];
        if (in_array($action, $userActions)) {
            if (!$this->isAuthenticated()) {
                $this->Flash->error(__('Please login to access this page.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        }

        // Admin-only actions
        $adminActions = ['index', 'edit', 'delete', 'confirmCashPayment'];
        if (in_array($action, $adminActions)) {
            if (!$this->isAdmin()) {
                $this->Flash->error(__('You are not authorized to access this page.'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }
        }

        // Block admin from creating new payments - only customers can pay
        if ($action === 'add' && $this->isAdmin()) {
            $this->Flash->error(__('Admins cannot make payments. Only customers can pay for bookings.'));
            return $this->redirect(['action' => 'index']);
        }

        // Use admin layout for admin users
        $this->setAdminLayoutIfAdmin();
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
                $isCash = ($data['payment_method'] === 'cash');
                $payment->payment_date = \Cake\I18n\FrozenTime::now();
                $payment->payment_status = $isCash ? 'pending' : 'paid';

                if ($this->Payments->save($payment)) {
                    // Update Invoice
                    $invoicesTable = $this->fetchTable('Invoices');
                    $invoice = $invoicesTable->find()->where(['booking_id' => $payment->booking_id])->first();

                    if ($invoice && !$isCash) {
                        $invoice->status = 'paid';
                        $invoicesTable->save($invoice);
                    }

                    // Update Booking
                    if (!$isCash) {
                        $bookingsTable = $this->fetchTable('Bookings');
                        $bookingRec = $bookingsTable->get($payment->booking_id);
                        $bookingRec->booking_status = 'confirmed';
                        $bookingsTable->save($bookingRec);

                        $this->Flash->success(__('Payment Successful! Booking Confirmed.'));
                    } else {
                        $this->Flash->success(__('Booking request submitted! Please visit our counter to complete the cash payment.'));
                    }

                    return $this->redirect(['controller' => 'Invoices', 'action' => 'viewInvoices', $invoice ? $invoice->id : $payment->booking_id]);
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

    /**
     * Confirm Cash Payment - Admin only
     * Manually mark a cash payment as paid and confirm the booking
     */
    public function confirmCashPayment($id = null)
    {
        $this->request->allowMethod(['post']);
        $payment = $this->Payments->get($id);

        // Accept 'pending', empty, or null as valid states for confirmation
        $currentStatus = $payment->payment_status ?? '';
        if (!empty($currentStatus) && $currentStatus !== 'pending') {
            $this->Flash->error(__('This payment is already processed (status: {0}).', $currentStatus));
            return $this->redirect(['action' => 'index']);
        }

        // Update payment status
        $payment->payment_status = 'paid';
        $payment->payment_date = \Cake\I18n\FrozenTime::now();
        $payment->setDirty('payment_status', true);
        $payment->setDirty('payment_date', true);

        if ($this->Payments->save($payment)) {
            // Update Invoice
            $invoicesTable = $this->fetchTable('Invoices');
            $invoice = $invoicesTable->find()->where(['booking_id' => $payment->booking_id])->first();
            if ($invoice) {
                $invoice->status = 'paid';
                $invoice->setDirty('status', true);
                if (!$invoicesTable->save($invoice)) {
                    $this->Flash->warning(__('Payment saved but invoice update failed.'));
                }
            } else {
                $this->Flash->warning(__('Payment saved but no invoice found for booking #{0}.', $payment->booking_id));
            }

            $this->Flash->success(__('Payment confirmed! You can now officially approve the booking from the Bookings Management page.'));
        } else {
            // Show validation errors
            $errors = $payment->getErrors();
            $errorMsg = '';
            foreach ($errors as $field => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $errorMsg .= "{$field}: {$error}; ";
                }
            }
            $this->Flash->error(__('Could not confirm payment. Errors: {0}', $errorMsg ?: 'Unknown'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
