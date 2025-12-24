<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Cars Controller
 *
 * @property \App\Model\Table\CarsTable $Cars
 */
class CarsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Allow public access to myCars, index, and view
        // myCars is the user-facing fleet catalog
        // index will redirect non-admins to myCars
        $this->Authentication->addUnauthenticatedActions(['myCars', 'index', 'view']);

        $user = $this->Authentication->getIdentity();
        $action = $this->request->getParam('action');

        // For index action: redirect non-admin users to myCars
        if ($action === 'index') {
            if (!$user || $user->role !== 'admin') {
                return $this->redirect(['action' => 'myCars']);
            }
        }

        // Admin-only actions require admin role
        $adminActions = ['add', 'edit', 'delete'];
        if (in_array($action, $adminActions)) {
            if (!$user || $user->role !== 'admin') {
                $this->Flash->error(__('You are not authorized to access this page.'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }
        }

        // Use admin layout for admin users
        if ($user && $user->role === 'admin') {
            $this->viewBuilder()->setLayout('admin');
        }
    }

    /**
     * My Cars method - User-facing 3D flip card catalog
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function myCars()
    {
        // Query cars from database with their categories
        $cars = $this->Cars->find()
            ->contain(['Categories'])
            ->where(['status !=' => 'maintenance'])
            ->all();

        // Query all categories for filter buttons
        $categories = $this->Cars->Categories->find()->all();

        $this->set(compact('cars', 'categories'));
    }

    /**
     * Index method - Admin view for managing cars
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Cars->find()
            ->contain([
                'Categories',
                'Bookings' => function ($q) {
                    return $q->order(['start_date' => 'ASC']);
                }
            ]);
        $cars = $this->paginate($query);

        $this->set(compact('cars'));
    }

    /**
     * View method
     *
     * @param string|null $id Car id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $car = $this->Cars->get($id, contain: ['Categories', 'Bookings', 'Maintenances', 'Reviews']);
        $this->set(compact('car'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $car = $this->Cars->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Handle file upload
            $imageFile = $this->request->getData('image_file');
            if ($imageFile && $imageFile->getSize() > 0 && $imageFile->getError() === UPLOAD_ERR_OK) {
                // Generate unique filename
                $extension = pathinfo($imageFile->getClientFilename(), PATHINFO_EXTENSION);
                $filename = strtolower(str_replace(' ', '-', $data['brand'] . '-' . $data['car_model'])) . '-' . time() . '.' . $extension;

                // Move uploaded file to webroot/img/
                $targetPath = WWW_ROOT . 'img' . DS . $filename;
                $imageFile->moveTo($targetPath);

                // Set the image field
                $data['image'] = $filename;
            }

            // Remove file upload field before patching entity
            unset($data['image_file']);

            $car = $this->Cars->patchEntity($car, $data);
            if ($this->Cars->save($car)) {
                $this->Flash->success(__('The car has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The car could not be saved. Please, try again.'));
        }
        $categories = $this->Cars->Categories->find('list', limit: 200)->all();
        $this->set(compact('car', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Car id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $car = $this->Cars->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Handle file upload
            $imageFile = $this->request->getData('image_file');
            if ($imageFile && $imageFile->getSize() > 0 && $imageFile->getError() === UPLOAD_ERR_OK) {
                // Generate unique filename
                $extension = pathinfo($imageFile->getClientFilename(), PATHINFO_EXTENSION);
                $filename = strtolower(str_replace(' ', '-', $data['brand'] . '-' . $data['car_model'])) . '-' . time() . '.' . $extension;

                // Move uploaded file to webroot/img/
                $targetPath = WWW_ROOT . 'img' . DS . $filename;
                $imageFile->moveTo($targetPath);

                // Update the image field with new filename
                $data['image'] = $filename;
            } else {
                // Keep existing image if no new upload
                $data['image'] = $data['existing_image'] ?? $car->image;
            }

            // Remove file upload fields before patching entity
            unset($data['image_file']);
            unset($data['existing_image']);

            $car = $this->Cars->patchEntity($car, $data);
            if ($this->Cars->save($car)) {
                $this->Flash->success(__('The car has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The car could not be saved. Please, try again.'));
        }
        $categories = $this->Cars->Categories->find('list', limit: 200)->all();
        $this->set(compact('car', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Car id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $car = $this->Cars->get($id);
        if ($this->Cars->delete($car)) {
            $this->Flash->success(__('The car has been deleted.'));
        } else {
            $this->Flash->error(__('The car could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
