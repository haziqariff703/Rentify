<?php

declare(strict_types=1);

namespace App\Factory;

use Cake\I18n\DateTime;

/**
 * Car Factory
 *
 * Generates fake car data for testing and seeding.
 * Creates realistic car inventory with Malaysian plate numbers.
 */
class CarFactory extends AbstractFactory
{
    /**
     * Car models by brand - realistic combinations
     */
    protected array $carModels = [
        'Toyota' => [
            ['model' => 'Vios', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.5L 4-Cylinder', 'zero_to_sixty' => '11.5s', 'price_range' => [80, 120]],
            ['model' => 'Camry', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.5L 4-Cylinder', 'zero_to_sixty' => '7.6s', 'price_range' => [200, 280]],
            ['model' => 'Corolla', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.8L 4-Cylinder', 'zero_to_sixty' => '9.5s', 'price_range' => [120, 160]],
            ['model' => 'Fortuner', 'seats' => 7, 'transmission' => 'automatic', 'engine' => '2.8L Turbodiesel', 'zero_to_sixty' => '9.8s', 'price_range' => [280, 380]],
            ['model' => 'Innova', 'seats' => 8, 'transmission' => 'automatic', 'engine' => '2.0L 4-Cylinder', 'zero_to_sixty' => '12.0s', 'price_range' => [180, 250]],
        ],
        'Honda' => [
            ['model' => 'City', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.5L 4-Cylinder', 'zero_to_sixty' => '10.5s', 'price_range' => [90, 130]],
            ['model' => 'Civic', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.5L Turbo', 'zero_to_sixty' => '7.0s', 'price_range' => [180, 250]],
            ['model' => 'Accord', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.4L 4-Cylinder', 'zero_to_sixty' => '7.2s', 'price_range' => [220, 300]],
            ['model' => 'CR-V', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.5L Turbo', 'zero_to_sixty' => '7.8s', 'price_range' => [250, 350]],
            ['model' => 'HR-V', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.8L 4-Cylinder', 'zero_to_sixty' => '9.5s', 'price_range' => [160, 220]],
        ],
        'Mazda' => [
            ['model' => 'Mazda 3', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.0L SkyActiv-G', 'zero_to_sixty' => '7.8s', 'price_range' => [150, 200]],
            ['model' => 'Mazda 6', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.5L SkyActiv-G', 'zero_to_sixty' => '7.0s', 'price_range' => [200, 280]],
            ['model' => 'CX-5', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.5L SkyActiv-G', 'zero_to_sixty' => '7.5s', 'price_range' => [250, 350]],
            ['model' => 'CX-8', 'seats' => 7, 'transmission' => 'automatic', 'engine' => '2.5L SkyActiv-G', 'zero_to_sixty' => '8.2s', 'price_range' => [300, 400]],
        ],
        'BMW' => [
            ['model' => '3 Series', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.0L TwinPower Turbo', 'zero_to_sixty' => '5.6s', 'price_range' => [400, 550]],
            ['model' => '5 Series', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.0L TwinPower Turbo', 'zero_to_sixty' => '5.9s', 'price_range' => [500, 700]],
            ['model' => 'X3', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.0L TwinPower Turbo', 'zero_to_sixty' => '6.0s', 'price_range' => [450, 600]],
            ['model' => 'X5', 'seats' => 7, 'transmission' => 'automatic', 'engine' => '3.0L TwinPower Turbo', 'zero_to_sixty' => '5.3s', 'price_range' => [600, 850]],
        ],
        'Mercedes-Benz' => [
            ['model' => 'C-Class', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.0L Turbo', 'zero_to_sixty' => '6.0s', 'price_range' => [420, 580]],
            ['model' => 'E-Class', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.0L Turbo', 'zero_to_sixty' => '5.9s', 'price_range' => [550, 750]],
            ['model' => 'GLC', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '2.0L Turbo', 'zero_to_sixty' => '6.3s', 'price_range' => [480, 650]],
            ['model' => 'S-Class', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '3.0L Turbo', 'zero_to_sixty' => '4.8s', 'price_range' => [900, 1500]],
        ],
        'Perodua' => [
            ['model' => 'Myvi', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.5L 4-Cylinder', 'zero_to_sixty' => '13.0s', 'price_range' => [60, 90]],
            ['model' => 'Axia', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.0L 3-Cylinder', 'zero_to_sixty' => '15.0s', 'price_range' => [50, 70]],
            ['model' => 'Bezza', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.3L 4-Cylinder', 'zero_to_sixty' => '13.5s', 'price_range' => [55, 80]],
            ['model' => 'Aruz', 'seats' => 7, 'transmission' => 'automatic', 'engine' => '1.5L 4-Cylinder', 'zero_to_sixty' => '14.0s', 'price_range' => [100, 140]],
        ],
        'Proton' => [
            ['model' => 'X50', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.5L Turbo', 'zero_to_sixty' => '9.5s', 'price_range' => [120, 170]],
            ['model' => 'X70', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.8L Turbo', 'zero_to_sixty' => '9.0s', 'price_range' => [150, 220]],
            ['model' => 'Saga', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.3L 4-Cylinder', 'zero_to_sixty' => '14.0s', 'price_range' => [50, 75]],
            ['model' => 'Persona', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.6L 4-Cylinder', 'zero_to_sixty' => '12.0s', 'price_range' => [65, 95]],
        ],
        'Nissan' => [
            ['model' => 'Almera', 'seats' => 5, 'transmission' => 'automatic', 'engine' => '1.0L Turbo', 'zero_to_sixty' => '11.5s', 'price_range' => [80, 120]],
            ['model' => 'X-Trail', 'seats' => 7, 'transmission' => 'automatic', 'engine' => '2.5L 4-Cylinder', 'zero_to_sixty' => '9.0s', 'price_range' => [200, 280]],
            ['model' => 'Serena', 'seats' => 8, 'transmission' => 'automatic', 'engine' => '2.0L Hybrid', 'zero_to_sixty' => '10.5s', 'price_range' => [220, 300]],
        ],
    ];

    /**
     * Malaysian state codes for plate numbers
     */
    protected array $plateStateCodes = [
        'W',
        'V',
        'P',
        'N',
        'M',
        'J',
        'A',
        'K',
        'D',
        'T',
        'C',
        'R',
        'B',
        'S',
        'Q',
        'L'
    ];

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'Cars';
    }

    /**
     * Generate a single car record definition
     *
     * @param array $overrides Field overrides
     * @return array
     */
    public function define(array $overrides = []): array
    {
        $now = DateTime::now();

        // Pick a random brand and model
        $brand = $this->faker->randomElement(array_keys($this->carModels));
        $carInfo = $this->faker->randomElement($this->carModels[$brand]);

        // Generate realistic year (2-8 years old cars typically in rental fleets)
        $year = $this->faker->numberBetween((int)date('Y') - 8, (int)date('Y'));

        // Generate price based on car model range
        $pricePerDay = $this->faker->randomFloat(2, $carInfo['price_range'][0], $carInfo['price_range'][1]);

        $data = [
            'category_id' => null, // Should be set via override or relationship
            'car_model' => $carInfo['model'],
            'plate_number' => $this->generateMalaysianPlateNumber(),
            'brand' => $brand,
            'year' => $year,
            'price_per_day' => $pricePerDay,
            'status' => 'available',
            'image' => null, // Default, can be overridden
            'transmission' => $carInfo['transmission'],
            'seats' => $carInfo['seats'],
            'engine' => $carInfo['engine'],
            'zero_to_sixty' => $carInfo['zero_to_sixty'],
            'created' => $now->format('Y-m-d H:i:s'),
            'modified' => $now->format('Y-m-d H:i:s'),
        ];

        return array_merge($data, $overrides);
    }

    /**
     * Create a car with specific status
     *
     * @param string $status Status (available, rented, maintenance)
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createWithStatus(string $status, array $overrides = [])
    {
        return $this->create(array_merge(['status' => $status], $overrides));
    }

    /**
     * Create a luxury car
     *
     * @param int $categoryId Category ID for luxury
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createLuxury(int $categoryId, array $overrides = [])
    {
        $luxuryBrands = ['BMW', 'Mercedes-Benz'];
        $brand = $this->faker->randomElement($luxuryBrands);
        $carInfo = $this->faker->randomElement($this->carModels[$brand]);

        return $this->create(array_merge([
            'category_id' => $categoryId,
            'brand' => $brand,
            'car_model' => $carInfo['model'],
            'price_per_day' => $this->faker->randomFloat(2, $carInfo['price_range'][0], $carInfo['price_range'][1]),
        ], $overrides));
    }

    /**
     * Create an economy car
     *
     * @param int $categoryId Category ID for economy
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createEconomy(int $categoryId, array $overrides = [])
    {
        $economyBrands = ['Perodua', 'Proton'];
        $brand = $this->faker->randomElement($economyBrands);
        $carInfo = $this->faker->randomElement($this->carModels[$brand]);

        return $this->create(array_merge([
            'category_id' => $categoryId,
            'brand' => $brand,
            'car_model' => $carInfo['model'],
            'price_per_day' => $this->faker->randomFloat(2, $carInfo['price_range'][0], $carInfo['price_range'][1]),
        ], $overrides));
    }

    /**
     * Generate a Malaysian vehicle plate number
     *
     * Format: [State Code][Numbers] [Letters]
     * Examples: WXY 1234, JKL 567, B 9999 Z
     *
     * @return string
     */
    protected function generateMalaysianPlateNumber(): string
    {
        $stateCode = $this->faker->randomElement($this->plateStateCodes);
        $letters = '';
        $letterCount = $this->faker->numberBetween(1, 3);

        for ($i = 0; $i < $letterCount; $i++) {
            $letters .= $this->faker->randomElement(range('A', 'Z'));
        }

        // KL plates (W) often have different format
        if ($stateCode === 'W') {
            $format = $this->faker->randomElement(['standard', 'new']);
            if ($format === 'new') {
                $numbers = $this->faker->numberBetween(1, 9999);
                return $stateCode . $letters . ' ' . $numbers;
            }
        }

        $numbers = $this->faker->numberBetween(1, 9999);
        return $stateCode . $letters . ' ' . $numbers;
    }

    /**
     * Get available car models for a specific brand
     *
     * @param string $brand Brand name
     * @return array|null
     */
    public function getModelsForBrand(string $brand): ?array
    {
        return $this->carModels[$brand] ?? null;
    }

    /**
     * Get all available brands
     *
     * @return array
     */
    public function getAvailableBrands(): array
    {
        return array_keys($this->carModels);
    }
}
