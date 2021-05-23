<?php
declare (strict_types = 1);

namespace app\model;

use app\BaseModel;

/**
 * @mixin BaseModel
 */
class PageModel extends BaseModel
{
    protected $name = 'page';
    
    /**
     * 转换成可以正常显示的HTML
     * @return mixed|string|string[]
     */
    public function coverHtmlContent ()
    {
        return $this->coverToHtmlContent($this->content);
    }
}
