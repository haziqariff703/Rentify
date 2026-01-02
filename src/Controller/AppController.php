<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        $this->loadComponent('FormProtection');
    }

    /**
     * Check if current user is authenticated
     *
     * @return bool
     */
    protected function isAuthenticated(): bool
    {
        return $this->Authentication->getIdentity() !== null;
    }

    /**
     * Check if current user is an admin
     *
     * @return bool
     */
    protected function isAdmin(): bool
    {
        $user = $this->Authentication->getIdentity();
        return $user && $user->role === 'admin';
    }

    /**
     * Require admin role or redirect with error
     *
     * @param string $redirectUrl URL to redirect to (default: home)
     * @return \Cake\Http\Response|null Returns redirect response if not admin, null otherwise
     */
    protected function requireAdmin(array $redirectUrl = ['controller' => 'Pages', 'action' => 'display', 'home']): ?\Cake\Http\Response
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect($redirectUrl);
        }
        return null;
    }

    /**
     * Set admin layout if user is admin
     *
     * @return void
     */
    protected function setAdminLayoutIfAdmin(): void
    {
        if ($this->isAdmin()) {
            $this->viewBuilder()->setLayout('admin');
        }
    }
}
