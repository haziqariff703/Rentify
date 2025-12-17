<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CarsFixture
 */
class CarsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'category_id' => 1,
                'car_model' => 'Lorem ipsum dolor sit amet',
                'plate_number' => 'Lorem ipsum dolor sit amet',
                'brand' => 'Lorem ipsum dolor sit amet',
                'year' => 1,
                'price_per_day' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'image' => 'Lorem ipsum dolor sit amet',
                'transmission' => 'Lorem ipsum dolor sit amet',
                'seats' => 1,
                'created' => '2025-12-17 17:32:27',
                'modified' => '2025-12-17 17:32:27',
            ],
        ];
        parent::init();
    }
}
