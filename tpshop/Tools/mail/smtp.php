<?php
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
//PHPMailer需要使用到时间，所以需要设置时区
date_default_timezone_set('Etc/UTC');


//引入文件
//require '../PHPMailerAutoload.php';
require "./class.smtp.php";
require "./class.phpmailer.php";

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
$mail->SMTPDebug = 2;


//设置邮件格式编码
$mail->CharSet'utf-8';


//Ask for HTML-friendly debug output 调试信息使用html
$mail->Debugoutput = 'html';

//Set the hostname of the mail server 邮局地址
$mail->Host = "mail.example.com"; 

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
$mail->addAddress('1393816162@qq.com', '新用户');


//Set the subject line
// 邮件标题
$mail->Subject = '找回密码';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML('邮件的内容<br><a href="http://www.baidu.com">点击找回密码</a>');


//当邮箱不识别HTML的时候，替换文本
$mail->AltBody = 'This is a plain-text message body';


//Attach an image file 这里是附件，也不一定是图片
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "邮件发送失败！信息: " . $mail->ErrorInfo;
} else {
    echo "邮件发送成功！";
}
