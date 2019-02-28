<extend name="Public:base" />
<block name="content">
<style type="text/css">
	
	.in-list-text{
		width: 24.7%;
	}
	/*.in-list-width{
		width: 20%;
	}*/
	.bank-select{
		position: absolute;
	    height:200px;
	    width: 100%;
	    border: 1px solid #ddd;
	    overflow: auto;
	    top: 100%;
	    left: 0%;
	    background: #fff;
	    z-index: 5;
	    text-align: center;
	    border-radius: 4px;
	    display: none;
	}
	.bank-select-text{
		float: left;
		height: 40px;
		line-height: 40px;
		width: 100%;
		border-top: 1px solid #ddd;
	}
	.bank-select-text span{
		color: #000;
		font-size: 1.5rem;
	}
</style>

		<div class="body" style="overflow: auto;" >
			<div class="body-head" style="height: 8%;">
				<div class="header-scll" style="opacity: 1;text-align: center;">
					<span style="font-size: 1.6rem;color: #fff;margin-top: 3%">充值与提现</span>
				</div>	
			</div>
			<div class="mine-hd-num" style="height: 8%">
				<div class="mine-num-list">
					<div class="mine-num-text mine-num-text1" onclick="rechange_show(1)"><span style="color: #282828">充值</span></div>		
				</div>
				<div class="mine-num-list">
					<div class="mine-num-text mine-num-text2" onclick="rechange_show(2)"><span>提现</span></div>		
				</div>
				<div class="mine-num-list">
					<div class="mine-num-text mine-num-text3" onclick="rechange_show(3)"><span>交易记录</span></div>
				</div>
			</div>

			<!--充值-->
			<div class="rechange-box rechange-box1" style="display: block;position: relative;">
				<!--二维码弹窗-->
				<div class="market-sure-box market-sure-erweima" style="height: 60%;top: 11%">
					<div class="body-head" style="height: 16%;">
						<div class="header-scll" style="opacity: 1;text-align: center;background: #ECA534;">
							<span style="font-size: 1.6rem;color: #fff;margin-top: 3.5%">扫描二维码充值</span>
						</div>	
					</div>
					<div class="input-box-register" id="erweima" style="height: 60%;margin-top: 5%;">
						<img src="" style="width: 56%;height: 100%; margin-left: 22%"
						class="erweima">
					</div>
					<div class="rechange-input" style="border: none;background: none;margin-top: 2%;height: 12%;margin-left: 1%">
						
						<button class="zc-input btns" onclick="erweima('hide')" style="background: #ddd;
						color: #282828;float: left;margin-left: 10%;width: 80%;padding: 0px">返回</button>
					</div>
				</div>
				<div class="rechange-gold-box">
					<div class="take-head"><span>请输入充值金额并选择付款方式</span></div>
					<div class="input-box-register" style="margin-top: 10%;">
						<span>充值金额：</span>
						<input type="text" 	 name="" placeholder="请输入充值金额"  autocomplete="off" id="rechange_gold">
						<input type="hidden" id="Q_TOKEN" value="{:session('TOKEN')}">
					</div>
					<div class="payment" style="height: auto;">
						<div class="take-head payment-head"><span>选择支付方式</span></div>
						<div class="payment-body" style="background: #fff">
							<div class="payment-body-img payment-body-img1" style="border: 1px solid #282828" onclick="rechangeClick(1)">
								<img src="__PUBLIC__/images/zfb.png">
							</div>
							<div class="payment-body-img payment-body-img2" onclick="rechangeClick(2)">
								<img src="__PUBLIC__/images/qqsm.png">
							</div>
							<div class="payment-body-img payment-body-img3" style="margin-top: 3%" onclick="rechangeClick(3)">
								<img src="__PUBLIC__/images/qqzf.png">
							</div>
							<div class="payment-body-img payment-body-img4" style="margin-top: 3%" onclick="rechangeClick(4)">
								<img src="__PUBLIC__/images/bitebi.png">
							</div>
							<div class="payment-body-img payment-body-img5" style="margin-top: 3%;position: relative;" onclick="rechangeClick(5)">
								<img src="__PUBLIC__/images/ylzf.png">
								<div class="bank-select">
								 <volist name="Pay_bank" id="val">
									<div class="bank-select-text" onclick="bankName({$key},event)">
										<span>{$val}</span>
									</div>
								 </volist>
								</div>
							</div>
							<div class="rechange-input" style="border: none;background: none;margin-top: 10%;margin-bottom: 10%">
						<!--<input type="button" name="" value="提交" class="zc-input btn"  onclick="susses('zhuce')">-->
						<button class="zc-input btns rechange_sure" onclick="rechange_sure()">提交</button>
						</div>
						</div>
						
					</div>
					
				</div>
				<div class="take-care" style="margin-top: 55%">
					<div class="take-head"><span>注意事项</span></div>
					<div class="take-body">
						<span style="margin-top: 4%">1.每次提现都将收取5%手续费</span>
						<span style="margin-top: 0%">2.支付宝充值金额需为100，200，300，500，800</span>
						<span style="color: #f00">PS.如利用本平台进行任何洗钱诈骗行为，本公司将保留权利终止会员服务及冻结账户</span>
					</div>
				</div>
			</div>


			<!--提领-->
			<div class="rechange-box rechange-box2" style="display: none;">
				<div class="rechange-gold-box">
					<div class="input-box-register">
						<span>银行名称：</span>
						<input type="text" name="" placeholder="请输入银行名称" value="{$data.bank_name}---{$data.bank_adress}" autocomplete="off" id="username" readonly="readonly">
					</div>
					<!--新加-->

					<div class="input-box-register">
						<span>银行所在省：</span>
						<input type="text" name="" placeholder="请输入银行所在省" value="{$data.bank_province}" autocomplete="off" id="bank_sheng">
					</div>
					<div class="input-box-register">
						<span>银行所在市：</span>
						<input type="text" name="" placeholder="请输入银行所在市" value="{$data.bank_city}" autocomplete="off" id="bank_shi">
					</div>



					<div class="input-box-register" id="aaa">
						<span>银行卡号：</span>
						<input type="text" name="" placeholder="请输入银行账号" value="{$data.bank_number}" id="mobile_account"  autocomplete="off" onchange="changeText()">
					</div>
					<div class="input-box-register">
						<span>提款户名：</span>
						<input type="text" name="" placeholder="请输入提款户名" value="{$data.name}" autocomplete="off" id="useryzm"> 
					</div>
					<div class="input-box-register">
						<span>提款金额：</span>
						<input type="text" name="" placeholder="请输入提款金额"  autocomplete="off" id="referee">
					</div>
					<div class="input-box-register">
						<span>提款密码：</span>
						<input type="password" name="" placeholder="请输入提款密码"  autocomplete="off" id="userpassword"> 
					</div>
					<div class="rechange-input" style="border: none;background: none;margin-top: 10%">
				
						<button class="zc-input btns" onclick="deposit('zhuce')" style="background: #ddd;color: #282828">提交</button>
					</div>
				</div>
				<div class="take-care" style="margin-top: 135px;">
					<div class="take-head"><span>注意事项</span></div>
					<div class="take-body">
						<span style="margin-top: 4%">1.每次提现都将收取5%手续费</span>
						<span style="color: #f00">PS.如利用本平台进行任何洗钱诈骗行为，本公司将保留权利终止会员服务及冻结账户</span>
					</div>
				</div>
			</div>

			<!--交易记录-->
			<div class="rechange-box rechange-box3" style="display: none;">
				<div class="rechange-gold-box" style="height: 7.5%">
					<div class="select">
						<span class="text" onclick="select_show('joins')" id="joins_value">充值记录</span>
						<span class="text-sj" onclick="select_show('joins')">  ▼</span>
						<div class="select-list" id="joins_select_box">
							<div class="select-list-num" onclick="select_list('joins','充值记录')">充值记录（人民币）</div>
							<input type="hidden" id="cash_state" value="1"/>
						    <div class="select-list-num" onclick="select_list('joins','提现记录')">提现记录（美元）</div>
						</div>
					</div>
				</div>
				<div class="rechange-gold-box-by">
					<div class="in-btn-box">
						<div class="in-list-box in-list-ft" style="border-top: 1px solid #E3E3E3;border-bottom: none;">
						
							<div class="in-list-text">时间</div>		
							<div class="in-list-text">金额</div>
							<div class="in-list-text">状态</div>
							<div class="in-list-text in-berder">手续费</div>
						</div>
						<!--插入内容 class名 in-list-box-inset -->
						<div class="in-list-box-inset" id="extract_box">
							
						 	
							
						</div>
						<!--结束-->
						<!--翻页-->
						<div class="in-list-box list-box-width" style="height: 50px;background: #fff">
							<div class="in-page" style="margin-left: 20%" onclick="page('pre')">上一页</div>
							<input id="page_num" value="$o" type="hidden"/>
							<div class="in-page"><laber id="extract_now_page">1</laber>/<laber id="extract_last_page">0</laber></div>
							<div class="in-page" onclick="page('next')">下一页</div>
						</div>
					</div>
				</div>
				
			</div>

			

		</div>

		<!--底部-->
		

