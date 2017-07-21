<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {
    //商品列表页
    public function index(){
      $this->goods = D('Goods')->where("is_show='1'")->select();
      $this->display();
    }

    public function detail(){

    	//获取商品ID
    	$goods_id = I('get.id', 0, 'intval'); 

    	//获取商品信息
    	$this->info = D('Goods')->find($goods_id);

    	if( $goods_id < 1 || !$this->info ){
    		$this->error( '参数有误！' );die;
    	}

    	//根据商品id查出相册
    	$this->photos = D('GoodsPhotos')->where("goods_id=$goods_id")->select();
    	// dump($this->photos);die;

    	$this->attr_simple=D('GoodsAttribute')->field('ga.id,attr_value,attr_name')->alias('ga')->join('LEFT JOIN __ATTRIBUTE__ a on a.attr_id = ga.attr_id')->where("ga.goods_id=$goods_id AND attr_sel = 0")->select();
 		// dump($this->attr_simple);die;


        //获取单选属性    
        $this->attr_radio=D('GoodsAttribute')->field('ga.id,attr_value,attr_name')->alias('ga')->join('LEFT JOIN __ATTRIBUTE__ a on a.attr_id = ga.attr_id')->where("ga.goods_id=$goods_id AND attr_sel = 1")->select();

        // dump($this->attr_radio);die;
        //数据重构
        $data = [];
        foreach($this->attr_radio as $item){
            $data[$item['attr_name']][] = $item;
        }
        $this->attr_radio=$data; 
 
    	$this->display();
    }
}