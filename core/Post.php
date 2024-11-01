<?php

namespace core;

use core\RequestMethod;

class Post extends RequestMethod
{
    public function __construct()
    {
        parent::__construct($_POST);
    }
}