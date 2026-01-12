<?php

declare(strict_types=1);

namespace App\Factory;

use Cake\I18n\DateTime;

/**
 * Invoice Factory
 *
 * Generates fake invoice data for testing and seeding.
 * Creates realistic invoice records linked to bookings.
 */
class InvoiceFactory extends AbstractFactory
{
    /**
     * Counter for generating unique invoice numbers
     */
    protected static int $invoiceCounter = 1000;

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'Invoices';
    }

    /**
     * Generate a single invoice record definition
     *
     * @param array $overrides Field overrides
     * @return array
     */
    public function define(array $overrides = []): array
    {
        $now = DateTime::now();

        // Generate unique invoice number
        self::$invoiceCounter++;
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad((string)self::$invoiceCounter, 6, '0', STR_PAD_LEFT);

        $data = [
            'booking_id' => null, // Should be set via override
            'invoice_number' => $invoiceNumber,
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'status' => $this->faker->randomElement(['unpaid', 'paid', 'partial', 'overdue']),
            'created' => $now->format('Y-m-d H:i:s'),
            'modified' => $now->format('Y-m-d H:i:s'),
        ];

        return array_merge($data, $overrides);
    }

    /**
     * Create an unpaid invoice
     *
     * @param int $bookingId Booking ID
     * @param float $amount Invoice amount
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createUnpaid(int $bookingId, float $amount, array $overrides = [])
    {
        return $this->create(array_merge([
            'booking_id' => $bookingId,
            'amount' => $amount,
            'status' => 'unpaid',
        ], $overrides));
    }

    /**
     * Create a paid invoice
     *
     * @param int $bookingId Booking ID
     * @param float $amount Invoice amount
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createPaid(int $bookingId, float $amount, array $overrides = [])
    {
        return $this->create(array_merge([
            'booking_id' => $bookingId,
            'amount' => $amount,
            'status' => 'paid',
        ], $overrides));
    }

    /**
     * Create an overdue invoice
     *
     * @param int $bookingId Booking ID
     * @param float $amount Invoice amount
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createOverdue(int $bookingId, float $amount, array $overrides = [])
    {
        $created = DateTime::now()->subDays($this->faker->numberBetween(15, 45));

        return $this->create(array_merge([
            'booking_id' => $bookingId,
            'amount' => $amount,
            'status' => 'overdue',
            'created' => $created->format('Y-m-d H:i:s'),
        ], $overrides));
    }

    /**
     * Generate a custom invoice number
     *
     * @param string $prefix Prefix for the invoice number
     * @return string
     */
    public function generateInvoiceNumber(string $prefix = 'INV'): string
    {
        self::$invoiceCounter++;
        return $prefix . '-' . date('Y') . '-' . str_pad((string)self::$invoiceCounter, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Reset the invoice counter (useful for testing)
     *
     * @param int $startFrom Starting number
     * @return void
     */
    public static function resetCounter(int $startFrom = 1000): void
    {
        self::$invoiceCounter = $startFrom;
    }
}
