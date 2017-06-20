<?php

/**
 * 后台bg_singlePage表操作模型
 */
 class SinglePageModel extends Model {
 	/**
 	 * 获取所有的单页面的信息
 	 */
 	public function getPages() {
 		$sql = "select * from bg_singlePage order by page_id desc";
 		return $this->dao->fetchAll($sql);
 	}
 	/**
 	 * 实现单页面入库
 	 */
 	public function insertPage($pageInfo) {
 		extract($pageInfo);
 		$sql = "insert into bg_singlePage values(null,'$title','$content')";
 		return $this->dao->my_query($sql);
 	}
 }