<?php

	return array(
			//定义文本回复模板
	"text" =>  "<xml>
		      <ToUserName><![CDATA[%s]]></ToUserName>
		     <FromUserName><![CDATA[%s]]></FromUserName>
		     <CreateTime>%s</CreateTime>
		     <MsgType><![CDATA[%s]]></MsgType>
		     <Content><![CDATA[%s]]></Content>
		     <FuncFlag>0</FuncFlag>
		      </xml>",
	//定义图片回复模板	      
             "image" => "<xml>
		         <ToUserName><![CDATA[%s]]></ToUserName>
		         <FromUserName><![CDATA[%s]]></FromUserName>
		         <CreateTime>%s</CreateTime>
		        <MsgType><![CDATA[%s]]></MsgType>
		       <Image>
		      <MediaId><![CDATA[%s]]></MediaId>
		      </Image>
	                  </xml>",

	//定义音乐的回复模板
           "music"=>"<xml>
		    <ToUserName><![CDATA[%s]]></ToUserName>
		    <FromUserName><![CDATA[%s]]></FromUserName>
		    <CreateTime>%s</CreateTime>
		    <MsgType><![CDATA[%s]]></MsgType>
		    <Music>
		    <Title><![CDATA[%s]]></Title>
		    <Description><![CDATA[%s]]></Description>
		    <MusicUrl><![CDATA[%s]]></MusicUrl>
		    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
		    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
		    </Music>
		    </xml>",

         //定义图文模板
         "news" => "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<ArticleCount>%s</ArticleCount>
		<Articles>
		 %s
		</Articles>
		</xml>"
		);