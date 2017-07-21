<?php
  namespace Admin\Model;
  use Think\Model;
  class GoodsTypeModel extends Model{
     protected $_validate = array(
        array( 'type_name','require','商品类型名称必须填写！',1 ),
     );

     // 获取数据和分页
     public function getAll(){
        // 获取数据总数
        $count = $this->count();
        $Page = new \Think\Page( $count, 3 ); // 参数1是要分页的数据总数，参数2是每一页显示的数据量
        
        // 使用 show方法生成页码
        $data['style'] = $Page->show();
      
        // 获取当前页的数据  limit 0,10   limit 10,10
        $data['list'] = $this->field('type_id,type_name')->limit($Page->firstRow . ',' . $Page->listRows )->select();

        return $data;
     }

  }