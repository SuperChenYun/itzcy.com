<?php
namespace app\api;

use app\common\lib\ErrCode;
use app\common\lib\IO;
use think\exception\RouteNotFoundException;
use think\Response;
use Throwable;

/**
 * API 应用异常处理类
 */
class ExceptionHandle extends \app\ExceptionHandle
{
    /**
     * Render an exception into an HTTP response.
     * @access public
     *
     * @param \think\Request $request
     * @param Throwable      $e
     *
     * @return Response
     */
    public function render(\think\Request $request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        
        // 其他错误交给系统处理
        if ($e instanceof RouteNotFoundException && !$this->app->env->get('app_debug')) {
            return IO::fail( $e->getMessage(), ErrCode::ROUTE_NOT_FOUNT);
        }
    }
}
