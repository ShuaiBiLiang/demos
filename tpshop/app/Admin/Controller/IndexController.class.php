<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class IndexController extends CommonController {
   // 后台首页[框架页]
    public function index(){
        $this->display();
    }

    // 后台首页[顶部导航]
    public function top(){
      $this->display();
    }

    // 后台首页[下左侧菜单]
    public function left(){
      // 获取当前登录管理员的角色ID
      $role_id = session('role_id');
      
      // 根据角色id获取当前角色信息
      $RoleInfo = D('Role')->find( $role_id );
      
      // 根据对应的角色id获取对应的权限[权限分顶级权限和子权限]
      // 先查询当前管理员所拥有的顶级权限
      $where = "auth_pid=0 AND auth_id IN ({$RoleInfo['role_auth_ids']})";
      $this->topAuth = D('Auth')->getAuth($where);

      // 接下来查询当前管理员所拥有的子权限
      $where = "auth_pid!=0 AND auth_id IN ({$RoleInfo['role_auth_ids']})";
      $this->sonAuth = D('Auth')->getAuth($where);
      
      $this->display();
    }

    // 后台首页[下右侧主体部分]
    public function main(){
      $this->display();
    }

    // 登录页面
    public function login(){

      // 如果有用户提交post数据
      if( IS_POST ){

        // 验证码验证
        $code = I('post.verify');
        // 借助 验证码类提供的 check方法来验证,check的返回值是 true/false
        $Verify = new \Think\Verify();
        if( !$Verify->check($code) ){
          $this->error( '验证码有误！' );die;
        }

        $username = I('username');
        $password = I('password');

        // 验证密码和帐号是否正确，要进行密码验证，必须先知道盐值
        // 根据帐号进入数据库中查询
        $res = D('Admin')->where("username = '$username'")->find();

        if( !$res ){// 帐号有误，查不出数据
          $this->error('帐号或密码有误！');die;
        }

        // 如果密码错误，则直接提示错误 
        if( password( $password , $res['salt'] ) != $res['password'] ){
          $this->error('帐号或密码有误！');die;
        }

        // 保存用户的登录状态
        session('username', $res['username']);  // 管理员帐号
        session('is_login', 1);                 // 登录状态
        session('role_id', $res['role_id']);    // 角色id
        // 更新最后登录时间
        $data = array(
          'aid' => $res['aid'],
          'login_time' => time(),
        );
        
        D('Admin')->save($data);

        // 最后登录成功！
        $this->success('欢迎回来!', U('index') );die;

      }

      $this->display();
    }

    // 退出登录
    public function logout(){
      // 删除session
      session_destroy(); 

      // 跳转回去登录页面 
      $this->success('退出成功', U('login'), 3);
    }

    // 显示验证码
    public function code(){
       // 实例化验证码类
       $Verify = new \Think\Verify();
       // $Verify->fontttf = '5.ttf';
       // $Verify->length = 3;
       // $Verify->useZh = true; // 使用中文,必须要有中文字体，这个字体默认保存在 ThinkPHP/Library/Think/Verify/zhttfs/
       // 展示验证码
       $Verify->entry();
       
    }

}