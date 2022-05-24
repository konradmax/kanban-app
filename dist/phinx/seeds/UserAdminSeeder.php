<?php


use Phinx\Seed\AbstractSeed;

class UserAdminSeeder extends AbstractSeed
{
    const TABLE_NAME = "user_admin";

    public function run()
    {
        $data = [
            [
                'user_id'    => 3,
            ],
        ];

        $posts = $this->table(self::TABLE_NAME);
        $posts->insert($data)
            ->saveData();
    }
}
