<?php
 session_start(); 
 
	//引入链接数据库页面
	include '../conn.php'; 
	//检测是否登录 当然要判断会话值还是否存在
	if(isset($_SESSION['user']) && isset($_SESSION['pwd'])){ 
  
			//这是删除留言的页面
			$id = isset($_GET['id'])?$_GET['id']:0;
			 if($id!==0){
			 	//删除操作这里开始
			 	$sql="delete from message where id=$id;";

				$result=mysql_query($sql);
				 if($result){
				  	echo "<script>alert('删除成功 id为".$id."的记录已经被成功删除!');window.location.href='./admin.php';</script>";
				}else{
				 	echo "<script>alert('删除失败!');window.location.href='./admin.php';</script>";
				 } 
			 }else{
			 	echo "<script>alert('操作错误!请重新操作!');window.location.href='../login.html';</script>";
			 }

	} else{
		echo "<script>alert('抱歉 请你登陆!');window.location.href='../login.html';</script>";
	}