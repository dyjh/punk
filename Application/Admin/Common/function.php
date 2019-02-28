<?php

// author QHP
// qhp
// 2018年1月5日17:27:00

function check_verify($code, $id = ''){    
	$verify = new \Think\Verify();    
	return $verify->check($code, $id);
}

/**
 * 取验证码hash值
 *
 * @param
 * @return string 字符串类型的返回结果
 */
function getHash(){
    return substr(md5(__SELF__),0,8);
}

/*生成哈希链接*/
function U_hash($link){
	return U($link,array('nchash'=>getHash()));
}

function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}

function makeSeccode($nchash){
	$seccode = random(6, 1);
	$seccodeunits = '';

	$s = sprintf('%04s', base_convert($seccode, 10, 23));
	$seccodeunits = 'ABCEFGHJKMPRTVXY2346789';
	if($seccodeunits) {
		$seccode = '';
		for($i = 0; $i < 4; $i++) {
			$unit = ord($s{$i});
			$seccode .= ($unit >= 0x30 && $unit <= 0x39) ? $seccodeunits[$unit - 0x30] : $seccodeunits[$unit - 0x57];
		}
	}
	session('seccode',$nchash);
	//cookie('seccode'.$nchash, encrypt(strtoupper($seccode)."\t".(time())."\t".$nchash,MD5_KEY),3600);
	return $seccode;
}

/**
 * 加密函数
 *
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function encrypt($txt, $key = ''){
	if (empty($txt)) return $txt;
	if (empty($key)) $key = md5(MD5_KEY);
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
	$ikey ="-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
	$nh1 = rand(0,64);
	$nh2 = rand(0,64);
	$nh3 = rand(0,64);
	$ch1 = $chars{$nh1};
	$ch2 = $chars{$nh2};
	$ch3 = $chars{$nh3};
	$nhnum = $nh1 + $nh2 + $nh3;
	$knum = 0;$i = 0;
	while(isset($key{$i})) $knum +=ord($key{$i++});
	$mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum%8,$knum%8 + 16);
	$txt = base64_encode(time().'_'.$txt);
	$txt = str_replace(array('+','/','='),array('-','_','.'),$txt);
	$tmp = '';
	$j=0;$k = 0;
	$tlen = strlen($txt);
	$klen = strlen($mdKey);
	for ($i=0; $i<$tlen; $i++) {
		$k = $k == $klen ? 0 : $k;
		$j = ($nhnum+strpos($chars,$txt{$i})+ord($mdKey{$k++}))%64;
		$tmp .= $chars{$j};
	}
	$tmplen = strlen($tmp);
	$tmp = substr_replace($tmp,$ch3,$nh2 % ++$tmplen,0);
	$tmp = substr_replace($tmp,$ch2,$nh1 % ++$tmplen,0);
	$tmp = substr_replace($tmp,$ch1,$knum % ++$tmplen,0);
	return $tmp;
}

/**
 * TODO 基础分页的相同代码封装，使前台的代码更少
 * 分页样式和
 * @param $count 要分页的总记录数
 * @param int $pagesize 每页查询条数
 * @param string $url   跳转的页面
 * @param string $order 分页需要携带的参数
 * @return \Think\Page
 */

function get_page_five($count ,$pagesize , $page , $url,  $order){
	
	$page_css  = '<div class="bootstrap-admin-panel-content">';
    $page_css .=	'<div class="pagination-container">';						
    $page_css .=	'<ul class="pagination pagination-sm">';								
    $page_css .=	'<li class="'.(($page==1)?"disabled":"").'"><a href="'.U($url,array_merge(array("page"=>'1') , (array)$order )).'">&laquo;</a></li>';
	
	$first_for = ($page - 2) > 0 ? $page-2 : 1;
	$last_for  = (($max_page_size = ceil($count/$pagesize)) > $page + 2) ? $page + 2  :  $max_page_size;
// echo $page;
	for($i = $first_for ; $i <= $last_for ; $i ++){
			$is_active = ($i==$page && empty($is_active)) ? "active" : "";
		
		    $page_css .=	'<li class="'.$is_active.'"><a href="'.U($url,array_merge(array("page"=>$i) , (array)$order )).'">'.$i.'</a></li>';	
		
	}

    $page_css .=	'<li class="'.(($page==$max_page_size)?"disabled":"").'"><a href="'.U($url,array_merge(array("page"=>$max_page_size) , (array)$order )).'">&raquo;</a></li>';
    $page_css .=	'</ul>';								
    $page_css .=	'</div>';								
    $page_css .=	'</div>';								
			
    return $page_css;
	
}

function do_order_state($state){
	
	switch($state){
		case "all_list":
			$state = false;
			break;
		case "complete":
			$state = "1";
			break;
		case "not_comp":
			$state = "'0'";
			break;				
		case "wait_order":	
			$state = "9";		
			break;
		case "not_ok":	
			$state = array("in","7,8");		
			break;
	}
	return $state;
}

function myfunction($value,$key,$p)
{
  $key  .= $p.$key;

  return($alias.$v);

}
















// That ' S  ALL 
// Thanks
