<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AddServiceSelectionsToBookings extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Add service selection fields to bookings table.
     * These capture the user's choices during the booking transaction.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('bookings');
        $table
            ->addColumn('has_chauffeur', 'boolean', [
                'default' => false,
                'null' => false,
                'after' => 'pickup_location'
            ])
            ->addColumn('has_gps', 'boolean', [
                'default' => false,
                'null' => false,
                'after' => 'has_chauffeur'
            ])
            ->addColumn('has_full_insurance', 'boolean', [
                'default' => false,
                'null' => false,
                'after' => 'has_gps'
            ])
            ->addColumn('security_deposit_amount', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'default' => 0.00,
                'null' => false,
                'after' => 'has_full_insurance'
            ])
            ->update();
    }
}
