<?php

namespace App\Tasks\Domain;

use Max\Dashboard\Common\Model\CommonModel;
use Max\Dashboard\Task\Entity\TaskEntity;

class TasksModel extends CommonModel
{
    protected $table_name = "tasks";

    protected $statuses = [1,2,3,4];

    /**
     * @param  integer|string $zadanieId
     * @param  integer        $stateId
     * @return false|\PDOStatement
     */
    public function updateTaskState($taskId,$stateId)
    {
        return $this->updateById($taskId, ['state'=>$stateId]);
    }

    /**
     * @param  $user_id
     * @return array
     */
    function getTasksByUser($user_id)
    {

        $result = $this->readAll(['user_id'=>$user_id]);

        $output = [];
        foreach($result as $item) {
            $output[] = new TaskEntity($item);
        }

        return $output;
    }

    /**
     * @param  $user_id
     * @return array
     */
    public function getTasksByUserGroupByStatus($user_id)
    {
        $tasks = $this->getTasksByUser($user_id);

        $output = [];

        if(! empty($tasks)) {
            foreach($tasks as $task) {
                $output[$task->status][$task->id] = $task;
            }
        }

        if(count($this->statuses)!==count($output[$task->status])) {
            foreach($this->statuses as $status) {
                if(! array_key_exists(intval($status), $output)) {
                    $output[$status] = null;
                }
            }
        }

        return $output;
    }

    /**
     * @param  $user_id
     * @param  $status
     * @return array
     */
    function getTasksByUserWithComments($user_id,$status)
    {
        // dla kazdego zadania pobierz komentarze
        $listaZadan = $this->getTasksByUser($user_id, $status);
        if(count($listaZadan)>0) {
            foreach($listaZadan as $index=>$pojedynczeZadanie) {

                $kommentarze = $this->getCommentsByTaskId($pojedynczeZadanie->id);
                $listaZadan[$index] = $pojedynczeZadanie->attachComments($kommentarze);

                $listaZadan[$index]->comments =$this->getCommentsByTaskId($pojedynczeZadanie->id);
            }
        }

        return $listaZadan;
    }

    /**
     * @param  $task_id
     * @return false
     */
    function getCommentsByTaskId($task_id)
    {

        return false;
    }
}
