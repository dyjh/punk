<extend name="Public:base" />
<block name="content">

		<div class="body">	
		<input type="hidden" value="交易明细" id="titles"> 
			<div class="body-head" style="height: 8%;">
				<div class="header-scll" style="opacity: 1;text-align: center;">
					<span style="font-size: 1.6rem;color: #fff;margin-top: 2%">交易明细</span>
				</div>	
			</div>
			<div class="mine-hd-num" style="height: 12.5%">
				<div class="mine-num-list" style="width: 50%">
					<div class="mine-num-text"><span class="bold size5" style="margin-top: 5%">交易金额</span></div>
					<div class="mine-num-text"><span  class="bold size5" style="color: #f00;margin-top: 2%">{$invest}</span></div>
				</div>
				
				<div class="mine-num-list"  style="width: 50%">
					<div class="mine-num-text"><span  class="bold size5" style="margin-top: 5%">预计估利</span></div>
					<div class="mine-num-text"><span class="bold size5" style="color:#51A44B;margin-top: 2%">{$forecast}</span></div>
				</div>	
			</div>

			<div class="mine-hd-num" style="height: 7.5%;background: #282828">
				<div class="mine-num-list" style="width: 45%;">
					<div class="mine-num-text mine-num-text1">
						<span style="color: #dbdbdb;margin-top: 5%;">投注场次</span>
					</div>		
				</div>
				<div class="mine-num-list" style="width: 20%;">
					<div class="mine-num-text mine-num-text1">
						<span style="color: #dbdbdb;margin-top: 10%;">类型</span>
					</div>		
				</div>
				<div class="mine-num-list" style="width: 20%;">
					<div class="mine-num-text mine-num-text1">
						<span style="color: #dbdbdb;margin-top: 10%;">资金</span>
					</div>
				</div>
			</div>
			<div class="trade-box">
				<volist name="data" id="v">
					<div id="div{$v.id}" class="score-box trade-list-box" style="height: 20%;">
						<div class="score-left" style="width: 45%;border: none">
							<div class="score-left-list" style="margin-top: 8%;position:relative">
								<span style="position: absolute; font-size: 1.2rem;top: -63%;width: 100%;left: 0%">开赛时间：</span>
								<span class="score-time" style="">{$v.start_time|date="m-d",###} / {$v.start_time|date="H:i",###} {$v.area}</span>
							</div>
							<div class="score-left-list">
								<span>{$v.team_first}</span>
								<span class="score-time">&nbsp;vs&nbsp;</span>
								<span>{$v.team_second}</span>
							</div>
						</div>
						<div class="score-right" style="width: 20%">
							<div class="score-left-list" style="margin-top: 16%;">
								<span class="score-time" style="font-size: 1.6rem;">
									<if condition="$v['type'] eq 0">
										全场
									<elseif condition="$v['type'] eq 1"/>
										半场
									<elseif condition="$v['type'] eq 2"/>
										进球数
									</if>
								</span>
							</div>
							<div class="score-left-list">
								<span style="color: #EDA12D;margin-top: 2%">{$v.score}</span>	
							</div>
						</div>
						<div class="score-right" style="width: 20%;position: relative;">
							<div class="score-left-list" style="margin-top: 16%;">
								<span class="score-time" style="font-size: 1.6rem;color: #f00">{$v.principal}</span>
								<button class="btn" onclick="back({$v.id}+'-'+{$v.case},{$v.score})" style="position: absolute;width: 50px;top: 23%;left: 90%;background-color: #f00;">撤销</button>
							</div>

							<div class="score-left-list">
								<span style="color: #51A44B;margin-top: 2%;">{$v.forecast}</span>	
							</div>
						</div>
					</div>
				</volist>
			</div>




		</div>




<script type="text/javascript">

	    pare();

	    	    
	 
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
       
		function back(id,score){
		//alert(id);
			$.post("{:U('Record/back')}",{id:id,score:score},function(data){
				var data = eval('(' + data + ')');
				error(data['msg'],2000);
				if(data['state']==1){
					$('#div'+data['id']).remove();
					setTimeout(function () {
                        window.location.href='__ROOT__/index.php/Home/Index/index';
                    },1000)
				}
			});
		}
	

</script>
</block>

