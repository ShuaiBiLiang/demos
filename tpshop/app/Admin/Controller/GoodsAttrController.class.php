<?php
namespace Admin\Controller;
use Admin\Controller\CommenController;
class GoodsAttrController extends CommonController{

	/*
		显示属性列表
	 */
		public function index(){
 
			$this->type_id = I('get.type_id', 0, "intval"); 

			//查找该id的属性 全部取出来
			$this->list = D('Attribute')->getAll($this->type_id);
			
			$this->display();
		}

	/*
		增加属性
	 */
		public function add(){  

			//增加数据
			if( IS_POST ){
				$Attr = D('Attribute');

				if( !$Attr->create() ){
					$this->error( $Attr->getError() );
				}

				$res = $Attr->add();

				if( $res ){
					$this->success('添加类型属性成功！', U('index',array('type_id'=>I('post.type_id')), 3));die;
						// ,array('type_id'=>I('post.type_id')), 3
				}else{
					$this->error('添加类型属性失败！');die;
				}


			} 
				
			$this->type_id = I('get.type_id', 0, "intval");
			$this->typeList = D('GoodsType')->select();
			$this->display();
		}
}