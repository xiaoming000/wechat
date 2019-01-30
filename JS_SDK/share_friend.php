<?php
require "../public.php";

$appid = "wx70b222a95832e8b1";
$time = time();
$fun = new PublicFunction();
$nonceStr = $fun -> get_rand_code(16);
$jsapi_tiket = $fun -> get_jsapi_tiket();
$url = "http://wechat.dmfly.xin/JS_SDK/share_friend.php";
$string1 = "jsapi_ticket=".$jsapi_tiket."&noncestr=".$nonceStr."&timestamp=".$time."&url=".$url;
$signature = sha1($string1);
// var_dump($signature);
?>

<!DOCTYPE html>
<html>
<head>
	<title>微信分享JS接口</title>
	<meta name="viewpoint" content="initial-scale=1.0;width=device-width" />
	<meta http-equiv="content" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
</head>
<body>

	<script type="text/javascript">
		wx.config({
		    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		    appId: '<?php echo $appid ?>', // 必填，公众号的唯一标识
		    timestamp: '<?php echo $time ?>', // 必填，生成签名的时间戳
		    nonceStr: '<?php echo $nonceStr ?>', // 必填，生成签名的随机串
		    signature: '<?php echo $signature ?>',// 必填，签名
		    jsApiList: [
			    	'updateAppMessageShareData',
			    	// 'updateTimelineShareData',
			    	'onMenuShareAppMessage',
			    	// 'onMenuShareTimeline'
			    ], // 必填，需要使用的JS接口列表
		});
		wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		    wx.updateAppMessageShareData({ 
		        title: '分享给朋友！', // 分享标题
		        desc: 'js_sdk', // 分享描述
		        link: 'http://wechat.dmfly.xin/power/code.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
		        imgUrl: 'https://www.baidu.com/img/superlogo_c4d7df0a003d3db9b65e9ef0fe6da1ec.png?where=super', // 分享图标
		        // success: function () {
		        //   // 设置成功
		        //   alert("分享成功！请在右上角菜单中选择发送给朋友！");
	        	// }
	        });

		});
		// 错误处理
		wx.error(function(res){
	    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
		});

		function share_friend(){
		    wx.updateAppMessageShareData({ 
		        title: '分享给朋友！', // 分享标题
		        desc: 'js_sdk', // 分享描述
		        link: 'http://wechat.dmfly.xin/power/code.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
		        imgUrl: 'https://www.baidu.com/img/superlogo_c4d7df0a003d3db9b65e9ef0fe6da1ec.png?where=super', // 分享图标
		        success: function () {
		          // 设置成功
		          alert("分享成功！请在右上角菜单中选择发送给朋友！");
	        	}
	        });
	    }

		function share_friends(){
		    wx.updateTimelineShareData({ 
		        title: '分享到朋友圈！', // 分享标题
		        desc: 'js_sdk', // 分享描述
		        link: 'http://wechat.dmfly.xin/power/code.php', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
		        imgUrl: 'https://www.baidu.com/img/superlogo_c4d7df0a003d3db9b65e9ef0fe6da1ec.png?where=super', // 分享图标
		        success: function () {
		          // 设置成功
		          alert("分享成功！");
	        	}
	        });
	    }	    
	</script>
	<!-- <button onclick="share_friend();">分享给朋友</button><br /> -->
	<!-- <button onclick="share_friends();">分享到朋友圈</button> -->
</body>
</html>