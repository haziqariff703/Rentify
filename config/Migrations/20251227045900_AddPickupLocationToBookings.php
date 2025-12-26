<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AddPickupLocationToBookings extends AbstractMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('bookings');
        $table->addColumn('pickup_location', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true,
            'after' => 'booking_status'
        ]);
        $table->update();
    }
}
