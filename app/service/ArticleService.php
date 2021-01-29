<?php


namespace app\service;


use app\BaseService;
use app\model\ArticleModel;
use app\model\CategoryModel;
use app\model\TagModel;
use app\Request;
use think\Collection;
use think\db\exception\DbException;
use think\facade\Db;
use think\facade\Log;
use think\Model;

/**
 * 文章管理类
 * Class ArticleService
 * @package app\service
 */
class ArticleService extends BaseService
{
    /**
     * @var TagService
     */
    private $tagService;
    
    
    public function __construct (Request $request, TagService $tagService)
    {
        parent ::__construct($request);
        $this -> tagService = $tagService;
    }
    
    /**
     * 添加
     *
     * @param string           $title
     * @param string           $contentMarkdown
     * @param string           $content
     * @param CategoryModel    $categoryModel
     * @param array|Collection $tagModelList [TagModel]
     * @param array            $extra
     *                                       String $extra [featured_image] 特色图像
     *                                       String $extra [keywords] 关键字用于SEO
     *                                       String $extra [describes] 简介用于SEO
     *                                       String $extra [views] 浏览量
     *                                       String $extra [is_original] 是否原创文章
     *                                       String $extra [source_url] 原文链接
     *                                       String $extra [source_name] 文章来源名称
     *
     * @return ArticleModel|false
     * @transaction
     */
    public function add (string $title, string $contentMarkdown, string $content, CategoryModel $categoryModel, $tagModelList = [], array $extra = [])
    {
        Db ::startTrans();
        $articleModel = new ArticleModel();
        
        // 这里这样写 而不用 -> data($extra) 的原因是,如果调用 data 方法后 接下来的操作拿不到 模型对象的 主键ID
        if (isset($extra['featured_image'])) $articleModel -> featured_image = $extra['featured_image'];
        if (isset($extra['keywords'])) $articleModel -> keywords = $extra['keywords'];
        if (isset($extra['describes'])) $articleModel -> describes = $extra['describes'];
        if (isset($extra['views'])) $articleModel -> views = $extra['views'];
        if (isset($extra['is_original'])) $articleModel -> is_original = $extra['is_original'];
        if (isset($extra['source_url'])) $articleModel -> source_url = $extra['source_url'];
        if (isset($extra['source_name'])) $articleModel -> source_name = $extra['source_name'];
        
        $articleModel -> title            = $title;
        $articleModel -> content_markdown = $contentMarkdown;
        $articleModel -> content          = $content;
        
        $articleModel -> category_id   = $categoryModel -> id;
        $articleModel -> category_name = $categoryModel -> category_name;
        
        if (!$articleModel -> save()) {
            Db ::rollback();
            return false;
        }
        
        // 保存 Tag Relation
        $relationSaveStatus = $this -> tagService -> relationAdd($articleModel, ArticleModel::TARGET_TYPE, $tagModelList);
        
        if ($relationSaveStatus) {
            Db ::commit();
            return $articleModel;
        }
        Db ::rollback();
        return false;
    }
    
    /**
     * 修改
     *
     * @param ArticleModel     $articleModel
     * @param string           $title
     * @param string           $contentMarkdown
     * @param string           $content
     * @param CategoryModel    $categoryModel
     * @param array|Collection $tagModelList [TagModel]
     * @param array            $extra
     *                                       String $extra [featured_image] 特色图像
     *                                       String $extra [keywords] 关键字用于SEO
     *                                       String $extra [describes] 简介用于SEO
     *                                       String $extra [views] 浏览量
     *                                       String $extra [is_original] 是否原创文章
     *                                       String $extra [source_url] 原文链接
     *                                       String $extra [source_name] 文章来源名称
     *
     * @transaction
     * @return ArticleModel|false
     */
    public function edit (ArticleModel $articleModel, string $title, string $contentMarkdown, string $content, CategoryModel $categoryModel, $tagModelList = [], array $extra = [])
    {
        Db ::startTrans();
        
        // 这里这样写 而不用 -> data($extra) 的原因是,如果调用 data 方法后 接下来的操作拿不到 模型对象的 主键ID
        if (isset($extra['featured_image'])) $articleModel -> featured_image = $extra['featured_image'];
        if (isset($extra['keywords'])) $articleModel -> keywords = $extra['keywords'];
        if (isset($extra['describes'])) $articleModel -> describes = $extra['describes'];
        if (isset($extra['views'])) $articleModel -> views = $extra['views'];
        if (isset($extra['is_original'])) $articleModel -> is_original = $extra['is_original'];
        if (isset($extra['source_url'])) $articleModel -> source_url = $extra['source_url'];
        if (isset($extra['source_name'])) $articleModel -> source_name = $extra['source_name'];
        
        $articleModel -> title            = $title;
        $articleModel -> content_markdown = $contentMarkdown;
        $articleModel -> content          = $content;
        
        $articleModel -> category_id   = $categoryModel -> id;
        $articleModel -> category_name = $categoryModel -> category_name;
        
        if (!$articleModel -> save()) {
            Db ::rollback();
            return false;
        }
        
        // 修改 Tag Relation
        $relationSaveStatus = $this -> tagService -> relationEdit($articleModel, ArticleModel::TARGET_TYPE, $tagModelList);
        
        if ($relationSaveStatus) {
            Db ::commit();
            return $articleModel;
        }
        Db ::rollback();
        return false;
    }
    
    
    /**
     * 读取
     *
     * @param Int $id
     *
     * @return array|false|Model|null
     */
    public function read (int $id)
    {
        try {
            $where = ['delete_time' => 0];
            return (new \app\model\ArticleModel()) -> with(['category', 'tagList.tag']) -> where($where) -> find($id);
        } catch (DbException $e) {
            $this -> handleException($e);
            return false;
        }
        
    }
    
    /**
     * 移除
     *
     * @param ArticleModel|int $article
     *
     * @return bool
     */
    public function remove ($article)
    {
        try {
            
            if (!($article instanceof ArticleModel)) {
                $article = (new \app\model\ArticleModel()) -> find((int)$article);
            }
            
            if (empty($article)) {
                return false;
            }
            
            $article -> delete_time = time();
            if ($article -> save()) {
                return true;
            }
            
            return false;
        } catch (DbException $e) {
            $this -> handleException($e);
            return false;
        }
        
    }
    
    /**
     * 列表
     *
     * @param array $where
     * @param array $order
     * @param false $page
     *
     * @return array|Collection
     */
    public function lists ($where = [], $order = [], $page = false)
    {
        try {
            
            $where = array_merge($where, ['delete_time' => 0]);
            
            $articleModel = ArticleModel ::where($where);
            
            if ($page !== false) {
                // 需要分页查询
                $articleModel -> limit($this -> offset($page), $this -> pageRows);
            }
            
            if (!empty($order)) {
                $articleModel -> order($order);
            }
            
            return $articleModel -> select();
            
        } catch (DbException $e) {
            $this -> handleException($e);
            return [];
        }
    }
    
    /**
     * 快捷增加浏览量
     *
     * @param ArticleModel $articleModel
     * @param int          $stepping
     *
     * @return ArticleModel|false
     */
    public function views (ArticleModel $articleModel, $stepping = 1)
    {
        $articleModel -> views = Db ::raw('views + ' . $stepping);
        if ($articleModel -> save()) {
            return $articleModel;
        }
        return false;
        
    }
}