<?php

/**
 * 后台的平台控制器,用于存放后台的公共代码
 */
class PlatformController extends Controller {
	/**
	 * 判断用户是否登录防止用户翻墙
	 */
	protected function checkLogin() {
		// 排除不需要登录验证的动作
		// 先列出不需要登录的动作列表
		$no_need = array(
			// '控制器名'=>'该控制器下不需要验证的动作列表'
			'Admin'	=>array('login', 'check', 'captcha'),
		);
		if(isset($no_need[CONTROLLER]) && in_array(ACTION,$no_need[CONTROLLER])) {
			// 说明不用验证,是特例
			return ;
		}
		// 防止用户翻墙
		@session_start();
		if(!isset($_SESSION['adminInfo'])) {
			// 说明用户没有登录
			$this->jump('index.php?p=Back&c=Admin&a=login', ':( 请您先登录!');
		}
	}
	/**
	 * 构造方法
	 */
	public function __construct() {
		// 先显式的调用父类的构造方法
		parent::__construct();
		// 防止用户翻墙
		$this->checkLogin();
	}
}