<?php
  namespace Admin\Controller;
  use Think\Controller;
  class CommonController extends Controller{
    public function __construct(){
      parent::__construct();
      // 检测当前访问者是否登录了。
      $this->checkLogin();

      // 检测当前管理员是否具有访问当前[控制器-方法]的权限
      $this->checkAuth();
    }

    // 登录检测
    protected function checkLogin(){
      // 验证用户的登录状态[ 因为 ACTION_NAME直接接收地址栏的方法名，所以会有大小写的情况 ] 
      $action = array('index/login','index/code');
      $res = !in_array( strtolower( CONTROLLER_NAME.'/'.ACTION_NAME ), $action );
      if( $res  && session('is_login') != 1 ){
        $this->error( '您尚未登录！',U('Admin/index/login') );
      }      
    }

    // 权限检测
    protected function checkAuth(){
      // 先获取当前访问的控制器 和 方法名
      $auth_key   = CONTROLLER_NAME .'-'. ACTION_NAME;

      // 获取当前登录的管理员的角色ID
      $role_id    = session('role_id');

      // 根据得到的角色ID，到角色表中获取当前角色所拥有的权限
      $role_info  = D('Role')->find($role_id);
      // dump( $role_info['role_auth_ac'] );

      // 判断当前权限 $auth_key 是否在当前管理员所拥有的权限范围内
      
      // 下面数组的方法都不应该验证权限
      $allow = array(
        'index/index',  // 后台首页
        'index/top',    // 后台顶部 
        'index/left',   // 后台菜单
        'index/main',   // 后台主页
        'index/login',  // 后台登录页面
        'index/logout', // 后台退出页面
        'index/code',   // 后台登录页面的验证码
      );
      
      $res = !in_array( strtolower( CONTROLLER_NAME.'/'.ACTION_NAME ), $allow );

      if($res && strpos($role_info['role_auth_ac'], $auth_key ) === false ){
        $this->error('您不具备当前操作的权限');die;
      }

    }

  }