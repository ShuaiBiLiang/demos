<?php
namespace Admin\Controller;
use Admin\Controller\CommenController;
class AdminController extends CommonController {

	public function index(){

		//获取所有的管理员
		$this->list = D('Admin')->select();
		$this->display();
	}

	public function add(){

		//接受数据
		if( IS_POST ){

			$Admin = D('Admin');
			$_POST['salt'] = mt_rand(10000, 99999);
			if( !$Admin->create() ){
				$this->error( '添加失败' );die;
			}

			$res = $Admin->add();

			if( $res ){
				$this->success('添加成功', U('index'), 3);die;
			}else{
				$this->error( '添加失败' );die;
			}
		}
		$this->display();
	}
}