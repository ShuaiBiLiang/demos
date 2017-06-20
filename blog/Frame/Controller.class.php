<?php

/**
 * 基础控制器类
 */
class Controller {
	protected $smarty;// 用于保存Smarty对象
	/**
	 * 构造方法
	 */
	public function __construct() {
		// 初始化编码
		$this->initCode();
		// 初始化Smarty
		$this->initSmarty();
	}
	/**
	 * 初始化编码
	 */
	protected function initCode() {
		header("Content-type:text/html;Charset=utf-8");
	}
	/**
	 * 初始化Smarty
	 */
	protected function initSmarty() {
		// 实例化
		$this->smarty = new Smarty;
		// 更改Smarty模板路径
		$this->smarty->setTemplateDir(CURRENT_VIEW_DIR . CONTROLLER . '/');
		// 更改Smarty编译目录
		$this->smarty->setCompileDir(APP_DIR . PLATFORM . '/View_c/' . CONTROLLER . '/');
	}
	/**
	 * 自己封装assign方法
	 */
	protected function assign($name, $value) {
		// 调用Smarty里面同名的方法
		$this->smarty->assign($name, $value);
	}
	/**
	 * 自动封装display方法
	 */
	protected function display($tpl) {
		// 调用Smarty里面同名的方法
		$this->smarty->display($tpl);
	}
	/**
	 * 封装跳转方法
	 * @param $url 目标URL
	 * @param $info 提示信息
	 * @param $time 跳转等待时间
	 */
	protected function jump($url, $info=NULL, $time=3){
		// 先判断是立即跳转还是刷新跳转
		if(is_null($info)) {
			// 说明是立即跳转
			header('location:' . $url);
			die;
		}else {
			// 说明是刷新跳转,需要给出提示信息
			// 直接利用定界符输出模板内容
			echo <<<TIAOZHUAN
			    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			    <title>提示信息</title>
			    <style type='text/css'>
			        * {margin:0; padding:0;}
			        div {width:390px; height:287px; border:1px #09C solid; position:absolute; left:50%; margin-left:-195px; top:10%;}
			        div h2 {width:100%; height:30px; line-height:30px; background-color:#09C; font-size:14px; color:#FFF; text-indent:10px;}
			        div p {height:120px; line-height:120px; text-align:center;}
			        div p strong {font-size:26px;}
			    </style>
				<div>
			        <h2>提示信息</h2>
			        <p>
			            <strong>$info</strong><br />
						页面在<span id="second">$time</span>秒后会自动跳转，或点击<a id="tiao" href="$url">立即跳转</a>
			        </p>
			    </div>
			    <script type="text/javascript">
			        var url = document.getElementById('tiao').href;
			        function daoshu(){
			            var scd = document.getElementById('second');
			            var time = --scd.innerHTML;
			            if(time<=0){
			                window.location.href = url;
			                clearInterval(mytime);
			            }
			        }
			        var mytime = setInterval("daoshu()",1000);
			    </script>
TIAOZHUAN;
		die;
		}

	}
	/**
	 * 对外部数据进行过滤
	 */
	protected function escapeData($data) {
		return addslashes(strip_tags(trim($data)));
	}
}