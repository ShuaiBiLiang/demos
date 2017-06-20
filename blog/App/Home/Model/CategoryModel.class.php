<?php

/**
 * 前台bg_category表的操作模型
 */
class CategoryModel extends Model {
	/**
	 * 获取所有的一级分类信息
	 */
	public function getFirstCate() {
		$sql = "select * from bg_category where cate_pid=0 order by cate_sort";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 根据当前的分类id号获取其下一层的子分类
	 */
	public function getSubCateById($cate_id) {
		$sql = "select cate_id,cate_name from bg_category where cate_pid=$cate_id";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 获取面包屑导航所有的父分类列表(也包括文章自己所属的分类)
	 */
	public function getAllParentCateName($cate_id) {
		// 先获取当前分类的名字和父类的id号
		$sql = "select cate_name,cate_pid from bg_category where cate_id=$cate_id";
		$cate = $this->dao->fetchRow($sql);
		$cate_name = $cate['cate_name'];//获取当前分类的名称
		static $list = array();
		$list[$cate_id] = $cate_name;
		$cate_pid = $cate['cate_pid'];
		// 判断该类别的父类的id号是否为0
		if($cate_pid != 0) {
			// 递归点
			$this->getAllParentCateName($cate_pid);
		}
		return array_reverse($list,true);
	}
}