<!DOCTYPE HTML>

<html lang="en">

<head>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"/>

	<title>注册</title>

	<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/login.css">

	<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>

	<script type="text/javascript" src="__PUBLIC__/js/login.js"></script>

</head>
<style type="text/css">
	body,html{
		height: 100%;
		width: 100%;
		background: none;
		background-image: url(__PUBLIC__/images/login-bg.png);
   		 background-size: 100% 100%;
   		 background-repeat: no-repeat;
	}
	.box-bg{
		background-image: url(__PUBLIC__/images/login-bg.png);
   		 background-size: 100% 100%;
   		 background-repeat: no-repeat;
	}
</style>
<body>

<div class="content">

	<div class="widths" style="height: 100%;">

		<form action="/" method="post" onsubmit="return susses('zhuce')">

			<div class="box-bg" style="height: 100%;width: 100%;float: left;">

				<div class="input-box-register" style="margin-top: 10%">

					<span>姓名</span>

					<input type="text" name="name" placeholder="请输入真实姓名"  autocomplete="off" id="username">

				</div>

				<div class="input-box-register" id="aaa">

					<span>手机号</span>

					<input type="text" name="user" placeholder="请输入手机号"  id="mobile_account"  autocomplete="off" onchange="changeText()">

					<!--

					<input type="button" value='获取验证码' class="yz-input"  onclick="susses('yzm')" id="yzm" autocomplete="off">

					-->

				</div>





				<div class="input-box-register" style="width: 45%;margin-right: 10px; float: left;">



					<input type="text" name="verify" placeholder="请输入验证码"  autocomplete="off" id="useryzm" style="text-indent: 15%;width: 100%">



				</div>

				<img src="{:U('Login/verify')}" id="verify_img" style=" float: left; margin-top: 11%;height: 61px;
    /* width: 85px; */
    width: 23%;">

				<div style="clear: both"></div>

				<div class="input-box-register">

					<span>推荐人</span>

					<input type="text" name="referrer" placeholder="请输入推荐人ID"  autocomplete="off" id="referee" value="{$referrer}">

				</div>
				<!--
				<div class="input-box-register">

					<span>银行名称</span>

					<input type="text" name="bank_name" placeholder="请输入银行名称"  autocomplete="off" id="userbank">

				</div>

				<div class="input-box-register">

					<span>银行支行</span>

					<input type="text" name="bank_adress" placeholder="请输入支行名称"  autocomplete="off" id="userbanks">

				</div>

				<div class="input-box-register">

					<span>银行卡号</span>

					<input type="text" name="bank_number" placeholder="请输入银行卡号"  autocomplete="off" id="userbanknum">

				</div>-->

				<div class="input-box-register">

					<span>登录密码</span>

					<input type="password" name="password" placeholder="请输入登录密码"  autocomplete="off" id="userpassword">

				</div>

				<div class="input-box-register">

					<span>交易密码</span>

					<input type="password" name="trade_password" placeholder="请输入交易密码"  autocomplete="off" id="userpasswords">

				</div>



				<div class="input-box-register" style="border: none;background: none;margin-top: 25%">

					<input type="button" name="" value="确认注册" class="zc-input" style="text-align: center;width: 100%;margin-left: 0;height: 110%;color: #000" onclick="susses('zhuce')">

				</div>

				<div class="re-footer" style="margin-bottom: 28%">

					<div class="dd"></div>

					<a href="{$url}">{$name}</a>

					<div class="dd"></div>

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



    $("#verify_img").click(function() {

       // alert(1);

            //var verifyURL = "Login/verify";

			var time = new Date().getTime();

            $("#verify_img").attr({

                   "src" :"__URL__/verify/" + time

            });

         });

    pare();



    function susses(type){



        if($("#mobile_account").val()!=''&&!/^(((16[0-9]{1})|(19[0-9]{1})|(13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test($("#mobile_account").val()))

        {

            error('手机号码非法',3500);

            return false;

        }





        if(type=='zhuce'){

            var mse = ['#username','#mobile_account','#useryzm','#referee','#userpassword','#userpasswords'];

            var msetext = ['姓名','手机号','验证码','推荐人','登录密码','交易密码'];



            for(var i=0;i<mse.length;i++){

                if($(String(mse[i])).val()==''){

                    error(msetext[i]+'不能为空',3500);

                    return false;

                }



            }



            if($("#userpassword").val().length<6){

                error('登录密码不能小于6位',3500);

                return false;

            }

            if($("#userpasswords").val().length<6){

                error('交易密码不能小于6位',3500);

                return false;

            }

            if($("#username").val().length>6){

                error('姓名不能超过6位',3500);

                return false;

            }



            var name=$('input[name="name"]').val();

            var password=$('input[name="password"]').val();

            var trade_password=$('input[name="trade_password"]').val();
/*
            var bank_name=$('input[name="bank_name"]').val();

            var bank_adress=$('input[name="bank_adress"]').val();

            var bank_number=$('input[name="bank_number"]').val();*/

            var verify=$('input[name="verify"]').val();

            var user=$('input[name="user"]').val();

            var referrer=$('input[name="referrer"]').val();

            //alert(name);

            $.post("{:U('Login/regist')}",{verify:verify,user:user,referrer:referrer,name:name,password:password,trade_password:trade_password},function (msg) {

                var data = eval('(' + msg + ')');

                //alert(data);exit;

                if(data['state']== 1){

				    error(data['msg'],3500);



                    setTimeout(function () {

                        window.location.href='__ROOT__/index.php/Home/Login/login';

                    },1000)

				}else{

					error(data['msg'],3500);

				}

            });

        }



        if(type=='yzm'){

            if($("#mobile_account").val()==''){

                error('手机号不能为空',3500);

                return false;

            }

            request();



        }





    }





</script>

</html>