<?php


namespace app\web\controller;


use app\service\LinkService;
use app\service\MenuService;
use app\service\PageService;
use app\service\SettingService;
use app\web\BaseController;
use think\App;
use think\facade\View;
use think\Response;

/**
 * @property PageService pageService
 */
class Page extends BaseController
{
    public function __construct (App $app, MenuService $menuService, LinkService $linkService, SettingService $settingService, PageService $pageService)
    {
        parent ::__construct($app, $menuService, $linkService, $settingService);
        
        $this->pageService = $pageService;
        
    }
    
    public function read(Int $id)
    {
        
        $page = $this->pageService->read($id);
        if (empty($page)) {
            return Response::create(View::fetch('error/404'), 'html', '404');
        }
        View::assign('page', $page);
        return View::fetch('page');
    
    }
    
    public function about(): string
    {
        return View::fetch('page/about');
    }
    
    public function resume(): string
    {
        return View::fetch('page/resume');
    }
    
}