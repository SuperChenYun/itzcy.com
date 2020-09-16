<?php

// 容器Provider定义文件
return [
    'think\Request'          => \app\web\Request::class,
    'think\exception\Handle' => \app\web\ExceptionHandle::class,
];
