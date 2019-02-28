<!DOCTYPE html>

<!-- saved from url=(0026)https://dafuvip.com/ZBJnmu -->

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no minimal-ui">

    <link rel="stylesheet" href="__PUBLIC__/bootstrap.min.css">

    <link rel="stylesheet" href="__PUBLIC__/font-awesome.min.css">

    <link rel="stylesheet" href="__PUBLIC__/style.css">

    <link rel="stylesheet" href="__PUBLIC__/custom.css">

    <link rel="stylesheet" href="__PUBLIC__/appstyle.css">

<style>

    body {

        margin: auto;

        text-align: center;

    }
    body,html{
        height: 100%;
        width: 100%;
        position: relative;
    }

    .btn-u2 {

        background: #000;

    }



    .btn-u2:hover {

        background: #ffffff;

    }



    .xuanfutishi {

        background-color: rgba(255, 0, 0, 0.6);

        bottom: 0;

        color: #fff;

        display: block;

        font-size: 15px;

        height: 40px;

        line-height: 40px;

        position: fixed;

        width: 100%;

    }

    .xuanfutishi span {

        float: left;

        padding-left: 15px;

    }

    .xuanfutishi img {

        float: right;

        height: 15px;

        margin: 12px 15px 0 0;

        width: 15px;

    }

    .appicon {

        border: 1px solid #ddd;

        border-radius: 24px;

        height: 120px;

        width: 120px;

    }



    .appicon2 {

        border: 1px solid #fff;

        border-radius: 24px;

        height: 140px;

        width: 140px;

    }



    #codeico {

        background-color: #efefef;

        border: 2px solid #fff;

        border-radius: 10px;

        margin: 77px;

        position: absolute;

        z-index: 999;

    }



    .one-key-report {

        background-color: #32b2a7;

        color: #fff;

        margin-top: -5px;

        padding: 5px 10px;

    }



    .one-key-report-dialog {

        background-color: #fff;

        border-radius: 10px;

        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);

        left: 50%;

        margin-left: -225px;

        margin-top: -275px;

        padding: 20px;

        position: fixed;

        top: 50%;

        width: 450px;

        z-index: 99999;

    }

    .one-key-report-dialog .dialog-close {

        position: absolute;

        right: 10px;

        top: 10px;

    }

    .one-key-report-dialog .dialog-close i.icon-close {

        cursor: pointer;

        font-size: 18px;

        font-weight: 700;

    }

    .one-key-report-dialog .dialog-close i.icon-close:hover {

        color: #333;

    }

    .one-key-report-dialog .dialog-close .icon-return {

        color: #32b2a7;

        display: none;

    }

    .one-key-report-dialog .custom-checkbox {

        cursor: pointer;

        display: inline-block;

        line-height: 24px;

        margin-right: 40px;

        padding: 2px 2px 2px 25px;

        position: relative;

        text-align: left;

    }

    .one-key-report-dialog .custom-checkbox:last-child {

        margin-right: 0;

    }

    .one-key-report-dialog .custom-checkbox::after, .one-key-report-dialog .custom-checkbox::before {

        content: " ";

        display: block;

        position: absolute;

    }

    .one-key-report-dialog .custom-checkbox::after {

        background-color: #1989fa;

        border-radius: 10px;

        display: none;

        height: 10px;

        left: 1px;

        top: 7px;

        width: 10px;

    }

    .one-key-report-dialog .custom-checkbox::before {

        background-color: #fff;

        border: 1px solid #1989fa;

        border-radius: 12px;

        height: 12px;

        left: 0;

        top: 6px;

        width: 12px;

    }

    .one-key-report-dialog .custom-checkbox.active::after {

        display: block;

    }

    .one-key-report-dialog .content-row {

        display: table;

        padding: 10px 10px 5px;

        position: relative;

        width: 100%;

    }

    .one-key-report-dialog .content-row input, .one-key-report-dialog .content-row label {

        display: inline-block;

        float: left;

    }

    .one-key-report-dialog .content-row label {

        font-size: 18px;

        line-height: 34px;

        margin-right: 30px;

    }

    .one-key-report-dialog .content-row input {

        border: 1px solid #a9b1b3;

        border-radius: 5px;

        height: 34px;

        outline: 0 none;

        padding: 5px 10px;

        width: 240px;

    }

    .one-key-report-dialog .content-row .checkbox-list {

        clear: both;

        padding: 5px 0;

        text-align: left;

        width: 100%;

    }

    .one-key-report-dialog .content-row textarea {

        border: 1px solid #a9b1b3;

        border-radius: 10px;

        color: #a9b1b3;

        font-size: 16px;

        height: 200px;

        outline: 0 none;

        padding: 10px;

        resize: none;

        width: 100%;

    }

    .one-key-report-dialog .content-row .btn-report {

        background-color: #32b2a7;

        border-radius: 15px;

        color: #fff;

        float: right;

        margin-top: -5px;

        padding: 5px 10px;

    }

    .one-key-report-dialog .report-feedback, .one-key-report-dialog .report-form {

        height: 100%;

        position: relative;

        width: 100%;

    }

    .one-key-report-dialog .report-sending {

        background-color: rgba(255, 255, 255, 0.5);

        color: #000;

        cursor: default;

        display: none;

        font-size: 20px;

        height: 100%;

        left: 0;

        line-height: 450px;

        position: absolute;

        text-align: center;

        top: 0;

        width: 100%;

        z-index: 100;

    }

    .one-key-report-dialog .report-form {

        display: block;

    }

    .one-key-report-dialog .report-feedback {

        cursor: default;

        display: none;

    }

    .one-key-report-dialog .report-feedback .feedback-thanks {

        background-color: #efefef;

        border-radius: 20px;

        height: 160px;

        margin: 50px auto 20px;

        width: 160px;

    }

    .one-key-report-dialog .report-feedback .feedback-thanks .brace-content {

        color: #000;

        margin: 0 auto;

        padding-top: 30px;

        text-align: center;

        width: 110px;

    }

    .one-key-report-dialog .report-feedback .feedback-thanks .thanks {

        color: #000;

        cursor: default;

        font-family: "Roboto Slab","Helvetica Neue",Helvetica,"Hiragino Sans GB",Arial,sans-serif;

        font-size: 16px;

        font-weight: 700;

        letter-spacing: 0.8px;

        margin: 15px 0 0;

        min-height: 22px;

        text-align: center;

    }

    .one-key-report-dialog .report-feedback .feedback-thanks .face, .one-key-report-dialog .report-feedback .feedback-thanks .icon-brace-left, .one-key-report-dialog .report-feedback .feedback-thanks .icon-brace-right {

        display: inline-block;

        vertical-align: middle;

    }

    .one-key-report-dialog .report-feedback .feedback-thanks .icon-brace-left, .one-key-report-dialog .report-feedback .feedback-thanks .icon-brace-right {

        font-size: 80px;

    }

    .one-key-report-dialog .report-feedback .feedback-thanks .face .icon-comma-eye {

        font-size: 22px;

        margin: 0 4px;

    }

    .one-key-report-dialog .report-feedback .feedback-thanks .face .icon-comma-eye.right {

        display: inline-block;

        margin-left: 16px;

        transform: scaleY(0.5);

    }

    .one-key-report-dialog .report-feedback .feedback-thanks .face .icon-mouth {

        display: block;

        margin-top: 15px;

        transform: rotateZ(-19deg) translateX(2px);

    }

    .one-key-report-dialog .report-feedback .feedback-message {

        color: #1989fa;

        font-size: 30px;

        text-align: center;

    }

    .one-key-report-dialog .report-feedback .feedback-content {

        color: #858585;

        font-size: 18px;

        margin-top: 40px;

    }

    .one-key-report-dialog .report-error {

        color: red;

        cursor: default;

        line-height: 34px;

        padding: 0 10px;

    }

    .one-key-report-dialog .report-error > div {

        display: none;

    }



    .ad_section {

        position: fixed; bottom: 0; margin-bottom: 0;left: 50%;margin-left: -365px;

    }

    @media (max-width:767px) {

        .ad_section {

            position: fixed;

            bottom: 0;

            left: 0;

            margin:auto;

        }

    }



    .floadAd { position: absolute;z-index: 999900; display: none; }

    .floadAd .item { display: block; }

    .floadAd .item img { vertical-align: bottom; }



