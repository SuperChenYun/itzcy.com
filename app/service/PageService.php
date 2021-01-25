<?php


namespace app\service;


use app\BaseService;
use app\model\CategoryModel;
use app\model\PageModel;
use think\Collection;
use think\db\exception\DbException;
use think\facade\Db;
use think\facade\Log;
use think\Model;

/**
 * 页面管理类
 * Class PageService
 * @package app\service
 */
class PageService extends BaseService
{
    /**
     * 添加页面
     *
     * @param string        $title
     * @param string        $content
     * @param CategoryModel $categoryModel
     * @param array         $extra
     *                        String $extra [featured_image] 特色图像
     *                        String $extra [keywords] 关键字用于SEO
     *                        String $extra [describes] 简介用于SEO
     *                        String $extra [views] 浏览量
     *                        String $extra [release_time] 发布时间
     *
     * @return PageModel|false
     */
    public function add (string $title, string $content, CategoryModel $categoryModel, array $extra = [])
    {
        $pageModel = new PageModel();
        
        $pageModel -> data($extra);
        
        $pageModel -> title   = $title;
        $pageModel -> content = $content;
        
        $pageModel -> category_id   = $categoryModel -> id;
        $pageModel -> category_name = $categoryModel -> category_name;
        
        if ($pageModel -> save()) {
            return $pageModel;
        }
        return false;
    }
    
    /**
     * 修改页面
     *
     * @param PageModel     $pageModel
     * @param string        $title
     * @param string        $content
     * @param CategoryModel $categoryModel
     * @param array         $extra
     *                        String $extra [featured_image] 特色图像
     *                        String $extra [keywords] 关键字用于SEO
     *                        String $extra [describes] 简介用于SEO
     *                        String $extra [views] 浏览量
     *                        String $extra [release_time] 发布时间
     *
     * @return PageModel|false
     */
    public function edit (PageModel $pageModel, string $title, string $content, CategoryModel $categoryModel, array $extra = [])
    {
        
        $pageModel -> data($extra);
        
        $pageModel -> title   = $title;
        $pageModel -> content = $content;
        
        $pageModel -> category_id   = $categoryModel -> id;
        $pageModel -> category_name = $categoryModel -> category_name;
        
        if ($pageModel -> save()) {
            return $pageModel;
        }
        return false;
    }
    
    /**
     * 读取页面
     *
     * @param Int $id
     *
     * @return array|false|Model|null
     */
    public function read (int $id)
    {
        try {
            $where = ['delete_time' => 0];
            return (new \app\model\PageModel()) -> where($where) -> find($id);
        } catch (DbException $e) {
            $this->handleException($e);
            return false;
        }
        
    }
    
    /**
     * 移除页面
     *
     * @param PageModel|int $page
     *
     * @return bool
     */
    public function remove ($page)
    {
        try {
            
            if (!($page instanceof PageModel)) {
                $page = (new \app\model\PageModel()) -> find((int)$page);
            }
            
            if (empty($page)) {
                return false;
            }
            
            $page -> delete_time = time();
            if ($page -> save()) {
                return true;
            }
            
            return false;
        } catch (DbException $e) {
            $this->handleException($e);
            return false;
        }
        
    }
    
    /**
     * 页面列表
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
            
            $pageModel = PageModel ::where('delete_time', 0) -> where($where);
            
            if ($page !== false) {
                // 需要分页查询
                $pageModel -> limit($this -> offset($page), $this -> pageRows);
            }
            
            if (!empty($order)) {
                $pageModel -> order($order);
            }
            
            return $pageModel -> select();
            
        } catch (DbException $e) {
            $this->handleException($e);
            return [];
        }
        
    }
    
    /**
     * 快捷增加浏览量
     *
     * @param PageModel $pageModel
     * @param int       $stepping
     *
     * @return PageModel|false
     */
    public function views (PageModel $pageModel, $stepping = 1)
    {
        $pageModel -> views = Db ::raw('views + ' . $stepping);
        if ($pageModel -> save()) {
            return $pageModel;
        }
        return false;
        
    }
    
}