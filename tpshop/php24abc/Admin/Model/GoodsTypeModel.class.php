<?php
namespace Admin\Model;
use Think\Model;
class GoodsTypeModel extends Model{
	protected $_validate = array(
		array('type_name', 'require', '商品类型名称必须填写!', 1),
	);


	/*
		获取所有商品分类
		并且分页
	 */
	public function getAll(){
		//获取数据总数 
		$count = $this->count();

		$Page = new \Think\Page( $count, 5 );//每页显示3条

		//使用show方法生成页码
		$data['style'] = $Page->show();

		$data['list'] = $this->field('type_id,type_name')->limit($Page->firstRow . ',' . $Page->listRows)->select();

		return $data;
	}
}