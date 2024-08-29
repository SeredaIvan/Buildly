<?php

namespace core;

use Couchbase\KeyDeletedException;

class Config
{
    protected $params;
    private static $instance;
    private function __construct()
    {
        /** @var array $Config */
        $dir = 'config';
        $files = scandir($dir);
        foreach ($files as $file) {
            if (substr($file, -4) === '.php') {
                $path = $dir . '/' . $file;
                include_once($path);
            }
        }
        $this->params = [];
        foreach ($Config as $config){
            foreach ($config as $key=>$value){
                $this->params[$key]=$value;
            }
        }
    }
    public function __set(string $name, $value): void
    {
        $this->params[$name] = $value;
    }
    public function __get($name)
    {
        return $this->params[$name];
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}