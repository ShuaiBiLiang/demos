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
            <li><a href="#">类型属性</a></li>
            <li><a href="#">属性列表</a></li>
        </ul>
    </div>
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar">
                <li><a href="<?php echo U('GoodsAttr/add',array('type_id'=>$type_id));?>"><span><img src="/Public/Admin/images/t01.png" /></span>添加属性</a></li>
<!--                 <li><span><img src="/Public/Admin/images/t02.png" /></span>修改</li>
                <li><span><img src="/Public/Admin/images/t03.png" /></span>删除</li>
                <li><span><img src="/Public/Admin/images/t04.png" /></span>统计</li> -->
            </ul>
        </div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>编号</th>
                    <th>属性名称</th>
                    <th>所属类型</th>
                    <th>唯一/单选</th>
                    <th>录入方式</th>
                    <th>可选值列表</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td><?php echo ($vo["attr_id"]); ?></td>
                    <td><?php echo ($vo["attr_name"]); ?></td>
                    <td><?php echo ($vo["type_name"]); ?></td>
                    <td><?php if($vo["attr_sel"] == 0): ?>唯一<?php else: ?>单选<?php endif; ?></td>
                    <td><?php if($vo["attr_write"] == 0): ?>手动录入<?php else: ?>从列表中选择<?php endif; ?></td>
                    <td><?php echo ($vo["attr_vals"]); ?></td>
                    <td><a href="#" class="tablelink">查看</a> <a href="#" class="tablelink"> 删除</a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
<!--                 <tr>
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td>1</td>
                    <td>cpu</td>
                    <td>手机</td>
                    <td>唯一</td>
                    <td>手动录入</td>
                    <td></td>
                    <td><a href="#" class="tablelink">查看</a> <a href="#" class="tablelink"> 删除</a></td>
                </tr>
                <tr>
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td>1</td>
                    <td>cpu</td>
                    <td>手机</td>
                    <td>唯一</td>
                    <td>手动录入</td>
                    <td></td>
                    <td><a href="#" class="tablelink">查看</a> <a href="#" class="tablelink"> 删除</a></td>
                </tr>
                <tr>
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td>1</td>
                    <td>cpu</td>
                    <td>手机</td>
                    <td>唯一</td>
                    <td>手动录入</td>
                    <td></td>
                    <td><a href="#" class="tablelink">查看</a> <a href="#" class="tablelink"> 删除</a></td>
                </tr> -->
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
</body>

</html>