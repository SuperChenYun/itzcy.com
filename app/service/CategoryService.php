<?php


namespace app\service;


use app\BaseService;
use app\model\CategoryModel;
use think\Collection;
use think\db\exception\DbException;
use think\facade\Log;
use think\Model;

/**
 * 分类管理类
 * Class CategoryService
 * @package app\service
 */
class CategoryService extends BaseService
{
    
    /**
     * 添加分类
     *
     * @param String $categoryName
     * @param String $categorySign
     * @param String $featuredImage
     * @param String $keywords
     * @param String $describes
     *
     * @return CategoryModel|false
     */
    public function add (string $categoryName, string $categorySign, string $featuredImage = '', string $keywords = '', string $describes = '')
    {
        $category                   = new CategoryModel();
        $category -> category_name  = $categoryName;
        $category -> category_sign  = $categorySign;
        $category -> featured_image = $featuredImage;
        $category -> keywords       = $keywords;
        $category -> describes      = $describes;
        if ($category -> save()) {
            return $category;
        }
        return false;
    }
    
    /**
     * 修改分类
     *
     * @param CategoryModel $category
     * @param String        $categoryName
     * @param String        $categorySign
     * @param String        $featuredImage
     * @param String        $keywords
     * @param String        $describes
     *
     * @return CategoryModel|false
     */
    public function edit (CategoryModel $category, string $categoryName, string $categorySign, string $featuredImage = '', string $keywords = '', string $describes = '')
    {
        $category -> category_name  = $categoryName;
        $category -> category_sign  = $categorySign;
        $category -> featured_image = $featuredImage;
        $category -> keywords       = $keywords;
        $category -> describes      = $describes;
        if ($category -> save()) {
            return $category;
        }
        return false;
    }
    
    /**
     * 获取分类
     *
     * @param Int $id
     *
     * @return array|false|Model|null
     */
    public function read (int $id)
    {
        try {
            $where = ['delete_time' => 0];
            return (new \app\model\CategoryModel) -> where($where) -> find($id);
        } catch (DbException $e) {
            $this -> handleException($e);
            return false;
        }
    }
    
    /**
     * @param CategoryModel|Int $category
     *
     * @return bool
     */
    public function remove ($category)
    {
        try {
            
            if (!($category instanceof CategoryModel)) {
                $category = (new \app\model\CategoryModel) -> find((int)$category);
            }
            
            if (empty($category)) {
                return false;
            }
            
            $category -> delete_time = time();
            if ($category -> save()) {
                return true;
            }
            
            return false;
        } catch (DbException $e) {
            $this -> handleException($e);
            return false;
        }
    }
    
    /**
     * 分类列表
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
            
            $categoryModel = CategoryModel ::where($where);
            
            if ($page !== false) {
                // 需要分页查询
                $categoryModel -> limit($this -> offset($page), $this -> pageRows);
            }
            
            if (!empty($order)) {
                $categoryModel -> order($order);
            }
            
            return $categoryModel -> select();
            
        } catch (DbException $e) {
            $this -> handleException($e);
            return [];
        }
    }
}