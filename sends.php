<?php

require "public.php";


class SendsMessage{

	// 预览接口
	public function sends_test($str){
		// 		http请求方式: POST
		// https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=ACCESS_TOKEN
		$arr = array(     
		    "touser"=>"oyfLo1Uh9dhVXb6uEYkYM1bmdqt0",
		    "text"=>array( "content"=>$str),     
		    "msgtype"=>"text"
		);
		$fun = new PublicFunction();		
		$url = "https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=".$fun->getWxAccessToken();
		$res = $fun -> http_curl($url, 'post', 'json', json_encode($arr));
		var_dump($res);
	} // sends_test end

} // class end

$send = new SendsMessage();
$send -> sends_test("test!");