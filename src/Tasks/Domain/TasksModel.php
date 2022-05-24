<?php
declare(strict_types=1);

namespace App\Tasks\Domain;

use App\Common\Domain\CommonModel;

class TasksModel extends CommonModel
{
    protected $table = "tasks";

    protected $statuses = [1,2,3,4];

    public function groupByStatus($data,$statuses=null)
    {
        $output = [];

        if(! empty($statuses)) {
            $this->statuses = $statuses;
        }

        if(! empty($data)) {
            foreach($data as $dataItem) {
                $output[$dataItem['state']][$dataItem['id']] = $dataItem;
            }
            if(count($this->statuses)!==count($output[$dataItem['state']])) {
                foreach($this->statuses as $status) {
                    if(! array_key_exists(intval($status), $output)) {
                        $output[$status] = null;
                    }
                }
            }
        }



        return $output;
    }

    public function updateTaskState($taskId,$stateId)
    {
        return $this->updateById($taskId, ['state'=>$stateId]);
    }
}
