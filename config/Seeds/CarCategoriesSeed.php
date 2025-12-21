<?php

declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * CarCategories seed.
 */
class CarCategoriesSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Economy', 'description' => 'Budget-friendly compact cars'],
            ['name' => 'Compact', 'description' => 'Slightly larger than economy,but still efficient'],
            ['name' => 'Luxury', 'description' => 'Premium vehicles'],
            ['name' => 'Economy', 'description' => 'Budget-friendly compact cars'],
            ['name' => 'Sports', 'description' => 'High-performance vehicles'],
            ['name' => 'Electric/Hybrid', 'description' => 'Eco-friendly vehicles'],

        ];

        $table = $this->table('car_categories');
        $table->insert($data)->save();
    }
}
