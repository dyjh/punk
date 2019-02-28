<extend name="Public:base" />

<block name="content">

<style type="text/css">
	.mine-by-box {
    float: left;
	    height: 711px;
	    width: 100%;
	    background: #fff;
	    overflow: auto;
	}
	.mine-by-list {
	    float: left;
	    height: 61px;
	    width: 100%;
	    background: #fff;
	    line-height: 60px;
	    border-top: 1px solid #ddd;
	}
	.userdata-right button{
		float: right;
   		margin-top: 13px;
	}
	.userdata-list1{
		margin-left: 30px;
	}
	.market-sure-box{
		height: 500px;
	}
	.user-data-alert2{
		height: 600px;
	}
	.input-box-register #yzm{
		width: 12%;
   		text-align: center;
   		text-indent: 0;
   		cursor: pointer;
	}
	.input-box-register {
	    float: left;
	    height: 40px;
	    margin-top: 37px;
	    width: 100%;
	}
	
	.select {
	    float: left;
	    height: 50px;
	    width: 97%;
	    border: 1px solid #ddd;
	    border-radius: 2px;
	    color: #fff;
	    font-size: 1.4rem;
	    text-align: center;
	    position: relative;
	    margin-left: 1%;
	    line-height: 50px;
	    cursor: pointer;
	}
	.select{
		position: absolute;
	    width: 59.8%;
	    left: 24%;
	    height: 0%;
	    border: none;
	    margin-top: 0;
	    margin-left: 0;
	}
	.select .text {
	    text-align: center;
	    font-size: 1.4rem;
	    color: #6B6B6B;
	    font-weight: bold;
	}
	.select span {
	    font-size: 1.5rem;
	    text-indent: 34%;
	    display: inline-block;
	    color: #6B6B6B;
	}
	.select-list {
	    position: absolute;
	    width: 100%;
	    border: 1px solid #ddd;
	    border-top: 0px;
	    left: 0%;
	    overflow: auto;
	    display: none;
	    background: #fff;
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
	}
</style>

		<div class="body" style="position: relative;">



			<!--修改登录密码-->

			<div class="market-sure-box user-data-alert1">

				<div class="body-head">

					<div class="header-scll trade-scll" style="opacity: 1;text-align: center;background: #ECA534;">

						<span style="font-size: 1.6rem;color: #fff;">修改登录密码</span>

					</div>	

				</div>

				<div class="input-box-register" style="position: relative;">

					<span><small style="opacity: 0;font-size: 1.6rem;">验</small>验证码：</span>

					<input type="text" name="" placeholder="请输入验证码" autocomplete="off" id="login-yzm">

					<input type="button" value='获取验证码' class="yz-input" onclick="susses('yzm')" autocomplete="off" id="yzm"> 

				</div>

				

				<div class="input-box-register" style="">

					<span><small style="opacity: 0;font-size: 1.6rem;">验</small>新密码：</span>

					<input type="password" name="" placeholder="请输入新登录密码" autocomplete="off" id="l-new-password"> 

				</div>

				<div class="input-box-register" style="">

					<span>重复密码：</span>

					<input type="password" name="" placeholder="请再次输入新登录密码" autocomplete="off" id="l-news-password"> 

				</div>

				<div class="rechange-input" style="border: none;background: none;">

					<button class="zc-input btns" onclick="market_sure()" style="background: #ddd;

					color: #282828;float: left;margin-left: 6%;width: 40%;margin-top: 70px;">提交</button>

					<button class="zc-input btns" onclick="market_return('hide','2','market-sure-box')" style="background: #ddd;

					color: #282828;float: left;margin-left: 6%;width: 40%;margin-top: 70px;">返回</button>

				</div>

			</div>





			<!--修改银行卡-->

			<div class="market-sure-box user-data-alert2">

				<div class="body-head">

					<div class="trade-scll" style="opacity: 1;text-align: center;background: #ECA534;">

						<span style="font-size: 1.6rem;color: #fff;">修改银行卡号</span>

					</div>	

				</div>


				<div class="input-box-register" style="position: relative;">

					<span>银行名称：</span>
					<!--
					<input type="text" name="" placeholder="请输入银行名称" autocomplete="off" id="bank-1"> 
					-->
					<input type="button" name="" placeholder="请输入银行名称" autocomplete="off" id="bank-1" onclick="select_show('joins')" value="选择银行  ▼">
					<div class="select">
						<div class="select-list" id="joins_select_box">
							<volist name="Bank_Info" id="v">
								<div class="select-list-num" onclick="select_list('joins','{$v.name}')">{$v.name}</div>
						    </volist>
						</div>
					</div>
				</div>

				<!--新加-->
				<div class="input-box-register">

					<span>银行所在省：</span>
					<input type="text" name="" placeholder="请输入银行所在省份" autocomplete="off" id="bank-4"> 
				</div>
				<div class="input-box-register">

					<span>银行所在市：</span>

					<input type="text" name="" placeholder="请输入银行所在市区" autocomplete="off" id="bank-5"> 

				</div>




				<div class="input-box-register">

					<span>银行支行：</span>

					<input type="text" name="" placeholder="请输入银行支行" autocomplete="off" id="bank-2"> 

				</div>

				<div class="input-box-register">

					<span>银行卡号：</span>

					<input type="text" name="" placeholder="请输入银行卡号" autocomplete="off" id="bank-3"> 

				</div>

				<div class="rechange-input" style="border: none;background: none;">

					<button class="zc-input btns" onclick="bank_sure()" style="background: #ddd;

					color: #282828;float: left;margin-left: 6%;width: 40%;margin-top: 70px;">提交</button>

					<button class="zc-input btns" onclick="market_return('hide','2','market-sure-box')" style="background: #ddd;

					color: #282828;float: left;margin-left: 6%;width: 40%;margin-top: 70px">返回</button>

				</div>

			</div>







			<div class="body-head">

				<div class="trade-scll" style="opacity: 1;text-align: center;">

					<span class="color-fff">个人资料</span>

				</div>	

			</div>

			

			

			<div class="mine-by-box" style="background: #ddd">

				

				<div class="mine-by-list">

					<div class="mine-by-right userdata-right">

						<span class="userdata-list1">手机号</span>

						<span id="tel" class="userdata-list2">{$data.user}</span>

					</div>

				</div>



				<div class="mine-by-list">

					

					<div class="mine-by-right userdata-right">

						<span class="userdata-list1">登录密码</span>

						<span class="userdata-list2">******</span>

						<button class="btn userdata-list3" onclick="make_sure('hide','user-data-alert1','1')">修改</button>

					</div>

				</div>

				<div class="mine-by-list">

					

					<div class="mine-by-right userdata-right">

						<span class="userdata-list1">交易密码</span>

						<span class="userdata-list2">******</span>

						<button class="btn userdata-list3" onclick="make_sure('hide','user-data-alert1','2')">修改</button>

					</div>

				</div>	

				<div class="mine-by-list">

					<div class="mine-by-right userdata-right">

						<span class="userdata-list1">银行卡号</span>

						<span class="userdata-list2">{$data.bank_number}</span>

						<button class="btn userdata-list3" onclick="make_sure('hide','user-data-alert2','3')">修改</button>

					</div>

				</div>

				<div class="mine-by-list">

					<div class="mine-by-right userdata-right">

						<span class="userdata-list1">银行名称</span>

						<span class="userdata-list2">{$data.bank_name}</span>

					</div>

				</div>

				<div class="mine-by-list">

					<div class="mine-by-right userdata-right">

						<span class="userdata-list1">所属支行</span>

						<span class="userdata-list2">{$data.bank_adress}</span>

					</div>

				</div>


				<!--新加-->

				<div class="mine-by-list">

					<div class="mine-by-right userdata-right">

						<span class="userdata-list1">所在省份</span>

						<span class="userdata-list2">{$data.bank_province}</span>

					</div>

				</div>
				<div class="mine-by-list">

					<div class="mine-by-right userdata-right">

						<span class="userdata-list1">所在市区</span>

						<span class="userdata-list2">{$data.bank_city}</span>

					</div>

				</div>

			</div>



		</div>



		<!--底部-->

	



