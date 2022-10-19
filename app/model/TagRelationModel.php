<?php
declare (strict_types=1);

namespace app\model;

use app\BaseModel;
use think\model\relation\HasOne;

/**
 * @mixin BaseModel
 */
class TagRelationModel extends BaseModel
{
    
    protected $name = 'tag_relation';
    
    /**
     * 关联模型
     * @return HasOne
     */
    public function tag (): HasOne
    {
        return $this -> hasOne(TagModel::class, 'id', 'tag_id') -> bind(['tag_name','tag_sign']);
    }
    
}
