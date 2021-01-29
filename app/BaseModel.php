<?php


namespace app;


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
    
}
