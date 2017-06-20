<?php

/**
 * 站长管理控制器
 */
class MasterController extends PlatformController {
	/**
	 * 显示站长信息动作
	 */
	public function indexAction() {
		// 调用模型
		$master = Factory::M('MasterModel');
		$masterInfo = $master->getMasterInfo();
		// 分配变量
		$this->assign('masterInfo', $masterInfo);
		// 输出视图
		$this->display('index.html');
	}
	/**
	 * 修改站长信息动作
	 */
	public function editAction() {
		// 接收数据
		$masterInfo = array();
		$masterInfo['nickname'] = $this->escapeData($_POST['nickname']);
		$masterInfo['job'] = $this->escapeData($_POST['job']);
		$masterInfo['home'] = $this->escapeData($_POST['home']);
		$masterInfo['email'] = $this->escapeData($_POST['email']);
		$masterInfo['tel'] = $this->escapeData($_POST['tel']);
		// 验证数据
		if(empty($masterInfo['nickname']) || empty($masterInfo['job']) || empty($masterInfo['home']) ||empty($masterInfo['email']) || empty($masterInfo['tel'])) {
			$this->jump('index.php?p=Back&c=Master&a=index',':( 请填写完整的信息！');
		}
		// 调用模型
		$master = Factory::M('MasterModel');
		$result = $master->updateMasterInfo($masterInfo);
		if($result) {
			$this->jump('index.php?p=Back&c=Master&a=index',':) 更新成功！');
		}else {
			$this->jump('index.php?p=Back&c=Master&a=index',':( 发生未知错误,更新失败！');
		}
	}
}