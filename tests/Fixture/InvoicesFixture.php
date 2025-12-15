<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvoicesFixture
 */
class InvoicesFixture extends TestFixture
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
                'invoice_id' => 1,
                'booking_id' => 1,
                'invoice_number' => 'Lorem ipsum dolor sit amet',
                'amount' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-15 11:19:46',
                'modified' => '2025-12-15 11:19:46',
            ],
        ];
        parent::init();
    }
}
