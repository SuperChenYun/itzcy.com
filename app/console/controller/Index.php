<?php

namespace app\console\controller;

use app\console\BaseController;

class Index extends BaseController
{
    public function index()
    {
        echo get_class($this->request);
        echo "\n";
        echo '<br />';
        echo __CLASS__;
        echo '\\';
        echo __FUNCTION__;
    }
}