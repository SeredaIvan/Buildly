<?php

use models\Worker;
/*
var_dump($_SESSION['user']);
echo "Core session get <br>";
var_dump(\core\Core::getInstance()->session->get('user'));
echo "<br>";
echo "Users->GetUser";
var_dump(\models\User::GetUser());
echo "IsLogged<br>";
echo \models\User::IsLogged();
echo "<br>User name<br>";
echo \models\User::GetUser()->name;
echo "<br>User id<br>";
echo \models\User::GetUser()->id;
*/

$freeWorkers = Worker::selectByCondition([
    'pay_per_hour' => ['>', '0'],
    'categories' => ['LIKE', '%зварювальні роботи%'],
], null, ['pay_per_hour' => ['<', '1000']]);//повертає масив значень [['id': 1 ...], ['id':2...],]
if(!empty($freeWorkers)) {
    $json='';
    //$json="[";
    foreach ($freeWorkers as $worker) {
        $tmpWorker = Worker::selectByUserId($worker['id_user']);//перетворення на об'єкт
        if(strtolower($tmpWorker->user->city) === strtolower('Київ'))
            $json .= $tmpWorker->toJson()." , ";
        else {
            $json=substr($json, 0, -3);
        }
    }
    //$json.=']';
    if($json!=='')
        echo  $json;
    else
        echo '';
}
else{
    echo '';
}
