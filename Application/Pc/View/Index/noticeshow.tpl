<extend name="Public:base" />
<block name="content">

		<div class="body">	

			<div class="body-head">
				<div class="header-scll notice-scll" style="opacity: 1;text-align: center;">
					<span style="font-size: 1.6rem;color: #fff;">网站公告</span>
				</div>	
			</div>
			
			<div class="trade-box">

				<div class="score-box trade-list-box nt-box-ht" style="position: relative;">
					<div class="score-left notice-left notice-height">
						<!--返回公告-->
						<a href="{:U('Index/notice')}">
							<div class="notice-return">
								<img src="__PUBLIC__/images/left-arrow.png">
							</div>
						</a>
						<div class="score-left-list notive-list">
							<span class="nt-text">{$data.title}</span>				
						</div>
						<div class="score-left-list notive-list ">
							<span class="score-time nt-text nt-left">{$data.time|date="Y-m-d H:i",###}</span>
						</div>
						
						<div class="score-left-list notive-list">
							<span class="nt-text nt-left nt-size">
								{$data.content}
							</span>				
						</div>

						<div class="notive-page">
							<a href="{$pre.url}"><span class="btn btn-left">{$pre.name}</span></a>
							<a href="{$next.url}"><span class="btn">{$next.name}</span></a>

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

