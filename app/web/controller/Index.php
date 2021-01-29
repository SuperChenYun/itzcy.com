<?php

namespace app\web\controller;

use app\service\LinkService;
use app\service\MenuService;
use app\service\SettingService;
use app\web\BaseController;
use think\App;
use think\facade\View;

class Index extends BaseController
{
   public function __construct (App $app, MenuService $menuService, LinkService $linkService, SettingService $settingService)
   {
       parent ::__construct($app, $menuService, $linkService, $settingService);
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
        
        return View::fetch('index');
        
    }
}