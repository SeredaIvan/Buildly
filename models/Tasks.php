<?php

namespace models;

use core\Model;
/**
    *@var int id
    *@var string short_text
    *@var int id_costumer
    *@var string description
    *@var int cost
    *@var string date
    *@var int id_worker
    *@var int id_brigade
 * */
class Tasks extends Model
{
    public static $tableName = 'tasks';
    public function FindTaskById($id)
    {
        $task=$this->miniSearchFunc(null,$id);
        return $task;
    }
    public function FindAllTaskbyCostumer($id)
    {
        $tasks=$this->FindAllTasks('costumer',$id);
        return $tasks;
    }
    public function FindAllTaskbyWorker($id)
    {
        $tasks= $this->FindAllTasks('worker',$id);
        return $tasks;
    }
    public function FindAllTaskbyBrigade($id)
    {
        $tasks=$this->FindAllTasks('brigade',$id);
        return $tasks;
    }
    public function FindAllTasks($typeFind,$id)
    {
        $fieldSeach="id_".$typeFind;
        switch ($typeFind){
            case 'worker':
            case 'brigade':
            case  'costumer':
                $tasks= $this->miniSearchFunc([$fieldSeach=>['=',$id]]);
                return $tasks;
            default:
                return [];
        }
    }
    private function miniSearchFunc($arr=null,$id=null)
    {
        if(!empty($arr))
        self::selectByCondition($arr);
        else if(!empty($id))
            self::selectByCondition(['id'=>['=',$id]]);
    }
}