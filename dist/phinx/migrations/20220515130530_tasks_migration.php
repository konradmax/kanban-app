<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TasksMigration extends AbstractMigration
{
    const TABLE_NAME = "tasks";

    public function change(): void
    {
        $this->table(self::TABLE_NAME)->drop()->save();

        $table = $this->table(self::TABLE_NAME);

        $table->addColumn('user_id', 'integer')
            ->addColumn('title', 'string')
            ->addColumn('description', 'string')
            ->addColumn('state', 'integer')
            ->addColumn('status', 'integer')
            ->save();
    }
}
