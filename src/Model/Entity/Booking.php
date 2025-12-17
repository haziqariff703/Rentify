<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

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
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Car $car
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\Payment[] $payments
 */
class Booking extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
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
        'created' => true,
        'modified' => true,
        'user' => true,
        'car' => true,
        'invoices' => true,
        'payments' => true,
    ];
}
