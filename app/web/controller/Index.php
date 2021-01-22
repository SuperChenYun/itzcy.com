<?php

namespace app\web\controller;

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
    }
}