</style>



<title>PUNK</title>



    

    

    <meta name="keywords" content="大福,dafuvip,IPA签名,企业签名,iOS,Android,iPad,iPhone,App下载,免费安装,adhoc,InHouse,fir cli,beta测试,ipa,apk,安卓,苹果应用,二维码下载,UDID,iOS内测,Android内测,beta test,app">

    <meta name="description" content="大福为开发者提供测试应用极速发布，应用崩溃实时分析、用户反馈收集等一系列开发测试效率工具服务，帮助开发者将更多精力放在产品的开发与应用的优化上">

    <link rel="shortcut icon" href="https://pic.dafuvip.com/images/64.ico" type="image/x-icon">

    <meta name="baidu-site-verification" content="ukBKOPYfE2">

    <meta name="baidu-site-verification" content="xSBa81fLpH">

    <meta name="author" content="dafuvip.com">

    <meta property="og:type" content="webpage">

    <meta property="og:url" content="https://dafuvip.com/ZBJnmu">

    <meta property="og:title" content="PUNK">

    <meta property="og:description" content="PUNK">

    <meta name="apple-mobile-web-app-title" content="https://dafuvip.com/ZBJnmu">

    <meta name="apple-mobile-web-app-capable" content="yes">

</head>
<style type="text/css">
    .aaa{
        position: absolute;
        height: 100%;
        width: 100%;
        z-index: 10;
        background: #000;
        opacity: 0.3;
        display: none;
    }
