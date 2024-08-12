<?php

namespace core;

class Core
{
    protected string $route;
    protected  static $instance;
    public function __construct($route)
    {
        $this->route = $route;
    }
    function run()
    {
        $router=new Router($this->route);
        $router->run();
        self::$instance=$this;
    }

    function end()
    {
        
    }
}