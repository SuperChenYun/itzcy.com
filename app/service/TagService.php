<?php

namespace app\service;

use app\BaseModel;
use app\BaseService;
use app\model\TagModel;
use app\model\TagRelationModel;
use think\Collection;
use think\db\exception\DbException;
use think\facade\Log;

/**
 * 标签管理类
 *     包含标签的管理和标签对应目标的管理
 * Class TagService
 * @package app\service
 */
class TagService extends BaseService
{
    /**
     * 添加 TAG
     *
     * @param string $tagName
     * @param string $tagSign
     * @param string $describes
     * @param string $keywords
     *
     * @return TagModel|false
     */
    public function tagAdd (string $tagName, string $tagSign, string $describes = '', string $keywords = '')
    {
        $tagModel = new TagModel();
        
        $tagModel -> tag_name  = $tagName;
        $tagModel -> tag_sign  = $tagSign;
        $tagModel -> describes = $describes;
        $tagModel -> keywords  = $keywords;
        
        if ($tagModel -> save()) {
            return $tagModel;
        }
        
        return false;
    }
    
    /**
     * 修改 TAG
     *
     * @param TagModel $tagModel
     * @param string   $tagName
     * @param string   $tagSign
     * @param string   $describes
     * @param string   $keywords
     *
     * @return TagModel|false
     */
    public function tagEdit (TagModel $tagModel, string $tagName, string $tagSign, string $describes = '', string $keywords = '')
    {
        $tagModel -> tag_name  = $tagName;
        $tagModel -> tag_sign  = $tagSign;
        $tagModel -> describes = $describes;
        $tagModel -> keywords  = $keywords;
        
        if ($tagModel -> save()) {
            return $tagModel;
        }
        
        return false;
    }
    
    /**
     * 读取 TAG
     *
     * @param Int $id
     *
     * @return TagModel|array|false
     */
    public function tagRead (int $id)
    {
        try {
            $tagModel = (new \app\model\TagModel) -> find($id);
            if ($tagModel) {
                return $tagModel;
            }
            return false;
        } catch (DbException $e) {
            Log ::error($e -> getTraceAsString());
            return false;
        }
    }
    
    /**
     * 删除 TAG
     *
     * @param Int|TagModel $tagModel
     *
     * @return bool
     */
    public function tagRemove ($tagModel)
    {
        
        try {
            if ($tagModel instanceof TagModel) {
                if ($tagModel -> delete()) {
                    return true;
                }
            } else {
                $tagModel = (new \app\model\TagModel) -> find((int)$tagModel);
                if ($tagModel -> delete()) {
                    return true;
                }
            }
            return false;
        } catch (DbException $e) {
            Log ::error($e -> getTraceAsString());
            return false;
        }
    }
    
    /**
     * 获取 TAG 列表
     *
     * @param array     $where
     * @param false|Int $page
     *
     * @return Collection|array
     */
    public function tagList ($where = [], $page = false)
    {
        try {
            
            $tagModel = TagModel ::where($where);
            
            if ($page !== false) {
                // 需要分页查询
                $tagModel -> limit($this -> offset($page), $this -> pageRows);
            }
            
            return $tagModel -> select();
            
        } catch (DbException $e) {
            Log ::error($e -> getTraceAsString());
            return [];
        }
    }
    
    /**
     * 给Target添加多个标签
     *
     * @param BaseModel  $targetModel
     * @param Int        $type
     * @param TagModel[] $tagModelList
     *
     * @return integer|boolean|Collection|array
     */
    public function relationAdd (BaseModel $targetModel, int $type, array $tagModelList)
    {
        // 获取目标的id
        $id = $targetModel -> getData($targetModel -> getPk());
        // 新增数据
        $insertData = [];
        foreach ($tagModelList as $tagModel) {
            $insertData[] = [
                'tag_id'        => is_object($tagModel) ? $tagModel -> id : $tagModel['id'],
                'relation_type' => $type,
                'target_id'     => $id,
            ];
        }
        return (new \app\model\TagRelationModel) -> insertAll($insertData);
    }
    
    /**
     * 给Target修改多个标签
     *
     * @param BaseModel  $targetModel
     * @param Int        $type
     * @param TagModel[] $tagModelList
     *
     * @return integer|boolean|Collection|array
     */
    public function relationEdit (BaseModel $targetModel, int $type, array $tagModelList)
    {
        // 删除旧数据
        $del = $this -> relationRemove($targetModel, $type);
        if (false === $del) {
            return false;
        }
        
        // 新增数据
        return $this -> relationAdd($targetModel, $type, $tagModelList);
        
    }
    
    /**
     * 读取Target的标签ID
     *
     * @param BaseModel $targetModel
     * @param Int       $type
     *
     * @return Collection|array
     */
    public function relationRead (BaseModel $targetModel, int $type)
    {
        // 获取目标的id
        $id = $targetModel -> getData($targetModel -> getPk());
        
        try {
            return TagRelationModel ::where(['target_id' => $id, 'relation_type' => $type]) -> with(['tag']) -> select();
        } catch (DbException $e) {
            Log ::error($e -> getTraceAsString());
            return [];
        }
    }
    
    /**
     * 移除Target的标签
     *
     * @param BaseModel $targetModel
     * @param Int       $type
     *
     * @return boolean
     */
    public function relationRemove (BaseModel $targetModel, int $type): bool
    {
        // 获取目标的id
        $id = $targetModel -> getData($targetModel -> getPk());
        
        return TagRelationModel ::where(['target_id' => $id, 'relation_type' => $type]) -> delete();
        
    }
    
}