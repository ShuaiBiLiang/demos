<?php

# 封装一个文件上传函数
/**
*upFile 封装的文件上传函数
*@param $fileInfo  array  上传文件的信息 
*例：array('name'=>'xx.jpg','type'=>'image/jpeg','tmp_name'=>'xx/xx/aa.tmp','error'=>0,'size'=>12343)
*/

function upFile($fileInfo) {
	// 1.检查系统错误
	switch ($fileInfo['error']) {
		case 1:
			echo '文件大小超过了400k,请重新选择上传！';
		return false;
		case 2:
			echo '文件超过了浏览器的限制！';
		return false;
		case 3:
			echo '上传的文件不完整，请重新上传!';
		return false;
		case 4:
			echo '没有指定上传文件！';
		return false;
		case 6:
		case 7:
			echo '系统繁忙！';
		return false;
	}
	# 2.检查逻辑问题
	// 检查文件类型是否符合要求
	$_type = array('image/jpeg', 'image/gif', 'image/png');
	if(!in_array($fileInfo['type'], $_type)) {
		echo '文件类型不符合要求！';
		return false;
	}
	// 检查文件大小是否符合要求
	$_maxsize = 400 * 1024; // 限制为400k
	if($fileInfo['size']>$_maxsize) {
		echo '文件超过400k!';
		return false;
	}
	# 3.给文件重命名
	$path = './upload/';
	$fileName = uniqid('img_') . mt_rand(0, 100) . strrchr($fileInfo['name'], '.');
	$wholeFileName = $path . $fileName;
	
	# 4.转移文件
	if (move_uploaded_file($fileInfo['tmp_name'], $wholeFileName)) {
		echo '文件上传成功！' . $wholeFileName;
		return true;
	}else {
		echo '文件上传失败！';
		return false;
	}
}

# 0.上传文件（调试upFile）
// var_dump($_FILES);
upFile($_FILES['idname']);
