<?php

namespace models;

use core\Core;
use core\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $role
 * @property string $email
 * @property string $phone
 * @property int $age
 * @property string $city
 * @property int $password
 * @property string|array $avatar
 * @property string $about
 */
class User extends Model
{
    public static $tableName = 'users';

    public static function FindUser($conditions)
    {
        return self::selectByCondition($conditions);
    }

    public static function LoginUser($user)
    {
        Core::getInstance()->session->set('user', $user);
    }

    public static function Logout()
    {
        if (self::IsLogged()) {
            Core::getInstance()->session->remove('user');
        }
    }

    public static function IsLogged()
    {
        return !empty(Core::getInstance()->session->get('user'));
    }

    public static function GetUser(): ?self
    {
        if (self::IsLogged()) {
            $userData = Core::getInstance()->session->get('user')[0];

            $user =new User();
            $user->createObject($userData);
            return $user;
        }
        return null;
    }
    public function IsWorker():bool
    {
        if ($this->role==='worker')return true;
        else return false;
    }
    public function IsCostumer():bool
    {
        if ($this->role==='costumer')return true;
        else return false;
    }
    public function toJson()
    {
        $this->ignoreJson=['password'];
        return parent::toJson();
    }
}
