<?php

declare(strict_types=1);

namespace App\Factory;

use Cake\I18n\DateTime;
use Cake\I18n\Date;

/**
 * Booking Factory
 *
 * Generates fake booking data for testing and seeding.
 * Creates realistic rental bookings with calculated prices.
 */
class BookingFactory extends AbstractFactory
{
    /**
     * Pickup locations in Malaysia
     */
    protected array $pickupLocations = [
        'KLIA Airport',
        'KLIA2 Airport',
        'Kuala Lumpur Sentral',
        'Penang International Airport',
        'Langkawi Airport',
        'Johor Bahru Sentral',
        'Malacca Sentral',
        'Kuching International Airport',
        'Kota Kinabalu Airport',
        'Ipoh Railway Station',
        'Shah Alam Office',
        'Petaling Jaya Office',
        'Subang Jaya Office',
        'Cyberjaya Office',
        'Putrajaya Sentral',
    ];

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'Bookings';
    }

    /**
     * Generate a single booking record definition
     *
     * @param array $overrides Field overrides
     * @return array
     */
    public function define(array $overrides = []): array
    {
        $now = DateTime::now();

        // Generate booking dates
        $startOffset = $this->faker->numberBetween(-60, 30); // Between 60 days ago and 30 days ahead
        $duration = $this->faker->numberBetween(1, 14); // 1-14 days rental

        $startDate = Date::now()->addDays($startOffset);
        $endDate = $startDate->addDays($duration);

        // Determine status based on dates
        $today = Date::now();
        if ($startDate > $today) {
            $status = $this->faker->randomElement(['pending', 'approved']);
        } elseif ($endDate < $today) {
            $status = $this->faker->randomElement(['completed', 'cancelled']);
        } else {
            $status = 'ongoing';
        }

        // Random add-ons
        $hasChauffeur = $this->faker->boolean(20);
        $hasGps = $this->faker->boolean(40);
        $hasFullInsurance = $this->faker->boolean(60);

        // Calculate estimated total (actual calculation would use car price + add-ons)
        $basePrice = $this->faker->randomFloat(2, 50, 500) * $duration;
        $addOns = ($hasChauffeur ? 100 * $duration : 0) + ($hasGps ? 10 * $duration : 0) + ($hasFullInsurance ? 30 * $duration : 0);
        $totalPrice = $basePrice + $addOns;

        $data = [
            'user_id' => null, // Should be set via override
            'car_id' => null, // Should be set via override
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'total_price' => round($totalPrice, 2),
            'booking_status' => $status,
            'pickup_location' => $this->faker->randomElement($this->pickupLocations),
            'has_chauffeur' => $hasChauffeur,
            'has_gps' => $hasGps,
            'has_full_insurance' => $hasFullInsurance,
            'security_deposit_amount' => $this->faker->randomFloat(2, 200, 1000),
            'created' => $now->format('Y-m-d H:i:s'),
            'modified' => $now->format('Y-m-d H:i:s'),
        ];

        return array_merge($data, $overrides);
    }

    /**
     * Create a pending booking
     *
     * @param int $userId User ID
     * @param int $carId Car ID
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createPending(int $userId, int $carId, array $overrides = [])
    {
        $startDate = Date::now()->addDays($this->faker->numberBetween(1, 14));
        $endDate = $startDate->addDays($this->faker->numberBetween(1, 7));

        return $this->create(array_merge([
            'user_id' => $userId,
            'car_id' => $carId,
            'booking_status' => 'pending',
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ], $overrides));
    }

    /**
     * Create an approved booking
     *
     * @param int $userId User ID
     * @param int $carId Car ID
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createApproved(int $userId, int $carId, array $overrides = [])
    {
        $startDate = Date::now()->addDays($this->faker->numberBetween(1, 14));
        $endDate = $startDate->addDays($this->faker->numberBetween(1, 7));

        return $this->create(array_merge([
            'user_id' => $userId,
            'car_id' => $carId,
            'booking_status' => 'approved',
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ], $overrides));
    }

    /**
     * Create a completed booking (in the past)
     *
     * @param int $userId User ID
     * @param int $carId Car ID
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createCompleted(int $userId, int $carId, array $overrides = [])
    {
        $endDate = Date::now()->subDays($this->faker->numberBetween(1, 60));
        $startDate = $endDate->subDays($this->faker->numberBetween(1, 7));

        return $this->create(array_merge([
            'user_id' => $userId,
            'car_id' => $carId,
            'booking_status' => 'completed',
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ], $overrides));
    }

    /**
     * Create an ongoing booking
     *
     * @param int $userId User ID
     * @param int $carId Car ID
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createOngoing(int $userId, int $carId, array $overrides = [])
    {
        $startDate = Date::now()->subDays($this->faker->numberBetween(1, 3));
        $endDate = Date::now()->addDays($this->faker->numberBetween(1, 5));

        return $this->create(array_merge([
            'user_id' => $userId,
            'car_id' => $carId,
            'booking_status' => 'ongoing',
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ], $overrides));
    }

    /**
     * Create a cancelled booking
     *
     * @param int $userId User ID
     * @param int $carId Car ID
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createCancelled(int $userId, int $carId, array $overrides = [])
    {
        return $this->create(array_merge([
            'user_id' => $userId,
            'car_id' => $carId,
            'booking_status' => 'cancelled',
        ], $overrides));
    }

    /**
     * Get available pickup locations
     *
     * @return array
     */
    public function getPickupLocations(): array
    {
        return $this->pickupLocations;
    }
}
