<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".click").click(function() {
            $(".tip").fadeIn(200);
        });

        $(".tiptop a").click(function() {
            $(".tip").fadeOut(200);
        });

        $(".sure").click(function() {
            $(".tip").fadeOut(100);
        });

        $(".cancel").click(function() {
            $(".tip").fadeOut(100);
        });

    });
    </script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">数据表</a></li>
            <li><a href="#">基本内容</a></li>
        </ul>
    </div>
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar">
                <li><a href="<?php echo U('add');?>">
                    <span><img src="/Public/Admin/images/t01.png" /></span>添加
                </a></li>
                <!--
                <li><span><img src="/Public/Admin/images/t02.png" /></span>修改</li> 
                <li><span><img src="/Public/Admin/images/t03.png" /></span>删除</li>
                <li><span><img src="/Public/Admin/images/t04.png" /></span>统计</li>
                 -->
            </ul>
        </div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>编号</th>
                    <th>类型名称</th>
                    <th>操作</th>
                </tr>

            </thead>
            <tbody>
                <?php if(is_array($data['list'])): $i = 0; $__LIST__ = $data['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </td>
                    <td><?php echo ($vo["type_id"]); ?></td>
                    <td><?php echo ($vo["type_name"]); ?></td>
                   <td>
                         <a href="<?php echo U('GoodsAttr/index',array('type_id'=>$vo['type_id']));?>" class="tablelink">属性列表</a> 
                        <a href="<?php echo U('editType',array('type_id'=>$vo['type_id']));?>" class="tablelink">编辑</a> 
                        <a href="<?php echo U('delType',array('type_id'=>$vo['type_id']));?>" class="tablelink"> 删除</a>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                
            </tbody>
        </table>
         <style type="text/css">
                .paginList a,
                .paginList span{
                    float: left;
                    width: 31px;
                    height: 28px;
                    border: 1px solid #DDD;
                    text-align: center;
                    line-height: 30px;
                    border-left: none;
                    color:#3399d5;
                }

                .paginList .current{
                    background: #d5d5d5;
                    cursor: default;
                    color:#737373;
                }
            </style>
                <div class="paginList">
                    <?php echo ($data["style"]); ?>
                </div>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
</body>

</html>