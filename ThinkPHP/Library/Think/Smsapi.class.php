<?php
namespace Think;

class Smsapi{

	private $sid = "d67889e0008544af9c9b023dd5eb5e62";
	private $auth_token = '2c1ed54135a64dee9a50c740c816d90f';
	private $url = "https://api.miaodiyun.com/20150822/industrySMS/sendSMS";


	function https_request($url,$data=null){ //定义程序内https传输 get或post
	   $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL, $url);
	   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

	   if(!empty($data)){
			   curl_setopt($ch, CURLOPT_POST, 1);
			   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 }

	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	   $output = curl_exec($ch);
	   curl_close($ch);
   }

   function httprequest($url){ //定义程序内http传输 get
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 $output = curl_exec($ch);

		 curl_close($ch);
		 if($output === FALSE){
			  return "CURL Error:".curl_error($ch);
		 }
		 return $output;
	}

	function produce_verification_code($tel,$type){

		  //type  1:找回密码  2:修改密码//
		$str ='0123456789';
		$code = substr(str_shuffle($str),0,6);
		if($type==1){
			$content = '【PUNK】您正在重置密码！验证码为'.$code.'，5分钟内有效。请确认是本人操作。';
			session('find_code',$code);
		}else if($type==2){
			$content = '【PUNK】您正在修改密码！验证码为'.$code.'，5分钟内有效。请确认是本人操作。';
			session('save_code',$code);
		}else if($type==3){
			$content = '【PUNK】您正在登录后台！验证码为'.$code.'，5分钟内有效。请确认是本人操作。';
			session('admin_code',$code);
		}else if($type==4){
			$content = '【PUNK】您正在修改密码！验证码为'.$code.'，5分钟内有效。请确认是本人操作。';
			session('save_code',$code);
		}else if($type==5){
			$content = '【PUNK】您正在修改二级密码！验证码为'.$code.'，5分钟内有效。请确认是本人操作。';
			session('save_code',$code);
		}
		$this->post_sms($tel,$content,$code);
	 }

	 function post_sms($tel,$content,$code){
		 $timestamp = date('YmdHis',time());
		 $sig = MD5($this->sid.$this->auth_token.$timestamp);
		 $data = "accountSid=".$this->sid."&smsContent=".$content."&to=".$tel."&timestamp=".$timestamp."&sig=".$sig."&respDataType=JSON";
		 $this->https_request($this->url,$data);
   }
}
















?>
