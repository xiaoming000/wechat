<?php

require "response.php";
require "meau.php";

$response = new Response();

$run = new Index();

class Index{

    // 入口函数
    public function __construct(){

        $nonce     = $_GET['nonce'];
        $token     = 'xiaoming000';
        $timestamp = $_GET['timestamp'];
        $echostr   = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str  == $signature && $echostr ){
            //第一次接入weixin api接口的时候
            echo  $echostr;
            exit;
        }else{
            // 定义菜单
            $meau = new Meau();            
            $meau -> definedItem();
            // 消息回复
            $this -> responseMsg();  
        } 
             
    } // index() end

    // 消息返回
    public function responseMsg(){

        //1.获取到微信推送过来post数据（xml格式）
        //$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];//php7开始不支持
        $postArr = file_get_contents("php://input"); 
        //2.处理消息类型，并设置回复类型和内容
        $postObj = simplexml_load_string( $postArr );
        global $response;

        //判断该数据包是否是订阅的事件推送
        if (strtolower($postObj->MsgType) == 'event') {
            //如果是关注 subscribe事件
            if (strtolower($postObj->Event) == 'subscribe') {
                $info = array(
                    'toUser' => $postObj->FromUserName,
                    'fromUser' => $postObj->ToUserName,
                    'time' => time(),
                    'msgType' => 'text',
                    'content' => '欢迎关注我的微信公众号！'
                );
                $response -> res_text($info);
            }// if end
        }//if end

        // 菜单click事件触发
        if( strtolower($postObj->Event) == 'click'){
            $meau = new Meau(); 
            $meau -> meau_res($postObj);
        }

        // 判断该数据是否是用户发送的文本消息
        if (strtolower($postObj->MsgType) == 'text'){
            $response -> res_user_msg($postObj);
        }// if end

    } // responseMsg() end

} // class end


