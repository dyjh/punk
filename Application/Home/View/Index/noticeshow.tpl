<extend name="Public:base" />
<block name="content">

		<div class="body">	

			<div class="body-head" style="height: 8%;">
				<div class="header-scll" style="opacity: 1;text-align: center;">
					<span style="font-size: 1.6rem;color: #fff;margin-top: 3%">网站公告</span>
				</div>	
			</div>
			
			<div class="trade-box" style="height: 81%">

				<div class="score-box trade-list-box" style="height: 15%;position: relative;">
					<div class="score-left" style="width: 100%;border: none;height: auto;background: #fff;padding-bottom:10px;">
						<!--返回公告-->
						<a href="{:U('Index/notice')}">
							<div class="notice-return">
								<img src="__PUBLIC__/images/left-arrow.png" style="margin-top: 4%;">
							</div>
						</a>
						<div class="score-left-list notive-list">
							<span style="color: #727272;text-indent:8%">{$data.title}</span>				
						</div>
						<div class="score-left-list notive-list">
							<span class="score-time" style="text-indent:10%">{$data.time|date="Y-m-d H:i",###}</span>
						</div>
						
						<div class="score-left-list notive-list">
							<span style="width: 90%;margin-left: 5%;text-indent:0%;color: #282828;font-size:2.6rem;">
								{$data.content}
							</span>				
						</div>

						<div class="notive-page">

							<a href="{$pre.url}"><span class="btn" style="margin-left: 13.5%">{$pre.name}</span></a>
							<a href="{$next.url}"><span class="btn" style="margin-left: 4.5%">{$next.name}</span></a>

						</div>
					</div>
					
				</div>


				
			</div>

			



		</div>



		<!--底部-->
		

<script type="text/javascript">

	    pare();

	    	    
	 
	 	$(".scll-text").css('line-height',$(".scll-text").height()+'px')
       
	
	

</script>
</block>

