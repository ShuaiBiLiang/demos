<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" /> 

    <link href="/Public/Admin/lightbox/css/lightbox.css" rel="stylesheet" type="text/css" /><!-- 灯箱样式 -->

    <script src="/Public/Admin/js/jquery.js"></script>

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

        .photos_list li{
            float: left;
            border: 1px solid #ccc;
            padding: 4px;
            margin:2px;
            text-align: center;
        }

        .photos_list li img{
            width: 60px;
        }

        .photos_list li .del_photo{
            font-size :18px;
            cursor: pointer;
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
            <ul class="photos_list">
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                        <span class="del_photo" data-id="<?php echo ($vo["photo_id"]); ?>">[ - ]</span><br>
                        <a href="/Public/Uploads/<?php echo ($vo["src"]); ?>" data-title="肥扎" data-lightbox="肥扎">                   
                            <img src="/Public/Uploads/<?php echo ($vo["thumb"]); ?>" alt="" />
                        </a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
	       <form action="" method="post" enctype="multipart/form-data"> 	            
	            <ul class="forminfo  goods_photos">
	                <li>
	                    <span class="add">[ + ]</span>
	                    <input type="file" name="goods_photos[]" multiple>
	                </li>              
	             </ul>
	             <ul>
	                 <li>
	                    <label> </label>
	                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存">
	                </li>
	             </ul>
	    </form>
        
    </div>
</body> 
<script type="text/javascript">
    

    $('.formtitle span').click(function(){
            $(this).addClass('current').siblings().removeClass('current');
            $('.forminfo').eq( $(this).index() ).show().siblings('.forminfo').hide();
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

     $('.del_photo').click(function(){

        var _this = $(this);

        var id=$(this).attr('data-id');//获取当前的id 也就是照片的id
        $.get('<?php echo U("Goods/delPhoto");?>',{'photo_id':id},function(res){
            //通过ajax发送照片的id到后台就可以根据照片id来删除对应的照片
            if(res){
                _this.parent().remove();
            }else{
                alert('删除失败！');
            }
        });
     });

</script>
<!-- 灯箱js -->
<script language="JavaScript" src="/Public/Admin/lightbox/js/lightbox-plus-jquery.js"></script>
</html>