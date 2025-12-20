<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Bookings Controller
 *
 * @property \App\Model\Table\BookingsTable $Bookings
 */
class BookingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
       // We MUST contain 'Invoices' to get the invoice ID for the button
    $query = $this->Bookings->find()->contain(['Cars', 'Invoices']); 
    $bookings = $this->paginate($query);
    $this->set(compact('bookings'));
    }

    /**
     * View method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $booking = $this->Bookings->get($id, contain: ['Users', 'Cars', 'Invoices', 'Payments']);
        $this->set(compact('booking'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

   public function add($carId = null)
{
    $booking = $this->Bookings->newEmptyEntity();

    if ($this->request->is('post')) {
        $booking = $this->Bookings->patchEntity($booking, $this->request->getData());

        // 1. Calculate Price Logic (Your existing logic)
        $startDate = $booking->start_date;
        $endDate   = $booking->end_date;
        
        // Safety check if dates are null
        if ($startDate && $endDate) {
             $days = $endDate->diffInDays($startDate);
             if ($days == 0) $days = 1; // Minimum 1 day charge
             
             // Get Car Price
             $car = $this->Bookings->Cars->get($booking->car_id ?? $carId);
             $booking->total_price = $days * $car->price_per_day;
        }

        $booking->user_id = $this->Authentication->getIdentity()->getIdentifier();
        $booking->status = 'Pending';

        // 2. Save the Booking
        if ($this->Bookings->save($booking)) {
            
            // --- START AUTO-INVOICE CODE (MEMBER B TASK) ---
            
            // Load the Invoices table
            $invoicesTable = $this->fetchTable('Invoices');
            $invoice = $invoicesTable->newEmptyEntity();

            // Populate Invoice Data
            $invoice->booking_id = $booking->id;
            $invoice->invoice_number = 'INV-' . strtoupper(uniqid()); // Generates unique ID like INV-65X89
            $invoice->amount = $booking->total_price;
            $invoice->status = 'Unpaid'; 
            $invoice->created = date('Y-m-d H:i:s');

            // Save the Invoice
            $invoicesTable->save($invoice);

            // --- END AUTO-INVOICE CODE ---

            $this->Flash->success(__('Booking successful! Invoice generated.'));
            
            // Redirect directly to the NEW invoice so they can see/pay it
            return $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoice->id]);
        }
        $this->Flash->error(__('The booking could not be saved.'));
    }

    // Load data for dropdowns
    $users = $this->Bookings->Users->find('list')->all();
    $cars = $this->Bookings->Cars->find('list')->all();
    
    // Pass 'carId' to view just in case
    $this->set(compact('booking', 'users', 'cars', 'carId'));
}
    
    /**
     * Edit method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
     * Delete method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
