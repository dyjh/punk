<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 17/5/8
 * Time: 下午6:58
 */


include '../config/config.php';
$PAY_GATEWAY = '/payment/ScanPayApply.do';
$input = file_get_contents("php://input");
$input=urldecode($input);

$string=signString($input);
echo $string;
echo "<br>";
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$TRANS_URL.$PAY_GATEWAY);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,0);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$string);
$data = curl_exec($ch);
$returnData=json_decode($data,true);
echo  $returnData['qrcode'];
curl_close($ch);



