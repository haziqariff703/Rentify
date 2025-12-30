<?php

declare(strict_types=1);

namespace App\Service;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use App\Model\Entity\Booking;

class BookingService
{
    /**
     * @var \App\Model\Table\BookingsTable
     */
    protected $Bookings;

    public function __construct()
    {
        $this->Bookings = TableRegistry::getTableLocator()->get('Bookings');
    }

    /**
     * Check if a car is available for a given date range.
     */
    public function isCarAvailable(int $carId, FrozenDate $startDate, FrozenDate $endDate, ?int $excludeBookingId = null): bool
    {
        $query = $this->Bookings->find()
            ->where([
                'car_id' => $carId,
                'booking_status IN' => ['confirmed', 'pending'],
                'OR' => [
                    ['start_date <=' => $endDate, 'end_date >=' => $startDate]
                ]
            ]);

        if ($excludeBookingId) {
            $query->where(['id !=' => $excludeBookingId]);
        }

        return $query->count() === 0;
    }

    /**
     * Calculate booking price details.
     */
    public function calculatePrice(Booking $booking): array
    {
        $startDate = $booking->start_date;
        $endDate = $booking->end_date;
        $days = $endDate->diffInDays($startDate) + 1;

        $car = $this->Bookings->Cars->get($booking->car_id, contain: ['Categories']);
        $category = $car->category;

        $chauffeurCost = 0;
        $gpsCost = 0;
        $insuranceCost = 0;

        if ($booking->has_chauffeur && $category && $category->chauffeur_available) {
            $chauffeurCost = (float)$category->chauffeur_daily_rate * $days;
        }

        if ($booking->has_gps && $category && $category->gps_available) {
            $gpsCost = (float)$category->gps_daily_rate * $days;
        }

        if ($booking->has_full_insurance && $category) {
            $insuranceCost = (float)$category->insurance_daily_rate * $days;
        }

        $baseCost = $days * $car->price_per_day;
        $addonsCost = $chauffeurCost + $gpsCost + $insuranceCost;
        $subtotal = $baseCost + $addonsCost;
        $taxRate = 0.06; // 6% SST
        $taxAmount = $subtotal * $taxRate;
        $totalPrice = $subtotal + $taxAmount;

        return [
            'days' => $days,
            'base_cost' => $baseCost,
            'addons_cost' => $addonsCost,
            'tax_amount' => $taxAmount,
            'total_price' => $totalPrice,
            'security_deposit' => $category ? (float)$category->security_deposit : 0,
        ];
    }

    /**
     * Create an invoice for a booking.
     */
    public function createInvoice(Booking $booking): bool
    {
        $invoicesTable = TableRegistry::getTableLocator()->get('Invoices');
        $invoice = $invoicesTable->newEmptyEntity();
        $invoice->booking_id = $booking->id;
        $invoice->invoice_number = 'INV-' . strtoupper(uniqid());
        $invoice->amount = $booking->total_price;
        $invoice->status = 'unpaid';

        return (bool)$invoicesTable->save($invoice);
    }
}
