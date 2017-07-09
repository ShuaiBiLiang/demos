<?php
header("Content-type:text/html;Charset=utf-8");
//引入链接数据库页面
include './conn.php';  

//获取传过来的数据
$name    =  isset($_GET['name'])?$_GET['name']:"";
$message =  isset($_GET['message'])?$_GET['message']:"";
$day     =  date('y-m-d h:i:s',time()); 
if(trim($name) && trim($message)){ 
	$sqlAddMessage = "insert into message values(null,'".htmlspecialchars($name)."','".htmlspecialchars($message)."','".$day."');";
	$resultAdd=mysql_query($sqlAddMessage);  
	//弹出结果提示窗口
	if($resultAdd){
	 //判断添加是否成功,成功后刷新页面
	 echo "<script>alert('留言成功');window.location.href='index.php';</script>";
	}else{
	 echo "<script>alert('留言失败');window.location.href='add.html';</script>";
	}   
}else{ 
	echo "<script>alert('留言失败');window.location.href='add.html';</script>";
}