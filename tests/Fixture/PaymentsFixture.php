<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PaymentsFixture
 */
class PaymentsFixture extends TestFixture
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
                'booking_id' => 1,
                'amount' => 1.5,
                'payment_method' => 'Lorem ipsum dolor sit amet',
                'payment_date' => '2025-12-17 17:32:58',
                'payment_status' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-17 17:32:58',
                'modified' => '2025-12-17 17:32:58',
            ],
        ];
        parent::init();
    }
}
