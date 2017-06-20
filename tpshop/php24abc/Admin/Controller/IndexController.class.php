<?php
namespace Admin\Controller;
use Admin\Controller\CommenController;
class IndexController extends CommonController {
    public function index(){       
        $this->display();
    }

    public function top(){
 		$this->display();
    }

    public function left(){
 		$this->display();
    }

    public function main(){
    	 $this->display();
    }

    /*
        登录方法
     */
    public function login(){

        // $salt = '21615';
        // $password = '123456';
        // dump( password($password,$salt) );
        // echo password('123456', '21615');
        // $this->display();
        

        if( IS_POST ){
            //验证验证码
            $code = I('post.verify');

            $Verify = new \Think\Verify();

            if( !$Verify->check($code) ){
                $this->error( '验证码有误！' );die;
            }

            $username = I('username');
            $password = I('password');

            //验证密码和账号是否正确
            
            $res = D('Admin')->where("username='$username'")->find();

            if( !$res ){
                $this->error('登录信息有误！');die;
            }

            if( password( $password, $res['salt'] ) != $res['password'] ){
                $this->error('登录信息有误！');die;
            }

            //登录成功就保存用户的登录状态
            session('username',$res['username']);//保存管理员的账号
            session('is_login',1);               //保存登录状态

            //更新最后的登录时间
            $data = array(
                'aid' => $res['aid'],
                'login_time' => time()
            );

            D('Admin')->save($data);

            //登录成功
            $this->success('欢迎回来!', U('index'), 3);die;
        }   

        $this->display();
    }


    public function code(){
        //实例化验证码类
        $Verify = new \Think\Verify();
        //展示验证码
        $Verify->entry();
    }

    /*
        管理员退出功能
     */
    public function logout(){

        session_start();
        session_unset(); 
        session_destroy();

        $this->success('退出成功！', U('Index/login'), 3);
    }
}