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
    public function category (): HasOne
    {
        return $this -> hasOne(CategoryModel::class, 'id', 'category_id');
    }
    
    /**
     * @return HasMany
     */
    public function tagList (): HasMany
    {
        return $this -> hasMany(TagRelationModel::class, 'target_id', 'id') -> where(['relation_type' => self::TARGET_TYPE]);
    }
    
    /**
     * @return string
     */
    public function getDescribe (): string
    {
        $content = $this -> content;
        $content = str_replace(["&nbsp;", "&amp;nbsp;", "\t", "\r\n", "\r", "\n"], ['', '', '', '', '', ''], $content);
        $content = strip_tags($content);
        
        return mb_substr($content, 0, 120) . '...';
    }
}
