<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class RoleController extends CommonController{
  public function __construct(){
    parent::__construct();
    // 保存模型，后面就可以使用 $this->RoleModel
    $this->RoleModel = D('Role'); // 角色
    $this->AuthModel = D('Auth'); // 权限
  }
  // 列表页
  public function index(){

    // 获取所有的管理员
    $this->RoleList = $this->RoleModel->select();

    $this->display();
  }

  // 添加角色
  public function add(){

    // 判断如果有post数据
    if( IS_POST ){
      // 调用Role模型的 create 方法接收post并验证
      if( !$this->RoleModel->create() ){
        $this->error('添加失败！错误：' . $this->RoleModel->getError() );die;
      }

      // 添加操作
      $res = $this->RoleModel->add();
      if( $res ){
        $this->success('添加角色成功！', U('index'), 3 );die;
      }else{
        $this->error('添加失败！错误：' . $this->RoleModel->getError() );die;
      }

    }
    $this->display();
  }

  // 分派权限
  public function setAuth(){
    // 接收地址栏上的角色id
    $role_id = I('get.role_id',0,'intval');

    // 判断，如果角色id为0，则返回上一页
    if( $role_id < 1 ){
      $this->error('非法参数！');die;
    }


    // 判断如果有post数据提交
    if( IS_POST ){

      $_POST['role_auth_ids'] = implode( ',', I('post.auth_id') );

      // 把得到的所有权限的id值，作为条件到权限表中，获取对应权限的信息
      // 组装成 sql语句： where  auth_id in (1,2,3)
      $where = "auth_pid!=0 AND auth_id IN ({$_POST['role_auth_ids']})";
      $current_auth = $this->AuthModel->getAuth($where);

      $auth_ac = ''; // 声明一个变量用于存储权限的控制器-方法名称
      // 因为获取到的数据是二维数组，我们需要在循环中组装名称
      foreach( $current_auth as $item ){
        $auth_ac .= $item['auth_controller'] .'-'. $item['auth_action'] . ',';
      }

      // 角色的权限名称组合 
      $_POST['role_auth_ac'] = rtrim( $auth_ac, ',' );

      // 接收post数据并自动验证
      if( !$this->RoleModel->create() ){
        $this->error( $this->RoleModel->getError() );die;
      }

      // 保存权限
      $res = $this->RoleModel->save();
      if( $res ){
        $this->success('分派权限成功！',U('Role/index'),3 );die;
      }else{
        $this->error('分派权限失败！');die;
      }

    }



    // 获取所有的顶级权限
    $this->topAuth = $this->AuthModel->getAuth();

    // 获取所有的子级权限[还是使用getAuth，但是要改造下这个方法 ]
    // auth_pid 不等于 0 的，都是子权限
    $this->sonAuth = $this->AuthModel->getAuth('auth_pid != 0');

    // 根据对应的角色id获取对应的角色信息，并赋值模板中
    $this->info = $this->RoleModel->find($role_id);

    $this->display();
  }


  // 编辑角色
  public function edit(){

    $this->display();
  }

  // 删除角色
  public function del(){
    
    $this->display();
  }

}