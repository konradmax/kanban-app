<?php
declare(strict_types=1);

namespace App\Tasks\Domain;

use App\Common\Domain\CommonModel;

class SwimlanesModel extends CommonModel
{
    protected $table = "swimlanes";

    protected $statuses = [1,2,3,4];

    public function setStatuses($statuses)
    {
        $this->statuses = $statuses;
    }

    public function sortByValue($data)
    {
        $output=null;
        foreach($data as $item) {
            $output[$item['value']]=$item;
        }

        return $output;
    }

    public function groupByStatus($data)
    {
        $output = [];

        if(! empty($data)) {
            foreach($data as $dataItem) {
                $output[$dataItem['state']][$dataItem['id']] = $dataItem;
            }
        }

        if(count($this->statuses)!==count($output[$dataItem['state']])) {
            foreach($this->statuses as $status) {
                if(! array_key_exists(intval($status), $output)) {
                    $output[$status] = null;
                }
            }
        }

        return $output;
    }
}
