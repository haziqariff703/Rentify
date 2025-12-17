<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Maintenance Entity
 *
 * @property int $id
 * @property int $car_id
 * @property string|null $description
 * @property string|null $cost
 * @property \Cake\I18n\Date|null $maintenance_date
 * @property string|null $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Car $car
 */
class Maintenance extends Entity
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
        'car_id' => true,
        'description' => true,
        'cost' => true,
        'maintenance_date' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'car' => true,
    ];
}
