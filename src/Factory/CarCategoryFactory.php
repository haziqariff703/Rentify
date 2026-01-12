<?php

declare(strict_types=1);

namespace App\Factory;

use Cake\I18n\DateTime;

/**
 * Car Category Factory
 *
 * Generates fake car category data for testing and seeding.
 * Creates realistic car rental categories with appropriate pricing tiers.
 */
class CarCategoryFactory extends AbstractFactory
{
    /**
     * Predefined car categories with realistic settings
     */
    protected array $predefinedCategories = [
        [
            'name' => 'Economy',
            'description' => 'Budget-friendly compact cars perfect for city driving. Fuel-efficient and easy to park.',
            'security_deposit' => 300.00,
            'insurance_tier' => 'basic',
            'insurance_daily_rate' => 15.00,
            'chauffeur_available' => false,
            'chauffeur_daily_rate' => 0.00,
            'gps_available' => true,
            'gps_daily_rate' => 10.00,
            'badge_color' => '#28a745',
        ],
        [
            'name' => 'Compact',
            'description' => 'Small sedans and hatchbacks ideal for couples and small families. Good balance of comfort and economy.',
            'security_deposit' => 400.00,
            'insurance_tier' => 'basic',
            'insurance_daily_rate' => 18.00,
            'chauffeur_available' => true,
            'chauffeur_daily_rate' => 80.00,
            'gps_available' => true,
            'gps_daily_rate' => 10.00,
            'badge_color' => '#17a2b8',
        ],
        [
            'name' => 'Standard',
            'description' => 'Mid-size sedans offering comfort and space for business or leisure travel.',
            'security_deposit' => 500.00,
            'insurance_tier' => 'standard',
            'insurance_daily_rate' => 25.00,
            'chauffeur_available' => true,
            'chauffeur_daily_rate' => 100.00,
            'gps_available' => true,
            'gps_daily_rate' => 10.00,
            'badge_color' => '#6f42c1',
        ],
        [
            'name' => 'SUV',
            'description' => 'Spacious SUVs for family trips and outdoor adventures. Extra cargo space and ground clearance.',
            'security_deposit' => 700.00,
            'insurance_tier' => 'premium',
            'insurance_daily_rate' => 35.00,
            'chauffeur_available' => true,
            'chauffeur_daily_rate' => 120.00,
            'gps_available' => true,
            'gps_daily_rate' => 10.00,
            'badge_color' => '#fd7e14',
        ],
        [
            'name' => 'Luxury',
            'description' => 'Premium vehicles for executive travel and special occasions. Top-tier comfort and features.',
            'security_deposit' => 1500.00,
            'insurance_tier' => 'premium',
            'insurance_daily_rate' => 50.00,
            'chauffeur_available' => true,
            'chauffeur_daily_rate' => 200.00,
            'gps_available' => true,
            'gps_daily_rate' => 15.00,
            'badge_color' => '#ffc107',
        ],
        [
            'name' => 'Sports',
            'description' => 'High-performance sports cars for thrill-seekers. Experience speed and style.',
            'security_deposit' => 2000.00,
            'insurance_tier' => 'premium',
            'insurance_daily_rate' => 75.00,
            'chauffeur_available' => true,
            'chauffeur_daily_rate' => 250.00,
            'gps_available' => true,
            'gps_daily_rate' => 15.00,
            'badge_color' => '#dc3545',
        ],
        [
            'name' => 'MPV',
            'description' => 'Multi-purpose vehicles with 7+ seats. Perfect for large families and group travel.',
            'security_deposit' => 600.00,
            'insurance_tier' => 'standard',
            'insurance_daily_rate' => 30.00,
            'chauffeur_available' => true,
            'chauffeur_daily_rate' => 130.00,
            'gps_available' => true,
            'gps_daily_rate' => 10.00,
            'badge_color' => '#20c997',
        ],
    ];

    /**
     * Track which predefined categories have been used
     */
    protected int $predefinedIndex = 0;

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'CarCategories';
    }

    /**
     * Generate a single car category record definition
     *
     * @param array $overrides Field overrides
     * @return array
     */
    public function define(array $overrides = []): array
    {
        $now = DateTime::now();

        // Use predefined categories first, then generate random ones
        if ($this->predefinedIndex < count($this->predefinedCategories)) {
            $category = $this->predefinedCategories[$this->predefinedIndex];
            $this->predefinedIndex++;
        } else {
            // Generate a random category
            $category = $this->generateRandomCategory();
        }

        $data = array_merge($category, [
            'created' => $now->format('Y-m-d H:i:s'),
            'modified' => $now->format('Y-m-d H:i:s'),
        ]);

        return array_merge($data, $overrides);
    }

    /**
     * Create all predefined categories
     *
     * @return array Array of created entities
     */
    public function createAllPredefined(): array
    {
        $this->predefinedIndex = 0;
        return $this->createMany(count($this->predefinedCategories));
    }

    /**
     * Get predefined category by name
     *
     * @param string $name Category name
     * @return array|null
     */
    public function getPredefinedCategory(string $name): ?array
    {
        foreach ($this->predefinedCategories as $category) {
            if (strtolower($category['name']) === strtolower($name)) {
                return $category;
            }
        }
        return null;
    }

    /**
     * Generate a random category configuration
     *
     * @return array
     */
    protected function generateRandomCategory(): array
    {
        $names = ['Economy Plus', 'Premium Sedan', 'Executive', 'Adventure', 'Family Van'];
        $colors = ['#6610f2', '#e83e8c', '#007bff', '#28a745', '#17a2b8', '#ffc107', '#dc3545'];
        $insuranceTiers = ['basic', 'standard', 'premium'];

        return [
            'name' => $this->faker->randomElement($names) . ' ' . $this->faker->numberBetween(1, 99),
            'description' => $this->faker->sentence(15),
            'security_deposit' => $this->faker->randomFloat(2, 200, 2500),
            'insurance_tier' => $this->faker->randomElement($insuranceTiers),
            'insurance_daily_rate' => $this->faker->randomFloat(2, 10, 100),
            'chauffeur_available' => $this->faker->boolean(70),
            'chauffeur_daily_rate' => $this->faker->randomFloat(2, 50, 300),
            'gps_available' => $this->faker->boolean(90),
            'gps_daily_rate' => $this->faker->randomFloat(2, 8, 20),
            'badge_color' => $this->faker->randomElement($colors),
        ];
    }
}
