<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>留言板</title>
	 <link rel="stylesheet" type="text/css" href="./css/index.css"> 

</head>
<body>
		 <div class="box">
		 	<div class="top">Message</div>
		 	<div class="main">
		 		
 
		<?php
			//引入链接数据库页面
			include './conn.php'; 

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
			echo "<div  class='message'>";
				while($row=mysql_fetch_array($result))
			{
				echo "<div class='name'>".htmlspecialchars($row['name'])."<span>".htmlspecialchars($row['day'])."</span></div><div class='con'>".htmlspecialchars($row['message'])."</div>";
			}    
			echo "</div>";
		?>

 <form action="index.php" method="get" style="text-align:center;">
 	<?php 
		//循环输出各页数目及连接
		if ($pageMax > 1) {
		    for($i=1;$i<=$pageMax;$i++) {
		        if($i==$page) {
		            echo ' [',$i,']';
		        } else {
		            echo ' <a class="page" href="index.php?page=',$i,'">',$i,'</a>';
		        }
		    }
		}
 	?>
 </form>
 <div class="fn"><a href="./add.html">我要留言</a>&nbsp;&nbsp;<a href="./login.html">后台入口</a></div>		 		
		 	</div>
		 </div>

 
</body>
</html>