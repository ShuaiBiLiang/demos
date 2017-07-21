<?php
/*
  过滤函数
 */
function filterXSS($string){
    //相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
    require_once './Public/Admin/htmlpurifier/HTMLPurifier.auto.php';
    // 生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 以下就是配置：
    $cfg -> set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg -> set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj -> purify($string);
}

/**
 * 密码加密函数
 * @param  [string] $pwd  [要进行加密的密码]
 * @param  [string] $salt [加密的盐值]
 * @return [string]       [加密以后的密文]
 */
function password($pwd,$salt){
    return sha1( $salt. sha1($pwd) . $salt );
}


function getTree($list,$pid=0,$level=0 ) {
    static $tree = array();  // static 表示声明一个静态变量, 静态变量在函数中会一直保存它的值
    foreach($list as $row) {
        if($row['pid']==$pid) {
            $row['level'] = $level;  // 这个level是原来数组没有的，用于表示缩进的次数，
            $tree[] = $row;
            getTree($list, $row['id'], $level + 1); // 递归操作，重新把当前id传入函数中，获取当前id对应的子分类
        }
    }
    return $tree;
}


function sendSMS($user, $mobile){
 // 	 // 使用短信接口必须先引入 入口文件 TopSdk.php
 //  // date_default_timezone_set('PRC');
	// $time = 60;
 //  // $code = mt_rand(1000, 9999); 
	// $code = 'abcd'; 
 //  require './Tools/alidayu/TopSdk.php';


 //  // 接下来，我们到阿里大鱼的个人中心的应用测试把使用代码复制过来。
 //  $c = new TopClient;
 //  $c ->appkey = '24489443' ;                              // 应用ID
 //  $c ->secretKey = '6460a4dc3b5480ca27edc11e3e5aa93f';    // 应用密钥
 //  $req = new AlibabaAliqinFcSmsNumSendRequest;            // 短信发送类
 //  $req ->setExtend( "" );                                 // 备注信息，可以不填
 //  $req ->setSmsType( "normal" );                          // 短信的类型，默认是normal即可。
 //  $req ->setSmsFreeSignName( "噶扎商城" );                     // 短信签名
 //  $req ->setSmsParam( "{name:'1234'}" );    // 短信模板的参数，json格式[和模板的参数一定要对应上]
 //  $req ->setRecNum( $mobile );                       // 接收短信的手机号码
 //  $req ->setSmsTemplateCode( "SMS_71910256" );             // 短信模板的模板ID

 //  $resp = $c ->execute( $req );                           // 发送短信

 //    return $resp;

  $time = 60;   // 有效时间
      // $code = mt_rand(1000,9999); // 短信验证码 和 图片验证码几乎是一样的套路
      $code = 1234; // 短信验证码 和 图片验证码几乎是一样的套路
      session('sms_code',$code );  // 使用session保存验证码
      session('sms_time',time() ); // 使用session保存发送短信时的时间戳

      require './Tools/alidayu/TopSdk.php'; //调整路径

      // 下面这些代码都是官网复制下来的
      $c = new TopClient;
      $c ->appkey = '23460212' ;                               // 应用ID
      $c ->secretKey = '0bf80c1a52716c39959fc732b4448bdf';     // 应用密钥
      $req = new AlibabaAliqinFcSmsNumSendRequest;             // 短信发送类
      $req ->setExtend( "" );                                  // 备注信息，可以不填
      $req ->setSmsType( "normal" );                           // 短信的类型，默认是normal即可。
      $req ->setSmsFreeSignName( "墨落" );                     // 短信签名
      $req ->setSmsParam( "{code:'$code',name:'$user',time:'$time'}" );    // 短信模板的参数，json格式[和模板的参数一定要对应上]
      $req ->setRecNum( $mobile );                             // 接收短信的手机号码
      $req ->setSmsTemplateCode( "SMS_33335409" );             // 短信模板的模板ID

      $resp = $c ->execute( $req );                           // 发送短信

      // 因为函数，所以我加上了一个return 
      return $resp;
}


 
function sendMail($address, $nickname, $subject, $content){
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
//PHPMailer需要使用到时间，所以需要设置时区
date_default_timezone_set('Etc/UTC');


//引入文件
//require '../PHPMailerAutoload.php';
// require "/mail/class.smtp.php";
// require "/mail/class.phpmailer.php";
require "./Tools/mail/class.smtp.php";
require "./Tools/mail/class.phpmailer.php";

//实例化PHPMailer类
//Create a new PHPMailer instance
$mail = new PHPMailer;

//告诉PHPMailer使用SMTP发邮件
//Tell PHPMailer to use SMTP
$mail->isSMTP(); 

//Enable SMTP debugging启用调试
// 0 = off (for production use)关闭
// 1 = client messages客户端信息
// 2 = client and server messages客户端 和 服务端消息[这里的客户端指的是我们，服务端指的是网易、QQ ]
// $mail->SMTPDebug = 2;


//设置邮件格式编码
$mail->CharSet = 'utf-8';


//Ask for HTML-friendly debug output 调试信息使用html
$mail->Debugoutput = 'html';

//Set the hostname of the mail server 邮局地址
$mail->Host = "smtp.163.com"; 

//Set the SMTP port number - likely to be 25, 465 or 587端口
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;


//Username to use for SMTP authentication
$mail->Username = "18316110442@163.com";
//Password to use for SMTP authentication
$mail->Password = "php1234";

//邮件发件人[完整的邮箱地址(不管是QQ还是网易)，发件人的昵称，例如京西商城]
//Set who the message is to be sent from
$mail->setFrom('18316110442@163.com', '噶扎');
// 邮件回复人[网站的邮箱地址和昵称，一般和上面的发件人是同一个]
$mail->addReplyTo('18316110442@163.com', '噶扎');


//邮件收件人[网站的邮箱地址和昵称]
//Set who the message is to be sent to
$mail->addAddress($address, $nickname);
// $mail->addAddress('balgfi@live.cn', 'abc');

//Set the subject line
// 邮件标题
$mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($content);
// $mail->msgHTML('测试邮件');


//当邮箱不识别HTML的时候，替换文本
$mail->AltBody = 'This is a plain-text message body';


//Attach an image file 这里是附件，也不一定是图片
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
return $mail->send();
}