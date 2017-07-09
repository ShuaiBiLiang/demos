<?php
session_start();
session_unset(); 
session_destroy();
if(empty($_SESSION['user']) && empty($_SESSION['pwd'])){
	echo "<script>alert('登出成功 现在返回主页');window.location.href='../index.php';</script>";
}else{
	echo "<script>alert('登出失败 返回前页');window.history.go(-1);</script>";
}