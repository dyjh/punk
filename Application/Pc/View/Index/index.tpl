
<extend name="Public:base" />
<block name="content">

<style>
.list-box {
    float: left;
    height: 100%;
    width: 20%;
    margin-left: 0%;
    text-align: center;
}
</style>
<div class="body">
<input type="hidden" value="市场列表" id="titles"> 
	<div class="body-head">
		<div class="header-scll" style="opacity: 1;">
			<img src="__PUBLIC__/images/laba.png"/>
			<div class="scll-text"><a style="color:#FFF;font-size: 1.4rem;font-weight: bold;" href="{:U('Index/notice')}"><span>{$info}</span></a></div>
		</div>
	</div>
	<div class="marked-body">
		<div class="marked-option">
			<div class="option-list option-list1" onclick="marked(1)"><span>全部</span>&nbsp;&nbsp;<span id="allg">{$count_all}</span></div>
			<div class="option-list" onclick="marked(2)"><span>今日</span>&nbsp;&nbsp;<span id="todayg">{$count_today}</span></div>
			<div class="option-list" onclick="marked(3)"><span>明日</span>&nbsp;&nbsp;<span id="tommorrowg">{$count_tomorrow}</span></div>
			<div class="option-list" onclick="marked(4)"><span>选择联盟</span></div>
		</div>

		<!--全部 class名marked-list-body1-->
		<!--循环a标签 和a标签包含的内容就可以了-->
		<div class="marked-list-body marked-list-body1" style="display: block;">
			<!--
			<a href="'.U('Index/detail',array('id'=>$va['id'])).'">
				<div class="marked-list">
					<div class="list-head">
						<div class="marked-head-time"><span>'.$time.'</span></div>
						<div class="marked-head-name"><span>'.$va['area'].'</span></div>
					</div>
					<div class="marked-list-box">
						<div class="list-box" ><img src="'.$va['img_first'].'"></div>
						<div class="list-box list-box-span list-box-width">
							<span class="size4 box-span-width">'.$va['team_first'].'</span>
							<span class="size3 box-span-width list-box-vs">VS</span>
							<span class="size4 box-span-width">'.$va['team_second'].'</span>
						</div>
						<div class="list-box"><img src="'.$va['img_second'].'"></div>
						<div class="list-box" style="width: auto;"><img style="margin-left: 85%;" src="'.$url.'/images/right-arrow.png" class="right-arrow"></div>
					</div>
				</div>
			</a>	
			-->		
		</div>


		<!--今日 class名marked-list-body2-->
		<div class="marked-list-body marked-list-body2">
			<!--<volist name="game_today" id="v">
				<a href="{:U('Index/detail',array('ID'=>$v['id']))}">
					<div class="marked-list">
						<div class="list-head">
							<div class="marked-head-time"><span>{$v.time|date="H:i",###}</span></div>
							<div class="marked-head-name"><span>{$v.area}</span></div>
						</div>
						<div class="marked-list-box">
							<div class="list-box" ><img style="padding-top: 43%" src="{$v.img_first}"></div>
							<div class="list-box list-box-span" style="width: 65%;">
								<span class="size4 box-span-width">{$v.team_first}</span>
								<span class="size3 box-span-width" style="width: 15%">VS</span>
								<span class="size4 box-span-width">{$v.team_second}</span>
							</div>
							<div class="list-box"><img style="padding-top: 43%" src="{$v.img_second}"></div>
							<div class="list-box" style="width: auto;"><img style="margin-left: 85%;" src="__PUBLIC__/images/right-arrow.png" class="right-arrow"></div>
						</div>
					</div>
				</a>
			</volist>-->
						
			
		</div>


		<!--明日 class名marked-list-body3-->
		<div class="marked-list-body marked-list-body3">
			<!--<volist name="game_tomorrow" id="v">
				<a href="{:U('Index/detail',array('ID'=>$v['id']))}">
					<div class="marked-list">
						<div class="list-head">
							<div class="marked-head-time"><span>{$v.time|date="H:i",###}</span></div>
							<div class="marked-head-name"><span>{$v.area}</span></div>
						</div>
						<div class="marked-list-box">
							<div class="list-box" ><img style="padding-top: 43%" src="{$v.img_first}"></div>
							<div class="list-box list-box-span" style="width: 65%;">
								<span class="size4 box-span-width">{$v.team_first}</span>
								<span class="size3 box-span-width" style="width: 15%">VS</span>
								<span class="size4 box-span-width">{$v.team_second}</span>
							</div>
							<div class="list-box"><img style="padding-top: 43%" src="{$v.img_second}"></div>
							<div class="list-box" style="width: auto;"><img style="margin-left: 85%;" src="__PUBLIC__/images/right-arrow.png" class="right-arrow"></div>
						</div>
					</div>
				</a>
			</volist>-->
		</div>
		<!--选择联盟 class名marked-list-body4-->
		<div class="marked-list-body marked-list-body4">
			<div class="opt-head">
				<div class="opt-list" onclick="opt_active('select',this)"><span>全选</span></div>
				<div class="opt-list" onclick="opt_active('remove')"><span>取消</span></div>
				<div class="opt-list" onclick="opt_active('sure',this)"><span>确定</span></div>
			</div>
			<!--选择联盟插入内容 class名opt-body-->
			<div class="opt-body">
				<volist name="area" id="a">
					<div class="opt-body-list"><span sel="false">{$a.area}（{$a.num}）</span><small class="opt-active">✔</small></div>
				</volist>
			</div>
		</div>
	</div>
</div>



		

<script type="text/javascript">

	    pare();

	    	    
	 
	 	//$(".scll-text").css('line-height',$(".scll-text").height()+'px')
		/*文字滚动*/
		var classSpan = $(".scll-text span");
		var Text_length = classSpan.width();
		var div_length = $('.scll-text').width();
		//console.log(div_length);
	 	
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

		function market_refresh(){
			var area='';
			$.post("{:U('Index/market_refresh')}",{area:area},function(data){
				var data = eval('(' + data + ')');
				//console.log(data['today']);
				$('.marked-list-body3').html('').html(data['tomorrow']);
				$('.marked-list-body2').html('').html(data['today']);
				$('.marked-list-body1').html('').html(data['all']);
				$('#allg').text('').text(data['all_count']);
				$('#todayg').text('').text(data['today_count']);
				$('#tommorrowg').text('').text(data['tomorrow_count']);
			});
			//console.log(1)
		}
		market_refresh();
		setInterval(market_refresh,300000);
	 	/*全部 今天 明日*/

	 	function marked(id){
	 		$(".marked-list-body").hide();
	 		$(".marked-list-body"+id).fadeIn(350);
	 	}

	 	$(".option-list").click(function(){
	 		$(".option-list span").css({"color":"#727272"})
	 		$(this).find('span').css({"color":"#000"})
	 	})

        
       /*点击选择联盟*/
	 function opt_active(type,aa){
	 		if(type=='select'){
	 			$(".opt-list").css({"background-color":"#fff"})
	 			aa.style.backgroundColor = '#bbb';
	 			$(".opt-body-list").css({"background":"#000"})
	 			$(".opt-body-list span").css({"color":"#fff"})
	 			$(".opt-body-list span").attr({"sel":"true"})
	 			$(".opt-body-list small").css({"color":"#fff"})
	 			$(".opt-active").css({"display":"inline-block"})
	 		}
	 		if(type=='remove'){
	 			$(".opt-list").css({"background-color":"#fff"})
	 			$(".opt-body-list").css({"background":"#fff"})
	 			$(".opt-body-list span").css({"color":"#414141"})
				$(".opt-body-list span").attr({"sel":"false"})
	 			$(".opt-body-list small").css({"color":"#414141"})
	 			$(".opt-active").css({"display":"none"})
	 		}
	 		if(type=='sure'){
	 			$(".opt-list").css({"background-color":"#fff"})
	 			aa.style.backgroundColor = '#bbb';
				var area='';
	 			$('.opt-body-list span[sel="true"]').each(function(){
					var len=($(this).text().indexOf("（"));
					
					var name=$(this).text().substring(0,len);
					area+= name +'|';
				});
				area=area.substring(0,area.length-1);//
				//alert(area);
				$.post("{:U('Index/market_refresh')}",{area:area},function(data){
				var data = eval('(' + data + ')');
					//console.log(data['today']);
					$('.marked-list-body3').html('').html(data['tomorrow']);
					$('.marked-list-body2').html('').html(data['today']);
					$('.marked-list-body1').html('').html(data['all']);
					$('#allg').text('').text(data['all_count']);
					$('#todayg').text('').text(data['today_count']);
					$('#tommorrowg').text('').text(data['tomorrow_count']);
				});
	 		}
	 }
	/*点击选择联盟*/
	 	$(".opt-body-list").click(function(){	
	 		/*$(".opt-body-list").css({"background":"#fff"})
	 		$(".opt-active").css({"display":"none"})
	 		$(".opt-body-list span").css({"color":"#414141"})*/
	 		var rgb = $(this).css('background-color');
			  rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
			  function hex(x) {return ("0" + parseInt(x).toString(16)).slice(-2);}
			  rgb= "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
			 //console.log(rgb);
			 if(rgb=='#000000'){
			 	$(this).find('span').css({"color":"#414141"})
			 	$(this).find('span').attr({"sel":"false"})
			 	$(this).find('small').css({"color":"#414141"})
	 			$(this).children('span').css({"display":"inline-block"});
	 			$(this).children('small').css({"display":"none"});
	 			$(this).css({"background":"#fff"})
			 }
			 if(rgb=='#ffffff'){
			 	$(this).find('span').css({"color":"#fff"})
				$(this).find('span').attr({"sel":"true"})
			 	$(this).find('small').css({"color":"#fff"})
		 		$(this).children('small').css({"display":"inline-block"});
		 		$(this).css({"background":"#000"})
			 }
	 		
	 		/*if($(this).css('background')==='rgb(0, 0, 0) none repeat scroll 0% 0% / auto padding-box border-box'){
	 			console.log(1111)
	 		}	*/
	 		

	 	})
		




</script>
</block>

