<?php
session_start();

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
        $error = curl_error($ch);
        // 关闭
        curl_close($ch);
        if ($res = 'json') {
            if ($error) {
                // 请求发生错误，返回错误信息
                return $error;
            }else{
                // 请求正确返回结果
                return json_decode($output, true);
            }       
        }
    }// html_curl() end

    private function get_new_access_token(){
        $appid = 'wx70b222a95832e8b1';
        $appsecret = 'afef21cf29c9e17c60c58ea37a210aa2';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $res = $this -> http_curl($url, 'get', 'json');
        $access_token = $res['access_token'];
        // 将获取到的access_token放到session中
        $_SESSION['access_token'] = $access_token;
        $_SESSION['expire_time'] = time() + 7000;
        return $access_token;
    } // get_new_access_token() end

    /* 将access_token存储在session中 */
    public function getWxAccessToken(){

        if ($_SESSION['access_token'] && $_SESSION['expire_time'] > time()) {
            // $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$_SESSION['access_token'];
            // $res = $this -> http_curl($url);
            // if (isset($res['errcode'])  && $res['errcode'] == 40001) {
            //      $this -> get_new_access_token();
            // }else{
            //     return $_SESSION['access_token'];
            // }
            return $_SESSION['access_token'];
            // 其实这种获取acces_token会出现一种情况就是access_token未过期失效的情况，但是如果每次返回检查是否失效在效率上有所降低
        }else{
            // 如果access_token不存在或者已经过期
            $this -> get_new_access_token();
        }
    }// getWxAccessToken() end

    // 获取随机数state, 最多128个字节
    public function get_rand_code($num){
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
    } // get_rand_code() end

    // 获取jsapi-tiket
    public function get_jsapi_tiket(){
        if ($_SESSION['jsapi_tiket_access_token'] && $_SESSION['jsapi_tiket_expire_time'] > time()) {
            return $_SESSION['jsapi_tiket_access_token'];
        }else{
            // 如果jsapi_tiket_access_token不存在或者已经过期
            $access_token = $this -> getWxAccessToken();
            // https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
            $res = $this -> http_curl($url, 'get', 'json');
            $access_token = $res['ticket'];
            // 将获取到的access_token放到session中
            $_SESSION['jsapi_tiket_access_token'] = $access_token;
            $_SESSION['jsapi_tiket_expire_time'] = time() + 7000;
            return $access_token;
        } 
    } // get_jsapi_tiket() end  

}// class end

// $puc_func = new PublicFunction();
// var_dump($puc_func -> get_jsapi_tiket());