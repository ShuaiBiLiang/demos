<?php

/**
 * 前台bg_article表的操作模型
 */
class ArticleModel extends Model {
	/**
	 * 获取推荐文章的信息
	 */
	public function getRecommendArt($length) {
		$sql = "select a.*,c.cate_name from bg_article as a left join bg_category as c on a.cate_id = c.cate_id where is_del='0' and is_recommend='1' order by addtime desc limit $length";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 获取最新文章
	 */
	public function getNewArt($length) {
		$sql = "select art_id,title from bg_article where is_del='0' order by addtime desc limit $length";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 获取最热门的推荐文章
	 */
	public function getRmdArtByHits($length) {
		$sql = "select art_id,title from bg_article where is_del='0' and is_recommend='1' order by hits desc limit $length";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 获取该栏目下所有的文章信息
	 */
	public function getArtInfo($cate_id) {
		// 先获取该分类下所有的后代分类的id号
		$ids = $this->getAllSubIds($cate_id);
		$ids .= $cate_id; // 再连接上自己的id号
		// 确定偏移量和长度
		$pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
		$rowsPerPage = 9;
		$offset = ($pageNum - 1) * $rowsPerPage;
		$sql = "select a.*,c.cate_name from bg_article as a left join bg_category as c on a.cate_id=c.cate_id where is_del='0' and a.cate_id in($ids) order by addtime desc limit $offset,$rowsPerPage";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 根据当前分类号获取其所有的后代子分类号
	 */
	protected function getAllSubIds($cate_id) {
		$sql = "select cate_id from bg_category where cate_pid = $cate_id";
		$id = $this->dao->fetchAll($sql);
		static $ids = '';
		foreach($id as $row) {
			$ids .= $row['cate_id'] . ',';
			$this->getAllSubIds($row['cate_id']);
		}
		return $ids;
	}
	/**
	 * 获取该分类下所有文章的个数
	 */
	public function getRowCount($cate_id) {
		// 先获取该分类下所有的后代分类的id号
		$ids = $this->getAllSubIds($cate_id);
		$ids .= $cate_id; // 再连接上自己的id号
		$sql = "select count(*) from bg_article where is_del='0' and cate_id in($ids)";
		return $this->dao->fetchColumn($sql);
	}
	/**
	 * 获取该分类及其所有的子分类下的文章点击排行
	 */
	public function getSortByHits($cate_id,$length) {
		// 先获取该分类下所有的子分类号
		$ids = $this->getAllSubIds($cate_id);
		// 再拼凑当前分类的id号
		$ids .= $cate_id;
		$sql = "select art_id,title from bg_article where is_del='0' and cate_id in($ids) order by hits desc limit $length";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 获取该分类及其所有的子分类的推荐文章列表
	 */
	public function getSortByRecommend($cate_id,$length) {
		// 先获取该分类下所有的子分类号
		$ids = $this->getAllSubIds($cate_id);
		// 再拼凑当前分类的id号
		$ids .= $cate_id;
		$sql = "select art_id,title from bg_article where is_del='0' and is_recommend='1' and cate_id in($ids) order by addtime desc limit $length";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 根据文章的id号获取文章的信息
	 */
	public function getArtInfoById($art_id) {
		$sql = "select * from bg_article where art_id=$art_id";
		return $this->dao->fetchRow($sql);
	}
	/**
	 * 根据id号更新文章的浏览次数
	 */
	public function updateHitsById($art_id) {
		$sql = "update bg_article set hits=hits+1 where art_id=$art_id";
		return $this->dao->my_query($sql);
	}
	/**
	 * 获取上一篇文章
	 */
	public function getPrevArt($art_id) {
		$sql = "select art_id,title from bg_article where is_del='0' and art_id<$art_id order by art_id desc limit 1";
		return $this->dao->fetchRow($sql);
	}
	/**
	 * 获取下一篇文章
	 */
	public function getNextArt($art_id) {
		$sql = "select art_id,title from bg_article where is_del='0' and art_id>$art_id order by art_id asc limit 1";
		return $this->dao->fetchRow($sql);
	}
}