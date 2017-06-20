<?php

/**
 * 文件上传类
 */
class Upload {
	// 定义静态属性,记录错误信息
	public static $error;
	/**
	 * 核心上传方法
	 * @param array $file 上传文件的信息
	 * @param array $allow 允许文件上传的类型
	 * @param string $path 文件上传的路径
	 * @param int $maxsize = 2*1024*1024 允许上传文件的大小
	 * @return false|$newname 上传失败就返回false成功就返回新的文件名
	 */
	public function uploadAction($file,$allow,$path,$maxsize=2097152) {
		// 1, 先判断有没有系统错误
		switch($file['error']) {
			case 1: self::$error = '上传错误,超出了文件限制的大小!';
					return false;
			case 2: self::$error = '上传错误,超出了浏览器表单限制的大小!';
					return false;
			case 3: self::$error = '上传错误,文件上传不完整!';
					return false;
			case 4: self::$error = '上传错误,请先选择上传的文件!';
					return false;
			case 6: 
			case 7: self::$error = '对不起,服务器繁忙!';
					return false;
		}
		// 2, 判断逻辑错误
		// 2.1 判断文件大小
		if($file['size'] > $maxsize) {
			self::$error = '上传错误,超出了文件限制的大小!允许的最大值为:' . $maxsize . '字节';
			return false;
		}
		// 2.2 判断文件类型
		if(!in_array($file['type'], $allow)) {
			// 文件类型非法
			self::$error = '文件的类型不正确,允许的类型有:' . implode(',', $allow);
			return false;
		}
		// 3, 得到文件的新名字
		$newname = $this->randName($file['name']);
		// 4, 移动文件
		$target = $path . '/' . $newname;
		if(move_uploaded_file($file['tmp_name'], $target)) {
			// 移动成功
			return $newname;
		}else {
			// 移动失败
			self::$error = '发生未知错误,上传失败!';
			return false;
		}
	}
	/**
	 * 生成一个随机名字的函数 文件名 = 当前时间 + 随机数字
	 */
	private function randName($filename) {
		// 生成文件名的时间部分
		$newname = date('YmdHis');
		// 加上6位随机数
		$str = '12345678901234567890';
		for($i=0;$i<6;$i++) {
			$newname .= $str[mt_rand(0,strlen($str)-1)];
		}
		// 加上后缀名
		$newname .= strrchr($filename,'.');
		return $newname;
	}
}