</style>
<body style="text-align: center;">
<div class="aaa">
   
</div>
<img src="__PUBLIC__/wxysj.jpg" style="height: 40%;width: 100%;z-index: 30;position: absolute;top: 0%;left: 0;display: none" class="bbb">

<script src="__PUBLIC__/hm.js"></script><script type="text/template" id="title">

<title>{{app_name}}</title>

</script>

<script language="text/template" id="meta">

    <meta charset="utf-8" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="keywords" content="{{keywords}}">

    <meta name="description" content="{{desciption}}">

    <link rel="shortcut icon" href="//pic.dafuvip.com/images/64.ico" type="image/x-icon" />

    <meta name="baidu-site-verification" content="ukBKOPYfE2" />

    <meta name="baidu-site-verification" content="xSBa81fLpH" />

    <meta name="author" content="dafuvip.com">

    <meta property="og:type" content="webpage">

    <meta property="og:url" content="{{web_url}}">

    <meta property="og:title" content="{{app_name}}">

    <meta property="og:description" content="{{app_name}}">

    <meta name="apple-mobile-web-app-title" content="{{web_url}}">

    <meta name="apple-mobile-web-app-capable" content="yes">

</script>



<script language="text/template" id="top_title">

<div style="display:none;">

    <img src="{{icon}}&imageMogr2/thumbnail/300x300!" onerror="javascript:this.src='//pic.dafuvip.com/images/icon_300.png';" />

</div>

<div class="row-fluid breadcrumbs margin-bottom-20">

    <div class="container">

        <div style="margin:0 auto;font-size: 24px;text-align:center;">{{app_name}}</div>

        {{if apples|notempty}}

        <div style="margin:0 auto;font-size: 18px;text-align:center;">{{qq}}</div>

        {{/if}}

    </div><!--/container-->

</div><!--/breadcrumbs-->

<div class="view">

    <div class="span12" style="text-align:center;">

        <img src="{{icon}}" class="appicon" onerror="javascript:this.src='//pic.dafuvip.com/images/icon_300.png';"  />

    </div>

</div>

</script>



<script language="text/template" id="button">

{{if checked}}

<hr class="devider devider-dotted" style="padding: 0px" />

<div>

    <div class="text-center" >

        {{if show_button}}

        <div class="margin-bottom-20">

            <div id="showtext">正在安装，请按 Home 键在桌面查看</div>

            <div class="loading"></div>

            <a href="{{downurl}}" type="ios" class="down_load btn-u btn-u-lg">

                <i class="fa"></i> 点击安装

            </a>

        </div>

        {{else}}

        <div class="margin-bottom-20">

            <div>

                <span>下载次数已经用完,请联系应用所有者处理</span>

            </div>

        </div>

        {{/if}}

        <p>

            <span class="label label-info" style="margin: 5px;">适用于 {{button_context}}</span>

        </p>

    </div>

</div>

{{else}}

<div class="container content" style="padding: 5px">

    <div class="span12" style="text-align:center;">

        <label>密码</label>

        <label class="input">

            <input id="password" name="password" placeholder="请输入密码" type="password">

        </label>

        <label class="input">

            <button class="btn-u" type="button" id="submitButton" onclick="DAFU.submitPwd()">进入应用</button>

        </label>

    </div>

</div>

{{/if}}

</script>

<script language="text/template" id="intro">

{{if app_intro|noempty}}

<div style="text-align:left;padding: 10px;font-size: 18px" class="container">

{{app_intro}}

</div>

{{/if}}

<hr class="devider devider-dotted" style="margin: 10px 0">

<div style="text-align: center">

    <span>版本：{{version}}</span><span style="padding: 15px">大小：{{app_size}}</span><span> {{update_dt}}</span>

</div>

</script>



<script language="text/template" id="qrcode">

