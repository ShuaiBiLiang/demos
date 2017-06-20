<?php

/**
 * 前台文章管理控制器
 */
class ArticleController extends PlatformController {
	/**
	 * 显示栏目页首页动作
	 */
	public function indexAction() {
		// 接收栏目编号,也就是一级分类的编号
		$cate_id = $_GET['cate_id'];
		// 获取该栏目下当前页的所有文章的信息
		$article = Factory::M('ArticleModel');
		$artInfo = $article->getArtInfo($cate_id);
		// 分配变量
		$this->assign('artInfo', $artInfo);
		// 获取页码字符串
		// 先实例化分页类
		$rowsPerPage = 9;
		$maxNum = $GLOBALS['conf']['Page']['maxNum'];
		$url = "index.php?p=Home&c=Article&a=index&cate_id=$cate_id";
		$rowCount = $article->getRowCount($cate_id);
		$page = new Page($rowsPerPage,$rowCount,$maxNum,$url);
		$strPage = $page->show();
		// 分配页码字符串
		$this->assign('strPage',$strPage);
		// 调用公共动作
		$this->PublicAction($cate_id);
		// 输出视图
		$this->display('index.html');
	}
	/**
	 * 公共动作
	 */
	protected function PublicAction($cate_id) {
		// 获取右侧子类别信息
		$category = Factory::M('CategoryModel');
		$subCate = $category->getSubCateById($cate_id);
		// 分配变量
		$this->assign('subCate',$subCate);
		// 获取面包屑导航所有的父分类列表
		$list = $category->getAllParentCateName($cate_id);
		// 分配变量
		$this->assign('list',$list);
		// 获取点击排行文章
		$article = Factory::M('ArticleModel');
		$sortByHits = $article->getSortByHits($cate_id,9);
		// 分配变量
		$this->assign('sortByHits',$sortByHits);
		// 获取当前分类推荐文章
		$sortByRecommend = $article->getSortByRecommend($cate_id,9);
		// 分配变量
		$this->assign('sortByRecommend',$sortByRecommend);
	}
	/**
	 * 显示文章内容页动作
	 */
	public function showAction() {
		// 接收文章的id号
		$art_id = $_GET['art_id'];
		// 调用模型
		$article = Factory::M('ArticleModel');
		// 根据id号查询文章的信息
		$row = $article->getArtInfoById($art_id);
		$this->assign('row',$row);
		// 更新浏览次数
		$article->updateHitsById($art_id);
		// 获取当前文章的分类的ID号
		$cate_id = $row['cate_id'];
		// 调用公共动作
		$this->PublicAction($cate_id);
		// 获取文章的上一篇和下一篇的信息
		$prev = $article->getPrevArt($art_id);
		$next = $article->getNextArt($art_id);
		// 分配变量
		$this->assign('prev', $prev);
		$this->assign('next', $next);
		// 提取当前文章的评论总数
		$comment = Factory::M('CommentModel');
		$rowCount = $comment->getCmtNumsById($art_id);
		$this->assign('rowCount',$rowCount);
		// $rowsPerPage,$rowCount,$maxNum,$url
		$rowsPerPage = $GLOBALS['conf']['Page']['rowsPerPage'];
		$maxNum = $GLOBALS['conf']['Page']['maxNum'];
		$url = "index.php?p=Home&c=Article&a=show&art_id=$art_id";
		// 实例化分页类,得到页码字符串
		$page = new Page($rowsPerPage,$rowCount,$maxNum,$url);
		$strPage = $page->show();
		// 分配页码字符串
		$this->assign('strPage', $strPage);
		// 提取当前文章的当前页的所有评论
		$cmtInfos = $comment->getCmtInfoByArtId($art_id);
		$this->assign('cmtInfos',$cmtInfos);
		// 输出视图
		$this->display('show.html');
	}
	/**
	 * 处理评论动作
	 */
	public function commentAction() {
		// 先判断用户有没有登录
		if(!isset($_SESSION['userInfo'])) {
			$this->jump('index.php?p=Home&c=User&a=login', ':( 请您先登录!');
		}
		// 接收数据
		$cmtInfo = array();
		$cmtInfo['art_id'] = $_POST['art_id'];//来自于隐藏域
		$cmt_content = $this->escapeData($_POST['content']);
		if(empty($cmt_content)) {
			$this->jump("index.php?p=Home&c=Article&a=show&art_id={$cmtInfo['art_id']}", ':( 评论的内容不能为空!');
		}
		$cmtInfo['cmt_content'] = $cmt_content;
		$cmtInfo['cmt_user'] = $_SESSION['userInfo']['user_name'];
		$cmtInfo['cmt_time'] = time();
		// 入库
		$comment = Factory::M('CommentModel');
		if($comment->insertComment($cmtInfo)) {
			// 跳转到该文章的内容页
			$this->jump("index.php?p=Home&c=Article&a=show&art_id={$cmtInfo['art_id']}");
		}else {
			$this->jump("index.php?p=Home&c=Article&a=show&art_id={$cmtInfo['art_id']}", ':( 发生未知错误,评论失败!');
		}
	}
}