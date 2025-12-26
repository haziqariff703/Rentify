<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class AddPricePerDayToBookings extends BaseMigration
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
        $table = $this->table('bookings');
        $table->addColumn('price_per_day', 'decimal', [
            'default' => null,
            'null' => true,
            'precision' => 10,
            'scale' => 2,
            'after' => 'end_date',
        ]);
        $table->update();
    }
}
