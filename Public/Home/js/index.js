$(function(){
            function opc(){
                    $("body").animate({"opacity":1},500);
                }
                var ooo = setTimeout(opc,350);
                function yl(){
                    var hf = [];
                    $("body").find("a").each(function(i){
                        hf[i] = $(this).attr("href");
                        $(this).attr("href","javascript:;");
                        $(this).bind("click",function(event){
                            $("body").animate({"opacity":0},500);
                            window.setTimeout(function(){ location.href=hf[i];},350); 
                        })
                    })
                }
                yl();
        });


function pare(){

        if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {

            //alert('yd')
            //$(".widths").height(640).width(360).css({'margin':'auto'});
            

        } else {

           $(".widths").height(640*1.52).width($('body').width()).css({'margin':'left'});
          
        }

    }

/*显示对战记录*/
function battle_show(id,score,odds,type,state){
	if(id=='market-alert2'){
		if(score.length==3){
			$("#score").text('').text('您正在反对波胆 '+score);
			$("#odd_name").text('').text('反波胆');
			$("#score_se").text(score.substring(0,1)+' - '+score.substring(2,3));
		}else{
			$("#score").text('').text('您正在下注进'+score+'球以上');
			$("#odd_name").text('').text('波胆');
			$("#score_se").text(score);
		}
		$("#odds").text(odds);
		$("#score_type").val(state);
		$('input[name="odds"]').val(odds);
		$('input[name="type"]').val(type);
		$('input[name="score"]').val(score);
	}
    $(".hide").show();
    $("."+id).fadeIn(500);
	
}

/*隐藏对战记录*/
function closes(id){
    $(".hide").hide();
    $("."+id).fadeOut(300);
}

/*错误提示*/
    function error(message,time){
        
        $(".error span").text(message);
        $(".error").show();
        $(".error").animate({top:'70%'},200);   
        setTimeout(function(){
            $(".error").hide();
            $(".error").stop().css({"top":"100%"});
        },1500)  
    }

/*获取验证码*/
    
function request(tel,type,url){
    times = setInterval(yztime,1000);
	//alert(type);
	$.post(url,{tel:tel,type:type},function(){
		error('发送成功',3500);
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


/*取消返回*/
        function market_return(id,alert,hide){
            $("."+id).hide();
            $("."+alert).fadeIn(500);  
            $("."+hide).fadeOut(200);
            $('.input-box-register input').val('');
            $('#bank-1').val('选择银行  ▼');
            $('#yzm').val('获取验证码');
        }