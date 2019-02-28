<!DOCTYPE HTML>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"/>

<title>PUNK</title>

<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/indexpc.css">

<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/login.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/index.js"></script>


</head>
<style type="text/css">

</style>

<body>

<div class="content">
	<div class="widths">
		<!--报错信息-->
		<div class="error">
			<span></span>
		</div>
		<!--遮罩-->
		<div class="hide"></div>
		<!--头部-->
		<div class="head">
			<div class="head-box">
				<div class="head-user"><img src="__PUBLIC__/images/head-user.png"><span>{$num_id}</span></div>
				<div class="head-user"><img src="__PUBLIC__/images/head-gold.png"><span id="user_gold">{$money} USD</span></div>
			</div>
		</div>

		<block name="content"></block>


		<!--底部-->
		<div class="footer">
			<a href="{:U('Index/index')}">
				<div class="footer-list-box foter-list1">
					<div class="footer-img"><img src="__PUBLIC__/images/footer-icon1.png"></div>
					<div class="footer-text"><span>市场列表</span></div>
				</div>
			</a>
			<a href="{:U('Record/trade')}">
				<div class="footer-list-box foter-list2">
					<div class="footer-img"><img src="__PUBLIC__/images/footer-icon2.png"></div>
					<div class="footer-text"><span>交易明细</span></div>
				</div>
			</a>
			<a href="{:U('Record/rebate')}">
				<div class="footer-list-box foter-list3">
					<div class="footer-img"><img src="__PUBLIC__/images/footer-icon3.png"></div>
					<div class="footer-text"><span>返佣列表</span></div>
				</div>
			</a>
			<a href="{:U('Record/bill')}">
				<div class="footer-list-box foter-list4">
					<div class="footer-img"><img src="__PUBLIC__/images/footer-icon4.png"></div>
					<div class="footer-text"><span>历史账务</span></div>
				</div>
			</a>
			<a href="{:U('User/per_center')}">
				<div class="footer-list-box foter-list5">
					<div class="footer-img"><img src="__PUBLIC__/images/footer-icon5.png"></div>
					<div class="footer-text"><span>我的</span></div>
				</div>
			</a>
		</div>
	 </div>
</div>

</body>

<script>
	//console.log($("#titles").val())//
	function active(id){
		var title = $("#titles").val()
			if(title == '市场列表'){
				$(".foter-list1").css({'background':'#1A1A1A'})
			}
			if(title == '交易明细'){
				$(".foter-list2").css({'background':'#1A1A1A'})
			}
			if(title == '返佣列表'){
				$(".foter-list3").css({'background':'#1A1A1A'})
			}
			if(title == '历史账务'){
				$(".foter-list4").css({'background':'#1A1A1A'})
			}
			if(title == '我的'){
				$(".foter-list5").css({'background':'#1A1A1A'})
			}
	}

	active();
</script>

	    
</html>

