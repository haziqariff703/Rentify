<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BookingsFixture
 */
class BookingsFixture extends TestFixture
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
                'booking_id' => 1,
                'user_id' => 1,
                'car_id' => 1,
                'start_date' => '2025-12-15',
                'end_date' => '2025-12-15',
                'total_price' => 1.5,
                'booking_status' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-15 11:19:45',
                'modified' => '2025-12-15 11:19:45',
            ],
        ];
        parent::init();
    }
}
