<?php

require "public.php";


// http请求方式: POST
// URL: https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=TOKEN
// POST数据格式：json
// POST数据例子：{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}

// 或者也可以使用以下POST数据创建字符串形式的二维码参数：
// {"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "test"}}}
$fun = new PublicFunction();
$access_token = $fun -> getWxAccessToken();
$url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$access_token;
$res = $fun -> http_curl($url);
// var_dump($access_token);
$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
$arr = array(
	"expire_seconds" => 604800,
	"action_name" => "QR_SCENE",
	"action_info" => array(
		"scene" => array(
			"scene_id" => 123	
		) 	
	)
);
$post_arr = json_encode($arr);
$res = $fun -> http_curl($url, 'post', 'json', $post_arr);
// var_dump($res);
// 通过ticket换取二维码
$ticket = $res['ticket'];
$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
// $res = $fun -> http_curl($url);
// var_dump($res);
echo '<img src="'.$url.'" />';
// 永久二维码就是post数组上不一样
