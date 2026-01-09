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
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $action = $this->request->getParam('action');

        // Unlock 'rating' field for addReview - uses custom HTML inputs for star rating UI
        if ($action === 'addReview') {
            $this->FormProtection->setConfig('unlockedFields', ['rating']);
        }
        $user = $this->Authentication->getIdentity();

        // Public access for carReviews
        $this->Authentication->allowUnauthenticated(['carReviews']);

        // Customer actions (logged-in users, not admin for addReview)
        $customerActions = ['myReviews', 'addReview'];
        if (in_array($action, $customerActions)) {
            if (!$this->isAuthenticated()) {
                $this->Flash->error(__('Please login to access this page.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
            if ($action === 'addReview' && $this->isAdmin()) {
                $this->Flash->error(__('Admins cannot add reviews.'));
                return $this->redirect(['controller' => 'Admins', 'action' => 'dashboard']);
            }
            // Use default layout for customers
            return;
        }

        // View action - accessible by any logged-in user
        if ($action === 'view') {
            if (!$this->isAuthenticated()) {
                $this->Flash->error(__('Please login to access this page.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
            // Use admin layout for admins
            $this->setAdminLayoutIfAdmin();
            return;
        }

        // Admin-only actions
        $adminActions = ['index', 'add', 'edit', 'delete'];
        if (in_array($action, $adminActions)) {
            if (!$this->isAdmin()) {
                $this->Flash->error(__('You are not authorized to access this page.'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }
            $this->viewBuilder()->setLayout('admin');
        }
    }

    /**
     * My Reviews - Customer view: Only their own reviews
     */
    public function myReviews()
    {
        $userId = $this->Authentication->getIdentity()->getIdentifier();

        $query = $this->Reviews->find()
            ->where(['Reviews.user_id' => $userId])
            ->contain(['Cars', 'Bookings'])
            ->order(['Reviews.created' => 'DESC']);

        $reviews = $this->paginate($query);

        // Calculate stats
        $totalReviews = $this->Reviews->find()
            ->where(['user_id' => $userId])
            ->count();

        $avgRating = $this->Reviews->find()
            ->where(['user_id' => $userId])
            ->select(['avg_rating' => $this->Reviews->find()->func()->avg('rating')])
            ->first();

        $this->set(compact('reviews', 'totalReviews'));
        $this->set('avgRating', ($avgRating && $avgRating->avg_rating !== null) ? round($avgRating->avg_rating, 1) : 0);
    }

    /**
     * Car Reviews - Public view: All reviews for a specific car
     */
    public function carReviews($carId = null)
    {
        if (!$carId) {
            $this->Flash->error(__('Invalid car.'));
            return $this->redirect(['controller' => 'Cars', 'action' => 'index']);
        }

        $car = $this->Reviews->Cars->get($carId);

        $query = $this->Reviews->find()
            ->where(['Reviews.car_id' => $carId])
            ->contain(['Users'])
            ->order(['Reviews.created' => 'DESC']);

        $reviews = $this->paginate($query);

        // Calculate average rating
        $avgRating = $this->Reviews->find()
            ->where(['car_id' => $carId])
            ->select(['avg_rating' => $this->Reviews->find()->func()->avg('rating')])
            ->first();

        $totalReviews = $this->Reviews->find()
            ->where(['car_id' => $carId])
            ->count();

        // Calculate rating distribution (count of each star level)
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = $this->Reviews->find()
                ->where(['car_id' => $carId, 'rating' => $i])
                ->count();
        }

        $this->set(compact('reviews', 'car', 'totalReviews', 'ratingDistribution'));
        $this->set('avgRating', ($avgRating && $avgRating->avg_rating !== null) ? round($avgRating->avg_rating, 1) : 0);
    }

    /**
     * Add Review - Customer adds review after payment
     */
    public function addReview($bookingId = null)
    {
        if (!$bookingId) {
            $this->Flash->error(__('Invalid booking.'));
            return $this->redirect(['controller' => 'Bookings', 'action' => 'myBookings']);
        }

        $bookingsTable = $this->fetchTable('Bookings');
        $booking = $bookingsTable->get($bookingId, [
            'contain' => ['Cars']
        ]);

        // Verify ownership
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        if ($booking->user_id != $userId) {
            $this->Flash->error(__('You are not authorized to review this booking.'));
            return $this->redirect(['controller' => 'Bookings', 'action' => 'myBookings']);
        }

        // Check if already reviewed
        $existingReview = $this->Reviews->find()
            ->where(['booking_id' => $bookingId])
            ->first();

        if ($existingReview) {
            $this->Flash->info(__('You have already reviewed this booking.'));
            return $this->redirect(['action' => 'myReviews']);
        }

        $review = $this->Reviews->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user_id'] = $userId;
            $data['car_id'] = $booking->car_id;
            $data['booking_id'] = $bookingId;

            $review = $this->Reviews->patchEntity($review, $data);

            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('Thank you for your review!'));
                return $this->redirect(['action' => 'myReviews']);
            }
            $this->Flash->error(__('The review could not be saved. Please try again.'));
        }

        $this->set(compact('review', 'booking'));
    }

    /**
     * Index method - Admin only
     */
    public function index()
    {
        $showingIssues = (bool) $this->request->getQuery('issues');

        $query = $this->Reviews->find()
            ->contain(['Users', 'Cars' => ['Maintenances'], 'Bookings']);

        // Filter for issue reviews if requested (low ratings that are NOT resolved)
        if ($showingIssues) {
            $query->where(['Reviews.rating <=' => 2]);

            // Get all reviews, then filter out resolved ones in PHP
            $allIssueReviews = $query->all()->toArray();

            $unresolvedReviews = [];
            foreach ($allIssueReviews as $review) {
                $isResolved = false;
                $carStatus = strtolower($review->car->status ?? '');

                // Cars in maintenance are still "issues" being addressed
                if ($carStatus === 'maintenance') {
                    $unresolvedReviews[] = $review;
                    continue;
                }

                // Check if there's a completed maintenance after the review date
                if (!empty($review->car->maintenances)) {
                    foreach ($review->car->maintenances as $maintenance) {
                        if ($maintenance->status === 'completed') {
                            $completionDate = $maintenance->end_date ?? $maintenance->modified;
                            if ($completionDate && $completionDate->format('Y-m-d') >= $review->created->format('Y-m-d')) {
                                $isResolved = true;
                                break;
                            }
                        }
                    }
                }

                if (!$isResolved) {
                    $unresolvedReviews[] = $review;
                }
            }

            // Pass the filtered reviews directly (bypassing pagination for filtered view)
            $this->set('reviews', $unresolvedReviews);
            $this->set('showingIssues', $showingIssues);
            return;
        }

        $reviews = $this->paginate($query);
        $this->set(compact('reviews', 'showingIssues'));
    }

    /**
     * View method - Admin only
     */
    public function view($id = null)
    {
        $review = $this->Reviews->get($id, contain: ['Users', 'Cars', 'Bookings']);
        $this->set(compact('review'));
    }

    /**
     * Add method - Admin only
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
        $bookings = $this->Reviews->Bookings->find('list', limit: 200)->all();
        $this->set(compact('review', 'users', 'cars', 'bookings'));
    }

    /**
     * Edit method - Admin only
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
        $bookings = $this->Reviews->Bookings->find('list', limit: 200)->all();
        $this->set(compact('review', 'users', 'cars', 'bookings'));
    }

    /**
     * Delete method - Admin only
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
