<?php

namespace app\web\controller;

use app\service\MenuService;
use app\service\TagService;
use app\web\BaseController;
use think\annotation\Route;
use think\App;

class Index extends BaseController
{
    public function __construct (App $app, MenuService $menuService)
    {
        parent ::__construct($app);
        $this -> menuService = $menuService;
    }
    
    /**
     *
     */
    public function index ()
    {
        // echo 'WEB';
        // echo "<br />";
        // echo get_class($this -> request);
        // echo "\n<br />";
        // # code...
        // echo __CLASS__;
        // echo "\n<br />";
        // echo __FUNCTION__;
        
        $m = $this -> menuService -> getMenuTypeBySign('FOOTER_MENU');
        
        echo     $this -> menuService -> menuTree($m) -> toJson();
        
    }
}