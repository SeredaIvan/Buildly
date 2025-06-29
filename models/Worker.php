<?php

namespace models;

use core\Model;

/**
 * @var int $id
 * @var int $id_user
 * @var int $id_brigade
 * @var string $categories
 * @var int $pay_per_hour
 */
class Worker extends Model
{
    public User $user;
    public static $tableName='workers';
    public function createObject($arr) {
        if ($arr !== null) {
            parent::createObject($arr);
        } else {
            echo "Warning: Unable to create object, data is null.";
        }
        $user = Worker::selectUserById($this->id_user);
        if (!empty($user)) {
            $this->user = $user;
        }
    }

    public static function findAllWorkers()
    {
        $workersArr = self::selectAll();
        $workers=[];
        foreach ($workersArr as $workerCount){
            $worker=new Worker();
            $worker->createObject($workerCount);
            $workers[]=$worker;
        }
        return $workers;
    }

    /***
     * @param $pay_per_hour_min
     * @param $pay_per_hour_max
     * @param $category
     * @param $city
     * @return string clear Json for Workers with Users
     */
    public static function findAllWorkersByConditionJson($pay_per_hour_min, $pay_per_hour_max, $category, $city='*'):string
    {
        $categoryPattern = "%" . $category . "%";

        $freeWorkers = Worker::selectByCondition([
            'pay_per_hour' => ['>', $pay_per_hour_min],
            'categories' => ['LIKE', $categoryPattern],
        ], null, ['pay_per_hour' => ['<', $pay_per_hour_max]]);//повертає масив значень [['id': 1 ...], ['id':2...],]
        if(!empty($freeWorkers)) {
            $json="[";
            if($city==="*"){
                foreach ($freeWorkers as $worker) {
                    $tmpWorker = Worker::selectByUserId($worker['id_user']);
                    $json.=$tmpWorker->toJson()." , ";
                }
            }
            else{
            foreach ($freeWorkers as $worker) {
                $tmpWorker = Worker::selectByUserId($worker['id_user']);//перетворення на об'єкт
                if(strtolower($tmpWorker->user->city) === strtolower($city))
                    $json .= $tmpWorker->toJson()." , ";
                else {
                    $json=substr($json, 0, -3);
                }
            }
            }

            if($json!=='') {
                $json.=']';
                return $json;
            }
            else
                return '';
        }
        else{
            return '';
        }
    }
    /***
     * @param $pay_per_hour_min
     * @param $pay_per_hour_max
     * @param $category
     * @param $city
     * @return array | null assoc arr for Workers with User
     */
    public static function findAllWorkersByConditionObj($pay_per_hour_min, $pay_per_hour_max, $category, $city='*'):array|null
    {
        $categoryPattern = "%" . $category . "%";

        $freeWorkers = Worker::selectByCondition([
            'pay_per_hour' => ['>', $pay_per_hour_min],
            'categories' => ['LIKE', $categoryPattern],
        ], null, ['pay_per_hour' => ['<', $pay_per_hour_max]]);
        if(!empty($freeWorkers)) {
            $workers= [];
            if($city!='*') {
                foreach ($freeWorkers as $worker) {
                    $tmpWorker = Worker::selectByUserId($worker['id_user']);
                    if (strtolower($tmpWorker->user->city) === strtolower($city))
                        $workers[] = $worker;
                    else continue;
                }
            }
            else{
                $workers=$freeWorkers;
            }
            if(!empty($workers))
                return $workers;
            else
                return null;
        }
        else{
            return null;
        }
    }

    public static function selectByUserId(int $userId): ?Worker
    {
        $workerArr = self::selectByCondition(['id_user' => $userId])[0] ?? null;

        if (!empty($workerArr) && is_array($workerArr)) {
            $worker = new Worker();
            $worker->createObject($workerArr);
            return $worker;
        } else {
            return null;
        }
    }
    protected static function selectUserById(int $userId):User
    {
        $userArr=User::selectById($userId);
        $user=new User();
        $user->createObject($userArr);
        return $user;
    }

    public function getArrayCategories():array
    {
        return(explode(',',$this->categories));
    }
    public function toJson()
    {
        $arr=[];
        foreach ($this->fieldsValue as $key => $value){
            $arr[$key]=$value;
        }
        if (!empty($this->user)) {
            $arr['user']=$this->user->toJson();
            $arr['user']=json_decode($arr['user'], true);

            return json_encode($arr);
        }
        return json_encode(['error' => 'user empty']);


    }
}