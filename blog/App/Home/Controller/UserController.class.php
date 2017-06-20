<?php

/**
 * 前台会员管理控制器
 */
class UserController extends PlatformController {
	/**
	 * 会员注册动作
	 */
	public function registerAction() {
		// 提取站长信息
		$master = Factory::M('MasterModel');
		$masterInfo = $master->getMasterInfo();
		$this->assign('masterInfo',$masterInfo);
		// 提取最新文章信息
		$article = Factory::M('ArticleModel');
		$newArt = $article->getNewArt(8);
		// 分配变量
		$this->assign('newArt', $newArt);
		// 提取最热门的推荐文章信息
		$rmdArtByHits = $article->getRmdArtByHits(8);
		// 分配变量
		$this->assign('rmdArtByHits', $rmdArtByHits);
		// 输出视图
		$this->display('register.html');
	}
	/**
	 * 处理用户注册提交表单的动作
	 */
	public function dealRegisterAction() {
		// 接收数据
		$userInfo = array();
		$user_name = $this->escapeData($_POST['user_name']);
		// 判断用户名是否为空或者已经存在
		if(empty($user_name)) {
			$this->jump('index.php?p=Home&c=User&a=register',':( 用户名不能为空!');
		}
		$user = Factory::M('UserModel');
		if($user->if_name_exists($user_name)) {
			$this->jump('index.php?p=Home&c=User&a=register',':( 用户名已经存在!');
		}
		$userInfo['user_name'] = $user_name;
		$user_pass1 = trim($_POST['pass1']);
		$user_pass2 = trim($_POST['pass2']);
		if(empty($user_pass1) || empty($user_pass2)) {
			$this->jump('index.php?p=Home&c=User&a=register',':( 密码不能为空!');
		}
		if($user_pass1 !== $user_pass2) {
			$this->jump('index.php?p=Home&c=User&a=register',':( 两次密码不一致!');
		}
		$userInfo['user_pass'] = md5($user_pass1);
		// 判断是否有上传头像
		if($_FILES['user_image']['error'] != 4) {
			// 说明上传了头像
			$upload = new Upload;
			$allow = array('image/png','image/gif','image/jpeg','image/jpg');
			$path = UPLOADS_DIR . 'user';
			$result = $upload->uploadAction($_FILES['user_image'],$allow,$path);
			if($result) {
				// 说明上传成功
				$userInfo['user_image'] = $result;
			}else {
				// 说明上传失败
				$this->jump('index.php?p=Home&c=User&a=register',Upload::$error);
			}
		}else {
			$this->jump('index.php?p=Home&c=User&a=register','请上传头像!');
		}
		// 入库
		if($user->insertUser($userInfo)) {
			// 跳转到登录页面或者首页
			$this->jump('index.php?p=Home&c=User&a=login',':) 注册成功!');
		}
	}
	/**
	 * 会员登录动作
	 */
	public function loginAction() {
		// 提取站长信息
		$master = Factory::M('MasterModel');
		$masterInfo = $master->getMasterInfo();
		$this->assign('masterInfo',$masterInfo);
		// 提取最新文章信息
		$article = Factory::M('ArticleModel');
		$newArt = $article->getNewArt(8);
		// 分配变量
		$this->assign('newArt', $newArt);
		// 提取最热门的推荐文章信息
		$rmdArtByHits = $article->getRmdArtByHits(8);
		// 分配变量
		$this->assign('rmdArtByHits', $rmdArtByHits);
		// 输出视图
		$this->display('login.html');
	}
	public function dealLoginAction() {
		// 接收数据
		$user_name = $this->escapeData($_POST['user_name']);
		$user_pass = $this->escapeData($_POST['pass']);
		if(empty($user_name) || empty($user_pass)) {
			$this->jump('index.php?p=Home&c=User&a=login',':( 用户名和密码都不能为空!');
		}
		// 调用模型
		$user = Factory::M('UserModel');
		$result = $user->check($user_name, md5($user_pass));
		if($result) {
			// 验证成功,将用户的信息写入session
			@session_start();
			$_SESSION['userInfo'] = $result;
			// 跳转到首页
			$this->jump('index.php?p=Home&c=Index&a=index');
		}else {
			$this->jump('index.php?p=Home&c=User&a=login',':( 用户名或密码不正确!');
		}
	}
	/**
	 * 完成会员退出动作
	 */
	public function logoutAction() {
		unset($_SESSION['userInfo']);
		// 直接跳转到首页
		$this->jump('index.php?p=Home&c=Index&a=index');
	}
}