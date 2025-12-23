<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class AddBookingIdToReviews extends BaseMigration
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
        $table = $this->table('reviews');
        $table->addColumn('booking_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,  // ← Changed to true (nullable)
            'signed' => true,  // ← Add this for unsigned
        ]);
        $table->addIndex([
            'booking_id',
        ], [
            'name' => 'booking_id_idx',
            'unique' => false,
        ]);
        // ← Add this foreign key:
        $table->addForeignKey('booking_id', 'bookings', 'id', [
            'delete' => 'SET_NULL',
            'update' => 'CASCADE'
        ]);
        $table->update();
    }
}
