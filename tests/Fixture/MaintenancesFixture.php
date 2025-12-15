<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MaintenancesFixture
 */
class MaintenancesFixture extends TestFixture
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
                'maintenance_id' => 1,
                'car_id' => 1,
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cost' => 1.5,
                'maintenance_date' => '2025-12-15',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-15 11:19:47',
                'modified' => '2025-12-15 11:19:47',
            ],
        ];
        parent::init();
    }
}
