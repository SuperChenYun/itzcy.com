<?php


namespace app\common\lib;


class ErrCode
{
    const SUCCESS = 0;
    const COMMON_ERROR = 100000; // 通用错误 默认错误码
    const ROUTE_NOT_FOUNT = 999999; // 未找到路由
    
}