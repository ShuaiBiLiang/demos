<?php
namespace Admin\Model;
use Think\Model;
class GoodsPhotosModel extends Model{
	/*
		删除相册图片  
	 */
		public function delPhoto($id){ 
			$info = $this->find($id);

			$res = $this->delete($id);//删除对应ID的照片

			//如果删除成功的话就把缩略图页删除了
			if( $res ){
				//先获取路径
				$src = './Public/Uploads' . $info['src'];
				$thumb = './Public/Uploads' . $info['thumb'];

				//再判断一下文件是不是存在
				if( file_exists( $src ) ){
					unlink( $src );
				}

				if( file_exists( $thumb ) ){
					unlink( $thumb );
				}
			}

			return $res;
		}
}