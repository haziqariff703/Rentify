<?php
declare(strict_types=1);

namespace App\Controller;

class BookingsController extends AppController
{
    public function index()
    {
        // Link Invoices so we can show the "Download" button in the list
        $query = $this->Bookings->find()->contain(['Cars', 'Invoices']); 
        $bookings = $this->paginate($query);
        $this->set(compact('bookings'));
    }

    public function view($id = null)
    {
        $booking = $this->Bookings->get($id, contain: ['Users', 'Cars', 'Invoices', 'Payments']);
        $this->set(compact('booking'));
    }

    public function add($carId = null)
    {
        $booking = $this->Bookings->newEmptyEntity();

        if ($this->request->is('post')) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->getData());

            // 1. Calculate Price
            $startDate = $booking->start_date;
            $endDate   = $booking->end_date;
            
            if ($startDate && $endDate) {
                 $days = $endDate->diffInDays($startDate);
                 if ($days == 0) $days = 1; 
                 
                 // Get Car Price
                 $car = $this->Bookings->Cars->get($booking->car_id ?? $carId);
                 $booking->total_price = $days * $car->price_per_day;
            }

            // 2. Set Default Data
            $booking->user_id = $this->Authentication->getIdentity()->getIdentifier();
            $booking->booking_status = 'pending'; // Matches your DB column

            if ($this->Bookings->save($booking)) {
                
                // 3. AUTO-GENERATE INVOICE (The Link)
                $invoicesTable = $this->fetchTable('Invoices');
                $invoice = $invoicesTable->newEmptyEntity();

                $invoice->booking_id = $booking->id;
                $invoice->invoice_number = 'INV-' . strtoupper(uniqid()); 
                $invoice->amount = $booking->total_price;
                $invoice->status = 'unpaid'; // Matches your DB column
                
                $invoicesTable->save($invoice);

                $this->Flash->success(__('Booking saved! Please pay the invoice.'));
                
                // Redirect to the Invoice to pay
                return $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoice->id]);
            }
            $this->Flash->error(__('The booking could not be saved.'));
        }

        $users = $this->Bookings->Users->find('list')->all();
        $cars = $this->Bookings->Cars->find('list')->all();
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
