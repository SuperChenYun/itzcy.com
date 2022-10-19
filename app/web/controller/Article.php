<?php


namespace app\web\controller;


use app\model\ArticleModel;
use app\service\ArticleService;
use app\service\CategoryService;
use app\service\LinkService;
use app\service\MenuService;
use app\service\SettingService;
use app\service\TagService;
use app\web\BaseController;
use think\App;
use think\Collection;
use think\facade\View;
use think\Paginator;
use think\Response;
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
    
    /**
     * 读取单个文章
     *
     * @param int $id
     *
     * @return string
     */
    public function read (int $id): string
    {
        $article = $this -> articleService -> read($id);
        
        if ($article == false) {
            return Response::create(View::fetch('error/404'), 'html', '404');
        }
        
        return View ::fetch('article', [
            'article' => $article
        ]);
    }
    
    /**
     * 全部列表
     * @return string
     */
    public function lists (): string
    {
        $articles = $this -> articleService -> lists([], ['id' => 'desc'], $this -> page);
        
        $paginator = Paginator ::make([], $this -> pageRows, $this -> page, $this -> articleService -> count(), false, ['path' => '']);
    
        $this -> assignArticleBaseData();
    
        return View ::fetch('articles', [
            'articles'  => $articles,
            'paginator' => $paginator
        ]);
    }
    
    /**
     * 按分类查询
     *
     * @param string $sign
     *
     * @return string
     */
    public function byCategory (string $sign)
    {
        $category = $this -> categoryService -> readBySign($sign);
        
        $articlesWhere = ['category_id' => $category -> id];
        $articles      = $this -> articleService -> lists($articlesWhere, ['id' => 'desc'], $this -> page);
        
        
        $paginator = Paginator ::make([], $this -> pageRows, $this -> page, $this -> articleService -> count($articlesWhere), false, ['path' => ""]);
        
        $this -> assignArticleBaseData();
        
        return View ::fetch('category_articles', [
            'category'  => $category,
            'articles'  => $articles,
            'paginator' => $paginator
        ]);
    }
    
    /**
     * 按标签查询
     *
     * @param string $sign
     *
     * @return string
     */
    public function byTag (string $sign)
    {
        $tag = $this -> tagService -> tagReadBySign($sign);
        
        if (empty($tag)) {
            return Response::create(View::fetch('error/404'), 'html', '404');
        }
        
        $tagRelation = $this -> tagService -> relationReadByTag($tag, ArticleModel::TARGET_TYPE);
        
        $articles = Collection ::make();
        $count    = 1;
        
        if (!$tagRelation -> isEmpty()) {
            
            $articlesWhere = [
                ['id', 'in', array_column($tagRelation -> toArray(), 'target_id')]
            ];
            
            $articles = $this -> articleService -> lists($articlesWhere, ['id' => 'desc'], $this -> page);
            
            $count = $this -> articleService -> count($articlesWhere);
        }
        
        
        $paginator = Paginator ::make([], $this -> pageRows, $this -> page, $count, false, ['path' => '']);
        
        $this -> assignArticleBaseData();
        
        return View ::fetch('tag_articles', [
            'tag'       => $tag,
            'articles'  => $articles,
            'paginator' => $paginator
        ]);
        
    }
    
    private function assignArticleBaseData ()
    {
        View ::assign([
            'categorys' => $this -> categoryService -> lists(),
            'tags'      => $this -> tagService -> tagList(),
        ]);
    }
}