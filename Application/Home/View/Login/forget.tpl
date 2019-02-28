<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"/>
<title>忘记密码</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/login.css">
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/login.js"></script>

</head>
<body>
<div class="content">
	<div class="widths">
		<form action="/" method="post" id="forget-submit" onsubmit="return susses('chongzhi')"> 
			<div style="height: 100%;width: 100%;float: left;">
				
				<div class="input-box-register input-box-h" id="input-box-t" style="margin-top: 30%">
					<span>手机号</span>
					<input type="text" name="" placeholder="请输入手机号" style="width: 35%" value="18228068397" id="mobile_account" autocomplete="off" onchange="changeText()">
					<input type="button" value='获取验证码' class="yz-input" onclick="susses('yzm')" id="yzm" autocomplete="off">
				</div>

				<div class="input-box-register input-box-h">
					<span>验证码</span>
					<input type="text" name="" placeholder="请输入验证码" autocomplete="off" id="yzm-input">
				</div>
				
				<div class="input-box-register input-box-h" id="ddd">
					<span>设置密码</span>
					<input type="password" name="" placeholder="请输入您的密码"  id="password" autocomplete="off"> 
				</div>
				<div class="input-box-register input-box-h">
					<span>确认密码</span>
					<input type="password" name="" placeholder="请确认您的密码" id="newpassword" autocomplete="off">
				</div>
				<div class="input-box-register input-box-h" style="background: none;margin-top: 35%" id="input-box-h">
					<input type="button" name="" value="重置密码" class="zc-input" style="text-align: center;width: 100%;margin-left: 0;height: 110%;color: #000" onclick="susses('chongzhi')">
				</div>
				<div class="re-footer">
					<div class="dd"></div>
					<a href="{:U('Login/login')}">返回登录界面</a>
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

	pare();

	function susses(type){console.log(type)
		if($("#mobile_account").val().length<1){
			error('手机号码不能为空',4000);
	 		return false; 
		}
		if($("#mobile_account").val()!=''&&!/^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test($("#mobile_account").val()))
			{
			error('手机号码非法',4000);
	 		return false;
		}

		if(type=='chongzhi'){

			if($("#yzm-input").val()=='')
			{
				error('验证码不能为空',4000);

		 		return false;
			}

			if($("#password").val().length<6){
				error('密码不能小于6位',4000);
				return false;
			}

			if($("#newpassword").val()!=$("#password").val()){
				error('两次输入密码不相同',4000);

				return false;
			}
            var user=$('#mobile_account').val();
            var yzm=$('#yzm-input').val();
            var password=$('#password').val();
			//alert(user);//
            $.post("{:U('Login/forget')}",{user:user,yzm:yzm,password:password},function (msg) {
                var data = eval('(' + msg + ')');
                //alert(data);exit;
                if(data['state']== 1){
                    error(data['msg'],3500);
                    setTimeout(function () {
                        window.location.href='__ROOT__/index.php/Home/Login/login';
                    },3500)
                }else{
                    error(data['msg'],3500);
                }
            });
		}		
		
		if(type=='yzm'){
			var url='__URL__/yzm';
			var tel=$('#mobile_account').val();
			request(tel,1,url);	
		}

		
		
		

	}



</script>
</html>