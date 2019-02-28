<extend name="Public:base" />
<block name="content">

		<div class="body">	

			<div class="body-head">
				<div class="header-scll notice-scll" style="opacity: 1;text-align: center;">
					<span style="font-size: 1.6rem;color: #fff;">网站公告</span>
				</div>	
			</div>
			
			<div class="trade-box" id="info">
				
				
			</div>

			<div class="notive-page">
				<span class="btn notive-btn" onclick="page('pre')">上一页</span>
				<input id="page_num" value="$o" type="hidden"/>
				<span class="btnnone">
					<small id="now">1</small>/
					<small id="all">1</small>
				</span>
				<span class="btn notive-btn" onclick="page('next')">下一页</span>
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

