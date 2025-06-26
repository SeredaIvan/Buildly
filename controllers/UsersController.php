<?php

namespace controllers;

use core\Config;
use core\Controller;
use core\Core;
use core\Get;
use core\Messages;
use core\Post;
use models\Tasks;
use models\User;

class UsersController extends Controller
{

    public function actionRegistration($role = null)
    {
        if ($this->isPost) {
            $post = new Post();
            $email = $post->getOne('email');

            if (!empty($email)) {
                $userExists = User::FindUser(['email' => $email]);

                if (empty($userExists)) {
                    $user = new User();
                    $user->name = $post->getOne('name');
                    $user->surname = $post->getOne('surname');
                    $user->email = $email;
                    $user->phone = $post->getOne('phone');
                    $user->age = $post->getOne('age');
                    $user->city = $post->getOne('city');
                    $user->password = $post->getOne('password');
                    $user->role = $role ?: $post->getOne('role');

                    $res = $user->save();

                    if ($res) {
                        if (is_numeric($res)) {
                            $user->id = $res;
                        }
                        $user= User::selectByCondition(['id'=>['=',$res]]);
                        User::LoginUser($user);
                        if($post->getOne('role')==='worker'){
                            $this->redirect("/worker/workerRegisterInfo");
                        }
                        else {
                            $this->redirect("/");
                        }
                    }
                }
                else {
                    Messages::addMessage( 'Цей email вже використовується','alert-danger');

                    return $this->render();
                }
            }

        }
        return $this->render();
    }
    public function actionLogin()
    {
        if($this->isPost){
            $post = new Post();
            $email = $post->getOne('email');
            $password = $post->getOne('password');

            if (!empty($email) && !empty($password)) {
                $user = User::FindUser(['email' => ['=', $email]]);

                if (!empty($user)) {
                    $user = $user[0];

                    if ($password == $user['password']) {
                        User::LoginUser($user);
                        $this->redirect("/");
                    } else {
                        Messages::addMessage('Невірний пароль', 'alert-warning');
                    }
                } else {
                    Messages::addMessage('Користувача не знайдено', 'alert-warning');
                }
            } else {
                Messages::addMessage('Заповніть усі поля', 'alert-warning');
            }
        }

        return $this->render();
    }
    public function actionWorkerRegisterInfo()
    {
        if ($this->isPost) {

        }
        return $this->render();
    }


    public function actionSignOut()
    {
        User::Logout();
        $this->redirect("/");
    }

    public function actionView()
    {
        return $this->render();
    }
    public function actionSee()
    {
        $get = new Get();
        $route = $get->arr['route'] ?? '';
        $parts = explode('/', $route);
        if(array_key_exists(2,$parts)){
            $id=$parts[2];
            $user = \models\User::selectById($id);

            $userObj= new User();
            $userObj->createObject($user);
            if (!empty($userObj) && $userObj->IsWorker()) {
                $worker = \models\Worker::selectByUserId($userObj->id);
                /*$currentUser=User::GetUser();
                if($currentUser->IsCostumer()) {
                    $tasks = Tasks::selectByCondition(['id_costumer' => ['=',$currentUser->id]]);
                    return $this->render(['user'=>$userObj, 'worker'=>$worker,'tasks'=>$tasks], 'views/users/view.php');
                }*/
                return $this->render(['user'=>$userObj, 'worker'=>$worker], 'views/users/view.php');
            }
            return $this->render(['user'=>$userObj], 'views/users/view.php');
        }
        else{
            Messages::addMessage('Немає Id');
        }

    }
    public function actionGfgf()
    {
        return $this->render();
    }
}