<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Service\ImageUploadService;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * @var \App\Service\ImageUploadService
     */
    protected ImageUploadService $ImageUploadService;

    public function initialize(): void
    {
        parent::initialize();
        $this->ImageUploadService = new ImageUploadService();
    }
    /**
     * @param \Cake\Event\EventInterface $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);

        $action = $this->request->getParam('action');

        // Admin-only actions
        $adminActions = ['index', 'delete', 'view'];
        if (in_array($action, $adminActions)) {
            if (!$this->isAdmin()) {
                // Redirect customers trying to view users to their own account
                if ($action === 'view') {
                    return $this->redirect(['action' => 'myAccount']);
                }
                $this->Flash->error(__('You are not authorized to access this page.'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }
        }

        // Use admin layout for admin users
        $this->setAdminLayoutIfAdmin();
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function login()
    {
        // Use minimal auth layout without header/footer
        $this->viewBuilder()->setLayout('auth');

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            // redirect to /admins/dashboard if admin, else /
            $identity = $this->request->getAttribute('identity');
            if ($identity && $identity->role === 'admin') {
                return $this->redirect(['controller' => 'Admins', 'action' => 'dashboard']);
            }

            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Pages',
                'action' => 'display',
                'home'
            ]);

            return $this->redirect($redirect);
        }

        // display error if user submitted and failed
        if ($this->request->is('post') && !$result->isValid()) {
            \Cake\Log\Log::error('Login failed: ' . print_r($result->getErrors(), true));
            \Cake\Log\Log::error('Login status: ' . $result->getStatus());
            $this->Flash->error(__('Invalid email or password'));
        }

        // Create empty user entity for the registration form in combined login page
        $user = $this->Users->newEmptyEntity();
        $this->set(compact('user'));
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: ['Bookings', 'Reviews']);
        $this->set(compact('user'));
    }

    /**
     * My Account method - Customer view: Only their own profile
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function myAccount()
    {
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $user = $this->Users->get($userId, contain: ['Bookings', 'Reviews']);
        $this->set(compact('user'));
        // Uses default layout (not admin)
    }

    // Avatar upload is now handled by ImageUploadService

    /**
     * Edit Profile method - Customer can edit their own profile
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function editProfile()
    {
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $user = $this->Users->get($userId, contain: []);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Handle avatar file upload using ImageUploadService
            $avatarFile = $this->request->getUploadedFile('avatar_file');
            if ($avatarFile) {
                $result = $this->ImageUploadService->uploadAvatar($avatarFile, $user->id, $user->avatar);
                if ($result['success']) {
                    $data['avatar'] = $result['filename'];
                } elseif ($result['error']) {
                    $this->Flash->error(__($result['error']));
                    $this->set(compact('user'));
                    return;
                }
            }

            // Only allow customers to update specific fields (not role)
            $allowedFields = ['name', 'ic_number', 'email', 'phone', 'address', 'avatar'];

            // Only include password if it's not empty
            if (!empty($data['password'])) {
                $allowedFields[] = 'password';
            } else {
                // Remove empty password from data to avoid validation errors
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data, [
                'fields' => $allowedFields
            ]);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your profile has been updated.'));
                return $this->redirect(['action' => 'myAccount']);
            }
            $this->Flash->error(__('Your profile could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            // Default role is customer
            $user->role = 'customer';

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Handle avatar file upload using ImageUploadService
            $avatarFile = $this->request->getUploadedFile('avatar_file');
            if ($avatarFile) {
                $result = $this->ImageUploadService->uploadAvatar($avatarFile, $user->id, $user->avatar);
                if ($result['success']) {
                    $data['avatar'] = $result['filename'];
                } elseif ($result['error']) {
                    $this->Flash->error(__($result['error']));
                    $this->set(compact('user'));
                    return;
                }
            }

            // Only include password if it's not empty
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
