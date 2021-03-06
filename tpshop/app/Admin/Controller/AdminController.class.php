<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class AdminController extends CommonController{
  
  // 列表页
  public function index(){

    // 获取所有的管理员
    $this->list = D('Admin')->select();
    $this->display();
  }

  // 添加页
  public function add(){

    // 判断是否有post数据
    if( IS_POST ){
      $Admin = D('Admin');
      $_POST['salt'] = mt_rand(10000,99999);
      if( !$Admin-> create() ){
        $this->error( '添加失败！');die;
      }

      $res = $Admin->add();
      if( $res ){
        $this->success('添加成功！',U('index') );die;
      }else{
        $this->error( '添加失败！');die;
      }
    }

    // 查询所有的角色
    $this->RoleList = D('Role')->select();

    $this->display();
  }

}