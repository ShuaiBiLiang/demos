<?php
namespace Admin\Model;
use Think\Model;
class GoodsAttributeModel extends Model{

	/*
		批量添加商品属性
	 */
	public function addAll($goods_id, $data){
		foreach ($data['attr_ids'] as $key => $item) {
			$info['goods_id']	= $goods_id;
			$info['attr_id']	= $item;
			$info['attr_value']	= $data['attr_value'][$key];
			$res = $this->add($info);


			if(!$res){
				//其实就是自定义错误信息
				$this->error = "添加属性失败!";
				return false;
			}
		}
		return true;
	}
}