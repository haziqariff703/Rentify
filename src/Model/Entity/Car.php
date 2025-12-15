<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Car Entity
 *
 * @property int $car_id
 * @property int|null $car_category_id
 * @property string $car_model
 * @property string $plate_number
 * @property string|null $brand
 * @property int|null $year
 * @property string|null $price_per_day
 * @property string|null $status
 * @property string|null $image
 * @property string $transmission
 * @property int $seats
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\CarCategory $car_category
 */
class Car extends Entity
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
        'car_category_id' => true,
        'car_model' => true,
        'plate_number' => true,
        'brand' => true,
        'year' => true,
        'price_per_day' => true,
        'status' => true,
        'image' => true,
        'transmission' => true,
        'seats' => true,
        'created' => true,
        'modified' => true,
        'car_category' => true,
    ];
}
