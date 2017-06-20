<?php
return array(
	//'配置项'=>'配置值'
	 /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'tpshop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'ceshiwuliao',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'ts_',    // 数据库表前缀

    //设置默认的模块
    'DEFAULT_MODULE'		=> 'Admin', //默认模块

    //设置变量
    'TMPL_PARSE_STRING' => array(
        '__Admin__' => __ROOT__ . '/Public/Admin',
        '__Home__' => __ROOT__ . '/Public/Home',
        '__ED__' => __ROOT__ . '/Public/editor',
        '__UPLOAD__' => __ROOT__ . '/Public/Uploads',

    ),
);