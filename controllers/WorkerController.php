<?php

namespace controllers;

use core\Controller;
use core\Core;
use core\Get;
use core\Messages;
use core\Post;
use core\QueryParser;
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
        if ($this->isGet) {
            $get = new Get();
            $route = $get->arr['route'] ?? '';
            $parts = explode('/', $route);

            if (count($parts) >= 3) {
                $workersObj=[];
                $category = urldecode($parts[2]);
                $workers = Worker::findAllWorkersByConditionObj(0, 999999, $category, '*');
                if ($workers!=null) {
                    foreach ($workers as $worker) {
                        $workerObj = new Worker();
                        $workerObj->createObject($worker);

                        if (isset($workerObj->user) && $workerObj->user->id !== null) {
                            $workersObj[] = $workerObj;
                        }
                    }
                    return $this->render(['workers' => $workersObj, 'category' => $category]);
                }
            }

            return $this->render();
        }

        if ($this->isPost) {
            $post = new Post();
            $pay_per_hour_min = $post->getOne('pay_per_hour_min');
            $pay_per_hour_max = $post->getOne('pay_per_hour_max');
            $category = $post->getOne('category');
            $city = $post->getOne('city');

            $sortedWorkersJson = Worker::findAllWorkersByConditionJson($pay_per_hour_min, $pay_per_hour_max, $category, $city);
            header('Content-Type: application/json; charset=UTF-8');
            echo $sortedWorkersJson ?: json_encode(['error' => 'Не знайдено робітників за заданими критеріями.']);
            exit;
        }

        return $this->render();
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