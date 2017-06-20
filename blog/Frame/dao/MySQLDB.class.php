<?php

// MySQLDB类
class MySQLDB implements I_DAO {
	private $host;	// 主机地址
	private $port;	// 端口号
	private $user;	// 用户名
	private $pass;	// 密码
	private $charset;// 字符集
	private $dbname;	// 数据库名
	private static $instance;// 用于保存对象
	// 运行的时候需要的属性
	private $link;	// 保存连接资源
	/**
	 * 构造方法
	 * @param array $arr 关联数组
	 *
	 */
	private function __construct($arr) {
		// 初始化属性
		$this->host = isset($arr['host']) ? $arr['host'] : 'localhost';
		$this->port = isset($arr['port']) ? $arr['port'] : '3306';
		$this->user = isset($arr['user']) ? $arr['user'] : 'root';
		$this->pass = isset($arr['pass']) ? $arr['pass'] : '';
		$this->charset = isset($arr['charset']) ? $arr['charset'] : 'utf8';
		$this->dbname = isset($arr['dbname']) ? $arr['dbname'] : '';
		// 完成数据库连接三步曲
		// 连接数据库
		$this->my_connect();
		// 设置默认字符集
		$this->my_charset();
		// 选择默认的数据库
		$this->my_dbname();
	}
	/**
	 * 用于获得单例对象
	 * @param array $arr 传递给构造方法的数组参数
	 */
	public static function getInstance($arr) {
		if(!self::$instance instanceof self) {
			self::$instance = new self($arr);
		}
		return self::$instance;
	}
	/**
	 * 连接数据库
	 * 
	 */
	private function my_connect() {
		if($link = @ mysql_connect("$this->host:$this->port", $this->user, $this->pass)) {
			// 连接成功
			$this->link = $link;
		}else {
			// 连接失败
			echo "数据库连接失败！<br />";
			echo "错误代码：" , mysql_errno() , '<br />';
			echo "错误信息：" , mysql_error() , '<br />';
			die;
		}
	}
	/**
	 * 执行sql语句的方法,该方法主动报错
	 * @param string $sql 一条sql语句
	 * @return mixed bool|resource 如果执行成功,就返回执行的结果
	 */
	public function my_query($sql) {
		// 先执行sql语句
		$result = mysql_query($sql);
		// 再判断是否执行成功
		if(!$result) {
			// 执行失败
			echo "SQL语句执行失败！<br />";
			echo "错误代码：" , mysql_errno() , '<br />';
			echo "错误信息：" , mysql_error() , '<br />';
			return false;
		}else {
			// 执行成功
			return $result;
		}
	}
	/**
	 * 返回查询结果为多行多列的记录
	 * @param string $sql 需要执行的sql语句
	 * @param mixed false|array 失败就是false,成功就是二维数组
	 *
	 */
	public function fetchAll($sql) {
		// 执行sql语句
		if($result = $this->my_query($sql)) {
			// 执行成功,遍历结果集
			$rows = array();
			while($row = mysql_fetch_assoc($result)) {
				$rows[] = $row;
			}
			// 结果集资源使用完毕最好主动释放
			mysql_free_result($result);
			// 返回所有的数据(二维数组或空数组)
			return $rows;
		}else {
			return false;
		}
	}
	/**
	 * 返回查询结果为一行多列的记录
	 * @param string $sql 需要执行的sql语句
	 * @param mixed false|array 失败就是false,成功就是一维数组
	 *
	 */
	public function fetchRow($sql) {
		// 执行sql语句
		if($result = $this->my_query($sql)) {
			// 执行成功,提取结果集
			$row = mysql_fetch_assoc($result);
			// 结果集资源使用完毕最好主动释放
			mysql_free_result($result);
			// 返回所有的数据(一维数组或空数组)
			return $row;
		}else {
			return false;
		}
	}
	/**
	 * 返回查询结果为单行单列的记录
	 * @param string $sql 需要执行的sql语句
	 * @return mixed(false|scalar) 成功就是单一值,失败就是false
	 *
	 */
	public function fetchColumn($sql) {
		if($result = $this->my_query($sql)) {
			// 执行成功,提取结果集
			$row = mysql_fetch_row($result);
			// 结果集资源使用完毕最好主动释放
			mysql_free_result($result);
			// 返回这个单一值
			return isset($row[0]) ? $row[0] : false;
		}else {
			return false;
		}
	}
	/**
	 * 选择默认字符集
	 *
	 */
	private function my_charset() {
		$sql = "set names $this->charset";
		$this->my_query($sql);
	}
	/** 
	 * 选择默认的数据库
	 *
	 */ 
	private function my_dbname() {
		$sql = "use $this->dbname";
		$this->my_query($sql);
	}
	/**
	 * 析构方法
	 *
	 */ 
	public function __destruct() {
		@ mysql_close($this->link);
	}
	/**
	 * __sleep
	 *
	 */ 
	public function __sleep() {
		return array('host', 'port', 'user', 'pass', 'charset', 'dbname');
	}
	/**
	 * __wakeup
	 *
	 */ 
	public function __wakeup() {
		// 反序列化对象的时候完成该对象的初始化工作
		// 完成数据库连接三步曲
		// 连接数据库
		$this->my_connect();
		// 设置默认字符集
		$this->my_charset();
		// 选择默认的数据库
		$this->my_dbname();
	}
	/**
	 * __set()
	 * @param $name 不可访问的属性的名
	 * @param $value 不可访问的属性的值
	 *
	 */
	public function __set($name, $value) {
		$allow_set = array('host', 'port', 'user', 'pass', 'charset', 'dbname');
		if(in_array($name, $allow_set)) {
			 $this->$name = $value;
		}
	}
	/**
	 * __get()
	 * @param $name 不可访问的属性的名
	 *
	 */
	public function __get($name) {
		$allow_get = array('host', 'port', 'charset', 'dbname');
		if(in_array($name, $allow_get)) {
			return $this->$name;
		}else {
			return NULL;
		}
	}
	/**
	 * __unset()
	 * @param $name 不可访问的属性的名
	 *
	 */
	public function __unset($name) {
		// 什么都不做,代表不能删除任何属性
	}
	/**
	 * __isset()
	 * @param $name 不可访问的属性的名
	 *
	 */
	public function __isset($name) {
		$allow_isset = array('host', 'port', 'user', 'pass', 'charset', 'dbname');
		if(in_array($name, $allow_isset)) {
			return true;
		}else {
			return false;
		}
	}
	/**
	 * 私有化__clone()方法
	 *
	 */
	private function __clone() {
		
	}
}