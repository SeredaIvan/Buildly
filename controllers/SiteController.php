<?php

namespace controllers;

use core\Controller;
use core\Core;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $fvds = Core::getInstance()->db->select('users', '*',['name'=>['=','DB']],['email'=>['=','[value-5]']],['email'=>['=','vanosereda77@gmail.com']]);
        /*$fvds = Core::getInstance()->db->insert('users', [
            'name' => 'DB',
            'surname' => 'MySQL',
            'role' => 'user',
            'email' => 'vanokseadsaawdr39eda77@gmail.com',
            'age' => 18,
            'brigade' => 5
        ]);*/
        // Оновлення запису
        // $fvds = Core::getInstance()->db->update('users', ['id' => ['>', 2]], ['name' => 'HOH']);

        // Видалення запису з таблиці users, де id = 4
        //$fvds = Core::getInstance()->db->delete('users', ['name'=>['=','HOH']]);

        // Вивести результат
        var_dump($fvds);

        return $this->render();
    }

}