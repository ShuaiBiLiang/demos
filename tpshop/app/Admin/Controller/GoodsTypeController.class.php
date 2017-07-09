<?php
namespace Admin\Controller;
use Admin\Controller\CommenController;

class GoodsTypeController extends CommonController{
	/*
		显示商品分类添加页面
	 */
	public function index(){

		$Type = D('GoodsType');

		$this->data = $Type->getAll(); 

		$this->display();
	}

	/*
		添加商品类型方法
	 */
	public function add(){

		if( IS_POST ):			

			$Type = D('GoodsType');

			if(!$Type->create()){

				$this->error($Type->getError());
			}

			$res = $Type->add();//把数据入库
 			
			if( $res ){
				$this->success('添加商品类型成功！', U('index'), 3);die;
			}else{
				$this->error('添加商品类型失败！');die;
			}

 		endif;

		$this->display();
	}

	/*
		根据id删除分类
	 */
	public function delType(){ 

		$Type = D('GoodsType');

 		//获取type_id
        $this->type_id = I('get.type_id', 0, 'intval');

        if ($this->type_id == 0) {
            $this->error('非法请求！请重新确认！');
        }

        $res = $Type->delete($this->type_id);

        if( $res ){
            $this->success('删除成功！', U('index'), 3);die;
        }else{
            $this->error('删除失败！');die;
        }
	}

	public function editType(){

		$Type = D('GoodsType');

		if( IS_POST ){ 

            if(!$Type->create()){
                //create会自动判断，如果提交过来的数据存在主键就会自动更新
                //否则就是新增操作
                $this->error( $Type->getError() );
            }

            //存储数据
            $res = $Type->save(); 
            
            if( $res ){
                $this->success('修改成功！', U('index'), 3);die;
            }else{
                $this->error('修改失败！');die;
            }

		} 

		//获取type_id
        $this->type_id = I('get.type_id', 0, 'intval'); 
		$this->GoodsType = $Type->find($this->type_id);

		$this->display('edit');

	}
}