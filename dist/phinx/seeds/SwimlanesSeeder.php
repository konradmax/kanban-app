<?php


use Phinx\Seed\AbstractSeed;

class SwimlanesSeeder extends AbstractSeed
{
    const TABLE_NAME = "swimlanes";

    public function run()
    {
        $data = [
            [
                'name'    => "todo",
                'value'    => 1,
                'description'    => 'Todo',
                'status'    => 1
            ],
            [
                'name'    => "in_progress",
                'value'    => 2,
                'description'    => 'In Progress',
                'status'    => 1
            ],
            [
                'name'    => "review",
                'value'    => 3,
                'description'    => 'Review',
                'status'    => 1
            ],
            [
                'name'    => "done",
                'value'    => 4,
                'description'    => 'Done',
                'status'    => 1
            ],
        ];

        $posts = $this->table(self::TABLE_NAME);
        $posts->insert($data)
            ->saveData();
    }
}
