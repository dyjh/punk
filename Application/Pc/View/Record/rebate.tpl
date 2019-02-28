<extend name="Public:base" />
<block name="content">
<style type="text/css">
	.weijiesuan{
		position: absolute;
	    height: 30px;
	    line-height: 30px;
	    top: 42px;
	    font-size: 1.2rem;
	    margin-top: 0%;
	    display: block;
	    width: 100%;
	}
	.weijiesuan span{
	    font-size: 1.2rem;
	    font-weight: normal;
	    margin-top: 0;
	    color: #f00 !important;
	}
</style>
		<div class="body">
			<input type="hidden" value="返佣列表" id="titles"> 
			<div class="marked-body" style="position: relative;background: none">	
				<div class="trade-scll">
					<span class="color-fff">返佣列表</span>
				</div>


				<div class="rebate-option">
					<div class="width-three rebate-list" onclick="marked(1)" style="position: relative;">
						<span class="bold size-16 color-00">本周</span>
						<div class="weijiesuan" style="position: absolute;">
							<span>未结算金额：{$rebate}</span>
						</div>
					</div>
					<div class="width-three rebate-list"onclick="marked(2)">
						<span class="bold size-16 color-72">上周</span>
					</div>
					<div class="width-three rebate-list"onclick="marked(3)">
						<span class="bold size-16 color-72">前两周</span>
					</div>
				</div>

				<!--本周-->
				<div class="marked-list-body marked-list-body1" style="display: block;">
					<div class="marked-head-msg">
						<div class="msg-list msg-list-left">时间</div>
						<div class="msg-list msg-list-left width-two">金额</div>
						<div class="msg-list msg-list-left">来源</div>
						<div class="msg-list msg-list-left width-two">类型</div>
					</div>

					<div class="rebate-list-box">
						<volist name="data_first" id="f">
							<div class="list-box-a">
								<div class="list-box-text list-box-pandding width-29">
									<span>{$f.time|date="m-d H:i",###}</span>
								</div>
								<div class="list-box-text list-box-pandding width-two">
									<span>{$f.money}</span>
								</div>
								<div class="list-box-text list-box-pandding msg-list-left">
									<span>{$f.from_id}</span>
								</div>
								<div class="list-box-text list-box-pandding width-two">
								<if condition="$f['type'] eq 0">
									<span>直推</span>
								<else/>
									<span>代理</span>
								</if>
								</div>
							</div>
						</volist>
					</div>
				</div>


				<!--上周-->
				<div class="marked-list-body marked-list-body2">
					<div class="marked-head-msg">
						<div class="msg-list msg-list-left">时间</div>
						<div class="msg-list msg-list-left width-two">金额</div>
						<div class="msg-list msg-list-left">来源</div>
						<div class="msg-list msg-list-left width-two">类型</div>
					</div>

					<div class="rebate-list-box">
						<volist name="data_second" id="s">
							<div class="list-box-a">
								<div class="list-box-text list-box-pandding width-29">
									<span>{$s.time|date="m-d H:i",###}</span>
								</div>
								<div class="list-box-text list-box-pandding width-two">
									<span>{$s.money}</span>
								</div>
								<div class="list-box-text list-box-pandding msg-list-left">
									<span>{$s.from_id}</span>
								</div>
								<div class="list-box-text list-box-pandding width-two">
								<if condition="$s['type'] eq 0">
									<span>直推</span>
								<else/>
									<span>代理</span>
								</if>
								</div>
							</div>
						</volist>
					</div>
				</div>

				<!--前两周-->
				<div class="marked-list-body marked-list-body3">
					<div class="marked-head-msg">
						<div class="msg-list msg-list-left">时间</div>
						<div class="msg-list msg-list-left width-two">金额</div>
						<div class="msg-list msg-list-left">来源</div>
						<div class="msg-list msg-list-left width-two">类型</div>
					</div>

					<div class="rebate-list-box">
						<volist name="data_last" id="l">
							<div class="list-box-a">
								<div class="list-box-text list-box-pandding width-29">
									<span>{$l.time|date="m-d H:i",###}</span>
								</div>
								<div class="list-box-text list-box-pandding width-two">
									<span>{$l.money}</span>
								</div>
								<div class="list-box-text list-box-pandding msg-list-left">
									<span>{$l.from_id}</span>
								</div>
								<div class="list-box-text list-box-pandding width-two">
								<if condition="$l['type'] eq 0">
									<span>直推</span>
								<else/>
									<span>代理</span>
								</if>
								</div>
							</div>
						</volist>
					</div>
				</div>



			</div>
		</div>



		<!--底部-->
		

<script type="text/javascript">

	    pare();

	    	    
	 	function marked(id){
	 		$(".marked-list-body").hide();
	 		$(".marked-list-body"+id).fadeIn(350);
	 		if(id==1){
	 			$(".weijiesuan").show();
	 		}else{
	 			$(".weijiesuan").hide();
	 		}
	 	}

	 	$(".rebate-list").click(function(){
	 		$(".rebate-list span").css({"color":"#727272"})
	 		$(this).find('span').css({"color":"#000"})
	 	})

	 	

</script>
</block>

