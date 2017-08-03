
<?php
/**
  * wechat php test
  */

require 'Wechat.class.php';
//define your token
define("TOKEN", "weixin"); 
#$wechatObj->valid();

class wechatCallbackapiTest extends Wechat
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){
              	  //把客户端传输过来的数据一律转化成为simplexml的对象
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                //代表客户端的微信账号（openid）
                $fromUsername = $postObj->FromUserName;
                //代表微信的公众平台的服务器id
                $toUsername = $postObj->ToUserName;
                //客户端提交上来的关注信息，比如：约么
                $keyword = trim($postObj->Content);

                //接受用户发送过来的数据类型
                $sendType = $postObj->MsgType;  
                $Event = $postObj->Event; //获取订阅方式类型
                //提交时所产生时间信息，默认是个Unix时间戳
                $time = time();

 
                //引入回复的xml模板文件
                $xmlTpl =  include( "tpl/xmlTpl.php" );
                /*由于我们需要接收用户发送过来数据类型分别是什么，所以不许对单独keyword进行判断，因此接收用户发送一切消息*/ 


                

              if( $keyword=='丽江小倩'){
                        /*由于我们需要接收用户发送过来数据类型分别是什么，所以不许对单独keyword进行判断，因此接收用户发送一切消息*/
                       $replyType = "image"; //定义回复的类型
                       //这个mediaid要换成我们编写的php接口返回的mediaID
                       $mediaId = "RCHsuoNso_2Bb3a-Hpzif3Rx9LBjOajknmLwOYrcccKBM09g0OBorXHtP_JlXiPo"; 
                       //使用sprintf函数把内容加载到xml模板当中
                        $resultStr = sprintf($xmlTpl[$replyType], $fromUsername, $toUsername, $time, $replyType, $mediaId );
                        //把内容组合后用xml的方式进行输出，相当用xml的格式进行了回复（响应）
                        echo $resultStr;
                        exit();
                }

                 //如果微信客户端有用户问“您好”我们就调用客服消息发送接口
                if( $keyword== "您好" ){
                    //由于该类继承了Wechat的基础类，所以可以使用$this调用get_access_token方法
                    $access_token = $this -> get_access_token("wx7ac3d581b020b234","ff1708f6c59746d0dca3e2557cba83d1");
                    //组合客服发送信息接口的数据
                    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
                    //定义客服的文本消息回复内容,由于我们发送的数据是通过url传递，为防止中文产生乱码，建议使用urlencode进行编码
                    $content  = urlencode("亲，您需要什么帮助吗?");
                    $data = array(
                                "touser" => "{$fromUsername}" , //把数据设置还给微信客户端
                                "msgtype"=>"text",//文本消息类型
                                "text" => array(
                                        "content"=> $content,//定义客服的文本消息回复内容
                                ),
                    );
                    //由于发送消息接口只接收json数据，所以我们需要把数组转化为json字符
                    $data = json_encode($data);
                    //由于我们进行urlencode的编码，所以我们在传递的时候就需要解码
                     $data = urldecode($data);
                    //使用curl的post提交方式
                   $this -> https_request( $url , $data );
                    exit(); //终止后面的代码进行运行
                }

                  //如果有玩家问37客服，关于攻城的攻略问题，问："游戏攻略"，客服就会回复图文并茂的攻略信息给玩家
                if( $keyword== "游戏攻略" ){
                    //由于该类继承了Wechat的基础类，所以可以使用$this调用get_access_token方法
                    $access_token = $this -> get_access_token("wx7ac3d581b020b234","ff1708f6c59746d0dca3e2557cba83d1");
                    //组合客服发送信息接口的数据
                    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
                    //定义客服的图文消息回复内容,由于我们发送的数据是通过url传递，为防止中文产生乱码，建议使用urlencode进行编码
                    //定义第1个攻略的内容
                    $content_1 = array(
                         "title"=>urlencode("攻城需要耐心等待，找靠谱队友"),
                         "description"=>urlencode("攻城还需要充值"),
                         "url"=>"http://www.37.com",
                         "picurl"=>"http://moluo.net/images/1.jpg",
                    );
                    //定义第2个攻略的内容
                    $content_2 = array(
                         "title"=>urlencode("攻城需要善于出卖队友"),
                         "description"=>urlencode("攻城需要有厉害的装备"),
                         "url"=>"http://www.baidu.com",
                         "picurl"=>"http://moluo.net/images/4.jpg",
                    );
                    //组合数据
                    $set = array($content_1,$content_2);
                    //组合发送的数据
                    $data = array(
                             "touser"=>"{$fromUsername}",
                              "msgtype"=>"news",
                              "news" => array(
                                    "articles" => $set,
                                ),
                    );
                    //由于发送消息接口只接收json数据，所以我们需要把数组转化为json字符
                    $data = json_encode($data);
                    //由于我们进行urlencode的编码，所以我们在传递的时候就需要解码
                     $data = urldecode($data);
                    //使用curl的post提交方式
                   $this -> https_request( $url , $data );
                    exit(); //终止后面的代码进行运行
                }             

                if( $sendType == 'location' )
                {
                    $replyType = 'text';
                    $lat = $postObj->Location_X;
                    $lng = $postObj->Location_Y;

                    $url = "http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location={$lat},{$lng}&output=json&pois=1&ak=KLVPlO6HGkab7KxEQg1MEHbxmC18aH8W";

                    $address = $this-> https_request($url);
                    $adr = json_decode($address, true);
                    $pois_address='';
                    foreach( $adr['result']['pois'] as $pois )
                    {
                        $pois_address .= $pois['name']."\n";
                    }

                    $contentStr = "你当前所在的纬度{$lat},经度{$lng}，详细地址：" . $adr['result']['formatted_address'];

                   $resultStr = sprintf($xmlTpl[$replyType], $fromUsername, $toUsername, $time, $replyType, $contentStr );

                   echo $resultStr;
                }


                if( !empty($keyword) )
                {
                    $replyType = 'text';
                    $url="http://www.tuling123.com/openapi/api?key=1b6f4b18d70141068939c838639b7d08&info={$keyword}";
                    $data = $this->https_request($url);
                    $json = json_decode($data);
                    $contentStr = $json->text;
                    $resultStr = sprintf($xmlTpl[$replyType], $fromUsername, $toUsername, $time, $replyType, $resultStr ); 
                    echo $resultStr;
                }



                

        }else {
        	echo "";
        	exit;
        }
    }

	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

//由于您引入Wechat类，然后wechatCallbackapiTest继承WeChat，为了放置代码的顺序发生逻辑性错误，所以我们把顺序调整
//把实例声明和自动回复的代码方法wechatCallbackapiTest声明之后
//该对象就是微信公众开发的api对象
$wechatObj = new wechatCallbackapiTest();
//对微信公众号和开发者账户的服务器进行通讯时发生验证的过程，如果做测试，微信公众号是不会传递任何的签名验证的
//所以在测试的时候必须注释掉
//$wechatObj->valid();
//开启自动回复功能
$wechatObj -> responseMsg();

?>
