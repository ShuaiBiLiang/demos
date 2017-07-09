<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<?php
define("host","db_address");
define("name","db_name");
define("password","db_pwd");

$conn = mysql_connect(host,name,password);
//选择数据库
mysql_select_db('db_name',$conn);
//设置编码格式
mysql_query("set names utf8");
?>
</body>
</html>
