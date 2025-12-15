<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MaintenancesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MaintenancesTable Test Case
 */
class MaintenancesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MaintenancesTable
     */
    protected $Maintenances;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Maintenances',
        'app.Cars',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Maintenances') ? [] : ['className' => MaintenancesTable::class];
        $this->Maintenances = $this->getTableLocator()->get('Maintenances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Maintenances);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MaintenancesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\MaintenancesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
