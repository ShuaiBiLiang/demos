<?php			
	@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改留言</title>
	<script type="text/javascript">
		function fn(){
			var id=document.getElementById('id').value;
			var name=document.getElementById('name').value;
			var message=document.getElementById('message').value;
			location.href='update_dao.php?id='+id+'&name='+name+'&message='+message;
		}
	</script>
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
			 	 $sql="select * from message where id=".$_GET['id'].";";

							 $result=mysql_query($sql) or die(mysql_error());
						 
						//拟定表格
						//echo '<table cellspacing="0" border="1"><tr><th>留言id</th><th>留言时间</th><th>昵称</th><th>内容</th><th>操作</th></tr>';
							while($row=mysql_fetch_array($result))
						{ 
								echo "<input id='id' type='text' disabled='disabled' value='".htmlspecialchars($row['id'])."'/><br>";
								echo "<input id='day' type='text'disabled='disabled' value='".htmlspecialchars($row['day'])."'/><br>";
								echo "<input id='name' type='text' value='".htmlspecialchars($row['name'])."'/><br>";
								echo "<textarea  id='message' rows='10' cols='50'>".htmlspecialchars($row['message'])."</textarea><br>";
 						}

				echo "<button style='width:60px;height:30px;' onclick='fn()'>修改</button>"; 
 			}
	 	}
	 	else
	 	{
	 		echo '<script>alert("抱歉 你没有权限");window.location.href="../index.php";</script>';
	 	}
 	?>
</body>
</html>