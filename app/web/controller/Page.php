<?php


namespace app\web\controller;


use app\web\BaseController;
use think\facade\View;

class Page extends BaseController
{
    
    public function read(Int $id)
    {
    
    }
    
    public function about(): string
    {
        return View::fetch('page/about');
    }
    
    public function resume(): string
    {
        return View::fetch('page/resume');
    }
    
}