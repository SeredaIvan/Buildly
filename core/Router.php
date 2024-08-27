<?php

namespace core;

class Router
{
    protected string $route;

    public function __construct($route)
    {
        $this->route = $route;

    }

    public function run()
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
        Core::getInstance()->nameController=$parts[0];
        Core::getInstance()->actionController=$parts[1];

        if (class_exists($controller)) {
            $method = 'action' . ucfirst($parts[1]);
            $controllerObj = new $controller();
            if (method_exists($controllerObj, $method)) {
                if (isset($params)){
                    return $controllerObj->$method($params);
                }
                else {
                    return $controllerObj->$method();

                }
            } else {
                $this->error(404);
            }
        } else {
            $this->error(404);
        }
        return null;
    }
    public function error($code)
    {
        http_response_code($code);
        switch ($code){
            case 404:
                echo "<h1>$code Not Found</h1>";
        }

    }
}
