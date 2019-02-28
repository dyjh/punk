<extend name="Public:base" />
<block name="content">
<style type="text/css">
	.list-box-span .box-span-width:nth-child(2){
    margin-top: 7%;
    
}
.option-list span {
    
   
    margin-top: 15%;
  
}
.list-box-a .list-box-text span {
    padding-top: 15px;
    padding-bottom: 15px;
    display: inline-block;
}
.mat-text-list span {
    margin-top: 3%;
}
.mat-text-lists span {
    
    margin-top: 7%;
}



</style>
		<div class="body">
			<div class="body-head">
				<div class="header-scll" style="opacity: 1;">
					<img src="__PUBLIC__/images/laba.png" style="height: 55%;margin-top: 3%;margin-left: 5%; width: 8%;">
					<div class="scll-text"><a style="color:#FFF;font-size: 1.4rem;font-weight: bold;" href="{:U('Index/notice')}"><span style="font-size: 1.5rem">{$info}</span></a></div>
				</div>
			</div>
			<div class="marked-body" style="position: relative;">

			<!--对战记录弹出框-->
			<div class="market-alert market-alert1">

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

			<div class="market-alert market-alert2" style="top: 5%;">
				<div class="mat-al-head">
					<div class="mat-head-list" style="position: relative;">
						<span class="bold">交易信息</span> 
					</div>
					<div class="mat-head-list mat-head-list2">
						<div class="mat-text-list" style="width: 100%;margin-top: 1.5%">
							<span id="score" style="margin-top: 0%;font-size: 1.4rem">您正在反对波胆 0-1</span>
						</div>
					</div>
					<input type="hidden" name="score" value=""/>
					<input type="hidden" name="odds" value=""/>
					<input type="hidden" name="type" value=""/>
				</div>
				<div class="score-box">
					<div class="score-left">
						<div class="score-left-list" style="margin-top: 10%;">
							<span class="score-time">{$game.time|date="m-d",###} / {$game.time|date="H:i",###} {$game.area}</span>
						</div>
						<div class="score-left-list">
							<span>{$game.team_first}(主)</span>
							<span class="score-time">&nbsp;vs&nbsp;</span>
							<span>{$game.team_second}</span>
						</div>
					</div>
					<div class="score-right">
						<div class="score-left-list" style="margin-top: 25%;">
							<span id="odd_name" class="score-time">波胆</span>
						</div>
						<div class="score-left-list">
							<span id="score_se" style="color: #EDA12D">0&nbsp;-&nbsp;0</span>	
						</div>
					</div>
				</div>
		
				<div class="mat-head-list mat-head-list2" style="height: 10%">
					<div class="mat-text-list mat-list-height"><span>交易金额</span></div>
					<div class="mat-text-list mat-list-height" style="width: 30%"><span>获利%</span></div>
					<div class="mat-text-list mat-list-height"><span>预计估利</span></div>				
				</div>

				<div class="score-footer">
					<div class="score-footer-list border-bottom">
						<div class="score-input">
							<input type="text" placeholder="请输入金额" oninput="score_gold()" id="score_gold" style="width: 25%">
							<span style="margin-left: 1%;color: #F00">USD</span>
							<span style="margin-left: 3%">x</span>
							<span id="odds" style="width: auto;"></span><span>%</span>
							<span style="margin-left: 8%">=</span>
							<span id="profit" style="">---USD</span>
						</div>
						<div class="score-input" style="height: 40%;margin-top: 4%">
							<input type="hidden" id='score_type' value=""/>
							<button class="btn" id="btn-text" style="margin-left: 5%;float: left;" onclick="full()">全部下注</button>
							<!--<input type="button" class="btn" name="" id="btn-text" style="margin-left: 5%;float: left;" onclick="full()" value="全部下注">
							<div class="btn" id="btn-text" style="margin-left: 5%;float: left;" onclick="full()">全部下注</div>
							-->
							<span style=" margin-left: 40%;font-weight: normal;font-size: 1.3rem;float: left;margin-top: 6%;"></span>
						</div>
					</div>
					<div class="score-footer-list border-bottom" style="height: 45%; background: #fff;" >
						<div class="score-footer-hd"><span>可用余额：</span><span id="my_gold">{$money}</span><span style="color:black" onclick="coin()">&nbsp;刷新</span></div>
						<div class="score-footer-bd">
						<!--
							<button class="btn footer-bd-btn" onclick="make_sure()" style="cursor: pointer;">确定交易</button>-->
							<input type="button" class="btn footer-bd-btn" name="" onclick="make_sure()" style="cursor: pointer;" value="确定交易">
							<!--
							<button class="btn footer-bd-btn" onclick="closes('market-alert2')" style="cursor: pointer;">取消交易</button>-->
							<input type="button" class="btn footer-bd-btn" name="" onclick="closes('market-alert2')" style="cursor: pointer;" value="取消交易">
						</div>
					</div>
						
				</div>
				

			</div>
			
			
			
			
			<!--确定交易弹框-->
			<div class="market-sure-box">
				<div class="body-head" style="height: 22%;">
					<div class="header-scll" style="opacity: 1;text-align: center;background: #ECA534;">
						<span style="font-size: 1.6rem;color: #fff;margin-top: 3.5%">下注</span>
					</div>	
				</div>
				<div class="input-box-register" style="height: 18%;margin-top: 10%;">
					<span>交易密码：</span>
					<input type="password" name="" placeholder="请输入交易密码" autocomplete="off" id="userpassword"> 
				</div>
				<div class="rechange-input" style="border: none;background: none;margin-top: 10%;height: 21%;margin-left: 1%">
					<button class="zc-input btns" onclick="market_sure()" style="background: #ddd;
					color: #282828;float: left;margin-left: 6%;width: 40%;font-weight: bold;font-size: 1.5rem">提交</button>
					<button class="zc-input btns" onclick="market_return()" style="background: #ddd;
					color: #282828;float: left;margin-left: 6%;width: 40%;font-weight: bold;font-size: 1.5rem">返回</button>
				</div>
			</div>
			
			



				<div class="marked-option" style="height: 17.3%; position: absolute;top: 0%;">
					<div class="marked-list" style="height: 100%">
						<div class="list-head">
							<div class="marked-head-time"><span style="text-indent: 25%;">{$game.time|date="m/d",###} {$game.time|date="H:i",###}</span></div>
							<div class="marked-head-name">
								<span>{$game.area}</span>
								<span style="float: right;color: #ECA534;margin-right: 5%;" onclick="battle_show('market-alert1')">对战记录</span>
							</div>
						</div>
						<div class="marked-list-box" style="position: relative;">
							<a href="{:U('Index/index')}">
								<div class="list-box marked-return"><img src="__PUBLIC__/images/left-arrow.png" class="right-arrow"></div>
							</a>
							<div class="list-box list-box-span list-detail" style="width: 90%;margin-left: 10%;">
								<span class="size5 box-span-width" style="text-align: right;">{$game.team_first}(主)</span>
								<span class="size4 box-span-width" style="width: 10%">VS</span>
								<span class="size5 box-span-width" style="text-align: left;">{$game.team_second}</span>
							</div>							
						</div>
					</div>
				</div>
				<div class="marked-option marked-option-detail">
					<div class="option-list option-list1" onclick="marked(1)" style="margin-left: 15%;"><span>全场</span></div>
					<div class="option-list" onclick="marked(2)"><span>半场</div>
					<div class="option-list" onclick="marked(3)"><span>总得分</div>
				</div>
				<input type="hidden" name="game" value="{$id}"/>
				

				<!--波胆-->
				<div class="marked-list-body marked-list-body1" style="height: 57.5%; margin-top: 54%;overflow: auto;">

					<div class="marked-volume">
						<span style="margin-top: 1.5%"><!--成交量：{$count_all}--></span>
					</div>
					
					<div class="marked-head-msg">
						<div class="msg-list">选项</div>
						<div class="msg-list">获利</div>
						<div class="msg-list">可交易量</div>
					</div>

					<div class="msg-list-box" style="height: 100%">
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
				<div class="marked-list-body marked-list-body2" style="height: 57.5%; margin-top: 54%;overflow: auto;">
					<div class="marked-volume">
						<span><!--成交量：{$count_half}--></span>
					</div>
					
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
				<div class="marked-list-body marked-list-body3" style="height: 57.5%; margin-top: 54%;overflow: auto;">
					<div class="marked-volume">
						<span><!--成交量：{$count_half}--></span>
					</div>
					
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
                        window.location.href='__ROOT__/index.php/Home/Index/detail?id='+id;
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
					window.location.href='__ROOT__/index.php/Home/Index/detail?id='+id;
				},1500)
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
					window.location.href='__ROOT__/index.php/Home/Index/detail?id='+id;
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

