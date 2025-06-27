<?php

namespace models;

use core\Model;
use models\User;
use models\Worker;

/**
 * @property int $id
 * @property int|null $id_costumer
 * @property int|null $id_worker
 * @property int|null $id_task
 * @property int|null $is_accepted
 * @property string $dateOffer
 */
class Offers extends Model
{
    public static $tableName = 'offers';

    public User|null $costumer = null;
    public Worker|null $worker = null;

    public function createObject($arr)
    {
        parent::createObject($arr);

        // Підвантаження об'єктів
        if (!empty($this->id_costumer)) {
            $userArr = User::selectById($this->id_costumer);
            if ($userArr) {
                $user = new User();
                $user->createObject($userArr);
                $this->costumer = $user;
            }
        }

        if (!empty($this->id_worker)) {
            $workerObj = Worker::selectById($this->id_worker);
            if ($workerObj) {
                $worker = new Worker();
                $worker->createObject($workerObj);
                $this->worker = $worker;
            }
        }
    }


    public static function findAllByWorkerId(int $workerId): array
    {
        $rows = self::selectByCondition(['id_worker' => ['=', $workerId]]);
        $offers = [];
        if ($rows) {
            foreach ($rows as $row) {
                $offer = new Offers();
                $offer->createObject($row);
                $offers[] = $offer;
            }
        }
        return $offers;
    }


    public static function findAllByCostumerId(int $costumerId): array
    {
        $rows = self::selectByCondition(['id_costumer' => ['=', $costumerId]]);
        $offers = [];
        if ($rows) {
            foreach ($rows as $row) {
                $offer = new Offers();
                $offer->createObject($row);
                $offers[] = $offer;
            }
        }
        return $offers;
    }

    public function toJson()
    {
        $arr = parent::toJson();
        $decoded = json_decode($arr, true);

        if (!empty($this->costumer)) {
            $decoded['costumer'] = json_decode($this->costumer->toJson(), true);
        }

        if (!empty($this->worker)) {
            $decoded['worker'] = json_decode($this->worker->toJson(), true);
        }

        return json_encode($decoded);
    }
}
