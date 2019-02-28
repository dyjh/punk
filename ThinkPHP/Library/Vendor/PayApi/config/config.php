<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 17/5/8
 * Time: 下午2:04
 */

function config(){
	
	$config['alipay']['MERID'] 	= "B5671873B97F4033824DDBC2116BED3F";
	$config['alipay']['KEY'] 	= "2871C5C5F7C595C684F0A4DEF55A92705C6655F091723CEBBE094D2B7BC99D3D";
	$config['00025']['MERID'] 	= "100520135";		//微信wap
	$config['00025']['KEY'] 	= "P8TCjR0QHysF";
	$config['00032']['MERID'] 	= "100520132";		//QQ扫码
	$config['00032']['KEY'] 	= "eTVAz74R1knQ";
	$config['00033']['MERID'] 	= "100520134";		//QQwap
	$config['00033']['KEY'] 	= "U2yL9M86xJJp";
	$config['00020']['MERID'] 	= "100520135";		//
	$config['00020']['KEY'] 	= "P8TCjR0QHysF";
	$config['TRANS_URL']		= "http://online.atrustpay.com";
	$config['SIGN_TYPE']		= "MD5";
	
	return $config;
	
}

function signString($input,$KEY){
    $pieces = explode("&", $input);
    sort($pieces);
    $string='';
    foreach ($pieces as $value){
        if($value!=''){
            $vlaue1= explode("=", $value);
            if($vlaue1[1]!=''&&$value[1]!=null){
                $string=$string.$value.'&';
            }
        }
    }
	
    $string=$string.'key='. $KEY;
	
    $sign=strtoupper(md5($string));
    $string=$string.'&signData='.$sign;
    return $string;
}

function sign($input,$KEY){
    $pieces = explode("&", $input);
    sort($pieces);
    $string='';
    foreach ($pieces as $value){
        if($value!=''){
            $vlaue1= explode("=", $value);
            if($vlaue1[1]!=''&&$value[1]!=null){
                $string=$string.$value.'&';
            }
        }
    }
    $string=$string.'key='. $KEY;
	
    $sign=strtoupper(md5($string));
    return $sign;
}

function yifusignstring($input){
   
    $string='{';
    $sign_string='{';
    foreach ($input as $key=>$value){
        if($value!=''){
			if($key != "secretKey"){
				$sign_string .= '"'.$key.'":"'.$value.'",';
			}
			$string .= '"'.$key.'":"'.$value.'",';
        }
    }

	$string  = substr($string , 0 , -1);
	$string .= "}";	
	
	// $string =  "{\"appId\":\"" . $input['appId'] .
					// "\",\"apiVer\":\"" . $input['apiVer'] .
					// "\",\"payType\":\"" . $input['payType']	 .
					// "\",\"scene\":\"" . $input['scene'] .
					// "\",\"terminal\":\"" . $input['terminal'] .
					// "\",\"fmt\":\"" . $input['fmt']	    .
					// "\",\"charset\":\"" . $input['charset'] .
					// "\",\"sgnType\":\"" . $input['sgnType']	 .
					// "\",\"merchOrdrNo\":\"" . $input['merchOrdrNo'] .
					// "\",\"totOrdrAmt\":\"" . $input['totOrdrAmt']		 .
					// "\",\"noteUrl\":\"" . $input['noteUrl'] .
					// "\",\"rtnUrl\":\"" . $input['rtnUrl']		.
					// "\",\"timeStamp\":\"" . $input['timeStamp'] .
					// "\",\"usrName\":\"" . $input['usrName'] 		.
					// "\",\"extParm\":\"" . $input['extParm'] .
					// "\",\"secretKey\":\"" . $input['secretKey'] .
					// "\"}";	
	
	$sign=strtolower(md5($string));
	
	$sign_string .= '"sgn":"'.$sign.'"';
	$sign_string .= "}";
	
    return ($sign_string);
}

function yifusignstring_bak($input){
   
    $string='';
    foreach ($input as $key=>$value){
        if($value!=''){
			// $string .= $key . "=". $value.'&';
        }
    }

	$sign=MD5(json_encode($input));
	$sign_string  = $string . 'sgn='.$sign;

    return $sign_string;
}




