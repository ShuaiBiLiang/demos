<?php
namespace Home\Model;
use Think\Model;

class MemberModel extends Model{

		//字段映射
		protected $_map = array(
			'username' => 'member_name',
			'password' => 'member_pwd',
			'mobile' => 'member_mobile',
			'email' => 'member_email',
			'uid'	=> 'member_id',
		);

		//自动完成
		protected $_auto = array(
			array('created_time', 'time', 1, 'function'),
			array('logined_time', 'time', 3, 'function'),
			array('member_salt', 'createSalt', 3, 'callback'),
			array('member_pwd', 'password', 3, 'callback'),
		);

		//自动验证
		protected $_validate = array(
			array('member_name', 'require', '会员账号不能为空!'),
			array('member_name', '', '会员账号已存在！', 1, 'unique'),
			array('member_pwd', 'require', '密码不能为空！'),
			array('member_pwd', 'check_pwd', '两次密码必须一致！', 1, 'confirm', 3),
				//验证是否验证码一致
			array('sms_code', 'checkSMS', '验证码错误！', 1, 'callback', 1),

		);

		//生成盐值
		protected function createSalt(){
			//array_merge用于合并多个数组
			$dist = array_merge( range('a','z'), range(0,9) );
			shuffle($dist);//打乱数组
			$dist = implode($dist);//把数组转成字符串
			$salt = substr( $dist, 0, 6 );//截取6个字符
			$this->salt = $salt;//用于给后面加密用的

			return $salt;
		}

		//密码加密
		public function password( $data ){
			//加密
			return sha1( md5( $this->salt . $data ) . $this->salt );
		}


		//短信验证码校验
		public function checkSMS( $data ){
			return $data == session('sms_code');
		}
}
 