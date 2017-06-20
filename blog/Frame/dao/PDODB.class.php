<?php

/**
 * 封装PDODB类
 */

class PDODB implements I_DAO {
	// 定义相关属性
	private $host;
	private $port;
	private $user;
	private $pass;
	private $charset;
	private $dbname;
	private $dsn; // 数据源名称
	private $pdo; // 存放pdo对象
	private static $instance; // 用于保存单例对象
	/**
	 * 构造方法
	 * @param array $arr 关联数组
	 *
	 */
	private function __construct($arr) {
		// 初始化属性
		$this->initParams($arr);
		// 初始化dsn
		$this->initDSN();
		// 实例化pdo对象
		$this->initPDO();
		// 初始化PDO属性
		$this->initAttribute();
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
	 * 初始化属性
	 */
	private function initParams($arr) {
		// 初始化属性
		$this->host = isset($arr['host']) ? $arr['host'] : 'localhost';
		$this->port = isset($arr['port']) ? $arr['port'] : '3306';
		$this->user = isset($arr['user']) ? $arr['user'] : 'root';
		$this->pass = isset($arr['pass']) ? $arr['pass'] : '';
		$this->charset = isset($arr['charset']) ? $arr['charset'] : 'utf8';
		$this->dbname = isset($arr['dbname']) ? $arr['dbname'] : '';
	}
	/**
	 * 初始化dsn
	 */
	private function initDSN() {
		$this->dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=$this->charset";
	}
	/**
	 * 初始化pdo,得到一个pdo对象
	 */
	private function initPDO() {
		// 在实例化一个pdo对象的时候会自动走异常模式
		try{
			$this->pdo = new PDO($this->dsn,$this->user,$this->pass);
		}catch(PDOException $e) {
			echo '数据库连接失败！<br />';
			echo '错误的编号为：',$e->getCode(),'<br />';
			echo '错误的信息为：',$e->getMessage(),'<br />';
			echo '错误的文件为：',$e->getFile(),'<br />';
			echo '错误的行号为：',$e->getLine(),'<br />';
			die;
		}
	}
	/**
	 * 初始化PDO对象属性,走异常模式
	 */
	private function initAttribute() {
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	/**
	 * 输出异常信息
	 */
	private function my_error($e) {
		echo 'SQL语句执行失败！<br />';
		echo '错误的编号为：',$e->getCode(),'<br />';
		echo '错误的信息为：',$e->getMessage(),'<br />';
		echo '错误的文件为：',$e->getFile(),'<br />';
		echo '错误的行号为：',$e->getLine(),'<br />';
		die;
	}
	/**
	 * my_query方法,实现增删改
	 */
	public function my_query($sql) {
		try{
			$result = $this->pdo->exec($sql);
		}catch(PDOException $e) {
			// 调用输出异常信息的方法
			$this->my_error($e);
		}
		return $result;
	}
	/**
	 * fetchAll
	 */
	public function fetchAll($sql) {
		try{
			$stmt = $this->pdo->query($sql);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			// 关闭光标,释放结果集资源
			$stmt->closeCursor();
		}catch(PDOException $e) {
			// 调用输出异常信息的方法
			$this->my_error($e);
		}
		return $result;
	}
	/**
	 * fetchRow
	 */
	public function fetchRow($sql) {
		try{
			$stmt = $this->pdo->query($sql);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			// 关闭光标,释放结果集资源
			$stmt->closeCursor();
		}catch(PDOException $e) {
			// 调用输出异常信息的方法
			$this->my_error($e);
		}
		return $result;
	}
	/**
	 * fetchColumn
	 */
	public function fetchColumn($sql,$i=NULL) {
		try{
			$stmt = $this->pdo->query($sql);
			if(is_null($i)){
				$result = $stmt->fetchColumn();
			}else{
				$result = $stmt->fetchColumn($i);
			}
			// 关闭光标,释放结果集资源
			$stmt->closeCursor();
		}catch(PDOException $e) {
			// 调用输出异常信息的方法
			$this->my_error($e);
		}
		return $result;
	}
	/**
	 * 私有化__clone
	 */
	private function __clone() {
		
	}
}