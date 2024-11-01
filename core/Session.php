<?php

namespace core;

class Session
{
    function set($name ,$value)
    {
        $_SESSION[$name]=$value;
    }
    function get($name)
    {
        if(!empty($_SESSION[$name]))
        return $_SESSION[$name];
    }
    function remove($name)
    {
        unset($_SESSION[$name]);
    }

}