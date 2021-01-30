<?php


namespace app\web\controller;


use app\web\BaseController;
use think\facade\View;

class Error extends BaseController
{
    public function e404()
    {
        return View::fetch('error/404');
    }
    
    public function e500()
    {
        return View::fetch('error/500');
    }
    
}