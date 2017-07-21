<?php
  // 商品相册模型
  namespace Admin\Model;
  use Think\Model;
  class GoodsPhotosModel extends Model{
    // 上传图片处理
    public function uploadImg(){
      // 文件上传类的配置项
      
    }

    /**
     * 删除相册图片
     * @param  $id   要删除的商品相册的主键id
     */
    
    public function delPhoto($id){
        // 删除之前，先把图片读取出来
        $info = $this->find($id);

        // 删除操作
        $res = $this->delete($id); // 删除数据

        // 如果成功删除数据，则把本地存储的图片也顺便清理掉
        if( $res ){
          // 删除操作，如果删除的图片不存在，会报错
          $src   = './Public/Uploads' . $info['src'];   // 源图
          $thumb = './Public/Uploads' . $info['thumb']; // 缩略图
          
          // file_exists($src) && unlink( $src );
          if( file_exists($src) ){  //删除源图
            unlink( $src );
          }
  
          if( file_exists( $thumb ) ){ // 删除缩略图
            unlink( $thumb );
          }
        }
        return $res;
    }
  }