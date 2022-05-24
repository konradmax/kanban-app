<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NewsMigration extends AbstractMigration
{
    const TABLE_NAME = "news";

    public function up(): void
    {
        $this->table(self::TABLE_NAME)->drop()->save();
        $table = $this->table(self::TABLE_NAME);
        $table->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('description', 'text', ['limit' => 255, 'null' => true])
            ->addColumn('content', 'string',['limit' => 2500])
            ->addColumn('status', 'integer', ['limit' => 2,'default' => 0])
            ->addColumn('date_created', 'datetime')
            ->addColumn('date_updated', 'datetime', ['null' => true])
            ->save();
    }
}
