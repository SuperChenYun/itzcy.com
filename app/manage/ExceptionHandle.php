<?php
namespace app\manage;

use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends \app\ExceptionHandle
{
    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        
        // 其他错误交给系统处理
        return parent::render($request, $e);
    }
}
