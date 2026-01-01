<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

class StatusHelper extends Helper
{
    /**
     * Render a status badge for bookings.
     */
    public function bookingBadge(string $status): string
    {
        $class = match (strtolower($status)) {
            'pending' => 'pending',
            'confirmed' => 'confirmed',
            'cancelled' => 'cancelled',
            'completed' => 'completed',
            default => 'default'
        };

        return sprintf('<span class="status-badge %s">%s</span>', $class, ucfirst(h($status)));
    }

    /**
     * Render a status badge for invoices/payments.
     */
    public function paymentBadge(string $status): string
    {
        $class = match (strtolower($status)) {
            'paid' => 'paid',
            'unpaid' => 'unpaid',
            'cancelled', 'void', 'refunded' => 'cancelled',
            'pending' => 'pending',
            default => 'default'
        };

        return sprintf('<span class="status-badge %s">%s</span>', $class, ucfirst(h($status)));
    }
}