<div class="container content" style="padding: 0 0 30px 0;">

    <div class="span12" style="text-align:center;">

        

        <br />

        手机浏览器输入网址: {{web_url}}<a id="copy_button" href="javascript:void (0)" data-clipboard-text="{{web_url}}" aria-label="复制成功！">复制</a>

    </div>

</div>

</script>

<script language="text/template" id="copyright">

<div class="copyright" style="padding: 25px">

    <div class="container content" style="padding: 0px">

        <div class="span12" style="text-align:center;">

            <a href="//dafuvip.com" target="_blank">大福</a>是应用内测平台，请自行甄别应用风险，如应用存在问题，可点击“举报”按钮 <button id="report_button" class="btn btn-sm btn-success" onclick="DAFU.clickReport()">举报!</button>

        </div>

        <div class="span12" style="text-align:center;">

            <a target="_blank" href="//dafuvip.com/show/disclaimer"> 免责申明</a>

        </div>

    </div><!--/container-->

</div>

{{if show_guide}}

<a class="xuanfutishi" target="_blank" href="/guide.html"><span>“未受信任的企业级开发者”解决方法教程</span><img src="//pic.dafuvip.com/images/xuanfutishi.png?2017122217"></a>

{{/if}}

<div id="weixin_ios" style="display:none">

    <div class="click_opacity"></div>

    <div class="to_btn">

        <span class="span1"><img

                src="//pic.dafuvip.com/images/click_btn.png?2017122217"></span>

        <span class="span2"><em>1</em> 点击右上角<img

                src="//pic.dafuvip.com/images/menu.png?2017122217">打开菜单</span>

        <span class="span2"><em>2</em> 选择<img

                src="//pic.dafuvip.com/images/safari.png?2017122217">用Safari打开下载</span>

    </div>

</div>

<div id="weixin_android" style="display: none">

    <div class="click_opacity"></div>

    <div class="to_btn">

        <span class="span1"><img

                src="//pic.dafuvip.com/images/click_btn.png?2017122217"></span>

        <span class="span2"><em>1</em> 点击右上角<img

                src="//pic.dafuvip.com/images/menu_android.png?2017122217">打开菜单</span>

        <span class="span2 android_open"><em>2</em> 选择<img

                src="//pic.dafuvip.com/images/android.png?2017122217"></span>

    </div>

</div>

<div class="one-key-report-dialog" id="reportDialog" style="display: none">

    <div class="dialog-close" style="cursor:pointer;padding: 10px;z-index: 999999">

        <a class="icon-close glyphicon glyphicon-remove">关闭</a>

        <a class="icon-return">&lt;&nbsp;返回下载页</a></div>

    <div class="report-form" id="report-form">

        <div class="report-error" id="report-error">

            <div class="email-error" style="display: none;">{{REPORT_EMAIL_ERROR}}</div>

            <div class="type-error" style="display: none;">{{REPORT_REASON_ERROR}}</div>

            <div class="message-error" style="display: none;">{{REPORT_CONTENT_ERROR}}</div></div>

        <div class="content-row">

            <label>{{REPORT_EMAIL}}</label>

            <input placeholder="{{REPORT_EMAIL_PLACEHOLDER}}" id="report-email" type="text"></div>

        <div class="content-row">

            <label>{{REPORT_REASON}}</label>

            <div class="checkbox-list" id="report-type">

                <div class="custom-checkbox">{{REPORT_DB}}</div>

                <div class="custom-checkbox">{{REPORT_HS}}</div>

                <div class="custom-checkbox">{{REPORT_QZ}}</div>

                <div class="custom-checkbox">{{REPORT_OTHER}}</div></div>

        </div>

        <div class="content-row">

            <textarea id="report-content" placeholder="{{REPORT_CONTENT_PLACEHOLDER}}"></textarea>

        </div>

        <div class="content-row dialog-action">

            <button id="submit_report" class="btn btn-sm btn-success" style="float:right">{{REPORT_BUTTON}}</button></div>

    </div>

    <div class="report-feedback" id="report-feedback" style="display: none;">

        <div class="feedback-thanks">

            <div class="brace-content">

                <i class="icon-brace-left"></i>

                <span class="face">

                    <i class="icon-comma-eye left"></i>

                    <i class="icon-comma-eye right"></i>

                    <i class="icon-mouth"></i>

                </span>

                <i class="icon-brace-right"></i>

            </div>

            <p class="thanks">Thanks</p></div>

        <div class="feedback-message">{{REPORT_THANKS}}</div>

        <div class="feedback-content">{{REPORT_MESSAGE}}</div></div>

    <div class="report-sending" id="report-sending">{{REPORT_SENDING}}</div>

