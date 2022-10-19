<?php
use app\ExceptionHandle;

// 容器Provider定义文件
return [
    'think\Request'          => \app\manage\Request::class,
    'think\exception\Handle' => \app\manage\ExceptionHandle::class,
];
