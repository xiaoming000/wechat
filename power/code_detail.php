<?php

// 通过access_token获取用户信息这里主要就是更改scope为snsapi_userinfo
class GetCode{

	// 获取随机数state, 最多128个字节
	public function get_state($num){
		$resource = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N','O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'S', 'Y', 'Z',
			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
			);
		$len = count($resource);
		$result = '';
		for ($i=0; $i < $num; $i++) { 
			$result.= $resource[rand(0, $len-1)];
		}
		return $result;
	}

	// 1、引导用户进入授权页面同意授权，获取code
	public function get_code(){
		// https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI
		// &response_type=code&scope=SCOPE&state=STATE#wechat_redirect 
		// 若提示“该链接无法访问”，请检查参数是否填写错误，是否拥有scope参数对应的授权作用域权限
		$appid = "wx70b222a95832e8b1";
		$redirect_uri = urlencode("http://wechat.dmfly.xin/power/userinfo_detail.php");
		$scope = "snsapi_userinfo";
		$state = $this->get_state(16);
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";

		header('location:'.$url);
	}


	// 3、如果需要，开发者可以刷新网页授权access_token，避免过期

	// 4、通过网页授权access_token和openid获取用户基本信息（支持UnionID机制）

} // class end

// 运行
$code = new GetCode();
$code -> get_code();