<?php

declare(strict_types=1);

namespace App\Service;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use App\Model\Entity\Booking;

/**
 * Service class for managing booking lifecycle operations.
 *
 * Handles booking creation, cancellation, approval, rejection,
 * and auto-completion of past bookings. Also provides price
 * calculation and car availability checks.
 */
class BookingService
{
    /**
     * Bookings table instance.
     *
     * @var \App\Model\Table\BookingsTable
     */
    protected $Bookings;

    /**
     * Constructor - initializes the Bookings table.
     */
    public function __construct()
    {
        $this->Bookings = TableRegistry::getTableLocator()->get('Bookings');
    }

    /**
     * Check if a car is available for a given date range.
     *
     * Checks for overlapping bookings with 'confirmed' or 'pending' status.
     *
     * @param int $carId The car ID to check availability for.
     * @param \Cake\I18n\FrozenDate $startDate The start date of the rental period.
     * @param \Cake\I18n\FrozenDate $endDate The end date of the rental period.
     * @param int|null $excludeBookingId Optional booking ID to exclude (for edits).
     * @return bool True if the car is available, false otherwise.
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
     * Calculate booking price details including add-ons and tax.
     *
     * Calculates the total price based on:
     * - Base rental cost (days × price per day)
     * - Optional add-ons (chauffeur, GPS, full insurance)
     * - 6% SST tax
     *
     * @param \App\Model\Entity\Booking $booking The booking entity with dates and service selections.
     * @return array Array containing 'days', 'base_cost', 'addons_cost', 'tax_amount', 'total_price', 'security_deposit'.
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
     * Create a new booking with full validation and invoice generation.
     *
     * Performs availability check, calculates pricing, saves the booking,
     * and automatically generates an invoice.
     *
     * @param array $data The booking data from the request.
     * @param int $userId The ID of the user making the booking.
     * @return \App\Model\Entity\Booking|null The saved booking entity, or null if unavailable/failed.
     */
    public function createBooking(array $data, int $userId): ?Booking
    {
        $booking = $this->Bookings->newEmptyEntity();
        $booking = $this->Bookings->patchEntity($booking, $data);

        // 1. Availability Check
        if (!$this->isCarAvailable((int)$booking->car_id, $booking->start_date, $booking->end_date)) {
            return null;
        }

        // 2. Price Calculation
        $priceData = $this->calculatePrice($booking);
        $booking->total_price = $priceData['total_price'];
        $booking->security_deposit_amount = $priceData['security_deposit'];

        // 3. Defaults
        $booking->user_id = $userId;
        $booking->booking_status = 'pending';

        if ($this->Bookings->save($booking)) {
            // 4. Generate Invoice
            $this->createInvoice($booking);
            return $booking;
        }

        return null;
    }

    /**
     * Cancel a booking with full refund and invoice voiding logic.
     *
     * Validates ownership, checks if cancellation is allowed,
     * marks payments as refunded, and voids invoices.
     *
     * @param int $bookingId The ID of the booking to cancel.
     * @param int $userId The ID of the user requesting cancellation.
     * @param bool $isAdmin Whether the requester is an admin (bypasses ownership check).
     * @return array Array with 'success' (bool) and 'message' (string) keys.
     */
    public function cancelBooking(int $bookingId, int $userId, bool $isAdmin = false): array
    {
        $booking = $this->Bookings->get($bookingId, contain: ['Payments', 'Invoices']);

        // Ownership check
        if (!$isAdmin && $booking->user_id !== $userId) {
            return ['success' => false, 'message' => __('You can only cancel your own bookings.')];
        }

        // Status check
        if (in_array($booking->booking_status, ['cancelled', 'completed'])) {
            return ['success' => false, 'message' => __('This booking is already processed.')];
        }

        // Date check
        if ($booking->start_date <= FrozenDate::now()) {
            return ['success' => false, 'message' => __('Cannot cancel a booking that has already started.')];
        }

        $booking->booking_status = 'cancelled';
        $refunded = false;

        // Refund Payments
        if (!empty($booking->payments)) {
            foreach ($booking->payments as $payment) {
                if ($payment->payment_status === 'paid') {
                    $payment->payment_status = 'refunded';
                    $this->Bookings->Payments->save($payment);
                    $refunded = true;
                }
            }
        }

        // Cancel Invoices
        if (!empty($booking->invoices)) {
            foreach ($booking->invoices as $invoice) {
                $invoice->status = 'cancelled';
                $this->Bookings->Invoices->save($invoice);
            }
        }

        if ($this->Bookings->save($booking)) {
            return [
                'success' => true,
                'message' => $refunded ? __('Booking cancelled and payment marked as REFUNDED.') : __('Booking cancelled successfully.')
            ];
        }

        return ['success' => false, 'message' => __('Could not cancel booking.')];
    }

    /**
     * Approve a pending booking (Admin Only).
     *
     * Performs a final double-booking check before confirming.
     *
     * @param int $bookingId The ID of the booking to approve.
     * @return array Array with 'success' (bool) and 'message' (string) keys.
     */
    public function approveBooking(int $bookingId): array
    {
        $booking = $this->Bookings->get($bookingId);

        // Final double-booking check
        if (!$this->isCarAvailable((int)$booking->car_id, $booking->start_date, $booking->end_date, $booking->id)) {
            return ['success' => false, 'message' => __('Cannot approve: This car is already booked for these dates.')];
        }

        $booking->booking_status = 'confirmed';
        if ($this->Bookings->save($booking)) {
            return ['success' => true, 'message' => __('Booking #{0} approved!', $bookingId)];
        }

        return ['success' => false, 'message' => __('Could not approve booking.')];
    }

    /**
     * Reject a pending booking (Admin Only).
     *
     * Sets the booking status to 'cancelled'.
     *
     * @param int $bookingId The ID of the booking to reject.
     * @return bool True if saved successfully, false otherwise.
     */
    public function rejectBooking(int $bookingId): bool
    {
        $booking = $this->Bookings->get($bookingId);
        $booking->booking_status = 'cancelled';
        return (bool)$this->Bookings->save($booking);
    }

    /**
     * Auto-complete bookings that have passed their end date.
     *
     * Changes 'confirmed' bookings with end_date < today to 'completed'.
     *
     * @param int|null $userId Optional user ID to filter bookings. If null, processes all users.
     * @return int The number of bookings that were auto-completed.
     */
    public function autoCompletePastBookings(?int $userId = null): int
    {
        $conditions = [
            'booking_status' => 'confirmed',
            'end_date <' => FrozenDate::now()
        ];

        if ($userId) {
            $conditions['user_id'] = $userId;
        }

        $pastBookings = $this->Bookings->find()->where($conditions)->all();
        $count = 0;

        foreach ($pastBookings as $booking) {
            $booking->booking_status = 'completed';
            if ($this->Bookings->save($booking)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Create an invoice for a booking.
     *
     * Generates a unique invoice number and sets status to 'unpaid'.
     *
     * @param \App\Model\Entity\Booking $booking The booking entity to create an invoice for.
     * @return bool True if the invoice was saved successfully.
     */
    public function createInvoice(Booking $booking): bool
    {
        $invoicesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Invoices');
        $invoice = $invoicesTable->newEmptyEntity();
        $invoice->booking_id = $booking->id;
        $invoice->invoice_number = 'INV-' . strtoupper(uniqid());
        $invoice->amount = $booking->total_price;
        $invoice->status = 'unpaid';

        return (bool)$invoicesTable->save($invoice);
    }
}
