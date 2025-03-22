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
    public function render($arr = null, $path = null)
    {
        if (!empty($path)) {
            $this->smallTemplate->setTemplatePath($path);
        }
        if (!empty($arr)) {
            $this->smallTemplate->setParams($arr);
        }
        $messages = $this->arrayMessages;
        $this->arrayMessages = [];

        return [
            'Content' => $this->smallTemplate->getHTML(),
            'Messages' => $messages ?: null
        ];
    }

    public function redirect($path)
    {
        http_response_code(302);
        header("Location: {$path}");
        exit;
    }
}