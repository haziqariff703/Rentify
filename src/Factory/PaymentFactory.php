<?php

declare(strict_types=1);

namespace App\Factory;

use Cake\I18n\DateTime;

/**
 * Payment Factory
 *
 * Generates fake payment data for testing and seeding.
 * Creates realistic payment records with Malaysian payment methods.
 */
class PaymentFactory extends AbstractFactory
{
    /**
     * Available payment methods
     */
    protected array $paymentMethods = [
        'Credit Card',
        'Debit Card',
        'Online Banking',
        'FPX',
        'Touch n Go eWallet',
        'Boost',
        'GrabPay',
        'ShopeePay',
        'Cash',
        'Bank Transfer',
    ];

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'Payments';
    }

    /**
     * Generate a single payment record definition
     *
     * @param array $overrides Field overrides
     * @return array
     */
    public function define(array $overrides = []): array
    {
        $now = DateTime::now();

        // Random payment date within last 90 days
        $paymentDate = $now->subDays($this->faker->numberBetween(0, 90));

        $data = [
            'booking_id' => null, // Should be set via override
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'payment_method' => $this->faker->randomElement($this->paymentMethods),
            'payment_date' => $paymentDate->format('Y-m-d H:i:s'),
            'payment_status' => $this->faker->randomElement(['paid', 'unpaid', 'pending', 'refunded']),
            'created' => $now->format('Y-m-d H:i:s'),
            'modified' => $now->format('Y-m-d H:i:s'),
        ];

        return array_merge($data, $overrides);
    }

    /**
     * Create a successful payment
     *
     * @param int $bookingId Booking ID
     * @param float $amount Payment amount
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createPaid(int $bookingId, float $amount, array $overrides = [])
    {
        return $this->create(array_merge([
            'booking_id' => $bookingId,
            'amount' => $amount,
            'payment_status' => 'paid',
            'payment_date' => DateTime::now()->format('Y-m-d H:i:s'),
        ], $overrides));
    }

    /**
     * Create an unpaid payment record
     *
     * @param int $bookingId Booking ID
     * @param float $amount Payment amount
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createUnpaid(int $bookingId, float $amount, array $overrides = [])
    {
        return $this->create(array_merge([
            'booking_id' => $bookingId,
            'amount' => $amount,
            'payment_status' => 'unpaid',
        ], $overrides));
    }

    /**
     * Create a refunded payment
     *
     * @param int $bookingId Booking ID
     * @param float $amount Payment amount
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createRefunded(int $bookingId, float $amount, array $overrides = [])
    {
        return $this->create(array_merge([
            'booking_id' => $bookingId,
            'amount' => $amount,
            'payment_status' => 'refunded',
        ], $overrides));
    }

    /**
     * Create a payment with specific method
     *
     * @param int $bookingId Booking ID
     * @param float $amount Payment amount
     * @param string $method Payment method
     * @param array $overrides Additional field overrides
     * @return \Cake\ORM\Entity
     */
    public function createWithMethod(int $bookingId, float $amount, string $method, array $overrides = [])
    {
        return $this->create(array_merge([
            'booking_id' => $bookingId,
            'amount' => $amount,
            'payment_method' => $method,
            'payment_status' => 'paid',
        ], $overrides));
    }

    /**
     * Get available payment methods
     *
     * @return array
     */
    public function getPaymentMethods(): array
    {
        return $this->paymentMethods;
    }
}
