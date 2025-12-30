<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 */
class InvoicesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $user = $this->Authentication->getIdentity();

        // Use admin layout for admin users
        if ($user && $user->role === 'admin') {
            $this->viewBuilder()->setLayout('admin');
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // 1. Check User Role
        $user = $this->Authentication->getIdentity();

        // If not admin, force them to their own page
        if ($user && $user->role !== 'admin') {
            return $this->redirect(['action' => 'myInvoices']);
        }

        // Admin Logic (Shows everything)
        $query = $this->Invoices->find()->contain(['Bookings']);
        $invoices = $this->paginate($query);
        $this->set(compact('invoices'));
    }

    /**
     * My Invoices - CUSTOMER VIEW
     * Shows only their own invoices, beautifully.
     */
    public function myInvoices()
    {
        $user = $this->Authentication->getIdentity();

        // Fetch invoices belonging to this user
        $query = $this->Invoices->find()
            ->contain(['Bookings' => ['Cars']]) // Get Car details
            ->matching('Bookings', function ($q) use ($user) {
                return $q->where(['Bookings.user_id' => $user->getIdentifier()]);
            })
            ->order(['Invoices.created' => 'DESC']);

        $invoices = $this->paginate($query);
        $this->set(compact('invoices'));
    }

    /**
     * View method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {
        // FIX: Added 'Payments' to the contain array
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Bookings' => ['Users', 'Cars', 'Payments']]
        ]);

        if ($this->request->getQuery('pdf')) {
            $this->viewBuilder()
                ->setClassName('CakePdf.Pdf')
                ->setOption('pdfConfig', [
                    'filename' => 'Invoice_' . $invoice->id . '.pdf'
                ]);
        }

        $this->set(compact('invoice'));
    }

    /**
     * View Invoices - USER VIEW
     * Allows customers to view their own invoice details with PDF download.
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewInvoices($id = null)
    {
        $user = $this->Authentication->getIdentity();

        $invoice = $this->Invoices->get($id, [
            'contain' => ['Bookings' => ['Users', 'Cars', 'Payments']]
        ]);

        // Authorization: Ensure user owns this invoice
        if ($invoice->booking->user_id !== $user->getIdentifier()) {
            $this->Flash->error(__('You are not authorized to view this invoice.'));
            return $this->redirect(['action' => 'myInvoices']);
        }

        $this->set(compact('invoice'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invoice = $this->Invoices->newEmptyEntity();
        if ($this->request->is('post')) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }
        $bookings = $this->Invoices->Bookings->find('list', limit: 200)->all();
        $this->set(compact('invoice', 'bookings'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoice = $this->Invoices->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }
        $bookings = $this->Invoices->Bookings->find('list', limit: 200)->all();
        $this->set(compact('invoice', 'bookings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoice = $this->Invoices->get($id);
        if ($this->Invoices->delete($invoice)) {
            $this->Flash->success(__('The invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