<script type="text/javascript">



	    pare();



	    	    

	 

	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')

        /*文字滚动*/

        



        	/*选择银行记录下拉框*/
	 	function select_show(type){	 

			 if($('#'+type+'_select_box').is(':hidden')){
				 $('#'+type+'_select_box').show();
			 }else{
				 $('#'+type+'_select_box').hide();
			 }	 

		 }

		 function select_list(type,id){
			 $('#bank-1').val(id);
			 $('#'+type+'_select_box').hide();
		 }




	 	



		



		/*显示弹框*/





		var types = '';

	 	function make_sure(hide,id,type){

	 		if(type == 1){

	 			$(".header-scll span").text('修改登录密码')

	 			types = 1;

	 		}

	 		if(type == 2){

	 			$(".header-scll span").text('修改交易密码')

	 			types = 2;

	 		}

	 		$("."+hide).show();

	 		$("."+id).fadeIn(500);



	 	}



		

		/*发送验证码*/

		function susses(){

			//alert(types);

			var url='__URL__/yzm';

			//alert(url);die;

			var tel=$('#tel').text();

			if(types==1){

				var type=4;

			}else{

				var type=5;

			}

			request(tel,type,url);

		}

		

	 	/*登录密码验证交易密码*/

		function market_sure(){

        	var mse = ['#login-yzm','#l-new-password','#l-news-password'];

			var msetext = ['验证码','新密码','重复密码'];



			for(var i=0;i<mse.length;i++){

				if($(String(mse[i])).val()==''){

					error(msetext[i]+'不能为空',3500);

		 			return false;

				}

				

			}

			if($("#l-new-password").val().length<6||$("#l-news-password").val().length<6){

				error('密码不能小于6位','3500');

				return false;

			}

			if($("#l-new-password").val()!=$("#l-news-password").val()){

				error('两次密码输入不同','3500');

				return false;

			}

			var password=$('#l-new-password').val();

			var yzm=$('#login-yzm').val();

			$.post("{:U('User/edit_user')}",{type:types,password:password,yzm:yzm},function(data){

				var data = eval('(' + data + ')');

				error(data['msg'],3500);

			});

        }







        /*银行卡修改确定*/

        function bank_sure(){

        	var mse = ['#bank-1','#bank-4','#bank-5','#bank-2','#bank-3'];

			var msetext = ['银行名称','银行所在省份','银行所在市区','银行支行','银行卡号'];



			for(var i=0;i<mse.length;i++){

				if($(String(mse[i])).val()==''){

					error(msetext[i]+'不能为空',3500);

		 			return false;

				}

				

			}

			var zhi=3;

			var bank_name=$('#bank-1').val();

			var bank_adress=$('#bank-2').val();

			var bank_number=$('#bank-3').val();
			var bank_province=$('#bank-4').val();
			var bank_city=$('#bank-5').val();
			$.post("{:U('User/edit_user')}",{type:zhi,bank_name:bank_name,bank_number:bank_number,bank_adress:bank_adress,bank_province:bank_province,bank_city:bank_city},function(data){

				var data = eval('(' + data + ')');

				//console.log(data);

				error(data['msg'],3500);

			});

        }

</script>

</block>



