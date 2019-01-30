<?php

require "../public.php";

// 2、通过code换取网页授权access_token（与基础支持中的access_token不同）
function get_user_info(){
	// 获取code后，请求以下链接获取access_token：  https://api.weixin.qq.com/sns/oauth2/access_token?appid=
	// APPID&secret=SECRET&code=CODE&grant_type=authorization_code
	$appid = "wx70b222a95832e8b1";
	$secret = "afef21cf29c9e17c60c58ea37a210aa2";
	$code = $_GET['code'];
	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
	$fun = new PublicFunction();
	$res = $fun -> http_curl($url);
	var_dump($res);
}


// 运行
get_user_info();