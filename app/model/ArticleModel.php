<?php
declare (strict_types=1);

namespace app\model;

use app\BaseModel;
use think\model\relation\HasMany;
use think\model\relation\HasOne;

/**
 * @mixin BaseModel
 */
class ArticleModel extends BaseModel
{
    const TARGET_TYPE = 1;
    
    protected $name = 'article';
    
    /**
     * @return HasOne
     */
    public function category()
    {
        return $this -> hasOne(CategoryModel::class, 'id', 'category_id');
    }
    
    /**
     * @return HasMany
     */
    public function tagList()
    {
        return $this->hasMany(TagRelationModel::class, 'target_id', 'id') -> where(['relation_type' => self::TARGET_TYPE]);
    }
}
