<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller {
    public function login(){

    //发送短信
    // $res = sendSMS('小灰灰', '18316110442');
    // dump( $res);


    	//判断数据
    	if( IS_POST ){
    		$member_name = I('username'); //账号
    		$password = I('password'); //密码

    		//根据账号查询对应的会员信息
    		$info = D('Member')->where("member_name = '$member_name'")->find();

    		if( !$info ){
    			$this->error('登录信息有误！');die;
    		}

    		//再来判断密码 先加密，再和数据库的密码匹配
    		D('Member')->salt = $info['member_salt'];
    		$password = D('Member')->password( $password );
    		/*到这一步已经在数据库拿了盐值，将用户输入的密码加密，接下来就是匹配*/

    		if( $password == $info['member_pwd'] ){
    			//密码一致就是登录成功，保存状态
    			session('member_name', $info['member_name']);
 				session('member_login', 1);
 				session('logined_time', $info['logined_time']);//保存上一次登录时间

 				//更新登录时间
 				$data = array(
 					'logined_time' => time(),
 					'member_id'	   => $info['member_id'],
 				);

 				D('Member')->save();

 				$this->success('登录成功！', U('index/index'), 3);die;
    		}else{
    			$this->error('登录失败！');die;
    		}


    	}

    	$this->display();
    }
 

 	public function register(){

 		//判断提交的数据
 		if( IS_POST ){
 				$info = D('Member')->create();
			//验证数据
 			if( !$info ){
 				$this->error( D('Member')->getError() );die;
 			}	

 			//增加数据
 			$res = D('Member')->add();

 			if( $res ){
 				//注册成功就保存在session里面
 				session('member_name', $info['member_name']);
 				session('member_login', 1);

 				$this->success('注册成功！', U('Index/index'), 3);die;
 			}else{
 				$this->error('注册失败！');die;
 			}
 		}
		$this->display();
 	}


 	//退出
 	public function logout(){
 		session('member_name', null);
 		session('member_login', null);

 		$this->success('退出登录成功！', U('Member/login'));die;
 	}

    //发送验证码
    public function sms_verify(){
        if( !IS_AJAX ){
            die;
        }

        // dump( I('get.') );


        if( session('sms_time') > 1 && time() - session('sms_time') < 60 ){
            $result = array(
                'code' => 1,        //1表示有错误
                'msg'  => '点击过于频繁',
            );
            echo json_encode( $result );
        }

        //接受前台发送过来的短信
        $mobile = I('get.mobile', '');
        $user   = '新用户';

        //发送短信
        $res = sendSMS($user, $mobile);
        // echo '<pre>';
        // print_r($res['result']);die;

        $res = (array)$res->result;
        // print_r($res);die;

        
        $result = array(
                'code' => $res['err_code'],     //0表示成功  
                'msg'  => $res['success'],
            );

        echo json_encode( $result );
 
    }

    public function find(){
        // echo 'find';

        if( IS_POST ){
            //接收
            $username = I('post.username');
            $email    = I('post.email');

            //把上面的数据
            $info = D('Member')->where("member_name = '$username' AND member_email = '$email'")->find();
            
            if( !$info ){
                $this->error('用户信息有误！');die;
            }

            //提供给用户点击的重置密码的链接
            $url = "http://" . $_SERVER['HTTP_HOST'] . U('Member/reset', array('uid'=>$info['member_id']));

            //邮件发送模版
            $content =<<<DDD
            <h3>京西商城</h3>
            <p>尊敬的{$username},<br>
            你在京西商城申请了密码找回服务，点击找回密码链接:<br>
            <a href="$url">点击链接</a><br>
            如果你没有进行此项操作，请忽略本次发送的邮件！

            </p>
DDD;
            //发送与偶见到当前会员的邮箱地址中
            $res = sendMail($info['member_email'], $info['member_name'], '找回密码', $content);
            // $res = sendMail('balgfi@live.cn', 'abc', '找回密码', '内容');

            // dump($res);die;

            /*
                    BUG
             */

            if( $res ){
                $this->success('邮件发送成功！请尽快打开邮箱完成后续操作！');die;
            }else{
                $this->error('邮件发送失败！请联系网站管理员！');die;
            }
        }


        $this->display();
    }


    //密码重置
    public function reset(){

        $Member = D('Member');

        //判断
        if( IS_POST ){
            
            //接受数据并校验
            if( !$Member->create() ){
                $this->error( $Member->getError() );die;
            }

            //保存密码
            $res = $Member->save(); 

            if( $res ){
                $this->success( '重置密码成功！', U('Member/login') );die;
            }else{
                $this->error( '重置密码失败！' );die;
            }
        }

        $this->display();
    }
}

