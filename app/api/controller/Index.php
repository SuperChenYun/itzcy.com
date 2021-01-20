<?php

namespace app\api\controller;

use app\api\BaseController;

class Index extends BaseController
{
    public function index()
    {
        echo get_class($this->request);
        echo "\n";
        echo '<br />';
        # code...
        echo __CLASS__;
        echo '\\';
        echo __FUNCTION__;
    }
}