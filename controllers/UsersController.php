<?php

namespace controllers;

use core\Config;
use core\Controller;
use core\Core;
use core\Get;
use core\Messages;
use core\Post;
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

    public function actionTestEmail()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: application/json');

        if($this->isGet){
            if (isset($_GET['email'])) {
                $email = $_GET['email'];
                $res = Core::getInstance()->db->select('users','*',['email'=>['=',$email]]);

                if (!empty($res)){
                    $data['data'] = $res;
                } else {
                    $data['data'] = 'err';
                }
            } else {
                $data['data'] = 'email not provided';
            }

            echo json_encode($data);
        } else {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
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
}