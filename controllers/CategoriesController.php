<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\User;

class CategoriesController extends Controller
{
    public function actionViewAll()
    {
        $categories=\core\Config::getInstance()->paramsCategories[0];
        return $this->render(['categories'=>$categories]);
    }

}