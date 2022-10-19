<?php


namespace app\web\controller;


use app\service\ArticleService;
use app\service\LinkService;
use app\service\MenuService;
use app\service\SettingService;
use app\web\BaseController;
use think\App;
use think\facade\View;

/**
 * @property ArticleService articleService
 */
class Archives extends BaseController
{
    public function __construct (App $app, MenuService $menuService, LinkService $linkService, SettingService $settingService, ArticleService $articleService)
    {
        parent ::__construct($app, $menuService, $linkService, $settingService);
        $this -> articleService = $articleService;
    }
    
    /**
     * 归档页面
     */
    public function index ()
    {
        
        View::assign([
            'archives' => $this -> articleService -> archives()
        ]);
        return View ::fetch('archives');
    }
    
}