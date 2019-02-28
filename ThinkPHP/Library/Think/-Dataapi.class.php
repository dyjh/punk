<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2 0002
 * Time: 下午 5:48
 */

namespace Think;


class Dataapi
{
    private $url = "http://feed.sportsdt.com/t_luyou/soccer/testing.aspx";


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
		//print_r($output);die;
        curl_close($ch);
        if($output === FALSE){
            return "CURL Error:".curl_error($ch);
        }
        return $output;
    }

    /*function produce_verification_code($tel,$type){

        //type  1:找回密码  2:修改密码
        $str ='0123456789';
        $code = substr(str_shuffle($str),0,6);
        if($type==1){
            $content = '【优客派】您正在重置密码！验证码为'.$code.'，5分钟内有效。请确认是本人操作。';
            session('find_code',$code);
        }else if($type==2){
            $content = '【优客派】您正在修改密码！验证码为'.$code.'，5分钟内有效。请确认是本人操作。';
            session('save_code',$code);
        }else if($type==3){
            $content = '【优客派】您正在登录后台！验证码为'.$code.'，5分钟内有效。请确认是本人操作。';
            session('save_code',$code);
        }
        $this->post_sms($tel,$content,$code);
    }*/

    function post_sms($type,$date){
		//echo $date;
		if($date==''){
			$data = $this->url."?type=".$type;
		}else{
			//$date=111;
			//echo $date;
			$data = $this->url."?type=".$type."&date=".$date;
		}
		//echo $data;die;
        return $this->httprequest($data);
    }
}