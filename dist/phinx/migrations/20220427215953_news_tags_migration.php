<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NewsTagsMigration extends AbstractMigration
{
    const TABLE_NAME = "news_tags";

    public function up(): void
    {
        $this->table(self::TABLE_NAME)->drop()->save();

        $table = $this->table(self::TABLE_NAME);
        $table->addColumn('news_id', 'integer', ['limit' => 11])
            ->addColumn('tags_id', 'integer', ['limit' => 11])
            ->save();
    }
}
