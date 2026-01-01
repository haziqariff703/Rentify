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
        $status = strtolower($status);
        $config = match ($status) {
            'pending' => ['class' => 'pending', 'icon' => 'fa-clock'],
            'confirmed' => ['class' => 'confirmed', 'icon' => 'fa-check-circle'],
            'cancelled' => ['class' => 'cancelled', 'icon' => 'fa-times-circle'],
            'completed' => ['class' => 'completed', 'icon' => 'fa-flag-checkered'],
            default => ['class' => 'default', 'icon' => 'fa-info-circle']
        };

        return sprintf(
            '<span class="status-badge %s"><i class="fas %s me-1"></i>%s</span>',
            $config['class'],
            $config['icon'],
            ucfirst($status)
        );
    }

    /**
     * Render a status badge for invoices/payments.
     */
    public function paymentBadge(string $status): string
    {
        $status = strtolower($status);
        $config = match ($status) {
            'paid' => ['class' => 'paid', 'icon' => 'fa-check-circle'],
            'unpaid' => ['class' => 'unpaid', 'icon' => 'fa-exclamation-circle'],
            'cancelled', 'void', 'refunded' => ['class' => 'cancelled', 'icon' => 'fa-redo'],
            'pending' => ['class' => 'pending', 'icon' => 'fa-hourglass-half'],
            default => ['class' => 'default', 'icon' => 'fa-info-circle']
        };

        return sprintf(
            '<span class="status-badge %s"><i class="fas %s me-1"></i>%s</span>',
            $config['class'],
            $config['icon'],
            ucfirst($status)
        );
    }
}
