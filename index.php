<?php
//session_start();
//设置系统的输出字符为utf-8
header("Content-Type:text/html;charset=utf-8");
//设置时区（中国）
date_default_timezone_set("PRC");
// 加载配置文件
include('app/config.php');

// 版本号
define('VERSION', '0.99');
// 项目根目录
define('ROOT_DIR', realpath( dirname(__FILE__) ) );

// 解析URL
$url = str_replace(APP_PATH, "", $_SERVER['REQUEST_URI']);

// 转换成数组
$array_tmp_uri = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);

// 处理
if ( 'index.php' == $array_tmp_uri[0] ) array_shift($array_tmp_uri);

// 数据长度
$elements = count($array_tmp_uri);

if ( 0 < $elements ) {

    $array_uri['controller']	= $array_tmp_uri[0];
    $array_uri['method']		= $array_tmp_uri[1];

    if ( 0 < ( $elements-2 ) ) {
        array_shift($array_tmp_uri);
        array_shift($array_tmp_uri);

        foreach ($array_tmp_uri as $key=>$val){
            $array_uri['params'][$key] = $val;
        }

    }

} else {
    // 默认controller
    $array_uri['controller'] = DEFAULT_CONTROLLER;

}

// 加载核心文件
include('app/app.php');

// 加载函数库文件
include('app/functions.php');

// 初始化
$application = new app($array_uri);
$application->load_controller($array_uri['controller']);

// 自动加载
function __autoload($class_name) {

    require_once ('app/lib/core/'.$class_name . '.php');

}

// End index.php