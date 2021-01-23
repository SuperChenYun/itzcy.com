<?php


namespace app;


use Exception;
use think\facade\Log;

/**
 * 业务服务的基类
 * Class BaseService
 * @package app\common
 */
abstract class BaseService
{
    protected $request;
    
    protected $pageRows = 15;
    
    public function __construct (Request $request)
    {
        $this -> request  = $request;
        $this -> pageRows = $request -> param('limit', $this -> pageRows);
    }
    
    /**
     * 获取分页偏移量
     *
     * @param int $page
     *
     * @return int
     */
    public function offset (int $page)
    {
        return ($page - 1) * $this -> pageRows;
        
    }
    
    /**
     * @param Exception $e
     */
    public function handleException ($e)
    {
        Log ::error($e -> getMessage() . "\n" . $e -> getTraceAsString());
    }
}