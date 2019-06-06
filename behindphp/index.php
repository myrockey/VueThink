<?php

// 检测程序安装
if(!is_file(__DIR__ . '/install/install.lock')){
	header('Location: ./install/index.php');
	exit;
}

/*防止跨域*/
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
header('Access-Control-Allow-Origin: '.$origin);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");

// 定义应用目录
define('APP_PATH', __DIR__ . '/app/');
define('BIND_MODULE','api');

// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';