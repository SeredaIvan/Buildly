<?php

namespace controllers;

use core\Controller;
use core\Core;
use core\Messages;
use core\Post;
use models\User;
use models\Worker;

class WorkerController extends Controller
{
    public function actionWorkerRegisterInfo()
    {
        if($this->isPost) {
            $post = new Post();
            $payPerHour = $post->getOne('pay_per_hour');
            echo $payPerHour;
            $allData=$post->getAll();
            $categories=implode(',', array_slice(array_values($allData),1));
            echo $categories;
            echo User::GetUser()->id;
            $worker= new Worker();
            $worker->id_user=User::GetUser()->id;
            $worker->pay_per_hour=$payPerHour;
            $worker->categories=$categories;
            if ($worker->save()){
                Core::getInstance()->session->set('is_register_worker',true);
                $this->redirect("/");
            }
            else{
                Messages::addMessage('Не вдалось зареєструвати');
                return $this->render();
            }
        }
        Core::getInstance()->session->set('is_register_worker',false);
        return $this->render();
    }
    public function actionFindAll()
    {
        $res= Worker::findAllWorkers();
        var_dump($res);
    }
    public function actionFindByCategories()
    {
        $res= Worker::findAllWorkersByCondition('штукатурка',75);
        var_dump($res);
    }
}