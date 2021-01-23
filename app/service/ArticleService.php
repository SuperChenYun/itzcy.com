<?php


namespace app\service;


use app\BaseService;
use app\model\ArticleModel;
use think\Db;

/**
 * 文章管理类
 *
 * Class ArticleService
 * @package app\service
 */
class ArticleService extends BaseService
{
    public function add()
    {}
    public function edit()
    {}
    public function read()
    {}
    public function remove()
    {}
    public function lists()
    {}
    
    /**
     * 快捷增加浏览量
     *
     * @param ArticleModel $articleModel
     * @param int          $stepping
     *
     * @return ArticleModel|false
     */
    public function views(ArticleModel $articleModel, $stepping = 1)
    {
        $articleModel -> views = Db::raw('views + ' . $stepping);
        if ($articleModel -> save()) {
            return $articleModel;
        }
        return false;
        
    }
}