<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TagsMigration extends AbstractMigration
{
    const TABLE_NAME = "tags";

    public function up(): void
    {
        $this->table(self::TABLE_NAME)->drop()->save();

        $table = $this->table(self::TABLE_NAME);
        $table->addColumn('title', 'string', ['limit' => 32])
            ->save();
    }
}
