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
    public function findAllWithFilters(array $filters = []): array
    {
        $conditions = [];

        if (!empty($filters['cost_min']) && is_numeric($filters['cost_min'])) {
            $conditions[] = ['cost', '>=', (float)$filters['cost_min']];
        }

        if (!empty($filters['cost_max']) && is_numeric($filters['cost_max'])) {
            $conditions[] = ['cost', '<=', (float)$filters['cost_max']];
        }

        if (!empty($filters['date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $filters['date'])) {
            $conditions[] = ['date', '=', $filters['date']];
        }

        $where = [];
        foreach ($conditions as $condition) {
            [$field, $operator, $value] = $condition;
            $where[$field] = [$operator, $value];
        }

        return self::selectByCondition($where) ?? [];
    }

}