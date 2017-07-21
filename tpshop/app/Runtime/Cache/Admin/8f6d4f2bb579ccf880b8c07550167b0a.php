<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加管理员</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">管理员</a></li>
            <li>添加</li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle"><span>基本信息</span></div>
        <form action="<?php echo U('add');?>" method="post">
            <ul class="forminfo">
                <li>
                    <label>登录帐号</label>
                    <input name="username" placeholder="请输入登录帐号" type="text" class="dfinput" />
                </li>
                <li>
                    <label>角色</label>
                    <select name="role_id" class="dfinput">
                        <?php if(is_array($RoleList)): $i = 0; $__LIST__ = $RoleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["role_id"]); ?>"><?php echo ($vo["role_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>                
                <li>
                    <label>登录密码</label>
                    <input name="password" placeholder="请输入登录密码" type="password" class="dfinput" />
                </li>      
                <li>
                    <label>&nbsp;</label>
                    <input id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
//jQuery代码
$(function(){
    //给btnsubmit绑定点击事件
    $('#btnSubmit').on('click',function(){
        //表单提交
        $('form').submit();
    })
});
</script>
</html>