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

/*显示对战记录*/
function battle_show(id,score,odds,type){
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
        $(".error").fadeOut(time);
        $(".error").animate({top:'100%'},0);
        
    }


    