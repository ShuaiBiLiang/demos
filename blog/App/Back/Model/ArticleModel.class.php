<?php

/**
 * 后台bg_article表操作模型
 */
class ArticleModel extends Model {
	/**
	 * 添加文章
	 * @param array $art 文章信息
	 */
	public function insertArt($art) {
		// 通过数组得到多个变量
		extract($art);
		// 完善其他的数据
		// $thumb = 'default.jpg';
		$addtime = time();
		// 入库
		$sql = "insert into bg_article values(null, $cate_id, '$title', '$thumb', '$art_desc', '$content', '$author', default, $addtime, default, default)";
		return $this->dao->my_query($sql);
	}
	/**
	 * 获取当前页所有的文章信息
	 */
	public function getArticle() {
		$pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
		$rowsPerPage = $GLOBALS['conf']['Page']['rowsPerPage'];
		$maxNum = $GLOBALS['conf']['Page']['maxNum'];
		$offset = ($pageNum - 1) * $rowsPerPage;
		$sql = "select a.*,c.cate_name from bg_article as a left join bg_category as c on a.cate_id = c.cate_id where is_del = '0' order by addtime desc limit $offset,$rowsPerPage";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 根据id号获取一篇文章的信息
	 */
	public function getArticleById($art_id) {
		$sql = "select * from bg_article where art_id = $art_id";
		return $this->dao->fetchRow($sql);
	}
	/**
	 * 根据id号修改某一篇文章的内容
	 */
	public function updateArtById($art) {
		// 通过数组得到多个变量
		extract($art);
		$sql = "update bg_article set cate_id=$cate_id,title='$title',thumb='$thumb',art_desc='$art_desc',author='$author',content='$content' where art_id=$art_id";
		return $this->dao->my_query($sql);
	}
	/**
	 * 根据id号逻辑删除一篇文章
	 */
	public function delArticleById($art_id) {
		$sql = "update bg_article set is_del = '1' where art_id = $art_id";
		return $this->dao->my_query($sql);
	}
	/**
	 * 批量逻辑删除文章
	 */
	public function delAllArticle($art_id) {
		$sql = "update bg_article set is_del = '1' where art_id in($art_id)";
		return $this->dao->my_query($sql);
	}
	/**
	 * 提取已经被逻辑删除的文章
	 */
	public function getDeledArticle() {
		$sql = "select a.*,c.cate_name from bg_article as a left join bg_category as c on a.cate_id = c.cate_id where is_del = '1' order by addtime desc";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 根据id号还原一篇文章
	 */
	public function recoverArtById($art_id) {
		$sql = "update bg_article set is_del = '0' where art_id = $art_id";
		return $this->dao->my_query($sql);
	}
	/**
	 * 根据id号彻底删除一篇文章
	 */
	public function realDelArticleById($art_id) {
		$sql = "delete from bg_article where art_id = $art_id";
		return $this->dao->my_query($sql);
	}
	/**
	 * 批量彻底删除文章
	 */
	public function realDelAllArticle($art_id) {
		$sql = "delete from bg_article where art_id in($art_id)";
		return $this->dao->my_query($sql);
	}
	/**
	 * 获取文章总记录数
	 */
	public function getRowCount() {
		$sql = "select count(*) from bg_article where is_del='0'";
		return $this->dao->fetchColumn($sql);
	}
	/**
	 * 根据id号切换推荐状态
	 */
	public function updateRecomendById($art_id,$is_recommend) {
		if($is_recommend == '0') {
			$is_recommend = '1';
		}else {
			$is_recommend = '0';
		}
		$sql = "update bg_article set is_recommend = '$is_recommend' where art_id=$art_id";
		return $this->dao->my_query($sql);
	}
}
