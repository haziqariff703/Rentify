<?php

declare(strict_types=1);

namespace App\Factory;

use Cake\I18n\DateTime;
use Cake\I18n\Date;

/**
 * Maintenance Factory
 *
 * Generates fake maintenance data for testing and seeding.
 * Creates realistic vehicle maintenance records.
 */
class MaintenanceFactory extends AbstractFactory
{
    /**
     * Maintenance descriptions/types
     */
    protected array $maintenanceTypes = [
        'Regular Service' => [
            'descriptions' => [
                'Oil change and filter replacement',
                'Scheduled maintenance service - 10,000km',
                'Scheduled maintenance service - 20,000km',
                'Scheduled maintenance service - 40,000km',
                'Routine inspection and fluid top-up',
            ],
            'cost_range' => [150, 500],
        ],
        'Brake Service' => [
            'descriptions' => [
                'Brake pad replacement - front',
                'Brake pad replacement - rear',
                'Brake disc replacement and pad change',
                'Brake fluid flush and replacement',
                'Complete brake system overhaul',
            ],
            'cost_range' => [200, 800],
        ],
        'Tire Service' => [
            'descriptions' => [
                'Tire rotation and balancing',
                'Full tire replacement - 4 units',
                'Tire puncture repair',
                'Wheel alignment and balancing',
                'Spare tire replacement',
            ],
            'cost_range' => [100, 2000],
        ],
        'Engine Repair' => [
            'descriptions' => [
                'Engine tune-up and diagnostics',
                'Spark plug replacement',
                'Air filter and cabin filter replacement',
                'Belt and hose replacement',
                'Engine coolant system service',
            ],
            'cost_range' => [150, 1500],
        ],
        'AC Service' => [
            'descriptions' => [
                'Air conditioning gas recharge',
                'AC compressor replacement',
                'AC system diagnostics and repair',
                'Cabin air filter replacement',
                'Evaporator cleaning service',
            ],
            'cost_range' => [80, 1200],
        ],
        'Body Repair' => [
            'descriptions' => [
                'Minor dent removal and touch-up',
                'Bumper repair and respray',
                'Side mirror replacement',
                'Windshield replacement',
                'Full body polish and detailing',
            ],
            'cost_range' => [200, 3000],
        ],
        'Electrical' => [
            'descriptions' => [
                'Battery replacement',
                'Headlight bulb replacement',
                'Electrical system diagnostics',
                'Alternator repair/replacement',
                'Starter motor replacement',
            ],
            'cost_range' => [150, 1000],
        ],
        'Accident Repair' => [
            'descriptions' => [
                'Post-accident inspection and repair',
                'Collision damage repair',
                'Frame straightening and repair',
                'Complete body panel replacement',
                'Insurance claim repair work',
            ],
            'cost_range' => [500, 10000],
        ],
    ];

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'Maintenances';
    }

    /**
     * Generate a single maintenance record definition
     *
     * @param array $overrides Field overrides
     * @return array
     */
    public function define(array $overrides = []): array
    {
        $now = DateTime::now();

        // Pick a random maintenance type
        $type = $this->faker->randomElement(array_keys($this->maintenanceTypes));
        $typeInfo = $this->maintenanceTypes[$type];

        // Pick a random description from that type
        $description = $this->faker->randomElement($typeInfo['descriptions']);

        // Generate cost within range
        $cost = $this->faker->randomFloat(2, $typeInfo['cost_range'][0], $typeInfo['cost_range'][1]);

        // Generate maintenance date (past or future)
        $dateOffset = $this->faker->numberBetween(-60, 30);
        $maintenanceDate = Date::now()->addDays($dateOffset);

        // Determine status based on date
        $today = Date::now();
        if ($maintenanceDate > $today) {
            $status = 'scheduled';
        } elseif ($maintenanceDate == $today || $maintenanceDate > $today->subDays(3)) {
            $status = $this->faker->randomElement(['scheduled', 'in_progress', 'completed']);
        } else {
            $status = 'completed';
        }

        $data = [
            'car_id' => null, // Should be set via override
            'description' => $description,
            'cost' => $cost,
            'maintenance_date' => $maintenanceDate->format('Y-m-d'),
            'status' => $status,
            'created' => $now->format('Y-m-d H:i:s'),
            'modified' => $now->format('Y-m-d H:i:s'),
        ];

        return array_merge($data, $overrides);
    }

    /**
     * Create a scheduled maintenance
     *
     * @param int $carId Car ID
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createScheduled(int $carId, array $overrides = [])
    {
        $maintenanceDate = Date::now()->addDays($this->faker->numberBetween(1, 30));

        return $this->create(array_merge([
            'car_id' => $carId,
            'status' => 'scheduled',
            'maintenance_date' => $maintenanceDate->format('Y-m-d'),
        ], $overrides));
    }

    /**
     * Create an in-progress maintenance
     *
     * @param int $carId Car ID
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createInProgress(int $carId, array $overrides = [])
    {
        return $this->create(array_merge([
            'car_id' => $carId,
            'status' => 'in_progress',
            'maintenance_date' => Date::now()->format('Y-m-d'),
        ], $overrides));
    }

    /**
     * Create a completed maintenance
     *
     * @param int $carId Car ID
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createCompleted(int $carId, array $overrides = [])
    {
        $maintenanceDate = Date::now()->subDays($this->faker->numberBetween(1, 60));

        return $this->create(array_merge([
            'car_id' => $carId,
            'status' => 'completed',
            'maintenance_date' => $maintenanceDate->format('Y-m-d'),
        ], $overrides));
    }

    /**
     * Create specific type of maintenance
     *
     * @param int $carId Car ID
     * @param string $type Maintenance type (e.g., 'Regular Service', 'Brake Service')
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createOfType(int $carId, string $type, array $overrides = [])
    {
        if (!isset($this->maintenanceTypes[$type])) {
            $type = 'Regular Service';
        }

        $typeInfo = $this->maintenanceTypes[$type];
        $description = $this->faker->randomElement($typeInfo['descriptions']);
        $cost = $this->faker->randomFloat(2, $typeInfo['cost_range'][0], $typeInfo['cost_range'][1]);

        return $this->create(array_merge([
            'car_id' => $carId,
            'description' => $description,
            'cost' => $cost,
        ], $overrides));
    }

    /**
     * Get available maintenance types
     *
     * @return array
     */
    public function getMaintenanceTypes(): array
    {
        return array_keys($this->maintenanceTypes);
    }
}
