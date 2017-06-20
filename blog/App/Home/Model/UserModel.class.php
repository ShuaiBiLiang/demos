<?php

/**
 * 前台bg_user表操作模型
 */
class UserModel extends Model {
	/**
	 * 判断用户名是否已经存在
	 */
	public function if_name_exists($user_name) {
		$sql = "select * from bg_user where user_name='$user_name'";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 用户注册信息入库
	 */
	public function insertUser($userInfo) {
		extract($userInfo);
		$user_time = time();
		$sql = "insert into bg_user values(null,'$user_name','$user_pass','$user_image',$user_time)";
		return $this->dao->my_query($sql);
	}
	/**
	 * 判断用户名和密码是否正确
	 */
	public function check($name,$pass) {
		$sql = "select * from bg_user where user_name='$name' and user_pass='$pass'";
		return $this->dao->fetchRow($sql);
	}
}