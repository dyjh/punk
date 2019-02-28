<extend name="Public:base" />
<block name="content">
<style type="text/css">
	.bill-img{
		position: absolute;
	    width: 36%;
	    left: 62%;
	    top: 29%;
	}
	.bill-img img{
		
		width: 101%;
	}
	.mine-num-text:first-child span {
    font-size: 1.4rem;
    color: #7C7C7C;
    margin-top: 6%;
}
</style>

		<div class="body" style="background: #ccc">	
		<input type="hidden" value="历史账务" id="titles"> 
			<div class="body-head" style="height: 8%;">
				<div class="header-scll" style="opacity: 1;text-align: center;">
					<span style="font-size: 1.6rem;color: #fff;margin-top: 2%">历史账务</span>
				</div>	
			</div>
			<div class="mine-hd-num" style="height: 12.5%">
				<div class="mine-num-list" style="width: 50%">
					<div class="mine-num-text"><span class="bold size5">波胆总计</span></div>
					<div class="mine-num-text"><span  class="bold size5" style="color: #f00;margin-top: 3%">{$invest}</span></div>
				</div>
				<div class="mine-num-list"  style="width: 50%">
					<div class="mine-num-text"><span  class="bold size5">盈亏</span></div>
					<div class="mine-num-text"><span class="bold size5" style="color:#51A44B;margin-top: 3%">{$profit}</span></div>
				</div>	
			</div>
			
			<div class="bill-body-box">
				<volist name="data" id="v">
					<div class="score-box trade-list-box bill-body-background" style="height: 55.5%;position: relative;" >
						<div class="bill-img">
							<if condition="$v['state'] eq 1">
								<img src="__PUBLIC__/images/success.png">
							<else/>
								<img src="__PUBLIC__/images/return.png">
							</if>
						</div>
						<div class="bill-box">
							<span>单<small style="opacity: 0;margin-top: 0">单号</small>号：{$v.order_num}
								<if condition="$v['state'] eq 3">
									(系统撤销)
								</if>
							</span>
						</div>
						<div class="bill-box">
							<span style="color: #ECA534">【{$v.area}】：{$v.team_first} vs {$v.team_second}</span>
						</div>
						<div class="bill-box">
							<span>交易时间：{$v.add_time|date="Y-m-d H:i",###}</span>
						</div>
						<div class="bill-box">
							<span>开赛时间：{$v.start_time|date="Y-m-d H:i",###}</span>
						</div> 
						<div class="bill-box">
							<span>波胆项目：{$v.score_name} {$v.score}</span>
						</div>
						<!--新加-->
						<div class="bill-box">
							<if condition="$v['state'] eq 1">
								<span>波胆结果：{$v.score_game}</span>
							<else/>
								<span>波胆结果：---</span>
							</if>
						</div>
						<div class="bill-box">
							<span>交易点数：<small style="color: #f00;font-size: 1.3rem">{$v.principal}</small> &nbsp;&nbsp;&nbsp;&nbsp;收益率：<small style="color: #f00;font-size: 1.3rem">{$v.odds}%</small></span>
						</div>
						<div class="bill-box">
							<if condition="$v['state'] eq 1">
								<span>收益结果：<small style="color: #51A44B;">{$v.forecast}</small> </span>
							<else/>
								<span>收益结果：<small style="color: #51A44B;">本金已退</small> </span>
							</if>
						</div>
					</div>
				</volist>
			</div>

			




		</div>



		<!--底部-->


<script type="text/javascript">

	    pare();

	    	    
	 
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
       
	
	

</script>
</block>

