<extend name="Public:base" />
<block name="content">
<input type="hidden" value="市场列表" id="titles"> 
		<div class="body" style="overflow: auto;">
			<div class="body-head" style="height: 8%;">
				<div class="header-scll" style="opacity: 1;text-align: center;">
					<span style="font-size: 1.6rem;color: #fff;margin-top: 3%">转账</span>
				</div>	
			</div>
			<div class="mine-hd-num" style="height: 8%">
				<div class="mine-num-list">
					<div class="mine-num-text mine-num-text1" onclick="rechange_show(1)"><span style="color: #282828">转账</span></div>		
				</div>
				
				<div class="mine-num-list">
					<div class="mine-num-text mine-num-text3" onclick="rechange_show(3)"><span>转账记录</span></div>
				</div>
			</div>

			<!--充值-->
			<div class="rechange-box rechange-box1" style="display: block;">
				<div class="rechange-gold-box">
					<!--
					<div class="take-head"><span>请输入转账金额为100的整倍数</span></div>
					-->
					<!--隐藏框-->
					


					<div class="input-box-register" style="margin-top: 10%;">
						<span><small style="opacity: 0;font-size: 1.6rem;">账户</small>账户：</span>
						<input type="text" name="" placeholder="请输入转账ID"  autocomplete="off" onblur="check()" id="acc_user" style="width:40%">
						<input type="text" name=""autocomplete="off" style="width:20%;border:none;color:green;" id="check_name" readonly="readonly" value="" >
					</div>
					<div class="input-box-register" style="margin-top: 10%;">
						<span>转账金额：</span>
						<input type="text" name="" placeholder="请输入转账金额为100的整倍数"  autocomplete="off" id="acc_num">
					</div>
					<div class="input-box-register" style="margin-top: 10%;">
						<span>交易密码：</span>
						<input type="password" name="" placeholder="请输入交易密码"  autocomplete="off" id="acc-password">
					</div>
					
					<div class="rechange-input" style="border: none;background: none;margin-top: 20%">
						<!--<input type="button" name="" value="提交" class="zc-input btn"  onclick="susses('zhuce')">-->
						<button class="zc-input btns rechange_sure" onclick="deposit()">提交</button>
					</div>
				</div>
				<div class="take-care">
					<div class="take-head"><span>注意事项</span></div>
					<div class="take-body">
						<span style="margin-top: 4%">1.每次转账金额需为100的整倍数</span>
						<span style="color: #f00">PS.如利用本平台进行任何洗钱诈骗行为，本公司将保留权利终止会员服务及冻结账户</span>
					</div>
				</div>
			</div>


			<!--交易记录-->
			<div class="rechange-box rechange-box3" style="display: none;">
				<!--
				<div class="rechange-gold-box" style="height: 7.5%">
					<div class="select">
						<span class="text" onclick="select_show('joins')" id="joins_value">充值记录</span>
						<span class="text-sj" onclick="select_show('joins')">  ▼</span>
						<div class="select-list" id="joins_select_box">
							<div class="select-list-num" onclick="select_list('joins','充值记录')">充值记录</div>
						    <div class="select-list-num" onclick="select_list('joins','提领记录')">提领记录</div>
						</div>
					</div>
				</div>
				-->
				<div class="rechange-gold-box-by" style="margin-top: 0%">
					<div class="in-btn-box">
						<div class="in-list-box in-list-ft" style="border-top: 1px solid #E3E3E3;border-bottom: none;">
							<div class="in-list-text in-list-width">时间</div>		
							<div class="in-list-text in-list-width">金额</div>
							<div class="in-list-text in-list-width">对方账号</div>
						</div>
						<!--插入内容 class名 in-list-box-inset -->
						<div class="in-list-box-inset" id="extract_box">
							
						 	<div class="in-list-box" style="border-top: 1px solid #E3E3E3;">
								<div class="in-list-text in-list-width">12-10</div>		
								<div class="in-list-text in-list-width">10000</div>
								<div class="in-list-text in-list-width">1858408486</div> 
							</div>
							
						</div>
						<!--结束-->
						<!--翻页-->
						<div class="in-list-box list-box-width" style="height: 50px;">
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

	    pare();
		page(1);
	    	    
	 
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
        /*文字滚动*/
        function check(){
			var num_id=$('#acc_user').val();
			$.post("{:U('User/check')}",{num_id:num_id},function(data){
				var data = eval('(' + data + ')');
				if(data['state']==0){
					error(data['msg'],3500);
					$('#acc_user').val('');
				}else{
					$('#check_name').val(data['name']);
				}
			});
		}

	 	function deposit(){
	 		var mse = ['#acc_user','#acc_num','#acc-password'];
			var msetext = ['账户名','金额','交易密码'];
			error('功能关闭',3500);
				return false;
			for(var i=0;i<mse.length;i++){
				if($(String(mse[i])).val()==''){
					error(msetext[i]+'不能为空',3500);
		 			return false;
				}
				
			}
			if($("#acc_num").val()%100!=0 || $("#acc_num").val()<100 ){
				error('转账金额为100的整倍数',3500);
				return false;
			}
			/*if($("#acc_num").val()>=$("#user_gold").val()){
				error('余额不足',3500);
				return false;
			}*/
			if($("#acc-password").val().length<6){
				error('交易密码错误',3500);
				return false;
			}
			var num_id=$('#acc_user').val();
			var money=$('#acc_num').val();
			var password=$('#acc-password').val();
			
			$.post("{:U('User/account_trade')}",{num_id:num_id,money:money,password:password},function(data){
				var data = eval('(' + data + ')');
				error(data['msg'],3500);
				setTimeout(function () {
					window.location.href='__ROOT__/index.php/Home/User/accounts';
				},3500)
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
		 }
	
		var o = '';
		function page(type){
			/*if(o==undefined){
				//alert(1);
			}*/
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
			//alert(o);
			$.post("{:U('User/accounts')}",{o:o},function(data){
				var data = eval('(' + data + ')');
				$('#extract_box').html('').html(data['data']);
				$('#extract_now_page').text('').text(data['o']);
				$('#page_num').val('').val(data['o']);
				$('#extract_last_page').text('').text(data['count']);
			});
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

