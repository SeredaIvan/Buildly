<?php

namespace controllers;

use core\Controller;
use core\Messages;
use core\Post;
use models\Brigade;
use models\Worker;
use models\User;

class BrigadeController extends Controller
{
    public function actionCreate()
    {
        $user = User::GetUser();

        if (!$user || !$user->IsWorker()) {
            Messages::addMessage('Доступ заборонено. Тільки виконавці можуть створювати бригади.', 'alert-danger');
            return $this->redirect('/');
        }

        if ($this->isPost) {
            $post = new \core\Post();
            $pay_per_hour       = floatval($post->getOne('pay_per_hour'));
            $selectedCategories = $post->getAll()['categories'] ?? [];

            $errors = [];
            if (empty($selectedCategories)) {
                $errors[] = 'Оберіть хоча б одну категорію.';
            }
            if ($pay_per_hour < 0) {
                $errors[] = 'Оплата повинна бути невід’ємною.';
            }
            if ($errors) {
                return $this->render([
                    'errors'  => $errors,
                    'oldData' => $post->getAll(),
                    'user'    => $user,
                ]);
            }

            $brigade = new Brigade();
            $brigade->user_id      = $user->id;
            $brigade->categories   = implode(',', $selectedCategories);
            $brigade->pay_per_hour = $pay_per_hour;
            $brigade->save();

            Messages::addMessage('Бригаду створено!', 'alert-success');
            return $this->redirect('/brigade/see/' . $brigade->id);
        }

        return $this->render([
            'user' => $user,
        ]);
    }
    public function actionSee($id)
    {
        if (is_array($id)) {
            $id = $id[0];
        }

        // 1) Отримуємо бригаду
        $brigadeData = Brigade::selectById((int)$id);
        if (!$brigadeData) {
            Messages::addMessage('Бригада не знайдена', 'alert-danger');
            return $this->redirect('/brigades');
        }
        // Преобразуємо масив у модель
        $brigade = new Brigade();
        $brigade->createObject($brigadeData);

        // 2) Перевірка, чи поточний виконавець вже приєднаний
        $user     = User::GetUser();
        $isJoined = false;
        if ($user && $user->IsWorker()) {
            $worker = Worker::selectByUserId($user->id);
            if ($worker && $worker->id_brigade == $brigade->id) {
                $isJoined = true;
            }
        }

        // 3) Завантажуємо всіх воркерів, в яких id_brigade = $brigade->id
        $rawMembers = Worker::selectByCondition(['id_brigade' => ['=', $brigade->id]]) ?? [];
        $members    = [];
        foreach ($rawMembers as $row) {
            $w = new Worker();
            $w->createObject($row);
            $members[] = $w;
        }

        return $this->render([
            'brigade'  => $brigade,
            'isJoined' => $isJoined,
            'user'     => $user,
            'members'  => $members,
        ]);
    }

    public function actionJoin($id)
    {
        if (is_array($id)) {
            $id = $id[0];
        }

        $user = User::GetUser();
        if (!$user || !$user->IsWorker()) {
            Messages::addMessage('Тільки виконавці можуть приєднатись до бригади', 'alert-danger');
            return $this->redirect("/brigade/see/$id");
        }


        $brigadeData = Brigade::selectById((int)$id);
        if (empty($brigadeData)) {
            Messages::addMessage('Бригада не знайдена', 'alert-danger');
            return $this->redirect('/brigades');
        }
        $brigade = (new Brigade())->toObj($brigadeData);

        $worker = Worker::selectByUserId($user->id);
        if (!$worker) {
            Messages::addMessage('Ви не зареєстровані як виконавець', 'alert-danger');
            return $this->redirect("/brigade/see/$id");
        }

        if ($worker->id_brigade == $brigade->id) {
            Messages::addMessage('Ви вже є членом цієї бригади', 'alert-info');
            return $this->redirect("/brigade/see/$id");
        }

        $worker->id_brigade = $brigade->id;
        if ($worker->save()) {
            Messages::addMessage('Ви успішно приєдналися до бригади!', 'alert-success');
        } else {
            Messages::addMessage('Помилка при приєднанні до бригади', 'alert-danger');
        }

        return $this->redirect("/brigade/see/$id");
    }
}
