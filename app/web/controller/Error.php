<?php


namespace app\web\controller;


use app\web\BaseController;
use think\facade\View;
use think\Response;

class Error extends BaseController
{
    public function e404()
    {
        return Response::create(View::fetch('error/404'), 'html', '404');
    }
    
    public function e500()
    {
        return Response::create(View::fetch('error/500'), 'html', '500');
    }
    
}