<?php

namespace app\web\controller;

use app\service\TagService;
use app\web\BaseController;
use think\annotation\Route;

class Index extends BaseController
{
    /**
     *
     */
    public function index() 
    {
        echo  'WEB';
        echo "<br />";
        echo get_class($this->request);
        echo "\n<br />";
        # code...
        echo __CLASS__;
        echo "\n<br />";
        echo __FUNCTION__;
        
        $a = (new TagService($this->request))->tagAdd('tagName', 'tagSign', '1', '2');
        var_dump($a);
    }
}