<?php
namespace Admin\Controller;
use Admin\Controller\CommenController;
class GoodsController extends CommonController {
    public function index() {
        $Goods = D('Goods');
        //获取所有的商品总数
        $count = $Goods->count();
        //获取所有的数据总数
        $this->count = $count;
        //实例化分页类[分页数据的总数，每一页显示的数据量]
        $Page = new \Think\Page($count, 3);
        $Page->setConfig('prev', 'Up');
        $Page->setConfig('next', 'Dm');
        $this->style = $Page->show(); //分页样式代码
        //获取分页数据
        // $this->list=$Goods->field('goods_id,goods_name,goods_price,goods_number,goods_small_logo,sale_time,is_show')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->list = $Goods->getList($Page->firstRow, $Page->listRows);
        $this->display();
    }
    public function add() {
        //创建模型对象
        $Goods = D('Goods');
        //判断是否post提交的数据
        if (IS_POST) {
            // dump($_POST);die;
            /*
            if():
                          这部分可以不用了 直接使用模型来处理就可以了
                      $data['goods_name'] = I("post.goods_name");
                    $data['goods_price'] = I("post.goods_price");
                    $data['goods_number'] = I("post.goods_number");
                    $data['goods_weight'] = I("post.goods_weight");
                    $data['goods_introduce'] = filterXSS($_POST['goods_desc']);
            
                    //验证
                    $info = array(
                        'goods_name' => $data['goods_name']
                    );
                    $res = $Goods->where($info)->find( array("fetch_mysql"=>true));
                    if( $res ){
                        $this->error("商品名称已经存在");
                    }
                     endif;
            */
            //配置并且实例化文件上传操作类
            $config = array('maxSize' => 8388608, // 上传文件的最大限制
            'rootPath' => './Public/Uploads/', // 上传文件的保存根目录
            'savePath' => '/Goods/', 'exts' => array('jpg', 'gif', 'png', 'jpeg'),);
            $Upload = new \Think\Upload($config);
            //进行上传文件处理
            $info = $Upload->upload();
            $_POST['goods_big_logo'] = $info['goods_big_logo']['savepath'] . $info['goods_big_logo']['savename'];
            //生成缩略图
            $Image = new \Think\Image();
            //打开原图
            $Image->open($config['rootPath'] . $_POST['goods_big_logo']);
            //指定缩略图的保存路径
            $_POST['goods_small_logo'] = $info['goods_big_logo']['savepath'] . "m_" . $info['goods_big_logo']['savename'];
            //生成缩略图并指定保存的位置
            $Image->thumb(220, 220, 2)->save($config['rootPath'] . $_POST['goods_small_logo']);
            if (!$Goods->create()):
                $this->error($Goods->getError(), '', 5);
                die;
            endif;
            //添加数据到Goods表中
            $res = $Goods->add($data);
            if ($res) {

                //获取属性
                $data = I('post.');
                //只有在添加商品成功的时候才能获取goodsid
                $result = D('GoodsAttribute')->addAll($res, $data);

                if( !$result ){
                    $this->error( D('GoodsAttribute')->getError() );die;
                }

                $this->success('添加商品成功', U('index'), 3); //3秒跳转
                die;
            } else {
                $this->error('添加商品失败!错误:' . $Goods->getError(), '', 3); //3秒，并且显示错误信息
                
            }
        }

        //获取所有的商品类型
        $this->typeList=D('GoodsType')->select();
        $this->display();
    }
    /*
     * 这个是多图上传的方法
    */
    public function photos() {
        //获取gid
        $this->gid = I('get.gid', 0, 'intval');
        if ($this->gid == 0) {
            $this->error('非法请求！请重新确认！');
        }
        //把每一个商品相关信息存储到goods_photos表中
        $GoodsPhotos = D('GoodsPhotos'); //商品相册的模型
        if (IS_POST) {
            //配置并且实例化文件上传操作类
            $config = array('maxSize' => 3145728, // 上传文件的最大限制
            'rootPath' => './Public/Uploads/', // 上传文件的保存根目录
            'savePath' => '/Goods/', 'exts' => array('jpg', 'gif', 'png', 'jpeg'),);
            //实例化文件上传操作类
            $Upload = new \Think\Upload($config);
            $info = $Upload->upload();
            $data = []; //创建一个数组来保存上村成功后的文件路径
            $Image = new \Think\Image();
            /*
                             功能就是给每一个上传的图片都增加缩略图
                             多个图片就循环来搞
                                 先通过拼接来获取图片的保存路径，然后通过路径来打开图片，生成缩略图
            */
            //通过循环来获取图片地址
            foreach ($info as $item):
                //保存图片地址 存在src数组中
                $src = $item['savepath'] . $item['savename'];
                $data['src'] = $src;
                //打开图片
                $Image->open($config['rootPath'] . $src);
                //指定保存的缩略图地址
                $thumb = $item['savepath'] . "m_" . $item['savename'];
                $Image->thumb(220, 220, 2)->save($config['rootPath'] . $thumb);
                $data['thumb'] = $thumb;
                $data['goods_id'] = $this->gid; //商品ID 
                // var_dump($data);die;
                $res = $GoodsPhotos->add($data); 
                if (!$res) {
                    $this->error("商品图片添加有误!");
                    die;
                }
            endforeach;
        }
        //最后根据商品的id来获取相对应的所有图片
         
        $where = array('goods_id' => $this->gid);
        $this->list = $GoodsPhotos->where($where)->select();
        $this->display();
    }

