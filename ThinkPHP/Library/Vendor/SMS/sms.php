<?php

class SMS {

	public  function  sendsms($mobilephone,$mobilecode){

	header("Content-Type: text/html; charset=utf-8");
	$post_data = array();
	$post_data['account'] = 'kmzz25';   //帐号
	$post_data['pswd'] = '1a7b920D';  //密码
	$post_data['msg'] =$mobilecode; //短信内容需要用urlencode编码下
	$post_data['mobile'] = $mobilephone; //手机号码， 多个用英文状态下的 , 隔开
	$post_data['product'] = ''; //产品ID
	$post_data['needstatus']=true; //是否需要状态报告，需要true，不需要false
	$post_data['extno']='';  //扩展码   可以不用填写
	$url='http://send.18sms.com/msg/HttpBatchSendSM';
	$o='';
	foreach ($post_data as $k=>$v)
	{
	   $o.="$k=".urlencode($v).'&';
	}
	$post_data=substr($o,0,-1); 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
	$result = curl_exec($ch);   
	return $result;
    }

}