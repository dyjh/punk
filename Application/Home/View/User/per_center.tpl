<extend name="Public:base" />
<block name="content">

		<div class="body">
		<input type="hidden" value="我的" id="titles"> 
			<div class="body-head" style="height: 8%;">
				<div class="header-scll" style="opacity: 1;text-align: center;">
					<span style="font-size: 1.6rem;color: #fff;margin-top: 2%">我的</span>
				</div>	
			</div>
			<div class="mine-hd-bg">
				<div class="mine-bg-list" style="height: 50%;margin-top: 1.5%"><img src="__PUBLIC__/images/mine-bg-logo.png"></div>
				<div class="mine-bg-list" style="margin-top: 2.5%"><span>{$name}</span></div>
				<div class="mine-bg-list"><span onclick="login_out()">退出</span></div>
			</div>
			<div class="mine-hd-num">
				<div class="mine-num-list" style="width:25%;">
					<div class="mine-num-text"><span style="margin-top: 6%;">未结算金额</span></div>
					<div class="mine-num-text"><span style="margin-top: 4%">{$sum_principal}</span></div>
				</div>
				<div class="mine-num-list" style="width:25%;">
					<div class="mine-num-text"><span style="margin-top: 6%">正在交易</span></div>
					<div class="mine-num-text"><span style="margin-top: 4%">{$count}</span></div>
				</div>
				<div class="mine-num-list" style="width:25%;">
					<div class="mine-num-text"><span style="margin-top: 6%">代理人数</span></div>
					<div class="mine-num-text"><span style="margin-top: 4%">{$direct}</span></div>
				</div>
				<div class="mine-num-list" style="width:25%;">
					<div class="mine-num-text"><span style="margin-top: 6%">团队人数</span></div>
					<div class="mine-num-text"><span style="margin-top: 4%">{$team}</span></div>
				</div>
			</div>
			<div class="mine-by-box">

					<div class="mine-by-list">
						<div class="mine-by-left"><img src="__PUBLIC__/images/mine-icon6.png"></div>
						<div class="mine-by-right"><span>账户状态</span><span style="color: {$color};text-indent: 62%">{$state}</span></div>
					</div>
	
				<a href="{:U('Pay/recharge')}">
					<div class="mine-by-list">
						<div class="mine-by-left"><img src="__PUBLIC__/images/mine-icon1.png"></div>
						<div class="mine-by-right"><span>充值与提现</span></div>
					</div>
				</a>
				<!--<a href="{:U('User/accounts')}">
					<div class="mine-by-list">
						<div class="mine-by-left"><img src="__PUBLIC__/images/mine-icon2.png"></div>
						<div class="mine-by-right"><span>用户转账</span></div>
					</div>
				</a>-->
				<a href="{:U('User/edit_user')}">
					<div class="mine-by-list">
						<div class="mine-by-left"><img src="__PUBLIC__/images/mine-icon3.png"></div>
						<div class="mine-by-right"><span>个人资料</span></div>
					</div>
				</a>
				<a href="{:U('Login/regist',array('num'=>$num_id))}">
					<div class="mine-by-list">
						<div class="mine-by-left"><img src="__PUBLIC__/images/mine-icon4.png"></div>
						<div class="mine-by-right"><span>注册玩家</span></div>
					</div>
				</a>
				<a href="{:U('User/team')}">
					<div class="mine-by-list">
						<div class="mine-by-left"><img src="__PUBLIC__/images/mine-icon5s.png" style="width: 50%;margin-left: 35%;margin-top:17%"></div>
						<div class="mine-by-right"><span>代理列表</span></div>
					</div>
				</a>
				
			</div>

		</div>


<script type="text/javascript">

	    pare();

	    	    
	 
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
        /*文字滚动*/
        function login_out(){
			$.post("{:U('Login/login_out')}",function(msg){
				if(msg==1){
					error('成功注销',3500)
					setTimeout(function () {
                        window.location.href='__ROOT__/index.php/Home/Login/login';
                    },3500);
				}
			});
		}

	 	
	

</script>
</block>

