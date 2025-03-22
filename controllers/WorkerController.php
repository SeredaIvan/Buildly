<?php

namespace controllers;

use core\Controller;
use core\Core;
use core\Get;
use core\Messages;
use core\Post;
use models\User;
use models\Worker;
use MongoDB\Driver\Server;

class WorkerController extends Controller
{
    public function actionWorkerRegisterInfo()
    {
        if($this->isPost) {
            $post = new Post();
            $payPerHour = $post->getOne('pay_per_hour');
            $allData=$post->getAll();
            $categories=implode(',', array_slice(array_values($allData),1));
            $user=User::GetUser();
            $worker= new Worker();
            $worker->id_user=$user->id;
            echo $user->id;
            $worker->id_brigade=null;
            $worker->pay_per_hour=$payPerHour;
            $worker->categories=$categories;
            var_dump($worker);
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
        $workers=Worker::findAllWorkers();
        return $this->render(['workers'=>$workers]);
    }
    public function actionFindByCategories()
    {
        if($this->isGet){
            $workers=Worker::findAllWorkers();
            return $this->render(['workers'=>$workers]);
        }
        if($this->isPost){
            $post = new Post();

        }

    }
    public static function findUserWorker():Worker|null
    {
        if(User::IsLogged()){
            $user=User::GetUser();
            $id=User::GetUser()->id;
            if($user->IsWorker()&&!empty($id)) {
                $worker=Worker::selectByUserId($id);
                return $worker;
            }
        }
        else{
            return null;
        }
        return null;
    }
}