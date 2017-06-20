<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>编辑</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />

    <link href="/Public/Admin/time/calendar.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/time/calendar.js"></script>

    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/editor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/editor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/editor/lang/zh-cn/zh-cn.js"></script>
    <style type="text/css">
        .textinput2{
            width: 800px;
            height: 370px; 
            border:none;
        } 

        /*鼠标点击才有的下边框样式*/
        .formtitle span.current{
            border-bottom:solid 3px #66c9f3; 
        }

        .formtitle span{
            position:static;
            margin-right:5px;
            cursor:pointer;
            border:none;
        }

        .calendar .nav{
            float: none;
        }

        .forminfo .add,     /*+号的样式*/
        .forminfo .div{     /*-号的样式*/
            font-size: 16px;
            margin-right: 10px;
            cursor: pointer;
        } 
        
         .forminfo{
            display: none;
        }
        .forminfo:first-child{
            display: block;
        }
    </style>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle">
             <span class="current">基本信息</span>
             <span>商品描述</span>
             <!-- <span>商品相册</span> -->
        </div>
       <form action="<?php echo U('edit');?>" method="post" enctype="multipart/form-data">
        <ul class="forminfo">
            <li>
                <label>商品名称</label>
                <input name="title" value="<?php echo ($info["goods_name"]); ?>" placeholder="请输入商品名称" type="text" class="dfinput"><i>名称不能超过30个字符</i>
            </li>
            <li>
                <label>商品价格</label>
                <input name="goods_price" value="<?php echo ($info["goods_price"]); ?>"  placeholder="请输入商品价格" type="text" class="dfinput"><i></i>
            </li>
            <li>
                <label>商品数量</label>
                <input name="goods_number" value="<?php echo ($info["goods_number"]); ?>" placeholder="请输入商品数量" type="text" class="dfinput">
            </li>
            <li>
                <label>商品重量</label>
                <input name="goods_weight" value="<?php echo ($info["goods_weight"]); ?>" placeholder="请输入商品重量" type="text" class="dfinput">
            </li>
            <li>
                <label>商品图片</label>
                <input type="file" name="goods_big_logo">
            </li> 
            <li>
                <label>是否上架</label>
                <cite>
                    <input name="is_show" type="radio" value="1" <?php if($info['is_show'] == 1): ?>checked<?php endif; ?> />上架
                     <input name="is_show" type="radio" value="0" <?php if($info['is_show'] == 0): ?>checked<?php endif; ?> />下架
                </cite>
            </li>
            <li>
                <label>添加时间</label>
                <input name="created_time" value="<?php echo (date('Y-m-d H:i:s',$info["created_time"])); ?>" id="created_time" placeholder="请输入添加时间" type="datetime" class="dfinput">
            </li> 
            </ul>

            <ul class="forminfo">
                <li>
                    <label>商品描述</label>
                    <textarea id="goods_desc" name="goods_desc" placeholder="请输入商品描述" cols="" rows="" class="textinput textinput2"></textarea>
                </li>              
             </ul>

            <!-- <ul class="forminfo  goods_photos" style="display: none;">
                <li>
                    <span class="add">[ + ]</span>
                    <input type="file" name="goods_photos[]" multiple>
                </li>              
             </ul> -->
             <ul>
                 <li>
                    <label></label>
                    <input type="hidden" name="goods_id" value="<?php echo ($info["goods_id"]); ?>">
                    <input type="hidden" name="goods_small_logo" value="<?php echo ($info["goods_small_logo"]); ?>">
                    <input type="hidden" name="goods_big_logo" value="<?php echo ($info["goods_big_logo"]); ?>">
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存">
                </li>
             </ul>
    </form>
    </div>
</body>

  <!-- 富文本编辑器 -->
<!-- <script id="goods_desc" type="text/plain" style="width:1024px;height:500px;"></script>
 -->
<script type="text/javascript">
    //实例化编辑器 通过id去指定某个元素
    var ue = UE.getEditor('goods_desc',{
        initialFrameWidth:800
        ,initialFrameHeight:250
    });

    $('.formtitle span').click(function(){
            $(this).addClass('current').siblings().removeClass('current');
            $('.forminfo').eq( $(this).index() ).show().siblings('.forminfo').hide();
    });

    //初始化时间选择器
    Calendar.setup({
        inputField  :   "created_time",//要使用时间选择器的元素
        ifFormat    :   "%Y-%m-%d %H:%M:%S",//时间的格式
        showsTime   :   true,
        timeFormat  :   "24"  //时制
    });

    //使用jq复制上传文本框
    $('.forminfo').on('click', '.add', function(e){
        $(e.target).parent().clone()//克隆span的父对象
        .find('span')//找到里面的span标签
        .removeClass('add').addClass('div').html('[ - ]')//设置span内容
        .parent().appendTo('.goods_photos');//把li追加到ul 
    });

    //使用jq动态删除文件上传框
    $('.forminfo').on('click', '.div', function(e){
        $(e.target).parent().remove();
    });
</script>
</html>