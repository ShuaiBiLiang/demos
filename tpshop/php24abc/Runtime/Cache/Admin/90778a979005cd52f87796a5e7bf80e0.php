<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
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
             <span>商品属性</span>
        </div>
       <form action="<?php echo U('add');?>" method="post" enctype="multipart/form-data">
        <ul class="forminfo">
            <li>
                <label>商品名称</label>
                <input name="title" placeholder="请输入商品名称" type="text" class="dfinput"><i>名称不能超过30个字符</i>
            </li>
            <li>
                <label>商品价格</label>
                <input name="goods_price" placeholder="请输入商品价格" type="text" class="dfinput"><i></i>
            </li>
            <li>
                <label>商品数量</label>
                <input name="goods_number" placeholder="请输入商品数量" type="text" class="dfinput">
            </li>
            <li>
                <label>商品重量</label>
                <input name="goods_weight" placeholder="请输入商品重量" type="text" class="dfinput">
            </li>
            <li>
                <label>添加时间</label>
                <input name="created_time" id="created_time" placeholder="请输入添加时间" type="datetime" class="dfinput">
            </li>
            <li>
                <label>商品图片</label>
                <input type="file" name="goods_big_logo">
            </li>  
            </ul>

            <ul class="forminfo">
                <li>
                    <label>商品描述</label>
                    <textarea id="goods_desc" name="goods_desc" placeholder="请输入商品描述" cols="" rows="" class="textinput textinput2"></textarea>
                </li>              
             </ul>

            <ul class="forminfo goods_attr" style="display: none;">
                <li>
                    <label>商品类型</label>
                    <select name="type_id" class="dfinput">
                        <option value="0">请选择商品的类型</option>
                        <?php if(is_array($typeList)): $i = 0; $__LIST__ = $typeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["type_id"]); ?>"><?php echo ($vo["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>  
                    </select>
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
    $('.goods_attr').on('click', '.add', function(e){
        var newLi = $(this).parents('.newItem')
                           .clone()
                           .find('span')
                           .html('[ - ]')
                           .removeClass('add').addClass('div')
                           .parents('.newItem');

                           $(this).parents('.newItem').after(newLi);
    });

    //使用jq动态删除文件上传框
    $('.goods_attr').on('click', '.div', function(e){
        $(this).parents('li').remove();
        // console.log($(this).parents('li'));
    });


    //选择不同的商品类型然后获取相对应的商品属性
    $('select[name=type_id]').change(function(){

        var cur = $(this).val();//获取选中的value
        
        if( cur == '0' ){ 
        //如果是0就是没有选择，就阻止事件执行
            return false;
        }
        $('.newItem').remove();
        var _this = $(this);

        //并且使用get方法，把type_id发送到后台
        $.get("<?php echo U('Goods/getAttr');?>",{'type_id':cur},function(msg){ 
            // console.log(msg);
            var html = '';

            $(msg).each(function(key, value){
                if( value.attr_sel == 0 ){
                    // console.log('唯一属性，需要单行文本框录入');
                    html += "<li class='newItem'>";
                    html += "<label>" + value.attr_name + "</label>";
                    html += "<input type='hidden' name='attr_ids[]' value='"+value.attr_id+"' />";
                    html += "<input type='text' class='dfinput' name='attr_value[]' placeholder='请输入" + value.attr_name + "' /><i></i></li>";
                }else{
                    // console.log('单选属性，需要下拉列表框选择');
                    var vals = value.attr_vals.split(',');
                    // console.log(vals);
                    html += "<li class='newItem'>";
                    html += "<input type='hidden' name='attr_ids[]' value='"+value.attr_id+"' />";
                    html +="<label><span class='add'>[+]</span>" + value.attr_name + "</label>";
                    html +="<select name='attr_value[]' class='dfinput'>";
                    for (var i = 0; i < vals.length; i++) {
                        html +="<option value = '" + vals[i] + "'>请选择" + vals[i] + "</option>";
                    }
                    html +="</select>";
                    html +="</li>";
                }
            });

            _this.parent().after(html);
        },'json');
    });
</script>
</html>