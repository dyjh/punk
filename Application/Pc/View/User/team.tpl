<extend name="Public:base" />
<block name="content">
<style type="text/css">
	.mine-hd-num {
	    float: left;
	    height:45px;
	    line-height: 45px;
	    width: 100%;
	    background: #FFFFFF;
	}
	.mine-hd-num span{
		font-size: 16px;
		margin-left: 20px;
		font-weight: bold;
	}
	.rechange-box {
	    float: left;
	    height: 666px;
	    width: 100%;
	    background: #fff;
	}
	.rechange-gold-box-by {
	    float: left;
	    height: 70%;
	    width: 100%;
	}
	.in-btn-box {
    float: left;
    height: 30%;
    width: 100%;
    display: block;
}
.in-list-box {
    float: left;
    width: 100%;
    border-bottom: 1px solid #E3E3E3;
    height: auto;
    background: #fff;
}
.in-list-ft .in-list-text {
    font-weight: bold;
}

.in-list-text {
    float: left;
    width: 19.4%;
    text-align: center;
    color: #7C7C7C;
    font-size: 1.4rem;
    border-right: 1px solid #E3E3E3;
    word-wrap: break-word;
    white-space: pre-wrap;
    height: 35px;
    line-height: 35px;
    word-break: break-all;
}
	.in-page {
    float: left;
    height: 50px;
    width: 20%;
    text-align: center;
    color: #7C7C7C;
    font-size: 1.4rem;
    font-weight: bold;
    line-height: 50px;
}
laber {
    font-size: 1.4rem;
}
.in-page-left{
	margin-left: 20%;
}
.in-list-width {
    width: 33.02%;
}
.in-berder {
	    border-right: none;
	}
</style>
<input type="hidden" value="市场列表" id="titles"> 
	<div class="body" style="overflow: auto;">
		<div class="body-head">
			<div class="trade-scll" style="opacity: 1;text-align: center;">
				<span style="font-size: 1.6rem;color: #fff;">代理列表</span>
			</div>	
		</div>
		<div class="mine-hd-num">		
				<span style="color: #282828">代理记录</span>
		</div>

		


		<!--直推列表-->
		<div class="rechange-box rechange-box3" style="display: block;">
			
			<div class="rechange-gold-box-by">
				<div class="in-btn-box">
					<div class="in-list-box in-list-ft" style="border-top: 1px solid #E3E3E3;">
						<div class="in-list-text in-list-width">电话</div>
						<div class="in-list-text in-list-width">编号</div>
						<div class="in-list-text in-list-width in-berder">状态</div>
					</div>
					<!--插入内容 class名 in-list-box-inset -->
					<div class="in-list-box-inset" id="extract_box">
						
						
						
					</div>
					<!--结束-->
					<!--翻页-->
					<div class="in-list-box list-box-width" style="height: 50px;">
						<div class="in-page cursor-pointer" style="margin-left: 20%" onclick="page('pre')">上一页</div>
						<input id="page_num" value="$o" type="hidden"/>
						<div class="in-page"><laber id="extract_now_page">1</laber>/<laber id="extract_last_page">1</laber></div>
						<div class="in-page cursor-pointer" onclick="page('next')">下一页</div>
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

