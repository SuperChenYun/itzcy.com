<?php

namespace app\web;

use app\service\LinkService;
use app\service\MenuService;
use app\service\SettingService;
use think\App;
use think\facade\View;

/**
 * web基类
 * Class BaseController
 * @property MenuService    menuService
 * @property LinkService    linkService
 * @property SettingService settingService
 * @package app\web
 */
abstract class BaseController extends \app\BaseController
{
    /**
     * @var Int
     */
    protected $page;
    
    public function __construct (App $app, MenuService $menuService, LinkService $linkService, SettingService $settingService)
    {
        parent ::__construct($app);
        $this -> page           = $this -> request -> param('page', 1);
        $this -> menuService    = $menuService;
        $this -> linkService    = $linkService;
        $this -> settingService = $settingService;
        $this -> loadWebBaseData();
    }
    
    private function loadWebBaseData ()
    {
        // 主菜单
        $mainMenu = $this -> menuService -> menuTree($this -> menuService -> getMenuTypeBySign('MAIN_MENU'));
        // 扩展菜单
        $extMenu = $this -> menuService -> menuTree($this -> menuService -> getMenuTypeBySign('EXT_MENU'));
        // 页脚菜单
        $footerMenu = $this -> menuService -> menuTree($this -> menuService -> getMenuTypeBySign('FOOTER_MENU'));
        // 外链
        $links = $this -> linkService -> lists(['audit_pass' => 1]);
        // 系统配置
        $setting = $this -> settingService -> toKV($this -> settingService -> lists());
        
        View ::assign([
            'mainMenu' => $mainMenu,
            'extMenu'  => $extMenu,
            'footerMenu' => $footerMenu,
            'links'    => $links,
            'setting'  => $setting
        ]);
    }
    
    public function __error (): string
    {
        return View ::fetch('error/500');
    }
    
    
}