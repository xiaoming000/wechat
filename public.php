<?php


class PublicFunction{

    /*
    *curl连接
    *$url 请求url string
    *$method 请求类型，默认为get string
    *$res 数据返回类型，默认为json string
    *$arr post请求数据,默认为空 string
     */
    public function http_curl($url, $method='get',$res='json',$arr=''){
        // 初始化curl
        $ch = curl_init();
        // 设置curl参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        // 采集
        $output = curl_exec($ch);
        // 关闭
        curl_close($ch);
        if ($res = 'json') {
            if (curl_error($ch)) {
                // 请求发生错误，返回错误信息
                return curl_error($ch);
            }else{
                // 请求正确返回结果
                return json_decode($output, true);
            }       
        }
    }// html_curl() end

    /* 将access_token存储在session中 */
    public function getWxAccessToken(){
        if ($_SESSION['access_token'] && $_SESSION['expire_time'] > time()) {
            return $_SESSION['access_token'];
        }else{
            // 如果access_token不存在或者已经过期
            $appid = 'wx70b222a95832e8b1';
            $appsecret = 'afef21cf29c9e17c60c58ea37a210aa2';
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $res = $this -> http_curl($url, 'get', 'json');
            $access_token = $res['access_token'];
            // 将获取到的access_token放到session中
            $_SESSION['access_token'] = $access_token;
            $_SESSION['expire_time'] = time() + 7000;
            return $access_token;
        }
    }// getWxAccessToken() end

}// class end

// $puc_func = new PublicFunction();
// var_dump($puc_func -> getWxAccessToken());