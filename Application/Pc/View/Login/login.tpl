<!DOCTYPE HTML>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"/>

<title>登录</title>

<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/login.css">
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/login.js"></script>
<!--
<css file="__CSS__/login.css"/>

<css file="__CSS__/layer.css"/>

<js file="__JS__/jquery.js"/>

<js file="__JS__/login.js"/>

<js file="__JS__/layer.js"/>

<js file="__JS__/ajax.js"/>
-->
</head>
<style type="text/css">
	.select {
	float: left;
    height: 100%;
    width: 97%;
    border: 1px solid #ddd;
    border-radius: 2px;
    color: #fff;
    font-size: 1.4rem;
    text-align: center;
    position: relative;
    margin-top: 2%;
    margin-left: 1%;

}
html,body{
	height: 100%;
	width: 100%;
	min-height: 1300px;
}
.select .text {
    text-align: center;
    font-size: 1.4rem;
    color: #fff;
    font-weight: bold;
    margin-top: 1.5%;
}
.select span {
    font-size: 1.5rem;
   
    display: inline-block;
    color: #fff;
}
.select-list {
    position: absolute;
    width: 100%;
    border: 1px solid #ddd;
    border-top: 0px;
    top: 107%;
    left: 0%;
    overflow: auto;
    display: none;
    background: none;
    z-index: 5;
}
.select-list-num {
    height: 30px;
    line-height: 30px;
    float: left;
    width: 100%;
    border-bottom: 1px solid #eee;
    color: #6B6B6B;
    text-indent: -6.2%;
    color: #fff;
}

.rechange-gold-box{
	width: 30%;
    position: absolute;
    top: 162%;
    left: 33.5%;
}

.daluban{
    font-size: 1.5rem;
    color: #fff;
    font-weight: bold;
    margin-top: 5%;
}

</style>

<body>

<div class="content" style="min-height: 640px">
	<div class="widths" style="position: relative;">
		<div class="head">
			<img src="__PUBLIC__/images/login-head.png">
		</div>
		<form action="/" method="" style="height: 100%;" onsubmit='return sign()'>
			<div class="body" style="position: relative;">

				<div class="input-box" style="margin-top: 10%">
					<div class="input-img"><img src="__PUBLIC__/images/login-user.png"></div>
					<span>账号</span>					
				    <input id="account" type="text" placeholder="请输入您的账号" name="user" value="" autocomplete="off">
					<input type="hidden" value="{$cookiees}" id="cookies" readonly>
					<input type="hidden" value="{$cookiees_p}" id="cookies_p" readonly>
					<input type="hidden" value="" id="remember" name="remember" readonly>
					<input type="hidden" value="" id="remember_p" name="remember_p" readonly>
				</div>
				<input type="hidden" name="state" value="{$state}"/>
				<div class="input-box" style="margin-top: 13%">
					<div class="input-img"><img src="__PUBLIC__/images/login-pasd.png" style="height: 85%;width: 78%; margin-top: 9%;"></div>
					 <span>密码</span>
					 <input id="password" type="password" placeholder="请输入您的密码" value="" name="password" autocomplete="off" style="margin-top: 0%">
				</div>

				<div class="input-boxs" style="width: 70%">
					<div class="hook-box hook-box1" style="margin-left: 10%;width: 4.8%" onclick="cli_cookies(1)">
						<img src="__PUBLIC__/images/hook.png" class="hook-img1">
						<span style="width: 95px">记住账号</span>
					</div>
					<div class="hook-box hook-box2" style="margin-left: 50%;width: 4.8%" onclick="cli_cookies(2)">
						<img src="__PUBLIC__/images/hook.png" class="hook-img2">
						<span style="width: 95px;">记住密码</span>
					</div>
				</div>
				<div class="rechange-gold-box" style="height: 7.5%;width: 100%;left: 0;text-align: center;">
					<span class="daluban">大陆版</span>
					<!--
					<div class="select" onclick="select_show('joins',event)">
						<span class="text"  id="joins_value" >选择语言</span>
						<span class="text-sj" >  ▼</span>
						<div class="select-list" id="joins_select_box" style="display: none;">
							<div class="select-list-num" onclick="select_list('joins','选择语言',event)">中文</div>
							<input type="hidden" id="cash_state" value="1">
						    <div class="select-list-num" onclick="select_list('joins','选择语言',event)">英文</div>
						</div>
					</div>
					-->
				</div>

			</div>

			<div class="footer">

				<div class="text-box" style="height: 35%">
					<div class="a-box">
						 <a href="{:U('Login/forget')}" style="margin-left: 28.5%;">忘记密码</a>
						 <span></span>
						 <if condition="$state eq 1">
						 <a href="{:U('Login/regist')}">注册账号</a>
						 <else/>
						 <a onclick="error('个人注册暂未开放，请联系上级',3500)">注册账号</a>
						 </if>
						 
					</div>
				</div>

				<div class="btn">
					<input id="submit" type="button" value="登录" onclick="sign()">
					<!--
					<div class="footer-list-box">
						<div class="footer-list" style="width: 40%"><span>24h线上客服</span></div>
						<div class="footer-list"><img src="__PUBLIC__/images/talk.png"></div>
						<div class="footer-list"><img src="__PUBLIC__/images/qq.png"></div>
						<div class="footer-list"><img src="__PUBLIC__/images/wx.png"></div>
					</div>
					-->
				</div>

				
			</div>

		</form>

		<div class="error">
			<span></span>
		</div>
	 </div>
