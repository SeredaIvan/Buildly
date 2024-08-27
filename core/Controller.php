<?php

namespace core;

class Controller
{
    protected Template $smallTemplate;
    public function __construct()
    {
        $name=Core::getInstance()->nameController;
        $action=Core::getInstance()->actionController;
        $path="views/{$name}/{$action}.php";
        $this->smallTemplate=new Template($path);
    }
    public function render()
    {
        return ['Content'=>$this->smallTemplate->getHTML()];
    }

}