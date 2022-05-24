<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UsersMigration extends AbstractMigration
{
    const TABLE_NAME = "users";

    public function up(): void
    {
        $this->table(self::TABLE_NAME)->drop()->save();
        $table = $this->table(self::TABLE_NAME);
        $table->addColumn('username', 'string', ['limit' => 255])
            ->addColumn('password', 'text', ['limit' => 255, 'null' => true])
            ->addColumn('status', 'integer', ['limit' => 2,'default' => 0])
            ->addColumn('date_created', 'datetime')
            ->addColumn('date_updated', 'datetime', ['null' => true])
            ->save();
    }
}
