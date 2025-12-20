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
        
        $user = $this->Authentication->getIdentity();
        if (!$user || $user->role !== 'admin') {
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }
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
        if ($this->request->is('post')) {
            $maintenance = $this->Maintenances->patchEntity($maintenance, $this->request->getData());
            if ($this->Maintenances->save($maintenance)) {
                // Update Car Status to 'Maintenance'
                $car = $this->Maintenances->Cars->get($maintenance->car_id);
                $car->status = 'Maintenance';
                $this->Maintenances->Cars->save($car);

                $this->Flash->success(__('The maintenance has been saved and the car status updated to Maintenance.'));

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
            $maintenance = $this->Maintenances->patchEntity($maintenance, $this->request->getData());
            if ($this->Maintenances->save($maintenance)) {
                $this->Flash->success(__('The maintenance has been saved.'));

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
}
