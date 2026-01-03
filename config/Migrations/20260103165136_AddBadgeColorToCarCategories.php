<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddBadgeColorToCarCategories extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('car_categories');
        $table->addColumn('badge_color', 'string', [
            'default' => null,
            'limit' => 7,
            'null' => false,
        ]);
        $table->addIndex([
            'badge_color',
        
            ], [
            'name' => 'BY_BADGE_COLOR',
            'unique' => false,
        ]);
        $table->update();
    }
}
