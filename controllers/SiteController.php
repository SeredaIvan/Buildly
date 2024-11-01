<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\User;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render();
    }

}