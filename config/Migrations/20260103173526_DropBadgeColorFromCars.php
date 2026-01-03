<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class DropBadgeColorFromCars extends BaseMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('cars');
        $table->removeColumn('badge_color');
        $table->update();
    }
}
