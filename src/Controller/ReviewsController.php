<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 */
class ReviewsController extends AppController
{
    /**
     * @var \App\Model\Table\ReviewsTable $Reviews
     */

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
        $query = $this->Reviews->find()
            ->contain(['Users', 'Cars']);
        $reviews = $this->paginate($query);

        $this->set(compact('reviews'));
    }

    /**
     * View method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $review = $this->Reviews->get($id, contain: ['Users', 'Cars']);
        $this->set(compact('review'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $review = $this->Reviews->newEmptyEntity();
        if ($this->request->is('post')) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $users = $this->Reviews->Users->find('list', limit: 200)->all();
        $cars = $this->Reviews->Cars->find('list', limit: 200)->all();
        $this->set(compact('review', 'users', 'cars'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $review = $this->Reviews->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $users = $this->Reviews->Users->find('list', limit: 200)->all();
        $cars = $this->Reviews->Cars->find('list', limit: 200)->all();
        $this->set(compact('review', 'users', 'cars'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $review = $this->Reviews->get($id);
        if ($this->Reviews->delete($review)) {
            $this->Flash->success(__('The review has been deleted.'));
        } else {
            $this->Flash->error(__('The review could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
