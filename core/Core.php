<?php

namespace core;

class Core
{
    public string $nameController;
    public  string $actionController;
    protected $defaultPath = 'views/layout/index.php';
    private static $instance;
    protected Router $router;
    public Template $template;
    public $db;

    private function __construct() {
        $this->template = new Template($this->defaultPath);
        /*$dbHost=Config::getInstance()->dbHost;
        $dbName=Config::getInstance()->dbName;
        $dbLogin=Config::getInstance()->dbLogin;
        $dbPassword=Config::getInstance()->dbPassword;*/

        $this->db=new DB(Config::getInstance()->dbHost,Config::getInstance()->dbName,Config::getInstance()->dbLogin,
            Config::getInstance()->dbPassword);
    }

    public function run($route)
    {
        $this->router = new Router($route);
        $params = $this->router->run();

        if(!empty($params)) {
            $this->template->setParams($params);
        }

        self::$instance = $this;
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function done()
    {
        $this->template->display();
    }
}