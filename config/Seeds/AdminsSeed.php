<?php

declare(strict_types=1);

use Migrations\BaseSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Admins seed.
 */
class AdminsSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@rentify.com',
                'password' => (new DefaultPasswordHasher())->hash('password123'),
                'role' => 'admin',
                'ic_number' => '999999-99-9999', // Dummy IC
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
