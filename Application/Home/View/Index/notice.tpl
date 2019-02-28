<extend name="Public:base" />
<block name="content">

		<div class="body">	

			<div class="body-head" style="height: 8%;">
				<div class="header-scll" style="opacity: 1;text-align: center;">
					<span style="font-size: 1.6rem;color: #fff;margin-top: 3%">网站公告</span>
				</div>	
			</div>
			
			<div class="trade-box" id="info" style="height: 81%">

				<div class="score-box trade-list-box" style="height: 15%;">
					<div class="score-left" style="width: 100%;border: none">
						<div class="score-left-list notive-list">
							<span class="score-time">2017-8-10 23:15:10</span>
						</div>
						<div class="score-left-list notive-list notive-list-hidden">
							<span style="color: #272769">网站公告：</span>		
							<span style="text-indent: 0%;color: #727272">【赛事公告】</span>
						</div>
					</div>
				</div>
			</div>

			<div class="notive-page">
				<span class="btn" style="margin-left: 2.5%" onclick="page('pre')">上一页</span>
				<input id="page_num" value="$o" type="hidden"/>
				<span class="btnnone" style="width: 15%;margin-left:2%">
					<small id="now" style="font-size:1.5rem">1</small>/
					<small id="all" style="font-size:1.5rem">1</small>
				</span>
				<span class="btn" onclick="page('next')" style="margin-left:2%">下一页</span>
			</div>



		</div>



		

<script type="text/javascript">

	    pare();
		page(1);
	    	    
	 
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
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
			$.post("{:U('Index/notice')}",{o:o},function(data){
				var data = eval('(' + data + ')');
				$('#info').html('').html(data['data']);
				$('#now').text('').text(data['o']);
				$('#page_num').val('').val(data['o']);
				$('#all').text('').text(data['count']);
			});
		}
		

</script>
</block>

