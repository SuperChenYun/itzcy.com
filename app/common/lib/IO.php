<?php

namespace app\common\lib;

use think\facade\Request;
use think\response\Json;

/**
 * @property array requestRaw
 * @property array request
 */
abstract class IO
{
    
    protected static $requestRaw;
    
    protected static $request = [];
    
    
    /**
     * @param null $key
     *
     * @return array|mixed|null
     */
    public static function input ($key = null)
    {
        if (empty(self ::$requestRaw)) {
            self ::$requestRaw = file_get_contents('php://input');
            self ::$request    = json_decode(self ::$requestRaw, true);
        }
        if (null === $key) {
            return self ::$request;
        }
        return self ::$request[$key] ?? Request ::param($key);
        
    }
    
    /**
     * 正确返回
     *
     * @param        $data
     * @param int    $count
     * @param int    $headerCode
     * @param string $msg
     *
     * @return Json
     * @author Itzcy <itzcy@itzcy.com>
     */
    public static function success ($data, $count = 0, $headerCode = 200, $msg = 'OK')
    {
        return json([
            'code'  => ErrCode::SUCCESS,
            'msg'   => $msg,
            'count' => $count,
            'data'  => $data
        ], $headerCode);
    }
    
    /**
     * 错误时返回
     *
     * @param       $msg
     * @param       $code
     * @param int   $headerCode
     * @param array $data
     *
     * @return Json
     * @author  Itzcy <itzcy@itzcy.com>
     */
    public static function fail ($msg, $code = ErrCode::COMMON_ERROR, $headerCode = 200, $data = [])
    {
        return json([
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        ], $headerCode);
    }
}