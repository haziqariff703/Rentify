<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class AddSpecsToCars extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('cars');
        $table->addColumn('engine', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
        ]);
        $table->addColumn('zero_to_sixty', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true,
        ]);
        $table->addColumn('badge_color', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true,
        ]);
        $table->update();
    }
}
