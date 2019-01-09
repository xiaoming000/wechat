<?php

class Response{

	// 消息函数
	/*<xml>
	<ToUserName><![CDATA[toUser]]></ToUserName>
	<FromUserName><![CDATA[fromUser]]></FromUserName>
	<CreateTime>12345678</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[你好]]></Content>
	</xml>*/
	public function res_user_msg($postObj){

	    $info = array(
	             'toUser' => $postObj->FromUserName,
	             'fromUser' => $postObj->ToUserName,
	             'time' => time()
	           );
	    // 发送纯文本消息
	    $res_text_msg = array(

	        '1' => '<a href="http://www.xiaoxiaoming.net/">个人博客，欢迎阅读！</a>'

	    );
	    // 发送图文消息
	    $res_pic_msg = array(

	        'wx' => array(
	            array()
	        )
	    
	    );
	    // 发送图文消息
	    $res_article = array(

	        'article_test' => array(
	        
	            array(
	                    'title'=>'MongoDB的优劣势',
	                    'description'=>"什么情况下选择MongoDB？",
	                    'picUrl'=>'https://mmbiz.qpic.cn/mmbiz_jpg/evOoWdxqPS3FabKwKqfhR86sibicEB5ZYUqVpmVo9L3kpXdjgPbicplZBiblUQ42jgONLbE8E4MM27av1IqibqwHQCg/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1&wx_co=1',
	                    'url'=>'https://mp.weixin.qq.com/s/O2R0X-3hw7K3deEXGDdBLA',
	                ),
	        ),

	    );
	    

	    // 文本消息遍历    
	    foreach($res_text_msg as $key=>$value){
	        if(trim($postObj->Content) == $key){
	            $info['content'] = $value;
	            $info['msgType'] = 'text';
	            $this -> res_text($info);
	        }
	    }// foreach end
	    // 图文消息
	    foreach($res_article as $key=>$value){
	        if(trim($postObj->Content) == $key){
	            $info['msgType'] = 'news';
	            $info['content'] = $value;
	            $this -> res_article($info);
	        }
	    }//foreach end
	    
	}// res_user_msg() end

	// 发送纯文本信息
	public function res_text($info){
	    $template = "<xml>
	        <ToUserName><![CDATA[%s]]></ToUserName>
	        <FromUserName><![CDATA[%s]]></FromUserName>
	        <CreateTime>%s</CreateTime>
	        <MsgType><![CDATA[%s]]></MsgType>
	        <Content><![CDATA[%s]]></Content>
	        </xml>";
	    $res = sprintf($template, $info['toUser'], $info['fromUser'], $info['time'], $info['msgType'], $info['content']);
	    echo $res;
	    

	}// res_text() end


	// 发送图片信息
	public function res_pic($info){

	    echo "";

	}

	// 回复图文消息
	public function res_article($info){
	    
	    $template = "<xml>
	        <ToUserName><![CDATA[%s]]></ToUserName>
	        <FromUserName><![CDATA[%s]]></FromUserName>
	        <CreateTime>%s</CreateTime>
	        <MsgType><![CDATA[%s]]></MsgType>
	        <ArticleCount>".count($info['content'])."</ArticleCount>
	        <Articles>";

	    foreach($info['content'] as $key=>$value){

	        $template .="<item>
	                <Title><![CDATA[".$value['title']."]]></Title>
	                <Description><![CDATA[".$value['description']."]]></Description>
	                <PicUrl><![CDATA[".$value['picUrl']."]]></PicUrl>
	                <Url><![CDATA[".$value['url']."]]></Url>
	          </item>";   
	 
	    }
	    $template .= "</Articles>
	        </xml>";
	     
	    $res = sprintf($template, $info['toUser'], $info['fromUser'], $info['time'], $info['msgType']);
	    echo $res;

	}// res_article end

}

