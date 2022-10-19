<?php

// 容器Provider定义文件
return [
    'think\Request'          => \app\api\Request::class,
    'think\exception\Handle' => \app\api\ExceptionHandle::class,
];
