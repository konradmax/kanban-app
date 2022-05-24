<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SwimlanesMigration extends AbstractMigration
{
    const TABLE_NAME = "swimlanes";

    public function change(): void
    {
        $this->table(self::TABLE_NAME)->drop()->save();

        $table = $this->table(self::TABLE_NAME);

        $table->addColumn('name', 'string')
            ->addColumn('value', 'string')
            ->addColumn('description', 'string')
            ->addColumn('status', 'integer')
            ->save();
    }
}
