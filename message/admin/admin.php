	<?php		
			@session_start();
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>管理后台</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
	<script type="text/javascript">
		function fndel(id){
			if(confirm('是否确定删除当前记录?')){
				location.href="del_dao.php?id="+id;
			}else{
				alert('操作已撤销!');
			}
		}

		function fnupdate(id){
			if(confirm('是否确定修改当前记录?')){
				location.href="update.php?id="+id;				
			}else{
				alert('操作已撤销!');
			}
		}
	</script>
</head>
<body>
<div class="box">
	<!-- 这里是头部 -->
	<div class="top">
		<?php  
			//检测是否登录 
			if(isset($_SESSION['user']) && isset($_SESSION['pwd'])){ 

			   //$_SESSION['logined']有设置，并且值为真，表示已经登录 

			   echo "欢迎你 ".$_SESSION['user']; 

			} else{
				echo "<script>alert('抱歉 请你登陆');window.location.href='../index.php';</script>";
			}

		?>
		<a href="../index.php">返回主页</a>&nbsp;&nbsp;<a href="./loginout.php">注销登陆</a>
	</div>
	<!-- 这里显示数据的部分 该页面不使用分页-->
	<div class="main">
		<?php
			//引入链接数据库页面
			include '../conn.php'; 

			//查询一共有多少条数据
			$sqlMax = mysql_query("select count(*) from message");
			//把数据放入数组
			$arr=mysql_fetch_array($sqlMax);
			//检查是否正确 
			//print_r($arr[0]);
			//定义每页显示多少条
			$pagesize = 10;
			//一共显示的页数 公式 页数=总数量/每页显示的数量
			//同时这个也是最大页数 向上取整的原因是最后一页不够四条数据也是显示一页
			$pageMax = ceil($arr[0]/$pagesize);
			// echo "一共显示".$page."页";
			 $page= isset($_GET['page'])?$_GET['page']:1; 
			  
			//每页该显示的数据 (当前页数-1)*每页显示的条数
			//一共四页,每页四条数据
			$sql="select * from message order by id desc limit ".($page-1)*$pagesize.",".$pagesize.";";
			$result=mysql_query($sql) or die(mysql_error());
			 
			//拟定表格
			 echo '<table cellspacing="0" border="1"><tr><th>留言id</th><th>留言时间</th><th>昵称</th><th>内容</th><th>操作</th></tr>';
				while($row=mysql_fetch_array($result))
			{
				  echo "<tr><td>".htmlspecialchars($row['id'])."</td><td>".htmlspecialchars($row['day'])."</td><td>"
				  .htmlspecialchars($row['name'])."</td><td>".htmlspecialchars($row['message']).
				  "</td><td><button style='width:60px;height:30px;' onclick='fndel(".$row['id'].")'>删除</button><button style='width:60px;height:30px;' onclick='fnupdate(".$row['id'].")'>修改</button></td></tr>";
			

				//**********************************测试


/*
					echo "<input type='text' value='".htmlspecialchars($row['id'])."'/><br>";
								echo "<input type='text' value='".htmlspecialchars($row['day'])."'/><br>";
								echo "<input type='text' value='".htmlspecialchars($row['name'])."'/><br>";
								echo "<textarea rows='10' cols='50'>".htmlspecialchars($row['message'])."</textarea><br>";

					echo "<button style='width:60px;height:30px;' onclick='fndel(".$row['id'].")'>删除</button><button style='width:60px;height:30px;' onclick='fnupdate(".$row['id'].")'>修改</button><br>";
*/


				//**********************************
			}    
			echo "<table>";
				echo '<div class="bottom">现在共有留言'.$arr[0].'条</div>';
			 
		?>
 
	</div>
</div>
	
</body>
</html>