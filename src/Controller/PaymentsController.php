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
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Payments->find()
            ->contain(['Bookings']);
        $payments = $this->paginate($query);

        $this->set(compact('payments'));
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, contain: ['Bookings']);
        $this->set(compact('payment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
   public function add($invoiceId)
{
    $Invoices = $this->fetchTable('Invoices');
    $Bookings = $this->fetchTable('Bookings');

    $invoice = $Invoices->get($invoiceId, [
        'contain' => ['Bookings']
    ]);

    if ($this->request->is('post')) {

        $card = $this->request->getData('card_number');

        if ($card === '4242-4242') {

            // Update invoice
            $invoice->status = 'Paid';
            $Invoices->save($invoice);

            // Update booking
            $booking = $invoice->booking;
            $booking->status = 'Confirmed';
            $Bookings->save($booking);

            $this->Flash->success('Payment successful.');
            return $this->redirect([
                'controller' => 'Invoices',
                'action' => 'view',
                $invoiceId
            ]);
        }

        $this->Flash->error('Payment failed. Invalid card number.');
    }

    $this->set(compact('invoice'));
}

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
