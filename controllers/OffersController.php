<?php

namespace controllers;

use core\Controller;
use core\Messages;
use core\Post;
use models\Offers;
use models\Tasks;
use models\User;
use models\Worker;

class OffersController extends Controller
{
    public function actionOfferJob()
    {
        $post = new Post();
        $taskId = $post->getOne('task_id');
        $workerId = $post->getOne('worker_id');
        $costumerId = $post->getOne('costumer_id');

        if (empty($taskId) || empty($workerId)) {
            Messages::addMessage('Недостатньо даних для створення пропозиції.', 'alert-danger');
            $this->redirect('/tasks/all');
            return;
        }

        $isFromWorker = empty($costumerId);

        if ($isFromWorker) {
            $task = Tasks::selectById($taskId);
            if (!$task || empty($task['id_costumer'])) {
                Messages::addMessage('Завдання не знайдено або немає замовника.', 'alert-danger');
                $this->redirect('/tasks/all');
                return;
            }
            $costumerId = $task['id_costumer'];
        }

        // Перевірка на існуючу пропозицію
        $existing = Offers::selectByCondition([
            'id_task' => ['=', $taskId],
            'id_worker' => ['=', $workerId],
            'id_costumer' => ['=', $costumerId],
        ]);

        if (!empty($existing)) {
            Messages::addMessage('Пропозиція вже існує.', 'alert-warning');
            $this->redirect('/tasks/all');
            return;
        }

        $offer = new Offers();
        $offer->id_task = $taskId;
        $offer->id_worker = $workerId;
        $offer->id_costumer = $costumerId;
        $offer->dateOffer = date('Y-m-d');

        if ($offer->save()) {
            Messages::addMessage('Пропозицію надіслано.', 'alert-success');
        } else {
            Messages::addMessage('Не вдалося зберегти пропозицію.', 'alert-danger');
        }

        $this->redirect('/tasks/all');
    }


    public function actionIndex()
    {
        $user = User::GetUser();
        if (!$user) {
            $this->redirect('/login');
            return;
        }

        $offersForCostumer = [];
        $offersForWorker = [];

        if ($user->IsCostumer()) {
            $offers = Offers::selectByCondition(['id_costumer' => $user->id]);

            if (!empty($offers) && (is_array($offers) || is_object($offers))) {
                foreach ($offers as $offer) {

                    $workerUser = null;

                    if (!empty($offer['id_worker'])) {
                        $worker = Worker::selectById($offer['id_worker']);
                        if ($worker) {
                            $workerUser = User::selectById($worker['id_user']);
                        }
                    }


                    $offer['workerUser'] = $workerUser;
                    $offersForCostumer[] = $offer;
                }
            }
        }

        if ($user->IsWorker()) {
            $worker = Worker::selectByUserId($user->id);
            if ($worker) {
                $offers = Offers::selectByCondition(['id_worker' => $worker->id]);
                if (!empty($offers) && (is_array($offers) || is_object($offers))) {
                    foreach ($offers as $offer) {
                        $costumerUser = null;
                        if (!empty($offer['id_costumer'])) {
                            $costumerUser = User::selectById($offer['id_costumer']);
                        }
                        $offer['costumerUser'] = $costumerUser;
                        $offersForWorker[] = $offer;
                    }
                }
            }
        }

        return $this->render([
            'user' => $user,
            'offersForCostumer' => $offersForCostumer,
            'offersForWorker' => $offersForWorker,
        ]);
    }
    public function actionAcceptOffer()
    {
        $post = new Post();
        $offerId = $post->getOne('offer_id');
        $user = User::GetUser();

        if (!$user || empty($offerId)) {
            Messages::addMessage('Невірні дані.', 'alert-danger');
            $this->redirect('/offers/index');
            return;
        }

        $offerArr = Offers::selectById($offerId);
        if (!$offerArr) {
            Messages::addMessage('Пропозиція не знайдена.', 'alert-danger');
            $this->redirect('/offers/index');
            return;
        }

        $offer = new Offers();
        $offer->createObject($offerArr);

        $canAccept = false;

        $ofidW=$offer->id_worker;

        if ($user->IsCostumer() && $offer->id_costumer == $user->id && !empty($ofidW)) {
            $canAccept = true;

        } elseif ($user->IsWorker()) {
            $worker = Worker::selectByUserId($user->id);
            $ofIdC=$offer->id_costumer;
            if ($worker && $offer->id_worker == $worker->id && !empty($ofIdC)) {
                $canAccept = true;
            }
        }
        if (!$canAccept) {
            Messages::addMessage('Ви не можете прийняти цю пропозицію.', 'alert-danger');
            $this->redirect('/offers/index');
            return;
        }

        $offer->is_accepted = 1;

        if ($offer->save()) {
            Messages::addMessage('Пропозицію прийнято.', 'alert-success');
        } else {
            Messages::addMessage('Не вдалося оновити пропозицію.', 'alert-danger');
        }

        $this->redirect('/offers/index');
    }

    public function actionDeclineOffer()
    {
        $post = new Post();
        $offerId = $post->getOne('offer_id');
        $user = User::GetUser();

        if (!$user || empty($offerId)) {
            Messages::addMessage('Невірні дані.', 'alert-danger');
            $this->redirect('/offers/index');
            return;
        }

        $offerArr = Offers::selectById($offerId);
        if (!$offerArr) {
            Messages::addMessage('Пропозиція не знайдена.', 'alert-danger');
            $this->redirect('/offers/index');
            return;
        }

        $offer = new Offers();
        $offer->createObject($offerArr);

        $canDecline = false;
        $ofidW=$offer->id_worker;
        if ($user->IsCostumer() && $offer->id_costumer == $user->id && !empty($ofidW)) {
            $offer->id_costumer = null;
            $canDecline = true;
        } elseif ($user->IsWorker()) {
            $worker = Worker::selectByUserId($user->id);
            $ofIdC=$offer->id_costumer;
            if ($worker && $offer->id_worker == $worker->id && !empty($ofIdC)) {
                $offer->id_worker = null;
                $canDecline = true;
            }
        }

        if (!$canDecline) {
            Messages::addMessage('Ви не можете відхилити цю пропозицію.', 'alert-danger');
            $this->redirect('/offers/index');
            return;
        }

        if ($offer->save()) {
            Messages::addMessage('Пропозицію відхилено.', 'alert-success');
        } else {
            Messages::addMessage('Не вдалося оновити пропозицію.', 'alert-danger');
        }

        $this->redirect('/offers/index');
    }
/*var_dump($offer);
        var_dump($offer->id_costumer == $user->id);
        var_dump($offer->id_costumer );
        var_dump( $user->id);
        var_dump(!empty($offer->id_worker));
        var_dump($offer->id_worker);    */
}
