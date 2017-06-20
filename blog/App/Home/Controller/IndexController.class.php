<?php

/**
 * 前台首页控制器
 */
class IndexController extends PlatformController {
	/**
	 * 显示前台首页
	 */
	public function IndexAction() {
		// 获取推荐文章的信息
		$article = Factory::M('ArticleModel');
		$recommendArt = $article->getRecommendArt(5);
		// 分配变量
		$this->assign('recommendArt', $recommendArt);

		// 提取站长信息
		$master = Factory::M('MasterModel');
		$masterInfo = $master->getMasterInfo();
		// 分配变量
		$this->assign('masterInfo', $masterInfo);

		// 提取最新文章信息
		$newArt = $article->getNewArt(8);
		// 分配变量
		$this->assign('newArt', $newArt);

		// 提取最热门的推荐文章信息
		$rmdArtByHits = $article->getRmdArtByHits(8);
		// 分配变量
		$this->assign('rmdArtByHits', $rmdArtByHits);

		// 输出视图
		$this->display('index.html');
	}
}