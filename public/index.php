<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]




define('APP_DEBUG', 10);

// isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');


define('APP_HOST', 'http://'.$_SERVER['HTTP_HOST']);  # http://127.0.0.1:8080

define('APP_URL', substr($_SERVER['SCRIPT_NAME'], 0, -10)); # /home/wwwroot/www.test.com

define('APP_DIR', __DIR__ ); // windows: E:\home\wwwroot\api.seqier.com  linux:/home/wwwroot/api.seqier.com  //同系统ROOT_PATH

define('APP_CDN_HOST', 'http://res.seqier.com'); 


 

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
