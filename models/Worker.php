<?php

namespace models;

use core\Model;

/**
 * @var int $id
 * @var int $id_user
 * @var string $categories
 * @var int $pay_per_hour
 */
class Worker extends Model
{
    public User $user;
    public static $tableName='workers';
    public static function findAllWorkers()
    {
        $workers = self::selectAll();
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
}


        /*
        $workers = self::selectAll();
        $mustCategories=explode(',', $categories);
        $filteredWorkers = [];

        foreach ($workers as $worker) {
            $incrementMustArray=$mustCategories;
            $workerCategories = explode(',', $worker['categories']);
            $workerPayPerHour=$worker['pay_per_hour'];
            $workerCategories = array_map('trim', $workerCategories);
            $incrementMustArray = array_map('trim', $incrementMustArray);
            //var_dump($incrementMustArray);
            //var_dump($workerCategories);
            foreach ($workerCategories as $category) {
                echo array_search($category, $incrementMustArray);
                if (!isset($incrementMustArray)) {
                    if (count($incrementMustArray) === 1) {
                        if (in_array($category, $incrementMustArray)) {
                            $incrementMustArray = [];
                        }
                    } else {
                        unset($incrementMustArray[array_search($category, $incrementMustArray)]);
                        var_dump($incrementMustArray);
                    }
                }


                /*for ($i=0;$i<count($workerCategories);$i++){
                    for ($j=0;$j<count($incrementMustArray);$j++){
                        if (!isset($incrementMustArray[$j])) {
                            continue;
                        }
                        if (levenshtein($workerCategories[$i], $incrementMustArray[$j]) <= 2){
                            unset($incrementMustArray[$j]);
                            break;
                        }
                    }
                }*/
/*
                if (count($incrementMustArray) == 0 && ($payPerHour == 0 || $workerPayPerHour == $payPerHour)) {
                    echo "yey";
                    $filteredWorkers[] = $worker;
                }
            }
        }
        return $filteredWorkers;
    }
}*/