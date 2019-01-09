<?php

require "public.php";

class Meau{

    /* 创建自定义菜单*/
    public function definedItem(){

        // 实例化公共方法
        $pub_func = new PublicFunction();

        header('content-type:text/html;charset=utf-8');
        $access_token = $pub_func -> getWxAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
        $postArr = array(
            'button' => array(
                    array(
                        'name' => urlencode('菜单一'),
                        'type' => 'click',
                        'key' => 'item1',
                    ),//第一个一级菜单
                    array(
                        'name' => urlencode('菜单二'),
                        'sub_button' => array(
                            array(
                                'name' => urlencode('歌曲'),
                                'type' => 'click',
                                'key' => 'songs',
                            ),//第一个二级菜单
                            array(
                                'name' => urlencode('电影'),
                                'type' => 'view',
                                'url' => 'http://www.baidu.com',
                            ),//第二个二级菜单
                        ),
                    ),//第二个一级菜单
                    array(
                        'name' => urlencode('菜单三'),
                        'type' => 'view',
                        'url' => 'http://www.qq.com',
                    ),//第三个一级菜单
                ),
            );
        // 编码转换
        $postJson = urldecode(json_encode($postArr));
        $res = $pub_func->http_curl($url,'post','json',$postJson);
        // echo "<hr>";
        // var_dump($res);
    } // definedItem() end

    /**
     *  菜单事件处理
     * $postObj 微信平台获取的对象化的xml数据
     */
    public function meau_res($postObj){

        $info = array(
            'toUser' => $postObj->FromUserName,
            'fromUser' => $postObj->ToUserName,
            'time' => time(),
            'msgType' => 'text',
        );             
        $key = $postObj->EventKey;
        if(strtolower($key == 'item1')){
            $info['content'] = "这是item1菜单的事件推送";
        }elseif(strtolower($key == 'songs')){
            $info['content'] = "这是歌曲菜单的事件推送";
        } else {
            $info['content'] = '未匹配'.print_r($postObj->EventKey, true);
        }
        // 纯文本消息回复
        $response = new Response();
        $response -> res_text($info); 

    } // meau_res() end

} // class end

// $item = new Meau();
// $item -> definedItem();