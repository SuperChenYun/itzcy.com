<?php


namespace app\service;


use app\BaseService;
use app\model\LinkModel;
use think\Collection;
use think\db\exception\DbException;
use think\facade\Log;
use think\Model;

/**
 * 链接管理类
 * Class LinkService
 * @package app\service
 */
class LinkService extends BaseService
{
    const LINK_TYPE_RECIPROCITY = 1;
    const LINK_TYPE_OVERLAPPING = 2;
    
    /**
     * 添加链接
     *
     * @param string $siteName
     * @param string $siteLink
     * @param int    $linkType
     * @param array  $extra
     *                     String $extra [in_site_link]
     *                     String $extra [audit_pass]
     *                     String $extra [contact_name]
     *                     String $extra [contact_email]
     *                     String $extra [contact_qq]
     *                     String $extra [contact_wechat]
     *                     String $extra [remarks]
     *                     String $extra [order_id]
     *
     * @return LinkModel|false
     */
    public function add (string $siteName, string $siteLink, int $linkType, array $extra = [])
    {
        $linkModel = new LinkModel();
        
        $linkModel -> data($extra);
        
        $linkModel -> site_name = $siteName;
        $linkModel -> site_link = $siteLink;
        $linkModel -> link_type = $linkType;
        
        if ($linkModel -> save()) {
            return $linkModel;
        }
        return false;
    }
    
    /**
     * 修改链接
     *
     * @param LinkModel $linkModel
     * @param string    $siteName
     * @param string    $siteLink
     * @param int       $linkType
     * @param array     $extra
     *                     String $extra [in_site_link]
     *                     String $extra [audit_pass]
     *                     String $extra [contact_name]
     *                     String $extra [contact_email]
     *                     String $extra [contact_qq]
     *                     String $extra [contact_wechat]
     *                     String $extra [remarks]
     *                     String $extra [order_id]
     *
     * @return LinkModel|false
     */
    public function edit (LinkModel $linkModel, string $siteName, string $siteLink, int $linkType, array $extra = [])
    {
        $linkModel -> data($extra);
        
        $linkModel -> site_name = $siteName;
        $linkModel -> site_link = $siteLink;
        $linkModel -> link_type = $linkType;
        
        if ($linkModel -> save()) {
            return $linkModel;
        }
        return false;
    }
    
    /**
     * 读取链接
     *
     * @param Int $id
     *
     * @return array|false|Model|null
     */
    public function read (int $id)
    {
        try {
            $where = ['delete_time' => 0];
            return (new \app\model\LinkModel()) -> where($where) -> find($id);
        } catch (DbException $e) {
            Log ::error($e -> getTraceAsString());
            return false;
        }
        
    }
    
    /**
     * 移除链接
     *
     * @param $link
     *
     * @return bool
     */
    public function remove ($link)
    {
        try {
            
            if (!($link instanceof LinkModel)) {
                $link = (new \app\model\LinkModel()) -> find((int)$link);
            }
            
            if (empty($link)) {
                return false;
            }
            
            $link -> delete_time = time();
            if ($link -> save()) {
                return true;
            }
            
            return false;
        } catch (DbException $e) {
            Log ::error($e -> getTraceAsString());
            return false;
        }
        
    }
    
    /**
     * 批量获取
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
            
            $linkModel = LinkModel ::where($where);
            
            if ($page !== false) {
                // 需要分页查询
                $linkModel -> limit($this -> offset($page), $this -> pageRows);
            }
            
            if (!empty($order)) {
                $linkModel -> order($order);
            }
            
            return $linkModel -> select();
            
        } catch (DbException $e) {
            Log ::error($e -> getTraceAsString());
            return [];
        }
        
    }
}