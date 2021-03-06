<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>修改商品</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <!-- 引入富文本编辑器 -->
    <script type="text/javascript" charset="utf-8" src="/Public/editor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/editor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/editor/lang/zh-cn/zh-cn.js"></script>
    <!-- 引入时间选择器 -->
    <script src="/Public/Admin/timer/calendar.js"></script>
    <link rel="stylesheet" href="/Public/Admin/timer/calendar.css" />
    <style>
        .textinput2{
            width: 800px;
            height: 300px;
            border: none;
        }
        .formtitle span.current{ /* 第一个span标签默认选中，有下边框 */
            border-bottom: solid 3px #66c9f3;
        }
        .formtitle span{
            position: static; /* 静态定位，position的默认值，也就是不定位了 */
            margin-right: 4px;
            border: none;
            cursor: pointer;
        }
        .forminfo{
            display: none;
        }
        .forminfo:first-child{
            display: block;
        }
        .calendar .nav{ /* 解决时间选择器的样式冲突 */
            float: none;
        }
        .forminfo .add, /* +号的样式 */
        .forminfo .div{ /* -号的样式 */
            font-size: 16px;
            margin-right: 10px;
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
        <div class="formtitle">
            <span class="current">基本信息</span>
            <span>商品描述</span>
            <!-- <span>商品相册</span> -->
        </div>
        <form action="<?php echo U('edit');?>" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>商品名称</label>
                    <input name="title" value="<?php echo ($info["goods_name"]); ?>" placeholder="请输入商品名称" type="text" class="dfinput" /><i>名称不能超过30个字符</i></li>
                <li>
                    <label>商品价格</label>
                    <input name="goods_price" value="<?php echo ($info["goods_price"]); ?>" placeholder="请输入商品价格" type="text" class="dfinput" /><i></i></li>
                <li>
                    <label>商品数量</label>
                    <input name="goods_number" value="<?php echo ($info["goods_number"]); ?>" placeholder="请输入商品数量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品重量</label>
                    <input name="goods_weight" value="<?php echo ($info["goods_weight"]); ?>" placeholder="请输入商品重量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品图片</label>
                    <input name="goods_big_logo" type="file"/>
                </li>                
                <li>
                    <label>添加时间</label>
                    <input name="created_time" value="<?php echo (date('Y-m-d H:i:s',$info["created_time"])); ?>" id="created_time" type="datetime" class="dfinput" />
                </li>                
                <li>
                    <label>是否上架</label>
                    <cite>
                        <input name="is_show" type="radio" value="1" <?php if($info['is_show'] == 1): ?>checked<?php endif; ?>  />上架&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="is_show" type="radio" value="0" <?php if($info['is_show'] == 0): ?>checked<?php endif; ?> />下架</cite>
                    </li>
            </ul>
            <ul class="forminfo">
                <li>
                    <label>商品描述</label>
                    <textarea name="goods_desc" id="goods_desc" placeholder="请输入商品描述" cols="" rows="" class="textinput textinput2"><?php echo ($info["goods_introduce"]); ?></textarea>
                </li>
            </ul>
<!--             <ul class="forminfo goods_photos">
                <li>
                    <span class="add">[ + ]</span><input name="goods_photos[]" type="file"/>
                </li>
            </ul>   -->          
            <ul>
                <li>
                    <label>&nbsp;</label>
                    <input type="hidden" name="goods_id" value="<?php echo ($info["goods_id"]); ?>" />
                    <input type="hidden" name="goods_small_logo" value="<?php echo ($info["goods_small_logo"]); ?>" />
                    <input type="hidden" name="goods_big_logo" value="<?php echo ($info["goods_big_logo"]); ?>" />
                    <input id="btnSubmit" type="submit" class="btn" value="确认保存" />
                </li>
            </ul>  
        </form>
    </div>
</body>
<script>
   // 实例化富文本编辑器
   var ue = UE.getEditor('goods_desc',{
        initialFrameWidth:800  //初始化编辑器宽度,默认1000
        ,initialFrameHeight:150  //初始化编辑器高度,默认320
        , toolbars: [[ // 工具栏的定制
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',

            'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
             'preview',
        ]]
   });
   $('.formtitle span').click(function(){
       // 当前被点击的span 添加 current样式，其他的span兄弟 移除 current 样式 
       $(this).addClass('current').siblings().removeClass('current');

       // alert( $(this).index() );  // 获取当前标签的序号
       // 让和当前被点击的标签序号对应的ul显示出来，然后其他的ul隐藏掉
       $('.forminfo').eq( $(this).index() ).show().siblings('.forminfo').hide();
   });
    // 时间选择器的配置
    Calendar.setup({
       inputField     :    "created_time",  // 要使用时间选择器的 表单项的ID值
       ifFormat       :    "%Y-%m-%d %H:%M:%S",  // 时间的格式
       showsTime      :    true,
       timeFormat     :    "12"                  // 时制[12,24]
    });

    // 使用jQ动态增加相册的文件上传框
    $('.forminfo').on('click','.add',function(e){
        // 使用 e.target 获取到最初被点击的那个DOM元素
        $(e.target).parent()  // 找到 当前被点击的.add的父级元素li
                   .clone()   // 把父级元素li复制出来
                   // 把复制出来的li里面的span中的 加号 改成 - 号,并修改样式成 .div
                   .find('span').removeClass('add').addClass('div').html('[ - ]')
                   // 接下来还要把 span的父级元素找到，并追加到 相册中 
                   .parent().appendTo('.goods_photos');
        // $(e.target).parent().clone().appendTo('.goods_photos');
    });

    // 使用jQ动态删除相册的文件上传框
    $('.forminfo').on('click','.div',function(e){
        // console.log( $(e.target) );
        // 找到被点击的 .div ，然后找到 .div的父级元素，并使用remove移除掉。
        $(e.target).parent().remove();
    });
</script>
</html>