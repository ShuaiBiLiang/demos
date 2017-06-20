<?php

/**
 * 前台单页面管理控制器
 */
class SinglePageController extends PlatformController {
	/**
	 * 单页面显示动作
	 */
	public function indexAction() {
		// 接收单页面的id号
		$page_id = $_GET['page_id'];
		// 调用模型
		$singlePage = Factory::M('SinglePageModel');
		$pageInfo = $singlePage->getSinglePageById($page_id);
		// 获取站长信息
		$master = Factory::M('MasterModel');
		$masterInfo = $master->getMasterInfo();
		// 分配变量
		$this->assign('pageInfo', $pageInfo);
		$this->assign('masterInfo', $masterInfo);
		// 输出视图
		$this->display('index.html');
	}
}