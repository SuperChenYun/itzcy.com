<?php
use app\ExceptionHandle;

// 容器Provider定义文件
return [
    'think\Request'          => \app\console\Request::class,
    'think\exception\Handle' => ExceptionHandle::class,
];
