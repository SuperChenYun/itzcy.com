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

Route ::miss('Error/e404');

Route ::get('/', 'Index/index');

// About
Route ::rule('about', 'Page/about');

// Resume
Route ::rule('resume', 'Page/resume');

// 文章详情
Route ::rule('article/:id', 'Article/read');

// 文章列表
Route ::rule('article', 'Article/lists');

// 分类文章列表
Route ::rule('category/:sign', 'Article/byCategory');

// Tag文章列表
Route ::rule('tag/:sign', 'Article/byTag');

// 页面详情
Route ::rule('page/:id', 'Page/read');

// 归档页面
Route ::rule('archives', 'Archives/index');

// Rss订阅
Route ::rule('rss', 'Xml/rss');
Route ::rule('rss.xml', 'Xml/rss');

// SiteMap
Route ::rule('sitemap', 'Xml/sitemap');
Route ::rule('sitemap.xml', 'Xml/sitemap');

