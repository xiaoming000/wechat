<?php
require "../public.php";

$appid = "wx70b222a95832e8b1";
$time = time();
$fun = new PublicFunction();
$nonceStr = $fun -> get_rand_code(16);
// 获取票据
$jsapi_tiket = $fun -> get_jsapi_tiket();
// 获取当前文件的url
if(isset($_SERVER['HTTPS'])){
	$url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];		
}else{
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}	
// 利用签名算法生成$signature
$string1 = "jsapi_ticket=".$jsapi_tiket."&noncestr=".$nonceStr."&timestamp=".$time."&url=".$url;
$signature = sha1($string1);
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
	
	<button onclick="choose();">选择图片</button>
	<div id="imgs" data-imgs=""></div>

	<script type="text/javascript">
		wx.config({
		    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		    appId: '<?php echo $appid ?>', // 必填，公众号的唯一标识
		    timestamp: '<?php echo $time ?>', // 必填，生成签名的时间戳
		    nonceStr: '<?php echo $nonceStr ?>', // 必填，生成签名的随机串
		    signature: '<?php echo $signature ?>',// 必填，签名
		    jsApiList: [
		    	'chooseImage'
			], // 必填，需要使用的JS接口列表
		});

		function  choose(){
			var imgs_div = document.getElementById('imgs');	
			wx.chooseImage({
				success: function (res) {
					var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
					// 注意localIds其实是一个对象
					var imgs = localIds.toString().split(',');
					for (var i = 0; i < imgs.length; i++) {
						var img = document.createElement('img');
						img.src = imgs[i];
						imgs_div.appendChild(img);
					}
				}
			});
		}

	</script>

</body>
</html>