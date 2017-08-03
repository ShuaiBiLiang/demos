<?php

/*
	入口文件
	1.定义常量
	2.加载函数库
	3.启动框架
 */

define('IMOOC',realpath('/imooc/'));
define('CORE',IMOOC.'/core');
define('APP',IMOOC.'/app');
define('MODULE','app');
define('DEBUG',true);

include "vendor/autoload.php";

if( DEBUG )
{
    $whoops = new \Whoops\Run;
    $errorTitle = '框架出错了';

//    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
//    $whoops->register();

    //自定义错误标题
    $option = new \Whoops\Handler\PrettyPageHandler();
    $option->setPageTitle($errorTitle);
    $whoops->pushHandler($option);
    $whoops->register();

    ini_set('display_error','On');
}else{
    ini_set('display_error','Off');
}

include CORE.'/common/function.php'; //加载函数库
include CORE.'/imooc.php'; //加载框架核心文件

spl_autoload_register('\core\imooc::load'); //如果实例化不存在的类就会触发

\core\imooc::run();

