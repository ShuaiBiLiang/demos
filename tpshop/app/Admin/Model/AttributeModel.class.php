<?php
namespace Admin\Model;
use Think\Model;
class AttributeModel extends Model{

	/*
		获取指定商品类型的所有属性
	 */
	public function getAll($type_id){
		// return $this->where('type_id='.$type_id)->select();

		return $this->alias('attr')->join('LEFT JOIN __GOODS_TYPE__ gt ON attr.type_id = gt.type_id')->where('attr.type_id=' . $type_id)->select();
	}









	
}