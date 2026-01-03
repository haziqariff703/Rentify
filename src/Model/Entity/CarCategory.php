<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CarCategory Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $security_deposit
 * @property string $insurance_tier
 * @property string|null $insurance_daily_rate
 * @property bool $chauffeur_available
 * @property string|null $chauffeur_daily_rate
 * @property bool $gps_available
 * @property string|null $gps_daily_rate
 * @property string|null $badge_color
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * 
 * @property \App\Model\Entity\Car[] $cars
 */
class CarCategory extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'description' => true,
        'security_deposit' => true,
        'insurance_tier' => true,
        'insurance_daily_rate' => true,
        'chauffeur_available' => true,
        'chauffeur_daily_rate' => true,
        'gps_available' => true,
        'gps_daily_rate' => true,
        'badge_color' => true,
        'created' => true,
        'modified' => true,
        'cars' => true,
    ];
}
