<?php


namespace app;


use think\facade\Config;
use think\Model;

abstract class BaseModel extends Model
{
    
    
    private $colorList = [
        '#FE4703',
        '#0391FE',
        '#44B138',
        '#D911FF',
        '#63D7F5',
    ];
    
    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->colorList[rand(0,count($this->colorList)-1)];
    }
    
    /**
     * 转换Html
     *
     * @param string $content
     *
     * @return string
     */
    public function coverToHtmlContent(string $content):string
    {
        $content = str_replace('src="/storage', 'src="'.Config::get('app.cdn_host').'/storage', $content);
        return $content;
    }
    
}
