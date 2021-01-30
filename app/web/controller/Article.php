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
use think\Paginator;
use think\service\PaginatorService;

/**
 * @property CategoryService categoryService
 * @property ArticleService  articleService
 * @property TagService      tagService
 */
class Article extends BaseController
{
    
    public function __construct (App $app, MenuService $menuService, LinkService $linkService, SettingService $settingService, ArticleService $articleService, CategoryService $categoryService, TagService $tagService)
    {
        parent ::__construct($app, $menuService, $linkService, $settingService);
        
        $this -> articleService  = $articleService;
        $this -> categoryService = $categoryService;
        $this -> tagService      = $tagService;
        
    }
    
    public function read (int $id): string
    {
        $article = $this -> articleService -> read($id);
        
        if ($article == false) {
            return View ::fetch('error/404');
        }
        
        return View ::fetch('article', [
            'article' => $article
        ]);
    }
    
    public function lists (): string
    {
        $articles = $this -> articleService -> lists([], ['id' => 'desc'], $this -> page);

        $paginator = Paginator::make([], $this->pageRows, $this->page, $this->articleService->count(), false, ['path'=>'/article']);
        
        return View ::fetch('articles', [
            'articles' => $articles,
            'paginator' => $paginator
        ]);
    }
    
    public function byCategory (string $sign)
    {
    }
    
    public function byTag (string $sign)
    {
    
    }
}