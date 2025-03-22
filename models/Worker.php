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
    public static function findAllWorkersByCondition(string $categories, int $payPerHour=0)
    {
        $filteredWorkersId=[];
        $filteredWorkers=[];

        $allworkers=self::selectAll();
        $mustCategories=explode(',',$categories);
        $prepearedWorkers=[];
        for($i=0;$i<count($allworkers);$i++){
            $prepearedWorkers[$i]=[explode(',',$allworkers[$i]['categories']),$allworkers[$i]['pay_per_hour']];
        }
        foreach ($prepearedWorkers as $id=>[$workerCategory,$workerPay]){
            if(count($mustCategories)==1){
                echo "one thing";
                if(in_array($mustCategories[0],$workerCategory)&&($payPerHour==0||$payPerHour===$workerPay)){
                    $filteredWorkersId[]=$id;
                    echo "one thing2";

                }
            }
            else if (count($mustCategories)>1) {
                echo "two thing";
                $newMust=$mustCategories;//для кожного робітника онновлюємо список
                foreach ($workerCategory as $category) {
                    $idArr=array_search($category,$newMust);
                    echo $idArr;
                    if(isset($idArr)) {
                        unset($newMust[$idArr]);
                    }
                }
                if(count($newMust)==0&&$payPerHour==$workerPay){
                    $filteredWorkersId[]=$id;
                }
            }
        }
        foreach ($filteredWorkersId as $id){
            $filteredWorkers=$allworkers[$id];
        }
        var_dump($filteredWorkers);
    }
    public static function selectByUserId(int $userId): ?Worker
    {
        $workerArr = self::selectByCondition(['id_user' => $userId])[0] ?? null;

        if (!empty($workerArr) && is_array($workerArr)) {
            $worker = new Worker();
            $worker->id = $workerArr['id'] ?? null;
            $worker->id_user = $workerArr['id_user'] ?? null;
            $worker->id_brigade = $workerArr['id_brigade'] ?? null;
            $worker->categories = $workerArr['categories'] ?? null;
            $worker->pay_per_hour = $workerArr['pay_per_hour'] ?? null;
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
}