<?php


use Phinx\Seed\AbstractSeed;

class TasksSeeder extends AbstractSeed
{
    const TABLE_NAME = "tasks";

    public function run()
    {
        $data = [
            [
                'user_id'    => 1,
                'title'    => 'lubiemaslo',
                'description'    => 'lubiemaslo',
                'state'    => 1,
                'status'    => 1
            ],
            [
                'user_id'    => 1,
                'title'    => '123',
                'description'    => 'lubiemaslo',
                'state'    => 8,
                'status'    => 1
            ],
            [
                'user_id'    => 1,
                'title'    => 'lubiem123333aslo',
                'description'    => 'lubiemaslo',
                'state'    => 2,
                'status'    => 1
            ],
            [
                'user_id'    => 1,
                'title'    => 'lubiemas321323lo',
                'description'    => 'lubiemaslo',
                'state'    => 2,
                'status'    => 1
            ],
            [
                'user_id'    => 1,
                'title'    => 'lubiem123123aslo',
                'description'    => 'lubiemaslo',
                'state'    => 4,
                'status'    => 1
            ],
            [
                'user_id'    => 1,
                'title'    => 'lubi123123emaslo',
                'description'    => 'lubiemaslo',
                'state'    => 1,
                'status'    => 1
            ],
            [
                'user_id'    => 1,
                'title'    => 'lubi123123emaslo',
                'description'    => 'lubiemaslo',
                'state'    => 3,
                'status'    => 1,
            ],
            [
                'user_id'    => 1,
                'title'    => 'lubiemaslo',
                'description'    => 'lubiemaslo',
                'state'    => 1,
                'status'    => 1,
            ],
        ];

        $posts = $this->table(self::TABLE_NAME);
        $posts->insert($data)
            ->saveData();
    }
}
