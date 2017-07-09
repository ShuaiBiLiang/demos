<?php 
session_start(); 

//引入链接数据库页面
include './conn.php'; 
//定义数据库查询语句
$sql="select * from admin where userName='".$_POST['user']."' and userPassword='".$_POST['pwd']."'";
$result=mysql_query($sql);
 if(!!$rows=mysql_fetch_array($result,MYSQL_ASSOC)){
 					
	/*验证成功就进来设置session*/
	// if($_POST['user']==$user && $_POST['pwd']==$pwd){
	//如果登录成功，生成对应的会话值。 

	    $_SESSION['pwd']=$_POST['user'];   //判断是否已经登录的依据。
	    $_SESSION['user']=$_POST['pwd'];  //记录当前登录用户。
	    echo  "<script>alert('登陆成功');window.location.href='./admin/admin.php';</script>"; 


	// }else{ 
	// echo "登录失败，不记录SESSION值"; 
	// } 
}else{
 	echo "<script>alert('登陆失败');window.location.href='./login.html';</script>";
 }
?>
