<?php


use Phinx\Seed\AbstractSeed;

class TagsSeeder extends AbstractSeed
{
    const TABLE_NAME = "tags";

    public function run()
    {

        $data = [
            [
                'title'    => "Maslo"
            ],
            [
                'title'    => "Mleko"
            ],
            [
                'title'    => "Maslanka"
            ],
        ];

        $posts = $this->table(self::TABLE_NAME);
        $posts->insert($data)
            ->saveData();
    }
}
