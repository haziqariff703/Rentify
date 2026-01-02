<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * CarCategories Controller
 *
 * @property \App\Model\Table\CarCategoriesTable $CarCategories
 */
class CarCategoriesController extends AppController
{
    /**
     * @var \App\Model\Table\CarCategoriesTable $CarCategories
     */

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
        $query = $this->CarCategories->find()->contain(['Cars']);
        $carCategories = $this->paginate($query);

        $this->set(compact('carCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Car Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $carCategory = $this->CarCategories->get($id, contain: ['Cars']);
        $this->set(compact('carCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $carCategory = $this->CarCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $carCategory = $this->CarCategories->patchEntity($carCategory, $this->request->getData());
            if ($this->CarCategories->save($carCategory)) {
                $this->Flash->success(__('The car category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The car category could not be saved. Please, try again.'));
        }
        $this->set(compact('carCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Car Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $carCategory = $this->CarCategories->get($id, contain: ['Cars']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $carCategory = $this->CarCategories->patchEntity($carCategory, $this->request->getData());
            if ($this->CarCategories->save($carCategory)) {
                $this->Flash->success(__('The car category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The car category could not be saved. Please, try again.'));
        }
        $this->set(compact('carCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Car Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $carCategory = $this->CarCategories->get($id);
        if ($this->CarCategories->delete($carCategory)) {
            $this->Flash->success(__('The car category has been deleted.'));
        } else {
            $this->Flash->error(__('The car category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
