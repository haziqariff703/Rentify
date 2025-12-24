<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveDefaultImageFromCars extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Removes the default value 'default_car.jpg' from the image column
     * so that uploaded images are properly saved.
     */
    public function change(): void
    {
        $table = $this->table('cars');
        $table->changeColumn('image', 'string', [
            'limit' => 255,
            'null' => true,
            'default' => null,  // Remove the default value
        ]);
        $table->update();
    }
}
