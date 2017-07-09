<?php			
	@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改留言</title>
</head>
<body>
		<?php
			//引入链接数据库页面
			include '../conn.php';
	if(isset($_SESSION['user']) && isset($_SESSION['pwd'])){  	
	 //这是删除留言的页面
	 $id = isset($_GET['id'])?$_GET['id']:0;
		 if($id!==0){
		 	//修改操作这里开始 
	 		$sql="update message set name='".$_GET['name']."',message='".$_GET['message']."' where id=".$_GET['id'].";";
			$result=mysql_query($sql) or die(mysql_error());						 
			if($result === true){
				echo '<script>alert("修改成功");window.location.href="./admin.php";</script>';
			}else{
				echo '<script>alert("修改失败");window.location.href="./admin.php";</script>';
			}		
		 }
 	}else{
 		echo '<script>alert("抱歉 你没有权限");window.location.href="../index.php";</script>';
 	}
 	?>
</body>
</html>