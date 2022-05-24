<?php


use Phinx\Seed\AbstractSeed;

class NewsTagsSeeder extends AbstractSeed
{
    const TABLE_NAME = "news_tags";

    public function run()
    {

        $data = [
            [
                'news_id'    => 1,
                'tags_id' => 1
            ],
            [
                'news_id'    => 1,
                'tags_id' => 2
            ],
            [
                'news_id'    => 2,
                'tags_id' => 1
            ],
        ];

        $posts = $this->table(self::TABLE_NAME);
        $posts->insert($data)
            ->saveData();
    }
}
