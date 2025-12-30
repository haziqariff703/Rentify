<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\FrozenDate;

/**
 * Booking Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $car_id
 * @property \Cake\I18n\Date $start_date
 * @property \Cake\I18n\Date $end_date
 * @property string|null $total_price
 * @property string|null $booking_status
 * @property string|null $pickup_location
 * @property bool $has_chauffeur
 * @property bool $has_gps
 * @property bool $has_full_insurance
 * @property string|null $security_deposit_amount
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * 
 * @property-read string $display_status Virtual property for computed status
 * @property-read float $total_calculated_price Virtual property for calculated price
 * @property-read int $rental_days Virtual property for rental duration
 * @property-read array $price_breakdown Virtual property for itemized price breakdown
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Car $car
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\Payment[] $payments
 */
class Booking extends Entity
{
    /**
     * Virtual property: Returns computed display status
     * - Confirmed bookings past end_date → "completed"
     * - All others → original booking_status
     *
     * @return string
     */
    protected function _getDisplayStatus(): string
    {
        if ($this->booking_status === 'confirmed' && $this->end_date) {
            if ($this->end_date < FrozenDate::now()) {
                return 'completed';
            }
        }
        return $this->booking_status ?? 'pending';
    }

    /**
     * Virtual property: Calculate rental duration in days
     *
     * @return int
     */
    protected function _getRentalDays(): int
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        return max(1, $this->start_date->diffInDays($this->end_date) + 1);
    }

    /**
     * Virtual property: Calculates total price including all add-ons
     * Requires car.category to be loaded via contain()
     *
     * @return float
     */
    protected function _getTotalCalculatedPrice(): float
    {
        // Base rental: car price × days
        $days = $this->rental_days;
        $carPrice = (float)($this->car->price_per_day ?? 0);
        $total = $carPrice * $days;

        // Get category rates (must be loaded via contain)
        $category = $this->car->category ?? null;

        if ($category) {
            // Chauffeur add-on
            if ($this->has_chauffeur && $category->chauffeur_available) {
                $total += (float)$category->chauffeur_daily_rate * $days;
            }

            // GPS add-on
            if ($this->has_gps && $category->gps_available) {
                $total += (float)$category->gps_daily_rate * $days;
            }

            // Full insurance add-on
            if ($this->has_full_insurance) {
                $total += (float)$category->insurance_daily_rate * $days;
            }
        }

        return round($total, 2);
    }

    /**
     * Virtual property: Price breakdown as array
     * Useful for invoices and receipts
     *
     * @return array
     */
    protected function _getPriceBreakdown(): array
    {
        $days = $this->rental_days;
        $category = $this->car->category ?? null;
        $carPrice = (float)($this->car->price_per_day ?? 0);

        $breakdown = [
            'base_rental' => [
                'label' => 'Car Rental (' . $days . ' days)',
                'rate' => $carPrice,
                'days' => $days,
                'subtotal' => $carPrice * $days
            ]
        ];

        if ($this->has_chauffeur && $category?->chauffeur_available) {
            $rate = (float)$category->chauffeur_daily_rate;
            $breakdown['chauffeur'] = [
                'label' => 'Chauffeur Service',
                'rate' => $rate,
                'days' => $days,
                'subtotal' => $rate * $days
            ];
        }

        if ($this->has_gps && $category?->gps_available) {
            $rate = (float)$category->gps_daily_rate;
            $breakdown['gps'] = [
                'label' => 'GPS Navigation',
                'rate' => $rate,
                'days' => $days,
                'subtotal' => $rate * $days
            ];
        }

        if ($this->has_full_insurance) {
            $rate = (float)($category?->insurance_daily_rate ?? 0);
            $breakdown['insurance'] = [
                'label' => 'Full Insurance Coverage',
                'rate' => $rate,
                'days' => $days,
                'subtotal' => $rate * $days
            ];
        }

        $breakdown['total'] = array_sum(array_column($breakdown, 'subtotal'));

        return $breakdown;
    }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'user_id' => true,
        'car_id' => true,
        'start_date' => true,
        'end_date' => true,
        'total_price' => true,
        'booking_status' => true,
        'pickup_location' => true,
        'has_chauffeur' => true,
        'has_gps' => true,
        'has_full_insurance' => true,
        'security_deposit_amount' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'car' => true,
        'invoices' => true,
        'payments' => true,
    ];
}
