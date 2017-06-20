<?php

/**
 * 验证码工具类
 */
class Captcha {
	// 定义相关属性
	private $width;
	private $height;
	private $pixelnum;
	private $linenum;
	private $stringnum;
	private $string;// 用于保存随机产生的字符串
	/**
	 * 构造方法
	 */
	public function __construct() {
		// 初始化相关属性
		$this->initParams();
	}
	private function initParams() {
		// 从配置文件中读取相关参数信息
		$this->width = $GLOBALS['conf']['Captcha']['width'];
		$this->height = $GLOBALS['conf']['Captcha']['height'];
		$this->pixelnum = $GLOBALS['conf']['Captcha']['pixelnum'];
		$this->stringnum = $GLOBALS['conf']['Captcha']['stringnum'];
		$this->linenum = $GLOBALS['conf']['Captcha']['linenum'];
	}
	/**
	 * 核心方法,生成验证码图片
	 */
	public function generate() {
		// 1, 创建图片
		$img = imagecreatetruecolor($this->width, $this->height);
		// 2, 填充背景色
		$backcolor = imagecolorallocate($img, mt_rand(200,255), mt_rand(150,255), mt_rand(200,255));
		imagefill($img, 0, 0, $backcolor);
		// 3, 得到随机产生的验证码字符串
		$this->string = $this->getString();
		// 4, 绘制文字
		// 计算字符间距
		$span = floor($this->width/($this->stringnum+1));
		for($i=1;$i<=$this->stringnum;$i++) {
			$stringcolor = imagecolorallocate($img, mt_rand(0,255), mt_rand(0,100), mt_rand(0,80));
			imagestring($img, 5, $i*$span, ($this->height/2) - 8, $this->string[$i-1], $stringcolor);
		}


		// 5,添加干扰线
		for($i=1;$i<=$this->linenum;$i++) {
			$linecolor = imagecolorallocate($img, mt_rand(0,150), mt_rand(30,250), mt_rand(200,255));
			$x1 = mt_rand(0, $this->width - 1);
			$y1 = mt_rand(0, $this->height - 1);			
			$x2 = mt_rand(0, $this->width - 1);
			$y2 = mt_rand(0, $this->height - 1);
			imageline($img, $x1, $y1, $x2, $y2, $linecolor);
		}

		// 6,添加干扰点(噪点)
		for($i=1;$i<=$this->width*$this->height*$this->pixelnum;$i++) {
			$pixelcolor = imagecolorallocate($img, mt_rand(100,150), mt_rand(0,120), mt_rand(0,255));
			$x = mt_rand(0, $this->width - 1);
			$y = mt_rand(0, $this->height - 1);
			imagesetpixel($img, $x, $y, $pixelcolor);
		}

		// 7,输出图片
		// 设置响应头信息
		header("Content-type:image/png");
		// 清理数据缓冲区
		ob_clean();
		imagepng($img);//  输出图片

		// 8,销毁图片(释放资源)
		imagedestroy($img);
	}
	/**
	 * 产生随机验证码字符串的方法
	 */
	private function getString() {
		$arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
		shuffle($arr);
		$rand_keys = array_rand($arr, $this->stringnum);
		$str = '';
		foreach ($rand_keys as $value) {
			$str .= $arr[$value];
		}
		// 将随机产生的字符串保存到session中
		@session_start(); // 确保开启session机制
		$_SESSION['captcha'] = $str;
		// 返回字符串
		return $str;
	}
	/**
	 * 核心方法,验证验证码是否正确
	 * @param $passcode 用户提交的验证码
	 * @return bool
	 */
	public function checkCaptcha($passcode) {
		@session_start();
		if(strtolower($_SESSION['captcha']) === strtolower($passcode)) {
			// 说明用户填写的验证码是正确的
			return true;
		}else {
			return false;
		}
	}
}
