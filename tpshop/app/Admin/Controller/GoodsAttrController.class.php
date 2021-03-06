<?php
  namespace Admin\Controller;
  use Admin\Controller\CommonController;
  class GoodsAttrController extends CommonController{
    
    // 类型属性列表
    public function index(){
      // 当前商品类型的type_id并赋值到模板中
      $this->type_id = I('get.type_id',0,'intval');

      // 获取当前商品类型的所有属性
      $this->list = D('Attribute')->getAll( $this->type_id );
      // dump( $this->list );
      $this->display();
    }

    // 添加类型属性
    public function add(){

      // 如果有post数据提交
      if( IS_POST ){
        $Attr = D('Attribute');
        // 使用create 接收post数据并验证数据
        if( !$Attr->create() ){
          $this->error( $Attr->getError() );
        }
        // 添加数据
        $res = $Attr->add();

        if( $res ){
          $this->success('添加类型属性成功！', U('index',array('type_id'=>I('post.type_id'))), 3 );die;
        }else{
          $this->error('添加类型属性失败！');die;
        }

      }

      // 当前商品类型的type_id
      $this->type_id = I('get.type_id',0,'intval');

      // 获取所有的商品类型
      $Type = D('GoodsType');

      // 赋值到模板中
      $this->type_list = $Type->select();

      $this->display();
    }
  }