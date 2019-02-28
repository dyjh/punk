	function pare(){

		if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {

   			//alert('yd')
   			//$(".widths").height(640).width(360).css({'margin':'auto'});//
   			

		} else {

		   $(".widths").height(640*1.52).width(360*1.52).css({'margin':'left'});
		   window.location.href='http://101.132.97.108/PUNK/index.php/Pc/Login/login.html';
		  
		}

	}

	



	



	function changeText(){

		$(".input-box-register").siblings("p").remove();

	}
	/*错误提示*/
	function error(message,time){
		
		$(".error span").text(message);
		$(".error").show();
		$(".error").animate({top:'70%'},200);	
		$(".error").fadeOut(time);
		$(".error").animate({top:'100%'},0);
		
	}

/*验证码*/
//http://119.29.168.120/zuqiu/index.php/Home/Login/%7B:U('Login/yzm')%7D
	function request(tel,type,url){
		times = setInterval(yztime,1000);
		//alert(url);
		$.post(url,{tel:tel,type:type},function(msg){
			error('验证码已发送',3500)
		});
	}

	var times;

	var i = 60;
	function yztime(){
		var s = i-1;
		i = s;
		$("#yzm").val(i+'秒后获取');
		$("#yzm").attr({"disabled":"disabled"});
		if(i<=0){
			 clearInterval(times);
			 $("#yzm").val('获取验证码');
			 $("#yzm").removeAttr("disabled");
			 i = 60;
		}
	}