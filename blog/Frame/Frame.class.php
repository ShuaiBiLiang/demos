<?php

/**
 * 项目初始化类,框架类
 */
class Frame {
	/**
	 * 项目入口方法
	 */
	public static function run() {
		// 定义基础目录常量
		static::initConst();
		// 初始化配置
		static::initConfig();
		// 确定分发参数
		static::initDispatchParam();
		// 定义与平台相关的目录常量
		static::initPlatformConst();
		// 注册自动加载方法
		static::initAutoload();
		// 请求分发
		static::initDispatch();
	}
	/**
	 * 定义基础目录常量
	 */
	private static function initConst() {
		// 根目录常量
		define('ROOT_DIR', str_replace('\\', '/', getcwd()) . '/');
		// 应用程序目录常量
		define('APP_DIR', ROOT_DIR . 'App/');
		// 框架目录常量
		define('FRAME_DIR', ROOT_DIR . 'Frame/');
		// 配置文件目录常量
		define('CONFIG_DIR', APP_DIR . 'Config/');
		// dao层目录常量
		define('DAO_DIR', FRAME_DIR . 'dao/');
		// 插件目录常量
		define('VENDOR_DIR', ROOT_DIR . 'Vendor/');
		// Smarty目录常量
		define('SMARTY_DIR', VENDOR_DIR . 'Smarty/');
		// Public目录常量
		define('PUBLIC_DIR', ROOT_DIR . 'Public/');
		// Uploads目录常量
		define('UPLOADS_DIR', ROOT_DIR . 'Uploads/');
	}
	/**
	 * 初始化配置
	 */
	private static function initConfig() {
		// 存储于超全局变量,保证在整个项目中都可以使用该配置数据
		$GLOBALS['conf'] = include CONFIG_DIR . 'conf.php';
	}
	/**
	 * 确定分发参数
	 */
	private static function initDispatchParam() {
		// 确定分发参数p平台,保存到一个常量中
		// $default_platform = 'Test';// 暂时用测试平台
		$default_platform = $GLOBALS['conf']['App']['default_platform'];
		define('PLATFORM', isset($_GET['p']) ? $_GET['p'] : $default_platform);
		// 确定分发参数c控制器,保存在一个常量中
		$default_controller = $GLOBALS['conf'][PLATFORM]['default_controller'];
		define('CONTROLLER', isset($_GET['c']) ? $_GET['c'] : $default_controller);
		// 确定分发参数a动作,保存在一个常量中
		$default_action = $GLOBALS['conf'][PLATFORM]['default_action'];
		define('ACTION', isset($_GET['a']) ? $_GET['a'] : $default_action);
	}
	/**
	 * 定义与平台相关的目录常量
	 */
	private static function initPlatformConst() {
		// 当前平台的控制器目录
		define('CURRENT_CON_DIR', APP_DIR . PLATFORM . '/Controller/');
		// 当前平台的模型目录
		define('CURRENT_MODEL_DIR', APP_DIR . PLATFORM . '/Model/');
		// 当前平台的视图目录
		define('CURRENT_VIEW_DIR', APP_DIR . PLATFORM . '/View/');
		// 以下的三个目录常量只能用相对路径而且与平台有关
		define('CSS_DIR', '/Public/' . PLATFORM . '/css');
		define('JS_DIR', '/Public/' . PLATFORM . '/js');
		define('IMAGES_DIR', '/Public/' . PLATFORM . '/images');
	}
	/**
	 * 实现类文件的加载
	 */
	public static function autoload($class_name) {
		// 先把已经确定好了的核心类放到一个数组里面
		$frame_class_list = array(
			// 键  	 =>  值
			// 类名  =>  类文件地址
			'Controller'=>FRAME_DIR . 'Controller.class.php',
			'Model'		=>FRAME_DIR . 'Model.class.php',
			'Factory'	=>FRAME_DIR . 'Factory.class.php',
			'MySQLDB'	=>DAO_DIR . 'MySQLDB.class.php',
			'PDODB'		=>DAO_DIR . 'PDODB.class.php',
			'I_DAO'		=>DAO_DIR . 'I_DAO.interface.php',
			'Smarty'	=>SMARTY_DIR . 'Smarty.class.php',
			'Captcha'	=>VENDOR_DIR . 'Captcha.class.php',
			'Upload'	=>FRAME_DIR . 'Upload.class.php',
			'Page'		=>FRAME_DIR . 'Page.class.php',
		);
		// 先判断需要的类是否为核心类
		if(isset($frame_class_list[$class_name])) {
			// 说明是核心类
			include $frame_class_list[$class_name];
		}
		// 再判断是否为控制器类,截取后10个字符进行匹配
		elseif(substr($class_name, -10) == 'Controller') {
			// 说明是控制器类,应该在当前平台下Controller目录下进行加载
			include CURRENT_CON_DIR . $class_name . '.class.php';
		}
		// 最后判断是否为模型类,截取后5个字符进行匹配
		elseif(substr($class_name, -5) == 'Model') {
			// 说明是模型类,应该在当前平台下的Model目录下进行加载
			include CURRENT_MODEL_DIR . $class_name . '.class.php';
		}
	}
	/**
	 * 注册自动加载方法
	 */
	private static function initAutoload() {
		spl_autoload_register(array(__CLASS__,'autoload'));
	}
	/**
	 * 请求分发
	 */
	private static function initDispatch() {
		// 实例化控制器类
		$controller_name = CONTROLLER . 'Controller';// 确定控制器的名称
		$controller = new $controller_name; // 可变类
		// 调用方法
		$action_name = ACTION . 'Action'; 	// 确定当前方法的名称
		$controller->$action_name();	// 可变方法
	}
}