    /*
        删除图片
     */
        public function delPhoto(){ 
            $GoodsPhotos = D('GoodsPhotos');
            if( IS_AJAX ){//判断是否ajax操作
                //删除操作
                // echo I('get.photo_id');
                //然后根据id来删除照片 
                $id = I('get.photo_id'); 

                echo $GoodsPhotos->delPhoto($id);

                // $res = $GoodsPhotos->delete($id);//删除对应ID的照片

                //     //如果删除成功的话就把缩略图页删除了
                //     if( $res ){
                //         //先获取路径
                //         $src = './Public/Uploads' . $info['src'];
                //         $thumb = './Public/Uploads' . $info['thumb'];

                //         //再判断一下文件是不是存在
                //         if( file_exists( $src ) ){
                //             unlink( $src );
                //         }

                //         if( file_exists( $thumb ) ){
                //             unlink( $thumb );
                //         }
                //     }

                // echo $res;
            }
        }

        //删除商品 
        public function del(){
            $id = I('get.gid', 0, 'intval');
            if( !$id ){
                $this->error("非法参数!");die;
            }

            //根据id删除商品
            $Goods = D('Goods');

            $info =$Goods->find($id); 

            $res = $Goods->delete($id);

            if( $res ){
                 //如果删除成功的话就把缩略图页删除了           
                //先获取路径
                $src = './Public/Uploads' . $info['goods_big_logo'];//大图
                $thumb = './Public/Uploads' . $info['goods_small_logo'];//小图

                //再判断一下文件是不是存在
                if( file_exists( $src ) ){
                    unlink( $src );
                }

                if( file_exists( $thumb ) ){
                    unlink( $thumb );
                }              

                //接着把相册里面相关的照片删除
                $GoodsPhotos = D('GoodsPhotos');
                $photos_id = $GoodsPhotos->field('photo_id')->where('goods_id = ' . $id)->select();

                //通过循环来删除
                foreach($photos_id as $item){
                    $GoodsPhotos->delPhoto( $item['photo_id'] );
                }
            
                $this->success('删除成功！', U('index'), 3);
            }else{
                $this->error('删除失败！');
            }


        }

        //编辑商品 
        public function edit(){
            $Goods = D('Goods');
            
            if( IS_POST ){

            $fileinfo = $Goods->upload();  
            /*
                如果更新成功
                    1.获取到大小图的路径
                    2.删除大小图
                    3.把新图的路径存入数据库
             */ 
            if($fileinfo){
                $big_logo = './Public/Uploads' . I('post.goods_big_logo');
                $small_logo = './Public/Uploads' . I('post.goods_small_logo');
                
                 if(file_exists($big_logo)){
                      unlink($big_logo);
                   }

                 if(file_exists($small_logo)){
                    unlink($small_logo);
                 }


                    //先上存，然后把路径写入数据库
                    $_POST['goods_big_logo'] = $fileinfo['src'];
                    $_POST['goods_small_logo'] = $fileinfo['thumb'];

            }
           

                // $data = I('post.');
                if(!$Goods->create()){
                    //create会自动判断，如果提交过来的数据存在主键就会自动更新
                    //否则就是新增操作
                    $this->error( $Goods->getError() );
                }

                //存储数据
                $res = $Goods->save();

                if( $res ){
                    $this->success('修改成功！', U('index'), 3);die;
                }else{
                    $this->error('修改失败！');die;
                }
            }

            $this->gid = I('get.gid', 0, 'intval'); 
            $this->info = $Goods->find( $this->gid );
            
            $this->display();
        }


        /*
            根据对应的type_id来获取指定的商品类型的所有属性
         */
        public function getAttr(){

            //判断是否是ajax请求   
            if( IS_AJAX ){
                $type_id = I('type_id', 0, 'intval');
                // echo $type_id;
                //查询所有属性
                if( $type_id > 0 ){
                    $data = D('Attribute')->getAll($type_id);

                    echo json_encode( $data );
                }
            }
        }


}
