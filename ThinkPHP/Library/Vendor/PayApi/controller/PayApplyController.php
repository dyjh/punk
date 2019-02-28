<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 17/5/8
 * Time: 上午8:36
 */


include '../config/config.php';


$PAY_GATEWAY = '/payment/PayApply.do';
$input = file_get_contents("php://input");
$input=urldecode($input);
$pieces=urldecode($pieces);
$pieces = explode("&", $input);
$sign= sign($input);
$pieces[front]='signData='.$sign;
$http='<script language="javascript">window.onload=function(){document.pay_form.submit();}</script>';
$http=$http.'<form id="pay_form" name="pay_form" action="'.$TRANS_URL.$PAY_GATEWAY.'" method="post">';
foreach ($pieces as $value){
    if($value!=''){
        $vlaue2= explode("=", $value);
        if($vlaue2[1]!=''&&$vlaue2[1]!=null) {
            $http = $http . '<input type="hidden"  name="' . $vlaue2[0] . '" id="' . $vlaue2[0] . '" value="' . $vlaue2[1] . '">';
        }

    }
}
$http=$http.'</form>';
echo $http;