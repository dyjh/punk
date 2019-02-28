<extend name="Public:base" />
<block name="content">
<style type="text/css">
	.option-list span {
    
   		 margin-top: 15%;	
	}
	.weijiesuan{
		position: absolute;
	    height: 30px;
	    line-height: 30px;
	    top: 53%;
	    font-size: 1.2rem;
	    margin-top: 0%;
	    display: block;
	}
	.weijiesuan span{
	    font-size: 1.2rem;
	    font-weight: normal;
	    margin-top: 0;
	    color: #f00 !important;
	}
	.list-box-a:last-child {
    margin-bottom: 0%;
}
</style>
		<div class="body">
			<input type="hidden" value="返佣列表" id="titles"> 
			<div class="marked-body" style="position: relative;background: none">


				
				<div class="marked-option marked-option-detail" style="top: 0;background: #282828;text-indent: 0;text-align: center;">
					<div style="width: 100%"><span style="margin-top: 3%;color: #E9E9E9;font-size: 1.6rem">返佣列表</span></div>
				
				</div>


				<div class="marked-option marked-option-detail" style="top: 10%">
					<div class="option-list option-list1 option-list-maginleft" onclick="marked(1)"><span >本周</span>
						<div class="weijiesuan" style="position: absolute;">
							<span>未结算领导奖：{$rebate}</span>
						</div>
					</div>
					<div class="option-list option-list-maginleft" onclick="marked(2)"><span>上周</div>
					<div class="option-list option-list-maginleft" onclick="marked(3)"><span>前两周</div>
				</div>

				<!--本周-->
				<div class="marked-list-body marked-list-body1" style="height: 73.5%; margin-top: 34%;overflow: auto;display: block;">
					<div class="marked-head-msg" style="top: 20%">
						<div class="msg-list msg-list-left" style="width: 29%">时间</div>
						<div class="msg-list msg-list-left" style="width: 22%" style="width: 30%">金额</div>
						<div class="msg-list msg-list-left" style="width: 32%">来源</div>
						<div class="msg-list msg-list-left" style="width: 15%">类型</div>
					</div>

					<div class="msg-list-box">
						<volist name="data_first" id="f">
							<div class="list-box-a">
								<div class="list-box-text list-box-pandding" style="width: 29%"><span>{$f.time|date="m-d H:i",###}</span></div>
								<div class="list-box-text list-box-pandding" style="width: 22%"><span>{$f.money}</span></div>
								<div class="list-box-text list-box-pandding" style="width: 30%"><span>{$f.from_id}</span></div>
								<div class="list-box-text list-box-pandding" style="width: 15%">
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
				<div class="marked-list-body marked-list-body2" style="height: 73.5%; margin-top: 34%;overflow: auto;">
					<div class="marked-head-msg" style="top: 20%">
						<div class="msg-list msg-list-left" style="width: 29%">时间</div>
						<div class="msg-list msg-list-left" style="width: 22%" style="width: 30%">金额</div>
						<div class="msg-list msg-list-left" style="width: 32%">来源</div>
						<div class="msg-list msg-list-left" style="width: 15%">类型</div>
					</div>

					<div class="msg-list-box">
						<volist name="data_second" id="s">
							<div class="list-box-a">
								<div class="list-box-text list-box-pandding" style="width: 29%"><span>{$s.time|date="m-d H:i",###}</span></div>
								<div class="list-box-text list-box-pandding" style="width: 22%"><span>{$s.money}</span></div>
								<div class="list-box-text list-box-pandding" style="width: 30%"><span>{$s.from_id}</span></div>
								<div class="list-box-text list-box-pandding" style="width: 15%">
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
				<div class="marked-list-body marked-list-body3" style="height: 73.5%; margin-top: 34%;overflow: auto;">
					<div class="marked-head-msg" style="top: 20%">
						<div class="msg-list msg-list-left" style="width: 29%">时间</div>
						<div class="msg-list msg-list-left" style="width: 22%" style="width: 30%">金额</div>
						<div class="msg-list msg-list-left" style="width: 32%">来源</div>
						<div class="msg-list msg-list-left" style="width: 15%">类型</div>
					</div>

					<div class="msg-list-box">
						<volist name="data_last" id="l">
							<div class="list-box-a">
								<div class="list-box-text list-box-pandding" style="width: 29%"><span>{$l.time|date="m-d H:i",###}</span></div>
								<div class="list-box-text list-box-pandding" style="width: 22%"><span>{$l.money}</span></div>
								<div class="list-box-text list-box-pandding" style="width: 30%"><span>{$l.from_id}</span></div>
								<div class="list-box-text list-box-pandding" style="width: 15%">
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

	 	$(".option-list").click(function(){
	 		$(".option-list span").css({"color":"#727272"})
	 		$(this).find('span').css({"color":"#000"})
	 	})

	 	

</script>
</block>

