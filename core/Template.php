<?php

namespace core;

class Template
{
    private $templatePath;
    protected $params;
    public function __set(string $name, $value)
    {
        Core::getInstance()->template->setParam($name,$value);
    }
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
    public function setTemplatePath($path)
    {
        $this->templatePath=$path;
    }
    public function getHTML()
    {
        ob_start();
        extract($this->params);
        include ($this->templatePath);
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }
    public function display()
    {
       echo $this->getHTML();
    }
}