<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class InitialSchema extends BaseMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('bookings')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('car_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('start_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('end_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('total_price', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('booking_status', 'string', [
                'default' => 'pending',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('pickup_location', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('has_chauffeur', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('has_gps', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('has_full_insurance', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('security_deposit_amount', 'decimal', [
                'default' => '0.00',
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                $this->index('user_id')
                    ->setName('user_id')
            )
            ->addIndex(
                $this->index('car_id')
                    ->setName('car_id')
            )
            ->create();

        $this->table('car_categories')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('security_deposit', 'decimal', [
                'default' => '0.00',
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('insurance_tier', 'string', [
                'default' => 'basic',
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('insurance_daily_rate', 'decimal', [
                'default' => '0.00',
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('chauffeur_available', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('chauffeur_daily_rate', 'decimal', [
                'default' => '0.00',
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('gps_available', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('gps_daily_rate', 'decimal', [
                'default' => '0.00',
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('badge_color', 'string', [
                'default' => null,
                'limit' => 7,
                'null' => false,
            ])
            ->addIndex(
                $this->index('badge_color')
                    ->setName('BY_BADGE_COLOR')
            )
            ->create();

        $this->table('cars')
            ->addColumn('category_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => true,
            ])
            ->addColumn('car_model', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('plate_number', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('brand', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('year', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => true,
            ])
            ->addColumn('price_per_day', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'available',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('transmission', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('seats', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('engine', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('zero_to_sixty', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addIndex(
                $this->index('plate_number')
                    ->setName('plate_number')
                    ->setType('unique')
            )
            ->addIndex(
                $this->index('category_id')
                    ->setName('car_id')
            )
            ->create();

        $this->table('invoices')
            ->addColumn('booking_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('invoice_number', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('amount', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'unpaid',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                $this->index('invoice_number')
                    ->setName('invoice_number')
                    ->setType('unique')
            )
            ->addIndex(
                $this->index('booking_id')
                    ->setName('booking_id')
            )
            ->create();

        $this->table('maintenances')
            ->addColumn('car_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('cost', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('maintenance_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'scheduled',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                $this->index('car_id')
                    ->setName('car_id')
            )
            ->create();

        $this->table('payments')
            ->addColumn('booking_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('amount', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('payment_method', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('payment_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('payment_status', 'string', [
                'default' => 'unpaid',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                $this->index('booking_id')
                    ->setName('booking_id')
            )
            ->create();

        $this->table('reviews')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('car_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('rating', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => true,
            ])
            ->addColumn('comment', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('booking_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => true,
            ])
            ->addIndex(
                $this->index('user_id')
                    ->setName('user_id')
            )
            ->addIndex(
                $this->index('car_id')
                    ->setName('car_id')
            )
            ->addIndex(
                $this->index('booking_id')
                    ->setName('booking_id_idx')
            )
            ->create();

        $this->table('users')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('ic_number', 'string', [
                'default' => null,
                'limit' => 12,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('phone', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('address', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('avatar', 'string', [
                'default' => 'default_user.png',
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('role', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addIndex(
                $this->index('email')
                    ->setName('email')
                    ->setType('unique')
            )
            ->addIndex(
                $this->index('ic_number')
                    ->setName('ic_number')
                    ->setType('unique')
            )
            ->create();

        $this->table('bookings')
            ->addForeignKey(
                $this->foreignKey('user_id')
                    ->setReferencedTable('users')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('NO_ACTION')
                    ->setName('bookings_ibfk_1')
            )
            ->addForeignKey(
                $this->foreignKey('car_id')
                    ->setReferencedTable('cars')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('NO_ACTION')
                    ->setName('bookings_ibfk_2')
            )
            ->update();

        $this->table('cars')
            ->addForeignKey(
                $this->foreignKey('category_id')
                    ->setReferencedTable('car_categories')
                    ->setReferencedColumns('id')
                    ->setOnDelete('SET_NULL')
                    ->setOnUpdate('NO_ACTION')
                    ->setName('cars_ibfk_1')
            )
            ->update();

        $this->table('invoices')
            ->addForeignKey(
                $this->foreignKey('booking_id')
                    ->setReferencedTable('bookings')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('NO_ACTION')
                    ->setName('invoices_ibfk_1')
            )
            ->update();

        $this->table('maintenances')
            ->addForeignKey(
                $this->foreignKey('car_id')
                    ->setReferencedTable('cars')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('NO_ACTION')
                    ->setName('maintenances_ibfk_1')
            )
            ->update();

        $this->table('payments')
            ->addForeignKey(
                $this->foreignKey('booking_id')
                    ->setReferencedTable('bookings')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('NO_ACTION')
                    ->setName('payments_ibfk_1')
            )
            ->update();

        $this->table('reviews')
            ->addForeignKey(
                $this->foreignKey('user_id')
                    ->setReferencedTable('users')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('NO_ACTION')
                    ->setName('reviews_ibfk_1')
            )
            ->addForeignKey(
                $this->foreignKey('car_id')
                    ->setReferencedTable('cars')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('NO_ACTION')
                    ->setName('reviews_ibfk_2')
            )
            ->addForeignKey(
                $this->foreignKey('booking_id')
                    ->setReferencedTable('bookings')
                    ->setReferencedColumns('id')
                    ->setOnDelete('SET_NULL')
                    ->setOnUpdate('CASCADE')
                    ->setName('reviews_ibfk_3')
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('bookings')
            ->dropForeignKey(
                'user_id'
            )
            ->dropForeignKey(
                'car_id'
            )->save();

        $this->table('cars')
            ->dropForeignKey(
                'category_id'
            )->save();

        $this->table('invoices')
            ->dropForeignKey(
                'booking_id'
            )->save();

        $this->table('maintenances')
            ->dropForeignKey(
                'car_id'
            )->save();

        $this->table('payments')
            ->dropForeignKey(
                'booking_id'
            )->save();

        $this->table('reviews')
            ->dropForeignKey(
                'user_id'
            )
            ->dropForeignKey(
                'car_id'
            )
            ->dropForeignKey(
                'booking_id'
            )->save();

        $this->table('bookings')->drop()->save();
        $this->table('car_categories')->drop()->save();
        $this->table('cars')->drop()->save();
        $this->table('invoices')->drop()->save();
        $this->table('maintenances')->drop()->save();
        $this->table('payments')->drop()->save();
        $this->table('reviews')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
