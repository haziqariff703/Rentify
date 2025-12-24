<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveBookedStatusFromCars extends AbstractMigration
{
    /**
     * Change Method.
     *
     * This migration removes the 'booked' status from cars table
     * since availability should be derived from bookings table dynamically.
     */
    public function up(): void
    {
        // First, update any cars with 'booked' or 'rented' status to 'available'
        $this->execute("UPDATE cars SET status = 'available' WHERE status IN ('booked', 'rented')");

        // Then change the enum to only have 'available' and 'maintenance'
        $this->execute("ALTER TABLE cars MODIFY COLUMN status ENUM('available', 'maintenance') DEFAULT 'available'");
    }

    public function down(): void
    {
        // Revert back to original enum with 'booked' option
        $this->execute("ALTER TABLE cars MODIFY COLUMN status ENUM('available', 'booked', 'maintenance') DEFAULT 'available'");
    }
}