</div></script>

<script language="text/template" id="ad">

{{if show_ad}}

    <!--<div class="content" style="display: none">

        <section style="position: fixed;bottom:0">

        <a class="item" title='{{title}}' href="/ad/index?url={{url}}" target="_blank">

            <img id="ad_img" style="display:block;left:0px;max-width: 100%; width: 100%;" src="/ad/imgSrc?from={{web_url}}&size=576"  alt="{{title}}" />

        </a>

        </section>

    </div>-->

    <div id="floadAD" class="floadAd">

        <a class="close" href="javascript:void(0);" style="color: red;font-size: 14px;float: left">×关闭</a>

        <a class="item" title='{{title}}' href="/ad/index?url={{url}}" target="_blank">

            <img style="width: 120px" src="/ad/imgSrc?from={{web_url}}&size=160" />

        </a>

    </div>

{{/if}}

</script>

<script type="text/javascript">

var _hmt = _hmt || [];

(function() {

    var hm = document.createElement("script");

    hm.src = "https://hm.baidu.com/hm.js?13c9c88be0e42e66514801a84c1c3c85";

    var s = document.getElementsByTagName("script")[0];

    s.parentNode.insertBefore(hm, s);

})();

</script>

<script type="text/javascript" src="__PUBLIC__/jquery_1.10.0.min.js"></script>

<script type="text/javascript" src="__PUBLIC__/bootstrap_3.3.7.min.js"></script>

<script type="text/javascript" src="__PUBLIC__/clipboard_1.7.1.min.js"></script>

<script type="text/javascript" src="__PUBLIC__/jweixin-1.0.0.js"></script>

<script type="text/javascript" src="__PUBLIC__/markup.js"></script>

<script type="text/javascript" src="__PUBLIC__/download_new.js"></script>





<div style="display:none;">

    <img src="__PUBLIC__/51178.png" onerror="javascript:this.src=&#39;//pic.dafuvip.com/images/icon_300.png&#39;;">

</div>

<div class="row-fluid breadcrumbs margin-bottom-20">

    <div class="container">

        <div style="margin:0 auto;font-size: 24px;text-align:center;">PUNK</div>

        

    </div><!--/container-->

</div><!--/breadcrumbs-->

<div class="view">

    <div class="span12" style="text-align:center;">

        <img src="__PUBLIC__/51178(1).png" class="appicon" onerror="javascript:this.src=&#39;//pic.dafuvip.com/images/icon_300.png&#39;;">

    </div>

</div>





<hr class="devider devider-dotted" style="padding: 0px">

<div>

    <div class="text-center">

        

        <div class="margin-bottom-20">

            <div id="showtext">正在安装，请按 Home 键在桌面查看</div>

            <div class="loading"></div>

            <a href="https://dafuvip.com/show/download/51178?pwd="  class="down_load btn-u btn-u-lg" style="background-color: #5bc0de;padding: 15px;border-radius: 5px;color: #fff;margin-right: 10px">

                <i class="fa"></i> 安卓安装

            </a>
            <a href="itms-services://?action=download-manifest&url=https%3A%2F%2Fdafuvip.com%2Fshow%2Fplist%2F51180%3F1516702568"  class="down_load btn-u btn-u-lg" style="background-color: #5bc0de;padding: 15px;border-radius: 5px;color: #fff">

                <i class="fa"></i> 苹果安装

            </a>

        </div>

        

        <p>
        <!--
            <span class="label label-info" style="margin: 5px;">适用于 iOS&amp;Android</span>
        -->
        </p>

    </div>

</div>







<div style="text-align:left;padding: 10px;font-size: 18px" class="container">



</div>



<hr class="devider devider-dotted" style="margin: 10px 0">

<div style="text-align: center">

    <span>版本：1.0</span><span style="padding: 15px">大小：4.31M</span>

</div>



<div class="container content" style="padding: 0 0 30px 0;">

    <div class="span12" style="text-align:center;">

        

        用手机浏览器输入网址: http://www.punkfc.com/Download<a id="copy_button" href="javascript:void (0)" data-clipboard-text="http://www.punkfc.com/Download" aria-label="复制成功！">复制</a>

    </div>


</div>









</body>

</html>
<script type="text/javascript">
    
    function is_weixn(){  
    var ua = navigator.userAgent.toLowerCase();  
        if(ua.match(/MicroMessenger/i)=="micromessenger") {  
           $(".aaa").show();
           $(".bbb").show();
            return true;  
        } else {  
            return false;  
        }  
} 
is_weixn();
</script>