</div>

</body>

<script type="text/javascript">
		$(document).ready(
            function (){
                var cookie=$("#cookies").val();
                var cookie_p=$("#cookies_p").val();
                if(cookie == ''){
                    $('#remember').val(0);
                    $('.hook-img1').css('display','none');
                }else{
                    $('#account').val(cookie);
                    $('#remember').val(1);
                    $('.hook-img1').css('display','block');
                }
				if(cookie_p == ''){
                    $('#remember_p').val(0);
                    $('.hook-img2').css('display','none');
                }else{
                    $('#password').val(cookie_p);
                    $('#remember_p').val(1);
                    $('.hook-img2').css('display','block');
                }
            }
		);
		
		function cli_cookies(id){
			var account = '';
			var password = ''; 
            var cookie=$("#remember").val();
            $('.hook-img'+id).toggle();
           
            if( !$('.hook-img1').is(":hidden")){
            	//account = 1;
				$('#remember').val('1');
            }else{
				$('#remember').val('0');
			}
            if( !$('.hook-img2').is(":hidden")){
            	//password = 2;
				$('#remember_p').val('1');
            }else{
				$('#remember_p').val('0');
			}
			





            //alert(cookie);exit;
            /*if(cookie == '0'){
                $('#remember').val('1');
                $('.hook-img1').css('display','block');
			}else if(cookie == '1'){
                $('#remember').val('0');
                $('.hook-img2').css('display','none');
			}*/
		}

		
		
		
	    pare();

	    

		/*获取首页高度 手机输入框弹出 布局不变形*/
	    $(".content").height($(".content").height()+'px');
	    /*点击勾选账号记住*/
	    var record_acc;
			/*$(".hook-box1").click(function(){
				$(".hook-img1").toggle();
				if(record_acc==0){
				    record_acc = 1;
				}else{
				    record_acc = 0;
				}
				
			});*/
		
		function sign(){
			if($("#account").val()==''){
				error('账号不能为空',4000);
				return false;
			}else if($("#password").val()==''){
				error('密码不能为空',3500);
				return false;
			}if($("#password").val().length<6){
				error('密码不能小于6位',4000);
				return false;
			}
			
			var user=$('#account').val();
			var password=$('#password').val();
            var remember=$("#remember").val();
            var remember_p=$("#remember_p").val();

			$.post("{:U('Login/login')}",{user:user,password:password,remember:remember,remember_p:remember_p},function (msg) {
                var data = eval('(' + msg + ')');
                //alert(data);exit;
                if(data['state']== 1){
                    error(data['msg'],3500);
                    //window.location.href='__ROOT__/index.php/Home/Index/index';
                    setTimeout(function () {
                        window.location.href='__ROOT__/index.php/Pc/Index/index';
                    },1000)
                }else{
                    error(data['msg'],3500);
                }
            });
		}



/*交易记录下拉框*/
	 	function select_show(type){	 

			 if($('#'+type+'_select_box').is(':hidden')){
				 $('#'+type+'_select_box').show();
			 }else{
				 $('#'+type+'_select_box').hide();
			 }	 
			

		 }

		 function select_list(type,id,e){
			 $('#'+type+'_value').text(id);
			 $('#'+type+'_value').text(id);
			 $("#joins_select_box").hide();	
			 e.stopPropagation();
		 }
		 
$(".select").css({"line-height":$(".select").height()-3+"px"});
</script>

</html>

