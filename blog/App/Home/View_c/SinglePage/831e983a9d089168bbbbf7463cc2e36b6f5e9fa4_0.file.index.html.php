<?php
/* Smarty version 3.1.29, created on 2017-05-08 14:22:19
  from "D:\amp\apache\htdocs\blog\App\Home\View\SinglePage\index.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_59100e9b8dd249_29163985',
  'file_dependency' => 
  array (
    '831e983a9d089168bbbbf7463cc2e36b6f5e9fa4' => 
    array (
      0 => 'D:\\amp\\apache\\htdocs\\blog\\App\\Home\\View\\SinglePage\\index.html',
      1 => 1494224486,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../Public/header.html' => 1,
  ),
),false)) {
function content_59100e9b8dd249_29163985 ($_smarty_tpl) {
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>黑色Html5响应式个人博客模板——主题《如影随形》</title>
<meta name="keywords" content="个人博客模板,博客模板,响应式" />
<meta name="description" content="如影随形主题的个人博客模板，神秘、俏皮。" />
<link href="<?php echo @constant('CSS_DIR');?>
/base.css" rel="stylesheet">
<link href="<?php echo @constant('CSS_DIR');?>
/about.css" rel="stylesheet">
<link href="<?php echo @constant('CSS_DIR');?>
/media.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<!--[if lt IE 9]>
<?php echo '<script'; ?>
 src="js/modernizr.js"><?php echo '</script'; ?>
>
<![endif]-->
</head>
<body>
<div class="ibody">
  <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:../Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

  <article>
    <h3 class="about_h">您现在的位置是：<a href="/">首页</a>><a href="index.php?p=Home&c=SinglePage&a=index&page_id=2">关于我</a></h3>
    <div class="about">
    <?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['content'];?>

    </div>
  </article>
  <aside>
    <div class="avatar"><a href="about.html"><span>关于杨青</span></a></div>
    <div class="topspaceinfo">
      <h1>执子之手，与子偕老</h1>
      <p>于千万人之中，我遇见了我所遇见的人....</p>
    </div>
    <div class="about_c">
      <p>网名：<?php echo $_smarty_tpl->tpl_vars['masterInfo']->value['nickname'];?>
</p>
      <p>职业：<?php echo $_smarty_tpl->tpl_vars['masterInfo']->value['job'];?>
 </p>
      <p>籍贯：<?php echo $_smarty_tpl->tpl_vars['masterInfo']->value['home'];?>
</p>
      <p>电话：<?php echo $_smarty_tpl->tpl_vars['masterInfo']->value['tel'];?>
</p>
      <p>邮箱：<?php echo $_smarty_tpl->tpl_vars['masterInfo']->value['email'];?>
</p>
    </div>
	<div class="copyright">
      <ul>
        <p> Design by <a href="/">圣骑士</a></p>
        <p>粤ICP备11002373号-1</p>
        </p>
      </ul>
    </div>
  </aside>
  <?php echo '<script'; ?>
 src="js/silder.js"><?php echo '</script'; ?>
>
  <div class="clear"></div>
  <!-- 清除浮动 --> 
</div>
</body>
</html><?php }
}
