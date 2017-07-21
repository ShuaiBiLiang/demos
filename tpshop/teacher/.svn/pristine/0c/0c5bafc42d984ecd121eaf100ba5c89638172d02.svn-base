<?php
  namespace Admin\Model;
  use Think\Model;
  class AttributeModel extends Model{
    // 获取指定商品类型的所有的属性
    public function getAll($type_id){
      // ThinkPHP为我们在连表时，避免写表前缀，所以提供一种支持的方案：
      // 如果我们的表名是 ts_goods  ，则在 join方法中写上 __GOODS__，在模型执行sql语句的时候会自动替换成对应的表名 ts_goods
      // 现在我们的表名是 ts_goods_type，则可以写成 __GOODS_TYPE__
      
      // alias 设置当前表的表别名
      return $this->alias('attr')->join('LEFT JOIN __GOODS_TYPE__ gt ON attr.type_id = gt.type_id')->where('attr.type_id='.$type_id)->select();
    }
  }