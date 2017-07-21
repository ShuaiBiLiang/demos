<?php
  namespace Admin\Model;
  use Think\Model;
  class GoodsModel extends Model{
     // 自动完成[二维数组，每一个子数组，就是一个字段的自动完成设置]
     protected $_auto = array(
       // array('完成字段名称','完成规则','完成条件','附加规则')
       array('created_time','mytime',1,'callback'),  // 调用自定义[会在当前模型中查找]
       array('updated_time','time',3,'function'), // 调用系统函数
       array('goods_name','filterXSS',3,'function'),
     );
     // 字段映射
     // 隐藏真实的数据表字段，防止一些恶意的用户猜测我们的数据表字段。 
     protected $_map = array(
       'title' => 'goods_name',
     );

     // 自动验证[二维数组,每一个子数组，就是一个字段的验证规则集合]
     protected $_validate = array(
       // array('验证字段名','验证规则','验证失败以后的提示错误信息','附加验证规则') 
        array('goods_name','require','商品名称必须填写'),
        array('goods_name','','该商品名称已经存在！',1,'unique',3),
     );

     protected function mytime($data=null){
       if($data){
          return strtotime($data);  // 把时间格式化字符串转换成时间戳
       }
       return time();
     
     }

     /* 获取分页的数据
      * @param  $firstRow   当前页数据的第一条数据下标[开始]  
      * @param  $listRows   每一页的数据量
      * limit 0,3     这里的0就是 $firstRow，3就是 $listRows
      */
     public function getList($firstRow,$listRows){
        return $this->field('goods_id,goods_name,goods_price,goods_number,goods_small_logo,sale_time,is_show')->limit($firstRow.','.$listRows)->select();   
     }

     // 上传图片处理，并生成缩略图操作
     public function upload(){
        
        // 判断如果有文件上传并上传文件完整
        if( $_FILES['goods_big_logo']['error'] == 0 ){
        
          // 图片上传处理
          $config = array( 
            'maxSize' => 3145728,  // 上传文件大小  1MB = 1024Kb  1G = 1024MB 1kb = 1024Bety
            'rootPath' => './Public/Uploads',  // 保存图片的根路径
            'savePath' => '/Goods/',           // 保存路径
            'exts' => array('jpg', 'gif', 'png', 'jpeg'), // 上传图片类型
          );
          $Upload = new \Think\Upload($config);
          $info = $Upload->uploadOne($_FILES['goods_big_logo']);
          $src = $info['savepath'] . $info['savename']; // 大图
          
          // 生成缩略图
          $Image = new \Think\Image();
          $Image->open('./Public/Uploads' . $src );
          $thumb = $info['savepath'] . 'm_' . $info['savename'];
          $Image->thumb(220,220,2)->save('./Public/Uploads' . $thumb );
          $data['src'] = $src;  // 源图
          $data['thumb'] = $thumb; //缩略图
          return $data;
        }
     }

  }