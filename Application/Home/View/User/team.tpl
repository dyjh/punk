<extend name="Public:base" />
<block name="content">
<input type="hidden" value="市场列表" id="titles"> 
	<div class="body" style="overflow: auto;">
		<div class="body-head" style="height: 8%;">
			<div class="header-scll" style="opacity: 1;text-align: center;">
				<span style="font-size: 1.6rem;color: #fff;margin-top: 3%">代理列表</span>
			</div>	
		</div>
		<div class="mine-hd-num" style="height: 8%">
			<div class="mine-num-list">
				<div class="mine-num-text mine-num-text1"><span style="color: #282828">代理记录</span></div>		
			</div>
			
			
		</div>

		


		<!--直推列表-->
		<div class="rechange-box rechange-box3" style="display: block;">
			
			<div class="rechange-gold-box-by" style="margin-top: 0%">
				<div class="in-btn-box">
					<div class="in-list-box in-list-ft" style="border-top: 1px solid #E3E3E3;border-bottom: none;">
						<div class="in-list-text in-list-width">电话</div>
						<div class="in-list-text in-list-width">编号</div>
						<div class="in-list-text in-list-width">状态</div>
					</div>
					<!--插入内容 class名 in-list-box-inset -->
					<div class="in-list-box-inset" id="extract_box">
						
						
						
					</div>
					<!--结束-->
					<!--翻页-->
					<div class="in-list-box list-box-width" style="height: 50px;">
						<div class="in-page" style="margin-left: 20%" onclick="page('pre')">上一页</div>
						<input id="page_num" value="$o" type="hidden"/>
						<div class="in-page"><laber id="extract_now_page">1</laber>/<laber id="extract_last_page">1</laber></div>
						<div class="in-page" onclick="page('next')">下一页</div>
					</div>
				</div>
			</div>
			
		</div>

		

	</div>

		<!--底部-->
		

<script type="text/javascript">

	    
		page(1);
	 	/*文字行高*/
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
		var o = '';
       function page(type){
			/*if(o==undefined){
				//alert(1);//
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
			$.post("{:U('User/team')}",{o:o},function(data){
				var data = eval('(' + data + ')');
				$('#extract_box').html('').html(data['data']);
				$('#extract_now_page').text('').text(data['o']);
				$('#page_num').val('').val(data['o']);
				$('#extract_last_page').text('').text(data['count']);
			});
		}

	 	

	 	
</script>
</block>