<script type="text/javascript">


/*二维码弹窗*/

	function erweima(type,message){
		$(".erweima").attr("src",message)
		$(".hide").show()
		$(".market-sure-erweima").show();
		if(type=='hide'){
			$(".hide").hide()
			$(".market-sure-erweima").hide();
		}
	}

	    pare();
		page(1);
		var o = '';
		function page(type){
			
			if(type==1){
				$('#page_num').val(1);
				o=1;
			}else if(type=='pre'){
				o=$('#page_num').val();
				o=o*1-1;
			}else if(type=='next'){
				o=$('#page_num').val();
				o=o*1+1;
			}
			state=$('#cash_state').val();
			//alert(o);
			$.post("{:U('Record/extract_top')}",{o:o,type:state},function(data){
				var data = eval('(' + data + ')');
				$('#extract_box').html('').html(data['data']);
				 $('#extract_now_page').text('').text(data['o']);
				 $('#page_num').val('').val(data['o']);
				 $('#extract_last_page').text('').text(data['count']);
			});
		}
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
        /*文字滚动*/
        
	 	function deposit(){
	 		var str=$("#user_gold").text();
			var reg=/.*?(?=USD)/;
			var m=str.match(reg);
	 		var mse = ['#username','#bank_sheng','#bank_shi','#mobile_account','#useryzm','#referee','#userpassword'];
			var msetext = ['银行名称','银行所在省份','银行所在市区','银行卡号','提款户名','提款金额','提款密码'];

			for(var i=0;i<mse.length;i++){
				if($(String(mse[i])).val()==''){
					error(msetext[i]+'不能为空',3500);
		 			return false;
				}
				
			}
			if($("#referee").val()>m[0]*0.95){
				error('余额不足',3500);
		 		return false;
			}
			if($("#referee").val()%15!=0||$("#referee").val()<10){
				error('提现金额为15的整倍数',3500);
		 		return false;
			}
			if($("#userpassword").val().length<6){
				error('提款密码错误',3500);
				return false;
			}
			var bank=$('#username').val();
			var bank_city=$('#bank_shi').val();
			var bank_province=$('#bank_sheng').val();
			var bank_number=$('#mobile_account').val();
			var name=$('#useryzm').val();
			var money=$('#referee').val();
			var password=$('#userpassword').val();
			$.post("{:U('Pay/extract_money')}",{bank:bank,bank_number:bank_number,name:name,money:money,password:password,bank_province:bank_province,bank_city:bank_city},function(data){
				var data = eval('(' + data + ')');
				error(data['msg'],3500);
				setTimeout(function () {
					window.location.href='__ROOT__/index.php/Home/Pay/recharge';
				},1000)
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

		 function select_list(type,id){
			 $('#'+type+'_value').text(id);
			 $('#'+type+'_select_box').hide();	
			 var type='';
			 if($("#joins_value").text()=='提现记录'){
				type=0;
			 }else if($("#joins_value").text()=='充值记录'){
				type=1;
			 }
			 $('#cash_state').val(type);
			 $.post("{:U('Record/extract_top')}",{type:type},function(data){
				 var data = eval('(' + data + ')');
				 $('#extract_box').html('').html(data['data']);
				 $('#extract_now_page').text('').text(data['o']);
				 $('#page_num').val('').val(data['o']);
				 $('#extract_last_page').text('').text(data['count']);
			 });
		 }
	

		 /*选择支付方式*/
		 $(".payment-body-img").click(function(){
		 	$(".payment-body-img").css({"border":"1px solid #fff"})
		 	$(this).css({"border":"1px solid #282828"})
		 	 var rgb = $(this).css('border-color');
			 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
			  function hex(x) {return ("0" + parseInt(x).toString(16)).slice(-2);}
			  rgb= "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
			  
			  if(rgb=='rgb(40,40,40)'){
			  	console.log(1);
			  }
		 })


		 /*点击选择某个提交方式*/
		 var rgb = 1;
		 function rechangeClick(id){
		 	rgb = id;
		 }


		 /*点击银联选择银行*/
		/* function bankSelect(){
		 	$(".bank-select").show();
		 }*/
		 var bank_type = '';
		 /*选择银行添加到页面*/
		 function bankName(id,event){
			$(".payment-body-img5 img").attr("src",'__PUBLIC__/images/ylzf'+id+'.png')
			event.stopPropagation();
			$(".bank-select").hide();
			bank_type = id;
			
		 }
		 $('body').click(function(e){
			$(".bank-select").hide();
			
		})
		 $(".payment-body-img5").click(function(e){
		 	$(".bank-select").show();
		 	e.stopPropagation();
		 })
		/*充值提交按钮*/
		function rechange_sure(){
			var tijiao = "";
			if($("#rechange_gold").val()=='' || isNaN($("#rechange_gold").val()) ){
				error('请输入金额',3500);
				return false;
			}

			if($("#rechange_gold").val()<100){
				error('充值金额最少100',3500);
				return false;
			}
						 
			  if(rgb==1){
				tijiao = 'alipay';
				chinese_con = "支付宝";
				error('该通道维护中，暂无法充值',3500);	
				return false;	
				if( $("#rechange_gold").val()!=100 &&  $("#rechange_gold").val()!=200 && $("#rechange_gold").val()!=300
					&& $("#rechange_gold").val()!=500 && $("#rechange_gold").val()!=800 ){
					error('支付宝支付金额必须为100，200，300，500，800',3500);
					
					return false;
				}
			  }
			  if(rgb==2){
				tijiao = 'qq';
				chinese_con = "qq扫码";				
			  }	
			  if(rgb==3){
				tijiao = 'qqwap';
				chinese_con = "qq支付";				
			  }	
			  if(rgb==4){
					error('暂未开放',3500);	
					return false;	
			  }	
			  if(rgb==5){
				tijiao = 'linebank';
				chinese_con = "银联充值";
			  }	
			error('使用'+chinese_con+'支付',3500);
			
			$Q_TOKEN = $("#Q_TOKEN").val();
			 
			 $.post(
			 	//bank_type
				"{:U('Pay/do_pay')}",
				{pay_money : $("#rechange_gold").val(),pay_method:tijiao,Q_TOKEN:$Q_TOKEN,bank:bank_type},
				function(res){
					$("#Q_TOKEN").val(res.Q_TOKEN);
					switch(res.state){
						case 0:
							error(res.msg,3500);
							break;
						case 1:	
							error(res.msg,3500);
							/*
							var string='';
							for(var i in res ){
								string += i + "--" +res[i];
							}
							*/	
							window.location = res.http_url;
							break;
						case 2:	
							error(res.msg,3500);
							erweima(1,res.imagepath);
							break;
						case 3:	
							error(res.msg,3500);
							document.write(res.html);
							document.pay_form.submit();
							break;	
						default :
							error("提交失败，请稍后重试。",3500);
							break;
					}
				},
				"json"
			)
			
		}

		/*选择充值提交 交易记录页面*/

		function rechange_show(id){
			$(".rechange-box").hide();
			$(".rechange-box"+id).fadeIn(500);
			$(".mine-num-text span").css({"color":"#7C7C7C","font-weight":"normal"});
			$(".mine-num-text"+id).find('span').css({"color":"#282828","font-weight":"bold"});
		}
</script>
</block>

