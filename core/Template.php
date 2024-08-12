<?php

namespace core;

class Template
{
    protected $templatePath;
    protected $params;
    public function __construct($templatePath)
    {
        $this->templatePath=$templatePath;
        $this->params=[];
    }
    public function setParam($nameParam,$value)
    {
        $this->params[$nameParam]=$value;
    }
    public function setParams($params)
    {
        foreach ($params as $key=>$value){
            $this->setParam($key,$value);
        }
    }
    public function getHTML()
    {
        ob_start();
        extract($this->params);
        include_once ($this->templatePath);
        $str = ob_get_contents();
        ob_clean();
        return $str;
    }
    public function display()
    {
       echo $this->getHTML();
    }
}