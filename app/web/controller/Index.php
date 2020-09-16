<?php

namespace app\web\controller;

use app\web\BaseController;
use think\annotation\Route;

class Index extends BaseController
{
    /**
     * @Route("xxxxxxxx")
     */
    public function index() 
    {
        echo  'WEB';
        echo "<br />";
        echo get_class($this->request);
        echo "\n";
        echo '<br />';
        # code...
        echo __CLASS__;
        echo '\\';
        echo __FUNCTION__;
    }
}