<?php

/**
 * 基础模型类
 */
class Model {
	protected $dao;//用户保存数据库操作对象
	/**
	 * 初始化数据库操作对象
	 */
	protected function initDAO() {
		// 加载数据库工具类
		// 初始化MySQLDB
		$config = $GLOBALS['conf']['db'];
		// 根据配置,选择dao类
		switch($GLOBALS['conf']['App']['dao']) {
			case 'mysql': $dao_class = 'MySQLDB';break;
			case 'pdo': $dao_class = 'PDODB';
		}
		$this->dao = $dao_class::getInstance($config);
	}
	/**
	 * 构造方法
	 */
	public function __construct() {
		// 调用initDAO
		$this->initDAO();
	}
}