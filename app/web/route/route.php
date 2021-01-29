<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::miss(function() {
    return view('error/404');
});

Route::get('/', 'index/index');

// 文章详情
Route::rule('article/:id', 'Article/read');

// 文章列表
Route::rule('article', 'Article/lists');

// 分类文章列表
Route::rule('category/:sign', 'Article/byCategory');

// Tag文章列表
Route::rule('tag/:sign','Article/byTag');

// 页面详情
Route::rule('page/:id', 'Page/read');

