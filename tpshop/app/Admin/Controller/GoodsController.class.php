<?php
  namespace Admin\Controller;
  use Admin\Controller\CommonController;
  class GoodsController extends CommonController{
    // 商品列表
    public function index(){
      $Goods = D('Goods');

      // 获取所有的商品总数
      $count = $Goods->count();
      
      // 实例化分页类[分页数据的总数,每一页显示的数据量]
      $Page = new \Think\Page($count,3);
      $Page->setConfig('prev','Up');
      $Page->setConfig('next','Dm');
      $this->style = $Page->show(); // 分页样式的代码

      // 获取分页的数据
      // $this->list = $Goods->field('goods_id,goods_name,goods_price,goods_number,goods_small_logo,sale_time,is_show')->limit($Page->firstRow.','.$Page->listRows)->select();
      $this->list = $Goods->getList( $Page->firstRow,$Page->listRows );

      $this->count = $count; // 数据总数

      $this->display('showList');
    }

    // 添加商品
    public function add(){      
      // 判读是否post提交的数据 
      if( IS_POST ){
        // 判断是否有文件上传
        if( !$_FILES['goods_big_logo']['error'] ){
          // 配置并实例化文件上传操作类
          $config = array(
              'maxSize' => 8388608,               // 上传文件的最大值
              'rootPath' => './Public/Uploads/',  // 上传文件的保存根目录[不会自动创建]
              'savePath' => '/Goods/', //  上传文件的保存路径[会自动创建，并组装路径返回到结果]
              'exts' => array('jpg', 'gif', 'png', 'jpeg'), 
          );
          $Upload = new \Think\Upload($config);
    
          // 进行上传文件处理
          $info = $Upload->upload();

          // 判断图片上传处理成功以后
          if( $info ){
             $_POST['goods_big_logo'] = $info['goods_big_logo']['savepath'] . $info['goods_big_logo']['savename'];

             // 生成缩略图
             $Image = new \Think\Image();
             // 打开源图
             $Image->open( $config['rootPath'] . $_POST['goods_big_logo'] );
             // 指定缩略图的保存路径
             $_POST['goods_small_logo'] =  $info['goods_big_logo']['savepath'] . 'm_' . $info['goods_big_logo']['savename'];

             // 生成缩略图并指定保存的未知
             $Image->thumb(220,220,2)->save( $config['rootPath'] . $_POST['goods_small_logo']); // 缩放填充
          
          }else{
            $this->error( $Upload->getError(),'',5 );die;
          }

        }

        $Goods = D('Goods');
        // 接收$_POST数据并帮我们验证
        if( !$Goods->create() ){
          $this->error( $Goods->getError() );
        }
    
        // 添加数据到Goods表中
        $res = $Goods->add();
        if( $res ){
          // 对属性存储入库，我们声明一个模型方法来完成属性的批量条件
          // 自定义一个方法，addAll
          $data = I('post.'); // 这里就是 $_POST的数据
          $result = D('GoodsAttribute')->addAll( $res, $data );
          
          // 如果属性失败，则直接返回错误信息
          if( !$result ){
            $this->error( D('GoodsAttribute')->getError() );die;
          }
          // 添加商品成功的跳转操作
          $this->success('添加商品成功！',U('index'),3 );die();
        }else{
          $this->error('添加商品失败！错误：'. $Goods->getError(), '', 3 );
        }

      }

      // 获取所有的商品类型
      $this->type_list = D('GoodsType')->select();
      // dump( $this->type_list );
      $this->display();
    }

    // 根据对应的type_id，获取指定的商品类型的所有属性
    public function getAttr(){
      // 判断是否是ajax请求
      if( IS_AJAX ){

        $type_id = I('type_id',0,'intval');
        if( $type_id > 0 ){
          $data = D('Attribute')->getAll($type_id);
          echo json_encode( $data );
          // $this->ajaxReturn( $data );
        }
      }
    
    }

    // 删除商品
    public function del(){
      // 接收商品ID
      $id = I('get.gid',0,'intval');
      if( !$id ){
        $this->error('非法参数！');die;
      }

      // 根据对应的id进行数据删除
      $Goods = D('Goods');
      // 删除数据之前，先把商品的图片地址获取到
      $info = $Goods->find($id);

      // 删除数据
      $res = $Goods->delete($id);
      if( $res ){
        // 数据删除成功以后，顺便把商品表中记录的商品图片也删掉
        $src   = './Public/Uploads/' . $info['goods_big_logo']; // 大图
        $thumb = './Public/Uploads/' . $info['goods_small_logo']; // 小图

        // 判断图片是否存在，如果存在则使用unlink删除
        if( file_exists($src) ){
          unlink( $src );
        }
        if( file_exists( $thumb ) ){
          unlink( $thumb );
        }

        // 删除商品相册中对应商品的图片
        $GoodsPhotos = D('GoodsPhotos'); // 商品相册的模型

        $photos_id   = $GoodsPhotos->field('photo_id')->where( 'goods_id = ' . $id )->select();
        
        foreach( $photos_id as $item ){
          $GoodsPhotos->delPhoto( $item['photo_id'] );
        }

        $this->success('删除成功！',U('index'),3);
      }else{
        $this->error('删除失败！');
      }
    }

    // 编辑商品数据
    public function edit(){
      $Goods = D('Goods');
      
      if( IS_POST ){ // 如果有post数据则进行数据存储操作

        // 文件上传处理
        $fileinfo = $Goods->upload();
        
        // 上传文件如果成功，则删除旧图并保存新图的地址
        if($fileinfo){
          // 删除掉原有的图片
          $big_logo = './Public/Uploads'. I('post.goods_big_logo');
          $small_logo = './Public/Uploads'. I('post.goods_small_logo');
          if( file_exists( $big_logo ) ){
            unlink($big_logo);
          }
          
          if( file_exists( $small_logo ) ){
            unlink($small_logo);
          }

          $_POST['goods_big_logo']   = $fileinfo['src'];   // 大图
          $_POST['goods_small_logo'] = $fileinfo['thumb']; // 小图
        }
        // 在create中，有一个判断，如果提交上来的数据存在主键ID，则默认是 更新操作
        // 如果提交上来的数据，没有主键ID，则默认是 新增操作
        if(!$Goods->create()){
          $this->error( $Goods->getError() );
        }

        // 存储数据
        $res = $Goods->save();

        if( $res ){
          $this->success('修改成功！',U('index'),3);die;

        }else{
          $this->error('修改失败！');die;
        }

      }

      // 接收商品ID
      $this->gid = I('get.gid',0,'intval');

      // 查询出当前商品的信息
      $this->info = $Goods->find( $this->gid );
      $this->display();
    
    }

    // 商品相册
    public function photos(){
      // dump( intval( 'insert into' ) );die;  // intval 专门把数据转换为 整数
      $this->gid = I('get.gid',0,'intval'); // 接收当前商品相册的商品ID
      if( $this->gid == 0 ){
        $this->error('非法请求！请重新确认！');
      }
      
      $GoodsPhotos = D('GoodsPhotos'); // 商品相册的模型

      if(IS_POST){
        // 进行文件上传处理
        // 判断上传过来的文件是否完整 
        $config = array( 
          'maxSize' => 3145728,  // 上传文件大小  1MB = 1024Kb  1G = 1024MB 1kb = 1024Bety
          'rootPath' => './Public/Uploads',  // 保存图片的根路径
          'savePath' => '/Goods/',           // 保存路径
          'exts' => array('jpg', 'gif', 'png', 'jpeg'), // 上传图片类型
        );
        // 实例化文件上传操作类
        $Upload = new \Think\Upload( $config );
        $info = $Upload->upload(); // upload方法负责对上传文件进行处理
        $data = [];  // 声明一个空的数组，用来存储上传成功以后的文件存储路径
        
        $Image = new \Think\Image();
        foreach($info as $item){
          // 上传图片的地址，存储在 src数组中
          $src = $item['savepath'] . $item['savename'];
          $data['src'] = $src;  // 源图路径

          // 打开要生成缩略图的地址['./Public/Uploads/' . '/Goods/2017-06-13/' . 文件名 ]
          $Image->open( $config['rootPath'] . $src );
          // 指定保存的缩略图的路径
          $thumb = $item['savepath'] . 'm_' . $item['savename'];
          $Image->thumb(220,220,2)->save( $config['rootPath'] . $thumb );
          $data['thumb'] = $thumb;  // 缩略图
          $data['goods_id'] = $this->gid; // 商品ID

          // 把每一个商品相关信息存储到 goods_photos表中
          $res = $GoodsPhotos->add($data);
          if( !$res ){
            $this->error('商品图片添加有误！');die;
          }
        }
      }
      // 根据对应的商品ID($this->gid) 获取所有的商品图片
      $this->list = $GoodsPhotos->where('goods_id = '. $this->gid )->select();
      $this->display();
    }

    // ajax删除商品相册里面的图片
    public function delPhoto(){
      $GoodsPhotos = D('GoodsPhotos');
      if( IS_AJAX ){  // 判断是否ajax请求
        // 接收ajax发送过来的 photo_id
        $id = I('get.photo_id',0,'intval');
        
        echo $GoodsPhotos->delPhoto($id);

        // // 删除之前，先把图片读取出来
        // $info = $GoodsPhotos->find($id);

        // // 删除操作
        // $res = $GoodsPhotos->delete($id); // 删除数据

        // // 如果成功删除数据，则把本地存储的图片也顺便清理掉
        // if( $res ){
        //   // 删除操作，如果删除的图片不存在，会报错
        //   $src   = './Public/Uploads' . $info['src'];   // 源图
        //   $thumb = './Public/Uploads' . $info['thumb']; // 缩略图
          
        //   // file_exists($src) && unlink( $src );
        //   if( file_exists($src) ){  //删除源图
        //     unlink( $src );
        //   }
  
        //   if( file_exists( $thumb ) ){ // 删除缩略图
        //     unlink( $thumb );
        //   }

        // }
        // echo $res;
      }
    }

  }