<?php

header("Content-type:text/html;Charset=utf-8");
// 加载数据库工具类
include './MySQLDB.class.php';
// 初始化MySQLDB
$config = array(
	'pass'=>'zhouyang',
	'dbname'=>'php2017'
);
$dao = MySQLDB::getInstance($config);
// 以下代码与分页有关
// (1) 先设置当前选中的页码数
$pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
if($pageNum < 1) {
	$pageNum = 1;
}
// (2) 定义每一页显示的记录数
$rowsPerPage = 2;
// (3) 查询总记录数
$sql = "select count(*) from php_student";
$rowCount = $dao->fetchColumn($sql);
// (4) 计算总页数
$pages = ceil($rowCount / $rowsPerPage);
// (5) 拼凑出页码字符串
$strPage = '';
// 拼凑出首页
$strPage .= "<a href = './stu.php?pageNum=1'>首页</a>&nbsp;";
// 拼凑出上一页
$preNum = $pageNum - 1;
if($pageNum > 1) {
	$strPage .= "<a href = './stu.php?pageNum=$preNum'><<上一页</a>";
}
// 拼凑出中间的页码
for($i=1;$i<=$pages;$i++) {
	$strPage .= "<a href = './stu.php?pageNum=$i'>$i</a>&nbsp;";
}
// 拼凑出下一页
$nextNum = $pageNum + 1;
if($pageNum < $pages) {
	$strPage .= "<a href = './stu.php?pageNum=$nextNum'>下一页>></a>";
}
// 拼凑出尾页
$strPage .= "&nbsp;<a href = './stu.php?pageNum=$pages'>尾页</a>";
// 拼凑出总页码数
$strPage .= "总页数:$pages";

// 分页到此结束
$offset = ($pageNum - 1) * $rowsPerPage; // 偏移量
$sql = "select * from php_student limit $offset, $rowsPerPage";
$result = $dao->fetchAll($sql);
// 加载模板文件
include './stu.html';