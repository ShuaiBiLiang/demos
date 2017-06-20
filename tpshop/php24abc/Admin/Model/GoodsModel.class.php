<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
	//字段映射
	//隐藏真实的数据表字段，防止一些恶意的用户猜测我们的数据表字段
	protected $_map = array(
		'title' => 'goods_name',
	);
	//自动完成【二维数组，每一个子数组，就是一个字段的自动完成设置】
	protected $_auto = array(
		array('created_time', 'mytime', 1, 'callback'),
		array('updated_time', 'time', 3, 'function'),
	);
	 //自动验证【二维数组，每一个子数组，就是一个字段的验证规则集合】
	 protected $_validate = array(
	 	array('goods_name', 'require', '商品名称必须填写'),
	 	array('goods_name', '', '该商品已经存在!', 1, 'unique', 3),
	 );

	//判断一下 如果有填时间就使用用户填写的时间
	//如果没有填写时间就自动获取当前时间来填入数据库	
	 protected function mytime($data=null){
	 	if( $data ): 
	 		return strtotime($data);
	 	endif;	 	 	 	
	    return time();
	 }

	 //封转一个分页的方法
	 public function getList($firstRow, $listRows){
	 		return $this->field('goods_id,goods_name,goods_price,goods_number,goods_small_logo,sale_time,is_show')->limit($firstRow .','. $listRows)->select();
	 }

	  public function upload(){
            if($_FILES['goods_big_logo']['error'] == 0){
                //图片上传处理 
                $config = array(
                    'maxSize' => 3145728, // 上传文件的最大限制
                    'rootPath' => './Public/Uploads/', //   上传文件的保存根目录
                    'savePath' => '/Goods/', 
                    'exts' => array('jpg', 'gif', 'png', 'jpeg'),
                    //实例化文件上传操作类
                ); 
            	 $Upload = new \Think\Upload($config);
      			$info = $Upload->uploadOne($_FILES['goods_big_logo']);
     			 $src = $info['savepath'] . $info['savename']; // 大图

                 //生成缩略图
                 //打开图片
                 $Image = new \Think\Image();
                $Image->open('./Public/Uploads' . $src);
                //指定保存的缩略图地址
                $thumb = $info['savepath'] . "m_" . $info['savename'];
                $Image->thumb(220, 220, 2)->save('./Public/Uploads' . $thumb);
                $data['src'] = $src;
                $data['thumb'] = $thumb;

                return $data;
            }
        }
}