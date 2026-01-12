<?php

declare(strict_types=1);

namespace App\Factory;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\I18n\DateTime;

/**
 * User Factory
 *
 * Generates fake user data for testing and seeding.
 * Creates users with valid Malaysian IC numbers (birthdate-encoded, age 21-60).
 */
class UserFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'Users';
    }

    /**
     * Generate a single user record definition
     *
     * @param array $overrides Field overrides
     * @return array
     */
    public function define(array $overrides = []): array
    {
        $now = DateTime::now();

        // Generate Malaysian IC number (format: YYMMDD-PP-XXXX)
        // PP = state code (01-16), XXXX = random 4 digits
        $icNumber = $this->generateMalaysianIC();

        // Malaysian states with area codes for address generation
        $malaysianStates = [
            'Johor',
            'Kedah',
            'Kelantan',
            'Melaka',
            'Negeri Sembilan',
            'Pahang',
            'Penang',
            'Perak',
            'Perlis',
            'Sabah',
            'Sarawak',
            'Selangor',
            'Terengganu',
            'Kuala Lumpur',
            'Labuan',
            'Putrajaya',
        ];

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        $data = [
            'name' => $firstName . ' ' . $lastName,
            'email' => strtolower($firstName . '.' . $lastName . $this->faker->numberBetween(1, 999)) . '@' . $this->faker->safeEmailDomain,
            'password' => (new DefaultPasswordHasher())->hash('password123'),
            'phone' => $this->generateMalaysianPhone(),
            'address' => $this->faker->streetAddress . ', ' .
                $this->faker->randomElement($malaysianStates) . ', ' .
                $this->faker->postcode . ', Malaysia',
            'ic_number' => $icNumber,
            'role' => 'customer',
            'avatar' => 'default_user.png',
            'created' => $now->format('Y-m-d H:i:s'),
            'modified' => $now->format('Y-m-d H:i:s'),
        ];

        return array_merge($data, $overrides);
    }

    /**
     * Create an admin user
     *
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createAdmin(array $overrides = [])
    {
        return $this->create(array_merge(['role' => 'admin'], $overrides));
    }

    /**
     * Create a customer user
     *
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createCustomer(array $overrides = [])
    {
        return $this->create(array_merge(['role' => 'customer'], $overrides));
    }

    /**
     * Generate a valid Malaysian IC number
     *
     * Format: YYMMDD-PP-XXXX
     * - YYMMDD = Birthdate (ensuring user is 21-60 years old)
     * - PP = State code (01-16)
     * - XXXX = Random 4 digits (last digit determines gender: odd=male, even=female)
     *
     * @return string
     */
    protected function generateMalaysianIC(): string
    {
        // Generate a birthdate for age 21-60 (eligible for car rental)
        $minAge = 21;
        $maxAge = 60;
        $yearsAgo = $this->faker->numberBetween($minAge, $maxAge);
        $birthDate = DateTime::now()->subYears($yearsAgo);

        // Add random months and days variation
        $birthDate = $birthDate->subMonths($this->faker->numberBetween(0, 11))
            ->subDays($this->faker->numberBetween(0, 28));

        $year = $birthDate->format('y');
        $month = $birthDate->format('m');
        $day = $birthDate->format('d');

        // State codes (simplified - common states)
        $stateCode = str_pad((string)$this->faker->numberBetween(1, 16), 2, '0', STR_PAD_LEFT);

        // Last 4 digits
        $lastFour = str_pad((string)$this->faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);

        return $year . $month . $day . '-' . $stateCode . '-' . $lastFour;
    }

    /**
     * Generate a Malaysian phone number
     *
     * Formats: 01X-XXXXXXX or 01X-XXXXXXXX
     *
     * @return string
     */
    protected function generateMalaysianPhone(): string
    {
        $prefixes = ['010', '011', '012', '013', '014', '016', '017', '018', '019'];
        $prefix = $this->faker->randomElement($prefixes);

        // Malaysian mobile numbers are 7-8 digits after prefix
        $length = $this->faker->randomElement([7, 8]);
        $number = '';
        for ($i = 0; $i < $length; $i++) {
            $number .= $this->faker->numberBetween(0, 9);
        }

        return $prefix . '-' . $number;
    }
}
