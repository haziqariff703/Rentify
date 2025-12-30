<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AddPolicyFieldsToCarCategories extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Add policy fields to car_categories table for the Policy Engine.
     * These fields define available services and financial policies per category.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('car_categories');
        $table
            ->addColumn('security_deposit', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'default' => 0.00,
                'null' => false,
                'after' => 'description'
            ])
            ->addColumn('insurance_tier', 'string', [
                'limit' => 50,
                'default' => 'basic',
                'null' => false,
                'after' => 'security_deposit'
            ])
            ->addColumn('insurance_daily_rate', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'default' => 0.00,
                'null' => false,
                'after' => 'insurance_tier'
            ])
            ->addColumn('chauffeur_available', 'boolean', [
                'default' => false,
                'null' => false,
                'after' => 'insurance_daily_rate'
            ])
            ->addColumn('chauffeur_daily_rate', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'default' => 0.00,
                'null' => false,
                'after' => 'chauffeur_available'
            ])
            ->addColumn('gps_available', 'boolean', [
                'default' => false,
                'null' => false,
                'after' => 'chauffeur_daily_rate'
            ])
            ->addColumn('gps_daily_rate', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'default' => 0.00,
                'null' => false,
                'after' => 'gps_available'
            ])
            ->update();
    }
}
