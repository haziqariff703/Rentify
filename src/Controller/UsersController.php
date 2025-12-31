<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * @param \Cake\Event\EventInterface $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);

        $user = $this->Authentication->getIdentity();
        $action = $this->request->getParam('action');

        // Admin-only actions
        $adminActions = ['index', 'delete', 'view'];
        if (in_array($action, $adminActions)) {
            if (!$user || $user->role !== 'admin') {
                // Redirect customers trying to view users to their own account
                if ($action === 'view') {
                    return $this->redirect(['action' => 'myAccount']);
                }
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

    /**
     * Handle avatar file upload
     *
     * @param \App\Model\Entity\User $user User entity
     * @param \Psr\Http\Message\UploadedFileInterface|null $avatarFile Uploaded file
     * @return string|null New avatar filename or null if failed/no file
     */
    private function _uploadAvatar($user, $avatarFile)
    {
        if ($avatarFile && $avatarFile->getError() === UPLOAD_ERR_OK) {
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxFileSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($avatarFile->getClientMediaType(), $allowedMimeTypes)) {
                $this->Flash->error(__('Invalid file type. Please upload JPG, PNG, GIF, or WebP.'));
                return null;
            }

            if ($avatarFile->getSize() > $maxFileSize) {
                $this->Flash->error(__('File is too large. Maximum size is 2MB.'));
                return null;
            }

            // Create avatars directory if it doesn't exist
            $uploadDir = WWW_ROOT . 'img' . DS . 'avatars';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $extension = pathinfo($avatarFile->getClientFilename(), PATHINFO_EXTENSION);
            $newFilename = 'avatar_' . $user->id . '_' . time() . '.' . $extension;
            $targetPath = $uploadDir . DS . $newFilename;

            // Move uploaded file
            $avatarFile->moveTo($targetPath);

            // Delete old avatar if exists
            if (!empty($user->avatar) && file_exists(WWW_ROOT . 'img' . DS . $user->avatar)) {
                @unlink(WWW_ROOT . 'img' . DS . $user->avatar);
            }

            return 'avatars' . DS . $newFilename;
        }

        return null;
    }

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

            // Handle avatar file upload
            $avatarFile = $this->request->getUploadedFile('avatar_file');
            $avatarPath = $this->_uploadAvatar($user, $avatarFile);
            if ($avatarPath) {
                $data['avatar'] = $avatarPath;
            } elseif ($avatarFile && $avatarFile->getError() !== UPLOAD_ERR_NO_FILE) {
                // If there was an error other than "no file", stop and let the user fix it
                $this->set(compact('user'));
                return;
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

            // Handle avatar file upload
            $avatarFile = $this->request->getUploadedFile('avatar_file');
            $avatarPath = $this->_uploadAvatar($user, $avatarFile);
            if ($avatarPath) {
                $data['avatar'] = $avatarPath;
            } elseif ($avatarFile && $avatarFile->getError() !== UPLOAD_ERR_NO_FILE) {
                // If there was an error other than "no file", stop
                $this->set(compact('user'));
                return;
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
