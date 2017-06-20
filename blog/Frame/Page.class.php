<?php

/**
 * 封装分页类
 */
class Page {
	// 定义相关属性
	private $rowsPerPage; // 每页显示的记录数
	private $maxNum; // 页面上最多显示的页码的个数
	private $rowCount;// 总记录数
	private $url; // 固定的url链接
	/**
	 * 构造方法
	 */
	public function __construct($rowsPerPage,$rowCount,$maxNum,$url) {
		$this->initParams($rowsPerPage,$rowCount,$maxNum,$url);
	}
	/**
	 * 初始化属性
	 */
	private function initParams($rowsPerPage,$rowCount,$maxNum,$url) {
		$this->rowsPerPage = $rowsPerPage;
		$this->rowCount = $rowCount;
		$this->maxNum = $maxNum;
		$this->url = $url;
	}
	/**
	 * 核心方法,返回页码字符串
	 */
	public function show() {
		// 计算总页数
		$pages = ceil($this->rowCount / $this->rowsPerPage);
		// 确定当前选中的页码数
		$pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
		// 定义页码字符串
		$strPage = '';
		// 拼凑出首页
		$strPage .= "<a href = '{$this->url}&pageNum=1'>首页</a>&nbsp;";
		// 拼凑出上一页
		$preNum = $pageNum - 1;
		if($pageNum > 1) {
			$strPage .= "<a href = '{$this->url}&pageNum=$preNum'><<上一页</a>&nbsp;";
		}
		// 拼凑出中间的页码
		// 确定显示的初始页$startNum
		if($pageNum <= 3) {
			$startNum = 1;
		}else {
			$startNum = $pageNum - 2;
		}
		// 确定显示的初始页的最大值
		if($startNum >= $pages - $this->maxNum + 1) {
			$startNum = $pages - $this->maxNum + 1;
		}
		// 防止页码出现负值
		if($startNum < 1) {
			$startNum = 1;
		}
		// 确定显示的最后一页$endNum
		$endNum = $startNum + $this->maxNum - 1;
		// 防止越界
		if($endNum >= $pages) {
			$endNum = $pages;
		}
		if($pages <= $this->maxNum) {
			$endNum = $pages;
		}
		for($i=$startNum;$i<=$endNum;$i++) {
			// 如果$i刚好是当前选中的那一页,就标红
			if($i == $pageNum) {
				$strPage .= "<a href = '{$this->url}&pageNum=$i'><font color='red'>$i</font></a>&nbsp;";
			}else {
				$strPage .= "<a href = '{$this->url}&pageNum=$i'>$i</a>&nbsp;";
			}	
		}
		// 拼凑出下一页
		$nextNum = $pageNum + 1;
		if($pageNum < $pages) {
			$strPage .= "<a href = '{$this->url}&pageNum=$nextNum'>下一页>></a>&nbsp;";
		}
		// 拼凑出尾页
		$strPage .= "<a href = '{$this->url}&pageNum=$pages'>尾页</a>&nbsp;";
		// 拼凑出总页码数
		$strPage .= "总页数:$pages";
		// 返回页码字符串
		return $strPage;
	}
}