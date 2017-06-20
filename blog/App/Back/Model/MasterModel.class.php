<?php

/**
 * 后台bg_master表操作模型
 */
class MasterModel extends Model {
	/**
	 * 获取站长信息
	 */
	public function getMasterInfo() {
		$sql = "select * from bg_master limit 1";
		return $this->dao->fetchRow($sql);
	}
	/**
	 * 更新站长信息
	 */
	public function updateMasterInfo($masterInfo) {
		extract($masterInfo);
		$sql = "update bg_master set nickname='$nickname', job='$job',home='$home',tel='$tel',email='$email'";
		return $this->dao->my_query($sql);
	}
}