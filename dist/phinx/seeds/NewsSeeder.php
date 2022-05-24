<?php


use Phinx\Seed\AbstractSeed;

class NewsSeeder extends AbstractSeed
{
    const TABLE_NAME = "news";

    public function run()
    {
        $data = [
            [
                'title'    => 'NewsItem #1',
                'description' => "Lorem ipsum",
                'content' => "Lorem ipsum dolor sit amet.",
                'status' => 1,
                'date_created' => date('Y-m-d H:i:s'),
            ],
            [
                'title'    => 'NewsItem #2',
                'description' => "Lorem ipsum",
                'content' => "Lorem ipsum dolor sit amet.",
                'status' => 1,
                'date_created' => date('Y-m-d H:i:s'),
            ],
            [
                'title'    => 'NewsItem #3',
                'description' => "Lorem ipsum",
                'content' => "Lorem ipsum dolor sit amet.",
                'status' => 1,
                'date_created' => date('Y-m-d H:i:s'),
            ],
            [
                'title'    => 'NewsItem #4',
                'description' => "Lorem ipsum",
                'content' => "Lorem ipsum dolor sit amet.",
                'status' => 1,
                'date_created' => date('Y-m-d H:i:s'),
            ],
            [
                'title'    => 'NewsItem #5',
                'description' => "Lorem ipsum",
                'content' => "Lorem ipsum dolor sit amet.",
                'status' => 1,
                'date_created' => date('Y-m-d H:i:s'),
            ]
        ];

        $posts = $this->table(self::TABLE_NAME);
        $posts->insert($data)
            ->saveData();
    }
}
