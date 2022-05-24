<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserAdminMigration extends AbstractMigration
{
    const TABLE_NAME = "user_admin";

    public function up(): void
    {
        $this->table(self::TABLE_NAME)->drop()->save();

        $table = $this->table(self::TABLE_NAME);
        $table->addColumn('user_id', 'integer', ['limit' => 11])
            ->save();
    }
}
