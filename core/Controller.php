<?php

namespace core;

class Controller
{
    /**
     * @var array key must be 'alert-danger' or 'alert-warning' or 'alert-success'
     */
    public $arrayMessages=[];
    protected Template $smallTemplate;
    public bool $isPost=false;
    public bool $isGet=false;
    public function __construct()
    {

        $name=Core::getInstance()->nameController;
        $action=Core::getInstance()->actionController;
        $path="views/{$name}/{$action}.php";
        $this->smallTemplate=new Template($path);
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $this->isPost=true;
        }
        if($_SERVER['REQUEST_METHOD']==='GET'){
            $this->isGet=true;
        }
    }
    public function render($path=null)
    {
        if(!empty($path)){
            $this->smallTemplate->setTemplatePath($path);
        }
        if(!empty($this->arrayMessages)){
            var_dump($this->arrayMessages);
            $messages=$this->arrayMessages;
            $this->arrayMessages=[];
            return ['Content'=>$this->smallTemplate->getHTML(),'Messages'=>$messages];
        }
        return ['Content'=>$this->smallTemplate->getHTML()];
    }
    public function redirect($path)
    {
        header("Location: {$path}");
        die;
    }


}