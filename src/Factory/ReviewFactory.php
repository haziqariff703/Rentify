<?php

declare(strict_types=1);

namespace App\Factory;

use Cake\I18n\DateTime;

/**
 * Review Factory
 *
 * Generates fake review data for testing and seeding.
 * Creates realistic customer reviews with varied ratings and comments.
 */
class ReviewFactory extends AbstractFactory
{
    /**
     * Positive review templates (for ratings 4-5)
     */
    protected array $positiveReviews = [
        "Excellent car! Very clean and well-maintained. The pickup process was smooth and hassle-free.",
        "Amazing experience! The car was in perfect condition and drove very smoothly. Will definitely rent again.",
        "Great value for money. The car exceeded my expectations. Highly recommended!",
        "Loved the car! It was brand new and had all the modern features. Thank you Rentify!",
        "Very satisfied with the rental. The car was fuel-efficient and comfortable for long drives.",
        "Outstanding service! The car was spotless and smelled fresh. The staff was very helpful.",
        "Best car rental experience I've had in Malaysia. The vehicle was in tip-top condition.",
        "The car was fantastic! Perfect for our family trip. Kids loved it too!",
        "Smooth rental process, great car condition. Would recommend to friends and family.",
        "Exceeded expectations! The car had low mileage and performed excellently on highway.",
    ];

    /**
     * Neutral review templates (for rating 3)
     */
    protected array $neutralReviews = [
        "Decent car for the price. Met my basic needs but nothing exceptional.",
        "The car was okay. Had minor cosmetic issues but ran fine overall.",
        "Average experience. The car worked fine but pickup took longer than expected.",
        "Fair rental. Car was clean but the AC could have been colder.",
        "Satisfactory. The car did the job but fuel consumption was higher than advertised.",
        "It was an okay experience. Car was functional but a bit dated.",
        "Met expectations. Nothing special but nothing to complain about either.",
        "Average car condition. Some wear and tear visible but mechanically sound.",
    ];

    /**
     * Negative review templates (for ratings 1-2)
     */
    protected array $negativeReviews = [
        "Disappointed with the car condition. Had several issues during my rental.",
        "The car was not as described. Had to wait long for support.",
        "Not satisfied. The car had strange noises and I was worried throughout my trip.",
        "Below expectations. The interior was not clean and had a weird smell.",
        "Poor experience. The car broke down and took time to get assistance.",
        "Would not recommend. The vehicle was old and uncomfortable.",
    ];

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'Reviews';
    }

    /**
     * Generate a single review record definition
     *
     * @param array $overrides Field overrides
     * @return array
     */
    public function define(array $overrides = []): array
    {
        $now = DateTime::now();

        // Generate rating with realistic distribution (more 4-5 stars than 1-2)
        $rating = $this->generateWeightedRating();

        // Pick appropriate comment based on rating
        $comment = $this->getCommentForRating($rating);

        $data = [
            'user_id' => null, // Should be set via override
            'car_id' => null, // Should be set via override
            'booking_id' => null, // Should be set via override (optional)
            'rating' => $rating,
            'comment' => $comment,
            'created' => $now->format('Y-m-d H:i:s'),
            'modified' => $now->format('Y-m-d H:i:s'),
        ];

        return array_merge($data, $overrides);
    }

    /**
     * Create a positive review (4-5 stars)
     *
     * @param int $userId User ID
     * @param int $carId Car ID
     * @param int|null $bookingId Booking ID (optional)
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createPositive(int $userId, int $carId, ?int $bookingId = null, array $overrides = [])
    {
        $rating = $this->faker->randomElement([4, 5]);

        return $this->create(array_merge([
            'user_id' => $userId,
            'car_id' => $carId,
            'booking_id' => $bookingId,
            'rating' => $rating,
            'comment' => $this->faker->randomElement($this->positiveReviews),
        ], $overrides));
    }

    /**
     * Create a neutral review (3 stars)
     *
     * @param int $userId User ID
     * @param int $carId Car ID
     * @param int|null $bookingId Booking ID (optional)
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createNeutral(int $userId, int $carId, ?int $bookingId = null, array $overrides = [])
    {
        return $this->create(array_merge([
            'user_id' => $userId,
            'car_id' => $carId,
            'booking_id' => $bookingId,
            'rating' => 3,
            'comment' => $this->faker->randomElement($this->neutralReviews),
        ], $overrides));
    }

    /**
     * Create a negative review (1-2 stars)
     *
     * @param int $userId User ID
     * @param int $carId Car ID
     * @param int|null $bookingId Booking ID (optional)
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createNegative(int $userId, int $carId, ?int $bookingId = null, array $overrides = [])
    {
        $rating = $this->faker->randomElement([1, 2]);

        return $this->create(array_merge([
            'user_id' => $userId,
            'car_id' => $carId,
            'booking_id' => $bookingId,
            'rating' => $rating,
            'comment' => $this->faker->randomElement($this->negativeReviews),
        ], $overrides));
    }

    /**
     * Create a 5-star review
     *
     * @param int $userId User ID
     * @param int $carId Car ID
     * @param int|null $bookingId Booking ID (optional)
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createFiveStar(int $userId, int $carId, ?int $bookingId = null, array $overrides = [])
    {
        return $this->create(array_merge([
            'user_id' => $userId,
            'car_id' => $carId,
            'booking_id' => $bookingId,
            'rating' => 5,
            'comment' => $this->faker->randomElement($this->positiveReviews),
        ], $overrides));
    }

    /**
     * Generate a weighted rating (more likely to be positive)
     *
     * Distribution: 5-star (40%), 4-star (30%), 3-star (15%), 2-star (10%), 1-star (5%)
     *
     * @return int
     */
    protected function generateWeightedRating(): int
    {
        $random = $this->faker->numberBetween(1, 100);

        if ($random <= 40) {
            return 5;
        } elseif ($random <= 70) {
            return 4;
        } elseif ($random <= 85) {
            return 3;
        } elseif ($random <= 95) {
            return 2;
        } else {
            return 1;
        }
    }

    /**
     * Get an appropriate comment for the given rating
     *
     * @param int $rating The rating (1-5)
     * @return string
     */
    protected function getCommentForRating(int $rating): string
    {
        if ($rating >= 4) {
            return $this->faker->randomElement($this->positiveReviews);
        } elseif ($rating === 3) {
            return $this->faker->randomElement($this->neutralReviews);
        } else {
            return $this->faker->randomElement($this->negativeReviews);
        }
    }

    /**
     * Add a custom positive review template
     *
     * @param string $review Review text
     * @return void
     */
    public function addPositiveReview(string $review): void
    {
        $this->positiveReviews[] = $review;
    }

    /**
     * Add a custom neutral review template
     *
     * @param string $review Review text
     * @return void
     */
    public function addNeutralReview(string $review): void
    {
        $this->neutralReviews[] = $review;
    }

    /**
     * Add a custom negative review template
     *
     * @param string $review Review text
     * @return void
     */
    public function addNegativeReview(string $review): void
    {
        $this->negativeReviews[] = $review;
    }
}
