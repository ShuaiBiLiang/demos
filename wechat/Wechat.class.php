<?php
class Wechat
{

	public function https_request( $url,$data = null )
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);

			if( !empty($data) )
			{
				@curl_setopt($ch, CURLOPT_POST, 1);
				@curl_setopt($ch, CURLOPT_POSTFIELDS, $data);				
			}

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);

			$str = curl_exec($ch);
			curl_close($ch);

			return $str;
		}

		//由于access_token在微信的开发当中，也有很多地方需要使用，所以可以把access_token的获取也封装成一个函数
function get_access_token($appid,$secret)
	{
		//组合生成access_token的请求url地址
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
		$access_token = $this->https_request( $url );
		//把access_token的json格式转化为json对象
		$json = json_decode($access_token);
		//返回json对象中的access_token的值
		return $json->access_token;
	}

}
// //声明一个Wechat的实例
// $wechat = new Wechat();
// //获取access_token
// $access_token = $wechat -> get_access_token("wx7ac3d581b020b234","ff1708f6c59746d0dca3e2557cba83d1");
// //组合多媒体上传接口的链接数据，由于我们需要上传是一张图片所以type设置image
// $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=image";
// //相当于生成一个这样的@E:\wamp\www\gqml.jpg的路径，因为我们需要把客户端的东西上传微信端，而我们的微信公众平台是一个媒体服务器，他需要使用一种@符号进行上传，明白这个道理就就行了，不需要纠结
// $data['media'] = '@'.dirname(__FILE__)."\xq.jpg"; 
// //使用post的curl方式进行提交
// $str = $wechat -> https_request( $url , $data );
// //把返回的结果进行输出
// echo $str;
// 
// 
//声明一个Wechat的实例
$wechat = new Wechat();
//获取access_token
$access_token = $wechat -> get_access_token("wx7ac3d581b020b234","ff1708f6c59746d0dca3e2557cba83d1");
//组合二维码ticket的生成链接
$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
//定义二维码的相关参数
$scene_id = 1000 ; //二维码的id,你可以随便定义为正整型，这个参数也是整个生成的二维码ticket当中最重要的参数
$data = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id":'. $scene_id.'}}}';
//接收请求回来的ticket数据(json)
$str = $wechat -> https_request($url,$data);
//把json数据转为对象
$json = json_decode($str);
//打印ticket
$ticket = $json -> ticket;

//使用ticket换取二维码的api链接
$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={$ticket}";
//获取图片的二进制流
$str = $wechat -> https_request($url);
//使用file_put_contents把二进制流转化成为图片
file_put_contents("qrcode.jpg", $str);