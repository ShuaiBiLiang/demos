<?php
  namespace Admin\Controller;
  use Admin\Controller\CommonController;
  class GoodsTypeController extends CommonController{
    // public function __construct(){
    //   $this->Type = D('GoodsType');
    // }
    // 商品类型的列表
    public function index(){
      $Type = D('GoodsType');
      
      // 获取所有的商品类型数据
      $this->data = $Type->getAll();
      // 赋值有两种方式
      // $this->assign( 'data', $Type->getAll() );
      $this->display();
    }

    // 添加商品类型
    public function add(){
      // 判断是否有post数据
      if(IS_POST){
        // 添加数据
        $Type = D('GoodsType');
        // 使用create接收post的数据并验证数据
        if( !$Type->create() ){
          $this->error( $Type->getError() );
        }

        $res = $Type->add();
        if( $res ){
          $this->success('添加商品类型成功！', U('index'), 3 );die;
        }else{
          $this->error('添加商品类型失败！');die;
        }
      }
      $this->display();
    }
  }