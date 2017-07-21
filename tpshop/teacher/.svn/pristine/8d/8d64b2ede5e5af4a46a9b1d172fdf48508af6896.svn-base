<?php
  namespace Admin\Model;
  use Think\Model;
  class GoodsAttributeModel extends Model{

    /**
     * 批量添加商品属性
     * @param int    $goods_id [商品ID]
     * @param array  $data     [要批量添加的商品属性，里面必须有两个子数组，分别存储属性id和属性值]
     */

    public function addAll($goods_id,$data){

      foreach($data['attr_ids'] as $key => $item ){
        $info['goods_id']   = $goods_id;  // 商品ID
        $info['attr_id']    = $item;      // 属性ID
        $info['attr_value'] = $data['attr_value'][$key]; // 属性值
        $res = $this->add( $info );
        if( !$res ){
          // 自定义模型错误，给当前模型定义 error属性，就可以在模型的外部通过 getError来接收到。
          $this->error = '添加属性失败！';
          return false;
        }
      }

      return true;  // 这里记得不能省，因为函数如果没有返回值，则表示返回 null
    }
  }