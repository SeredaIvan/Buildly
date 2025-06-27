<?php

namespace controllers;

use core\Controller;
use core\Get;
use core\Messages;
use core\Post;
use models\Tasks;
use models\User;

class TasksController extends Controller
{

    public function actionAdd()
    {
        $user = User::GetUser();

        if (!$user || !$user->IsCostumer()) {
            Messages::addMessage('Ви не є замовником', 'alert-danger');
            return $this->render(['user' => $user]);
        }

        if ($this->isPost) {
            $post = new Post();
            $short_text = trim($post->getOne('short_text'));
            $description = trim($post->getOne('description'));
            $cost = $post->getOne('cost');
            $date = $post->getOne('date');
            $city = trim($post->getOne('city'));
            $category = trim($post->getOne('category'));

            $errors = [];

            if (empty($short_text)) {
                $errors[] = 'Короткий опис обовʼязковий';
            }
            if (empty($description)) {
                $errors[] = 'Опис обовʼязковий';
            }
            if (empty($cost) || !is_numeric($cost) || $cost < 0) {
                $errors[] = 'Некоректна вартість';
            }
            if (empty($date)) {
                $errors[] = 'Дата обовʼязкова';
            }
            if (empty($city)) {
                $errors[] = 'Місто обовʼязкове';
            }
            if (empty($category)) {
                $errors[] = 'Категорія обовʼязкова';
            }

            if (!empty($errors)) {
                return $this->render([
                    'errors' => $errors,
                    'oldData' => $post->getAll(),
                    'user' => $user
                ]);
            }

            $task = new Tasks();
            $task->short_text = $short_text;
            $task->description = $description;
            $task->cost = $cost;
            $task->date = $date;
            $task->id_costumer = $user->id;
            $task->id_worker = null;
            $task->id_brigade = null;
            $task->city = $city;
            $task->category = $category;

            if ($task->save()) {
                Messages::addMessage('Завдання успішно створено', 'alert-success');
                $this->redirect('/');
            } else {
                $errors[] = 'Не вдалося зберегти завдання';
                return $this->render([
                    'errors' => $errors,
                    'oldData' => $post->getAll(),
                    'user' => $user
                ]);
            }
        }

        return $this->render(['user' => $user]);
    }

    public function actionAll()
    {
        $user = \models\User::GetUser();
        $get  = new \core\Get();

        $filters = [
            'cost_min'  => $get->arr['cost_min']  ?? null,
            'cost_max'  => $get->arr['cost_max']  ?? null,
            'date'      => $get->arr['date']      ?? null,
            'city'      => $get->arr['city']      ?? null,
            'category'  => $get->arr['category']  ?? null,
        ];

        $taskModel = new \models\Tasks();
        $tasks = $taskModel->findAllWithFilters($filters);

        return $this->render([
            'user'    => $user,
            'filters' => $filters,
            'tasks'   => $tasks,
        ]);
    }
    public function actionView($params)
    {
        if (!empty($params[0])) {
            $id = (int)$params[0];
            $taskArray = \models\Tasks::selectById($id);
            if (!empty($taskArray)) {
                $task = new \models\Tasks();
                $task->createObject($taskArray);
                return $this->render(['task' => $task], 'views/tasks/view.php');
            } else {
                \core\Messages::addMessage('Завдання не знайдене', 'alert-danger');
                return $this->redirect('/tasks');
            }
        } else {
            \core\Messages::addMessage('Невірний ID завдання', 'alert-danger');
            return $this->redirect('/tasks');
        }
    }

}
