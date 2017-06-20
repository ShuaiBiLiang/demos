<?php

/**
 * dao层操作接口
 */
interface I_DAO {
	public static function getInstance($config);//获取单例对象
	public function my_query($sql); // 执行增删改
	public function fetchAll($sql); // 获得多行多列数据
	public function fetchRow($sql); // 获得单行多列数据
	public function fetchColumn($sql); // 获得单行单列数据
}