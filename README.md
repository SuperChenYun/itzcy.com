# Itzcy.Com

===============
>  该项目基于`ThinkPHP`,为 [Itzcy.Com](https://itzcy.com) 的代码开源仓库  

## 运行环境

- 运行环境要求PHP7.1+。

## 目录结构

```
WebRoot
├─app                           应用目录
│   ├─api                       单独API
│   │   ├─controller            控制器层
│   │   ├─route                 当前目录路由定义
│   │   ├─BaseController.php    控制器层基类
│   │   ├─ExceptionHandle.php   错误处理
│   │   ├─provider.php          provider定义
│   │   └─Request.php           请求类    
│   │
│   ├─common                    公共目录
│   │   ├─model                 模型层
│   │   └─service               服务层
│   │
│   ├─console                   控制台脚本
│   │   └─controller            控制器层
│   │
│   ├─manage                    管理后台
│   │   └─controller            控制器层
│   │
│   ├─web                       WEB界面
│   │   └─controller            控制器层
│   │
│   ├─common.php                公共函数文件
│   └─event.php                 事件定义文件
│
├─config                        配置目录
│   ├─app.php                   应用配置
│   ├─cache.php                 缓存配置
│   ├─console.php               控制台配置
│   ├─cookie.php                Cookie配置
│   ├─database.php              数据库配置
│   ├─filesystem.php            文件磁盘配置
│   ├─lang.php                  多语言配置
│   ├─log.php                   日志配置
│   ├─middleware.php            中间件配置
│   ├─route.php                 URL和路由配置
│   ├─session.php               Session配置
│   ├─trace.php                 Trace配置
│   └─view.php                  视图配置
│
├─extend                        扩展目录
├─public                        WEB目录（对外访问目录）
│  ├─index.php                  入口文件
│  ├─router.php                 快速测试文件
│  └─static                     静态资源路径
│
├─route                         路由配置
├─tests                         单元测试脚本
├─vendor                        扩展目录
├─view                          视图目录
├─.example.env                  环境变量示例文件
├─composer.json                 composer 定义文件
├─LICENSE.txt                   授权说明文件
├─README.md                     README 文件
└─think                         命令行入口文件
```

## 安装步骤

1. `composer install`
2. `cp .example.env .env`
3. modify .env
4. `php think migrate run`

## ThinkPHP 官方文档

[完全开发手册](https://www.kancloud.cn/manual/thinkphp6_0/content)
