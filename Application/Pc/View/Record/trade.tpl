<extend name="Public:base" />
<block name="content">

		<div class="body">	
		<input type="hidden" value="交易明细" id="titles"> 
			<div class="body-head">
				<div class="header-scll trade-scll" style="opacity: 1;text-align: center;">
					<span style="color: #fff;">交易明细</span>
				</div>	
			</div>
			<div class="mine-hd-num">
				<div class="mine-num-list">
					<div class="mine-num-text"><span class="bold size5">交易金额</span></div>
					<div class="mine-num-text"><span  class="bold size5" style="color: #f00;">{$invest}</span></div>
				</div>
				
				<div class="mine-num-list">
					<div class="mine-num-text"><span  class="bold size5">预计估利</span></div>
					<div class="mine-num-text"><span class="bold size5" style="color:#51A44B;">{$forecast}</span></div>
				</div>	
			</div>

			<div class="mine-hd-num mine-hd-bg">
				<div class="mine-num-list mine-num-five">
					<div class="mine-num-text mine-num-text1">
						<span style="color: #dbdbdb;">投注场次</span>
					</div>		
				</div>
				<div class="mine-num-list mine-num-two">
					<div class="mine-num-text mine-num-text1">
						<span style="color: #dbdbdb;">类型</span>
					</div>		
				</div>
				<div class="mine-num-list mine-num-two">
					<div class="mine-num-text mine-num-text1">
						<span style="color: #dbdbdb;">资金</span>
					</div>
				</div>
			</div>
			<div class="trade-box trade-box-ht">
				<volist name="data" id="v">
					<div id="div{$v.id}" class="score-box trade-list-box border-top">
						<div class="score-left mine-num-five" style="border: none">
							<div class="score-left-list" style="position: relative;">
								<span style="position: absolute; font-size: 1.2rem;top: -24px;width: 100%;left: 0%">开赛时间：</span>
								<span class="score-time">{$v.start_time|date="m-d",###} / {$v.start_time|date="H:i",###} {$v.area}</span>
							</div>
							<div class="score-left-list">
								<span>{$v.team_first}</span>
								<span class="score-time">&nbsp;vs&nbsp;</span>
								<span>{$v.team_second}</span>
							</div>
						</div>
						<div class="score-right mine-num-two">
							<div class="score-left-list">
								<span class="score-time">
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
								<span style="color: #EDA12D;">{$v.score}</span>	
							</div>
						</div>
						<div class="score-right mine-num-two">
							<div class="score-left-list" >
								<span class="score-time" style="color: #f00">{$v.principal}</span>
							</div>
							<div class="score-left-list" style="position: relative;">
								<span style="color: #51A44B;">{$v.forecast}</span>	
								<button class="btn" onclick="back({$v.id}+'-'+{$v.case},{$v.score})" style="position: absolute;width: 50px;top: -28px;left: 70%;background-color: #f00;">撤销</button>
							</div>
						</div>
					</div>
					

				</volist>
			</div>




		</div>




<script type="text/javascript">

	    pare();

	    function back(id,score){
		//alert(id);
			$.post("{:U('Record/back')}",{id:id,score:score},function(data){
				var data = eval('(' + data + ')');
				error(data['msg'],2000);
				if(data['state']==1){
					$('#div'+data['id']).remove();
					setTimeout(function () {
                        window.location.href='__ROOT__/index.php/Pc/Index/index';
                    },1000)
				}
			});
		}	    
	 
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
       
	
	

</script>
</block>

