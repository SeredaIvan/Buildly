<?php

namespace core;

class Router
{
    protected string $route;
    protected $indexTemplate;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function run(): void
    {
        $parts = explode('/', $this->route);

        if (strlen($parts[0])===0)
        {
            $parts[0]='site';
            $parts[1]='index';
        }
        if (count($parts)==1){
            $parts[1]='index';
        }
        if (count($parts)>2) {
            $params = array_slice($parts, 2);
        }
        $controller = 'controllers\\' . ucfirst($parts[0]) . 'Controller';

        if (class_exists($controller)) {
            $method = 'action' . ucfirst($parts[1]);
            $controllerObj = new $controller();
            if (method_exists($controllerObj, $method)) {
                if (isset($params)){
                    $controllerObj->$method($params);
                }
                else {
                    $controllerObj->$method();
                }
            } else {
                $this->error(404);
            }
        } else {
            $this->error(404);
        }
    }
    public function error($code)
    {
        http_response_code($code);
        switch ($code){
            case 404:
                echo "<h1>$code Not Found</h1>";
        }

    }
    public function end()
    {

    }
}
