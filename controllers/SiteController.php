<?php

namespace controllers;

use core\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render();
    }
}