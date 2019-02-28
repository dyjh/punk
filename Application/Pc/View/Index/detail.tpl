<extend name="Public:base" />
<block name="content">
<style type="text/css">
	.list-box-a{
		cursor: pointer;
	}
</style>
		<div class="body">
			<div class="body-head">
				<div class="header-scll" style="opacity: 1;">
					<img src="__PUBLIC__/images/laba.png">
					<div class="scll-text"><a style="color:#FFF;font-size: 1.4rem;font-weight: bold;" href="{:U('Index/notice')}"><span>{$info}</span></a></div>
				</div>
			</div>
			<div class="marked-body" style="position: relative;">

			<!--对战记录弹出框-->
			<div class="market-alert market-alert1" style="display: none">

				<div class="mat-al-head">
					<div class="mat-head-list" style="position: relative;">
						<span class="bold">对战记录</span> 
						<span class="closes" onclick="closes('market-alert1')">关闭</span>
					</div>
					<div class="mat-head-list mat-head-list2 mat-head-list2-height">
						<div class="mat-text-list"><span>主场</span></div>
						<div class="mat-text-list mat-text-lists"><span>全场</span></div>
						<div class="mat-text-list"><span>客场</span></div>
						<div class="mat-text-list mat-text-lists"><span>半场</span></div>
					</div>
				</div>
				<!--对战记录插入 class名mat-al-body-->
				<div class="mat-al-body" style="overflow: auto;">
				
					<!--<div class="mat-body-box">
						<div class="mat-body-list"><span class="mat-tl">{$p.area} {$p.time|date="Y-m-d H:i:s",###}</span></div>
						<div class="mat-body-list">
							<div class="mat-battle-list border-right">{$p.team_first}</div>
							<div class="mat-battle-list mat-text-lists border-right">{$p.score}</div>
							<div class="mat-battle-list border-right">{$p.team_second}</div>
							<div class="mat-battle-list mat-text-lists border-right">{$p.half}</div>
						</div>
					</div>-->
					<volist name="history" id="p">
					<div class="mat-body-box">
						<div class="mat-body-list"><span class="mat-tl">{$p.area} {$p.time|date="Y-m-d H:i:s",###}</span></div>
						<div class="mat-body-list">
							<div class="mat-battle-list border-right">{$p.team_first}</div>
							<div class="mat-battle-list mat-text-lists border-right">{$p.score}</div>
							<div class="mat-battle-list border-right">{$p.team_second}</div>
							<div class="mat-battle-list mat-text-lists border-right">{$p.half}</div>
						</div>
					</div>
				</volist>
				
				</div>

			</div>




			<!--比分选择框-->

			<div class="market-alert market-alert2" style="display: none">
				<div class="mat-al-head">
					<div class="mat-head-list" style="position: relative;">
						<span class="bold">交易信息</span> 
					</div>
					<div class="mat-head-list mat-head-list2">
						<div class="mat-text-list mat-text-wt">
							<span id="score">您正在反对波胆 0-1</span>
						</div>
					</div>
					<input type="hidden" name="score" value=""/>
					<input type="hidden" name="odds" value=""/>
					<input type="hidden" name="type" value=""/>
				</div>
				<div class="score-box">
					<div class="score-left">
						<div class="score-left-list">
							<span class="score-time">{$game.time|date="m-d",###} / {$game.time|date="H:i",###} {$game.area}</span>
						</div>
						<div class="score-left-list">
							<span>{$game.team_first}(主)</span>
							<span class="score-time">&nbsp;vs&nbsp;</span>
							<span>{$game.team_second}</span>
						</div>
					</div>
					<div class="score-right">
						<div class="score-left-list">
							<span id="odd_name" class="score-time">波胆</span>
						</div>
						<div class="score-left-list">
							<span id="score_se" style="color: #EDA12D">0&nbsp;-&nbsp;0</span>	
						</div>
					</div>
				</div>
		
				<div class="mat-head-list mat-head-list2">
					<div class="mat-text-list mat-list-height"><span>交易金额</span></div>
					<div class="mat-text-list mat-list-height mat-list-wt"><span>获利%</span></div>
					<div class="mat-text-list mat-list-height"><span>预计估利</span></div>				
				</div>

				<div class="score-footer">
					<div class="score-footer-list border-bottom">
						<div class="score-input">
							<input type="text" placeholder="请输入金额" oninput="score_gold()" id="score_gold" autocomplete="off">
							<span class="color-red">USD</span>
							<span class="x-wt">x</span>
							<span id="odds"></span><span>%</span>
							<span class="x-wt">=</span>
							<span id="profit">---USD</span>
						</div>
						<div class="score-input">
						<input type="hidden" id='score_type' value=""/>
							<button class="btn" id="btn-text" onclick="full()">全部下注</button>
							<span></span>
						</div>
					</div>
					<div class="score-footer-list border-bottom">
						<div class="score-footer-hd">
							<span>可用余额：</span>
							<span id="my_gold">{$money}</span>
							<span onclick="coin()">&nbsp;刷新</span>
						</div>
						<div class="score-footer-bd">
							<button class="btn footer-bd-btn" onclick="make_sure()">确定交易</button>
							<button class="btn footer-bd-btn" onclick="closes('market-alert2')">取消交易</button>
						</div>
					</div>
						
				</div>
				

			</div>
			
			
			
			
			<!--确定交易弹框-->
			<div class="market-sure-box" style="display: none">
				<div class="body-head">
					<div class="header-scll detail-header-scll">
						<span>下注</span>
					</div>	
				</div>
				<div class="input-box-register">
					<span>交易密码：</span>
					<input type="password" name="" placeholder="请输入交易密码" autocomplete="off" id="userpassword"> 
				</div>
				<div class="rechange-input detail-rechange-input">
					<button class="zc-input btns" onclick="market_sure()" style="font-size: 16px;font-weight: bold;">提交</button>
					<button class="zc-input btns" onclick="market_return()" style="font-size: 16px;font-weight: bold;">返回</button>
				</div>
			</div>
			
			

			<!--首页-->

				<div class="marked-option marked-option-detail">
					<div class="marked-list marked-list-detail">
						<div class="list-head">
							<div class="marked-head-time"><span>{$game.time|date="m/d",###} {$game.time|date="H:i",###}</span></div>
							<div class="marked-head-name">
								<span>{$game.area}</span>
								<span onclick="battle_show('market-alert1')" class="detail-head-text">对战记录</span>
							</div>
						</div>
						<div class="marked-list-box">
							<a href="{:U('Index/index')}">
								<div class="list-box marked-return"><img src="__PUBLIC__/images/left-arrow.png" class="right-arrow"></div>
							</a>
							<div class="list-box list-box-span list-detail">
								<span class="size5 box-span-width">{$game.team_first}(主)</span>
								<span class="size4 box-span-width list-box-vs">VS</span>
								<span class="size5 box-span-width">{$game.team_second}</span>
							</div>							
						</div>
					</div>
				</div>
				<div class="marked-option marked-detail">
					<div class="option-list option-list-detail" onclick="marked(1)"><span>全场</span></div>
					<div class="option-list" onclick="marked(2)"><span>半场</div>
					<div class="option-list" onclick="marked(3)"><span>总进球数</div>
				</div>
				<input type="hidden" name="game" value="{$id}"/>
				

				<!--波胆-->
				<div class="marked-list-body marked-list-body1 detail-list-body" style="display: block;">

					<!--<div class="marked-volume">
						<span>成交量：{$count_all}</span>
					</div>-->
					
					<div class="marked-head-msg">
						<div class="msg-list">选项</div>
						<div class="msg-list">获利</div>
						<div class="msg-list">可交易量</div>
					</div>

					<div class="msg-list-box">
						<volist name="odds_all" id="val">
							<div class="list-box-a" onclick="battle_show('market-alert2','{$val.score}','{$val.odds}','{$val.type}','0')">
								<div class="list-box-text"><span>{$val.score}</span></div>
								<div class="list-box-text"><span>{$val.odds}%</span></div>
								<div class="list-box-text"><span>$ {$val.max_money}</span></div>
							</div>
						</volist>
					</div>
					
				</div>


				<!--半场-->
				<div class="marked-list-body marked-list-body2 detail-list-body">
					<!--<div class="marked-volume">
						<span>成交量：{$count_half}</span>
					</div>-->
					
					<div class="marked-head-msg">
						<div class="msg-list">选项</div>
						<div class="msg-list">获利</div>
						<div class="msg-list">可交易量</div>
					</div>

					<div class="msg-list-box">
						<volist name="odds_half" id="vo">
							<div class="list-box-a" onclick="battle_show('market-alert2','{$vo.score}','{$vo.odds}','{$vo.type}','1')">
								<div class="list-box-text"><span>{$vo.score}</span></div>
								<div class="list-box-text"><span>{$vo.odds}%</span></div>
								<div class="list-box-text"><span>￥ {$vo.max_money}</span></div>
							</div>
						</volist>
					</div>
								
					
				</div>


				<!--得分-->
				<div class="marked-list-body marked-list-body3 detail-list-body">
					<!--<div class="marked-volume">
						<span>成交量：{$count_half}</span>
					</div>-->
					
					<div class="marked-head-msg">
						<div class="msg-list">选项</div>
						<div class="msg-list">获利</div>
						<div class="msg-list">可交易量</div>
					</div>

					<div class="msg-list-box">
						<volist name="odds_number" id="vc">
							<div class="list-box-a" onclick="battle_show('market-alert2','{$vc.score}','{$vc.odds}','{$vc.type}','2')">
								<div class="list-box-text"><span>进球{$vc.score}个以上</span></div>
								<div class="list-box-text"><span>{$vc.odds}%</span></div>
								<div class="list-box-text"><span>￥ {$vc.max_money}</span></div>
							</div>
						</volist>
					</div>
				

				</div>



			</div>
		</div>



		
		

<script type="text/javascript">

	    pare();

	    	    
	 
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
		/*文字滚动*/
		var classSpan = $(".scll-text span");
		var Text_length = classSpan.width();
		var div_length = $('.scll-text').width();
		console.log(div_length);
	 	
	 	var a = 0;
	 	function roll(){
	 		a = a-1
	       classSpan.css('margin-left',a+'px');
	 		if(a<=-Text_length){
	 			classSpan.css('margin-left',(Text_length+div_length)+'px');
	 			a = div_length;
	 		}
	 	}
	 	
	 	setTimeout(function(){
	 		setInterval(roll,50);
	 	},2000)
		
		function coin(){
		//alert(1);
			$.post("{:U('Index/coin')}",function(data){
				var data = eval('(' + data + ')');
				if(data['state']==1){
					$("#my_gold").text('').text(data['money']);
				}
			});
		}

	 	/*波胆 半场 得分*/

	 	function marked(id){
	 		$(".marked-list-body").hide();
	 		$(".marked-list-body"+id).fadeIn(350);
	 	}

	 	$(".option-list").click(function(){
	 		$(".option-list span").css({"color":"#727272"})
	 		$(this).find('span').css({"color":"#000"})
	 	})
	 	/*交易弹框设置行高*/

	 	$(".mat-list-height span").css({"line-height":25+'px'})

		

	 	/*投注金额计算*/

	 	function score_gold(){
			var money=$("#score_gold").val()*($("#odds").text()/100);
			money=money*100;
			money=parseInt(money)
			money=money/100;
	 		$("#profit").text(money+'USD');	
	 		if($("#score_gold").val()>9999999){
	 			$("#score_gold").val(9999999);	
	 		}
	 	}

	 	/*全部投注*/

	 	/*
	 	function full(){
	 		$("#score_gold").val(parseInt($("#my_gold").text()))
			var money=$("#score_gold").val()*($("#odds").text()/100);
			money=money*100;
			money=parseInt(money)
			money=money/100;
	 		$("#profit").text(money);
	 		score_type = 2;
	 	}
*/
		var score_type = 1;
	 	function full(){	
			
	 		if($("#btn-text").text()=='全部下注'){
				$("#score_gold").val(parseInt($("#my_gold").text()))
		 		$("#score_gold").attr("disabled",true);
		 		$("#btn-text").text('取消全部'); 
		 		score_type = 2;
		 		score_gold();
		 		return false;	
	 		}
	 		if($("#btn-text").text()=='取消全部'){
				$("#score_gold").val(parseInt($("#my_gold").text()))
		 		$("#score_gold").attr("disabled",false);
		 		$("#btn-text").text('全部下注'); 
		 		score_type = 1;
		 		score_gold();
		 		return false;	
	 		}
	 		
	 	}


		
		
		
	 	/*确定交易*/


/*
	 	function make_sure(){
			var money=$("#score_gold").val();
			var score=$('input[name="score"]').val();
			var id=$('input[name="game"]').val();
			var odds=$('input[name="odds"]').val();
			var type=$('input[name="type"]').val();
	 		if($("#score_gold").val()==parseInt($("#my_gold").text())){
				if($("#score_gold").val()==0){
					error('下注金额不能为0',1500)
					return false;
				}
				$.post("{:U('Index/bet')}",{money:money,score:score,id:id,odds:odds,type:type},function(data){
					var data = eval('(' + data + ')');
					error(data['res'],1500);
					setTimeout(function () {
                        window.location.href='__ROOT__/index.php/Pc/Index/detail?id='+id;
                    },1500)
					return false;
				});
				
	 		}
	 		if(score_type==1){
	 			if($("#score_gold").val()%100!=0){
	 				error('请输入100的整倍数',3500)
					return false;
	 			}
	 		}
	 		
	 		if($("#score_gold").val()==''){
	 			error('请输入100的整倍数',3500)
				return false;
	 		}
			if($("#score_gold").val()==0){
				error('下注金额不能为0',3500)
				return false;
			}
			
	 		$.post("{:U('Index/bet')}",{money:money,score:score,id:id,odds:odds,type:type},function(data){
				var data = eval('(' + data + ')');
				error(data['res'],3500);
				setTimeout(function () {
					window.location.href='__ROOT__/index.php/Pc/Index/detail?id='+id;
				},3500)
				return false;
			});
			
			
	 	}*/
		
		
		/*确定交易*/



	 	function make_sure(){

	 		if($("#score_gold").val()==''||$("#score_gold").val()<10){
	 			error('请输入10的整倍数',3500)
				return false;
	 		}
	 		if($("#score_gold").val()*1 > $("#my_gold").text()*1){
				error('金额不足',3500);
				return false;
			}
	 		if($("#score_gold").val()==parseInt($("#my_gold").text())){
	 			$(".market-alert2").hide();
	 			$(".market-sure-box").fadeIn(500);
				return false;
	 		}
	 		if(score_type==1){
	 			if($("#score_gold").val()%10!=0 || $("#score_gold").val()<10){
	 				error('请输入10的整倍数',3500)
					return false;
	 			}
	 		}
			if($("#score_gold").val()!=0 &&$("#score_gold").val()%10==0 ){
				$(".market-alert2").hide();
	 			$(".market-sure-box").fadeIn(500);
				return false;
			}
			

	 	}


		
		
		
		/*确定交易密码输入*/

	 	function market_sure(){
			var state=$("#score_type").val();
			var money=$("#score_gold").val();
			var score=$('input[name="score"]').val();
			var id=$('input[name="game"]').val();
			var odds=$('input[name="odds"]').val();
			var type=$('input[name="type"]').val();
			var pass=$("#userpassword").val();
	 		if($("#userpassword").val()==''){
	 			error('请输入密码',3500)
	 			return false;
	 		}
			
	 		$.post("{:U('Index/bet')}",{money:money,score:score,pass:pass,id:id,odds:odds,type:type,state:state},function(data){
				var data = eval('(' + data + ')');
				error(data['res'],3500);
				setTimeout(function () {
					window.location.href='__ROOT__/index.php/Pc/Index/detail?id='+id;
				},800)
				return false;
			});
			
	 	}

	 	/*取消交易返回下注界面*/
	 	function market_return(){
	 		$(".market-sure-box").hide();
	 		$(".market-alert2").fadeIn(500);
	 		
	 	}



</script>
</block>

