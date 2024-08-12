<?php
use \core\Template;

namespace controllers;

class RegistrationController
{
    public function actionRun()
    {
        $template = new core\Template('views/layout/header.php');
        $template->setParams(['Title'=>'mytitle','Content'=>'myCONTENT']);
        $template->display();
    }
}