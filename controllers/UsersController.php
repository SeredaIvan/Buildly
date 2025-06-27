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
    public function actionSee($id)
    {

        $userData = !empty($id[0]) ? (int)$id[0] : null;
        //var_dump($userData);
        //die();
        $viewed = User::selectById($userData);
        if (!$viewed) {
            Messages::addMessage('Користувача не знайдено', 'alert-danger');
            return $this->redirect('/');
        }


        $user = new User();
        $user->createObject($viewed);

        $worker = null;
        $tasksForDropdown = [];


        if ($user->IsWorker()) {
            $worker = \models\Worker::selectByUserId($user->id);

        }


        $current = User::GetUser();
        if ($current && $current->IsCostumer()) {
            $rawTasks = Tasks::selectByCondition(['id_costumer' => ['=', $current->id]]) ?? [];
            foreach ($rawTasks as $t) {
                $tasksForDropdown[] = $t;
            }
        }

        return $this->render([
            'user'           => $user,
            'worker'            => $worker,
            'tasksForDropdown'  => $tasksForDropdown,
        ], 'views/users/view.php');
    }

}