<?php

namespace core;

class RequestMethod
{
    public $arr;
    public function __construct($arr)
    {
        $this->arr=$arr;
    }
    public function getOne($name)
    {
        return $this->arr[$name];
    }
    public function getAll()
    {
        return $this->arr;
    }
}