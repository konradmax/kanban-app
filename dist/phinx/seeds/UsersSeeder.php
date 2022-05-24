<?php


use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    const TABLE_NAME = "users";

    public function run()
    {

        $data = [
            [
                'username'    => 'username1',
                'password' => "lubiemaslo",
                'status' => 1,
                'date_created' => date('Y-m-d H:i:s'),
            ],
            [
                'username'    => 'username2',
                'password' => "lubiemaslo",
                'status' => 1,
                'date_created' => date('Y-m-d H:i:s'),
            ],
            [
                'username'    => 'admin',
                'password' => "swiezemlekotez",
                'status' => 1,
                'date_created' => date('Y-m-d H:i:s'),
            ],
        ];

        $posts = $this->table(self::TABLE_NAME);
        $posts->insert($data)
            ->saveData();
    }
}
