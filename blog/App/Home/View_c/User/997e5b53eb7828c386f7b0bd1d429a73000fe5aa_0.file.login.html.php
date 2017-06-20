<?php
/* Smarty version 3.1.29, created on 2017-05-08 15:39:41
  from "D:\amp\apache\htdocs\blog\App\Home\View\User\login.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_591020bda74b69_49549244',
  'file_dependency' => 
  array (
    '997e5b53eb7828c386f7b0bd1d429a73000fe5aa' => 
    array (
      0 => 'D:\\amp\\apache\\htdocs\\blog\\App\\Home\\View\\User\\login.html',
      1 => 1494229177,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../Public/header.html' => 1,
  ),
),false)) {
function content_591020bda74b69_49549244 ($_smarty_tpl) {
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>圣骑士个人博客</title>
<meta name="keywords" content="个人博客,圣骑士个人博客,周洋老师个人博客,响应式" />
<meta name="description" content="个人博客,圣骑士个人博客,周洋老师个人博客,响应式，神秘、俏皮。" />
<link href="<?php echo @constant('CSS_DIR');?>
/base.css" rel="stylesheet">
<link href="<?php echo @constant('CSS_DIR');?>
/index.css" rel="stylesheet">
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
    <div class="banner">
      <ul class="texts">
        <p>The best life is use of willing attitude, a happy-go-lucky life. </p>
        <p>最好的生活是用心甘情愿的态度，过随遇而安的生活。</p>
      </ul>
    </div>
    <div class="bloglist">
      <h2>
        <p><span>会员</span>登录</p>
      </h2>
      <div>
        <form method="POST" action="index.php?p=Home&c=User&a=dealLogin">
          <p>会员名：<input type="text" name="user_name">*请填写您的用户名</p>       
          <p>密  码：<input type="password" name="pass">*请填写您的密码</p> 
          <p><input type="submit" value="点击登录"></p>       
        </form>
      </div>
    </div>
  </article>
  <aside>
    <div class="avatar"><a href="about.html"><span>关于zhouyang</span></a></div>
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
    
    <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
  <?php echo '<script'; ?>
>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];<?php echo '</script'; ?>
>
    
     <div class="tj_news">
      <h2>
        <p class="tj_t1">最新文章</p>
      </h2>
      <ul>
        <?php
$_from = $_smarty_tpl->tpl_vars['newArt']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_0_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['row']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$__foreach_row_0_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
        <li><a href="index.php?p=Home&c=Article&a=show&art_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['art_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
</a></li>
        <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
?>
      </ul>
      <h2>
        <p class="tj_t2">推荐文章</p>
      </h2>
      <ul>
        <?php
$_from = $_smarty_tpl->tpl_vars['rmdArtByHits']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_1_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['row']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$__foreach_row_1_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
        <li><a href="index.php?p=Home&c=Article&a=show&art_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['art_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
</a></li>
        <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_1_saved_local_item;
}
if ($__foreach_row_1_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_1_saved_item;
}
?>
      </ul>
    </div>
    <div class="links">
      <h2>
        <p>友情链接</p>
      </h2>
      <ul>
        <li><a href="/">zhouyang个人博客</a></li>
        <li><a href="http://bbs.itcast.cn">传智播客论坛</a></li>
      </ul>
    </div>
    <div class="copyright">
      <ul>
        <p> Design by <a href="/">圣骑士</a></p>
        <p>粤ICP备11002373号-1</p>
        </p>
      </ul>
    </div>
  </aside>
  <div class="clear"></div>
  <!-- 清除浮动 --> 
</div>
</body>
</html><?php }
}
