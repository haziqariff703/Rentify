<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Maintenances Controller
 *
 * @property \App\Model\Table\MaintenancesTable $Maintenances
 */
class MaintenancesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // All actions in this controller require admin role
        $redirect = $this->requireAdmin();
        if ($redirect) {
            return $redirect;
        }

        // Use admin layout
        $this->viewBuilder()->setLayout('admin');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Maintenances->find()
            ->contain(['Cars']);
        $maintenances = $this->paginate($query);

        $this->set(compact('maintenances'));
    }

    /**
     * View method
     *
     * @param string|null $id Maintenance id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $maintenance = $this->Maintenances->get($id, contain: ['Cars']);
        $this->set(compact('maintenance'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $maintenance = $this->Maintenances->newEmptyEntity();

        // Pre-fill car_id if coming from review
        $carId = $this->request->getQuery('car_id');
        if ($carId) {
            $maintenance->car_id = $carId;
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Auto-set end_date if status is completed and end_date is empty
            if (($data['status'] ?? '') === 'completed' && empty($data['end_date'])) {
                $data['end_date'] = new \Cake\I18n\Date();
            }
            $maintenance = $this->Maintenances->patchEntity($maintenance, $data);
            if ($this->Maintenances->save($maintenance)) {
                // Update Car Status based on maintenance status
                $car = $this->Maintenances->Cars->get($maintenance->car_id);
                if ($maintenance->status === 'scheduled') {
                    $car->status = 'maintenance';
                    $this->Maintenances->Cars->save($car);
                    $this->Flash->success(__('Maintenance scheduled. Car status updated to Maintenance.'));
                } elseif ($maintenance->status === 'completed') {
                    $car->status = 'available';
                    $this->Maintenances->Cars->save($car);
                    $this->Flash->success(__('Maintenance completed. Car is now Available.'));
                } else {
                    $this->Flash->success(__('The maintenance has been saved.'));
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The maintenance could not be saved. Please, try again.'));
        }
        $cars = $this->Maintenances->Cars->find('list', limit: 200)->all();
        $this->set(compact('maintenance', 'cars'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Maintenance id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $maintenance = $this->Maintenances->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // Auto-set end_date if status is completed and end_date is empty
            if (($data['status'] ?? '') === 'completed' && empty($data['end_date'])) {
                $data['end_date'] = new \Cake\I18n\Date();
            }
            $maintenance = $this->Maintenances->patchEntity($maintenance, $data);
            if ($this->Maintenances->save($maintenance)) {
                // Auto-update car status based on maintenance status
                $car = $this->Maintenances->Cars->get($maintenance->car_id);
                if ($maintenance->status === 'scheduled') {
                    $car->status = 'maintenance';
                    $this->Maintenances->Cars->save($car);
                    $this->Flash->success(__('Maintenance updated. Car status set to Maintenance.'));
                } elseif ($maintenance->status === 'completed') {
                    $car->status = 'available';
                    $this->Maintenances->Cars->save($car);
                    $this->Flash->success(__('Maintenance completed. Car is now Available.'));
                } else {
                    $this->Flash->success(__('The maintenance has been saved.'));
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The maintenance could not be saved. Please, try again.'));
        }
        $cars = $this->Maintenances->Cars->find('list', limit: 200)->all();
        $this->set(compact('maintenance', 'cars'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Maintenance id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $maintenance = $this->Maintenances->get($id);
        if ($this->Maintenances->delete($maintenance)) {
            $this->Flash->success(__('The maintenance has been deleted.'));
        } else {
            $this->Flash->error(__('The maintenance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    /**
     * Complete active maintenance for a car
     *
     * @param string|null $carId Car id.
     * @return \Cake\Http\Response|null Redirects to referer.
     */
    public function completeActive($carId = null)
    {
        $this->request->allowMethod(['post']);

        // Find the active maintenance for this car
        $maintenance = $this->Maintenances->find()
            ->where([
                'car_id' => $carId,
                'status' => 'scheduled'
            ])
            ->first();

        if ($maintenance) {
            $maintenance->status = 'completed';
            $maintenance->end_date = new \Cake\I18n\Date(); // Set completion date to today

            if ($this->Maintenances->save($maintenance)) {
                // Determine redirect based on referer
                // If referer contains 'reviews', go back there, otherwise index
                $referer = $this->request->referer();

                // Update car status
                $car = $this->Maintenances->Cars->get($carId);
                $car->status = 'available';
                $this->Maintenances->Cars->save($car);

                $this->Flash->success(__('Maintenance marked as done. Car is available.'));
            } else {
                $this->Flash->error(__('Could not update maintenance status.'));
            }
        } else {
            $this->Flash->error(__('No active maintenance found for this car.'));
        }

        return $this->redirect($this->request->referer() ?: ['action' => 'index']);
    }
}
