<?php

require "public.php";


class Templates{
	// http请求方式: POST
	// https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=ACCESS_TOKEN
	public function send_template($openid, $name){
		$arr = array(
			"touser"=>$openid,
			"template_id"=>"7D5ybniJpsoxq8NXi-09MWPm7qhNBrCYhyoIXrMiPts",
			"url"=>"http://weixin.qq.com/download",
			"data"=>array(
				'name'=>array('value'=>$name, 'color'=>"#173177")
			)
		);
		$fun = new PublicFunction();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$fun->getWxAccessToken();
		$res = $fun -> http_curl($url, 'post', 'json', json_encode($arr));
		var_dump($res);
	}
}

$temp = new Templates();
$openid = "oyfLo1Uh9dhVXb6uEYkYM1bmdqt0";
$name = "xiaoxiaoming";
$temp -> send_template($openid, $name);