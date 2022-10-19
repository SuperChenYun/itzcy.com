<?php


namespace app\web\controller;


use app\service\ArticleService;
use app\service\CategoryService;
use app\service\LinkService;
use app\service\MenuService;
use app\service\SettingService;
use app\service\TagService;
use app\web\BaseController;
use think\App;
use think\facade\View;
use think\Response;

/**
 * @property CategoryService categoryService
 * @property ArticleService  articleService
 * @property TagService      tagService
 */
class Xml extends BaseController
{
    public function __construct (App $app, MenuService $menuService, LinkService $linkService, SettingService $settingService, CategoryService $categoryService, ArticleService $articleService, TagService $tagService)
    {
        parent ::__construct($app, $menuService, $linkService, $settingService);
        $this -> categoryService = $categoryService;
        $this -> articleService  = $articleService;
        $this -> tagService      = $tagService;
    }
    
    public function rss (): Response
    {
        View ::assign([
            'articles'  => $this -> articleService -> lists([], ['id' => 'desc']),
            'categorys' => $this -> categoryService -> lists([], ['id' => 'desc'])
        ]);
        
        return Response ::create(View ::fetch('xml/rss'), 'xml');
    }
    
    public function sitemap (): Response
    {
        View ::assign([
            'articles'  => $this -> articleService -> lists([], ['id' => 'desc']),
            'categorys' => $this -> categoryService -> lists([], ['id' => 'desc']),
            'tags'      => $this -> tagService -> tagList(),
        ]);
        return Response ::create(View ::fetch('xml/sitemap'), 'xml');
    }
}