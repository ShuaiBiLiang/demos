<?php

/**
 * 前台平台控制器
 */
class PlatformController extends Controller {
	/**
	 * 构造方法
	 */
	public function __construct() {
		// 先显示的调用父类的构造方法
		parent::__construct();
		// 调用模型
		$category = Factory::M('CategoryModel');
		// 获取所有的一级分类
		$firstCate = $category->getFirstCate();
		// 分配变量
		$this->assign('firstCate', $firstCate);
		// 开启session
		session_start();
	}
}