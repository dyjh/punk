(function () {
    var language = {
        AUTO_RETURN_HOME: "<label id='countdown'>{{countdown}}</label> 秒后发现新应用",
        LOADING: "加载中...",
        DOWNLOAD_INSTALL: "下载安装",
        DOWNLOAD_LOADING: "下载中",
        DATA_ERROR: "数据错误",
        DATA_INCOMPLETE: "请联系应用开发者, <a href='/apps/new'>去新版重新上传</p>",
        DATA_INCOMPLETE_IN_MOBILE: "请联系应用开发者重新上传",
        DOWNLOAD_FAILED: "刷新并重试",
        VIEW_IN_DESKTOP: "正在安装，请按 Home 键在桌面查看",
        VIEW_IN_BROWSER: "请在浏览器中查看下载进度",
        PLATFORM_NOT_MATCHING: "只支持 {{app|app_type}} 设备",
        CHANGELOG_PLACEHOLDER: "没有更新日志",
        FAILED_LOAD_APP: "加载失败",
        NOT_FOUND_TITLE: "404 - Not Found",
        NOT_FOUND_LOG: "您访问的 应用/页面 不存在",
        FORBIDDEN_TITLE: "403 - Forbidden",
        FORBIDDEN_TITLE_LOG: "您没有权限访问这个应用",
        REQUIRE_PWD: "请输入密码",
        PASSWORD_WRONG: "密码错误",
        SCAN_TIPS: "扫描二维码下载<br/>或用手机浏览器输入这个网址:&nbsp;&nbsp;<span class='text-black'>{{full_short}}</span>",
        DESC: "应用描述",
        CURRENT_VERSION: "当前版本",
        FILE_SIZE: "文件大小",
        UPDATED_AT: "更新于",
        RELEASES: "历史版本",
        CHANGELOG: "更新日志",
        VIEW_ALL_APP_RELEASES: "查看全部 {{app.histories|length}} 个历史版本",
        VIEW_ALL_APP_RELEASES_IOS: "查看全部 {{ios.histories|length}} 个历史版本",
        VIEW_ALL_APP_RELEASES_ANDROID: "查看全部 {{android.histories|length}} 个历史版本",
        FOLDING: "隐藏",
        VIEW_ALL_COMBOAPP_RELEASES: "查看全部 {{combo_app.releases|length}} 个历史版本",
        SCREENSHOTS: "应用截图",
        INHOUSE: "123",
        ADHOC: "内测版",
        CONFIRM: "确认",
        UNABLE_INSTALL: "微信/QQ 内无法下载应用",
        GO_OUT_WECHAT_TIP: "请点击右上角<br/>选择“浏览器中打开”",
        GO_OUT_WECHAT_IOS_TIP: "点击右上角菜单在<br/>Safari中打开并安装",
        FOOTER_SLOGAN: 'fir.im 是应用内测平台，请自行甄别应用风险，<wbr />如应用存在问题，<wbr />可点击“举报”按钮 <a class="one-key-report"href="javascript:;">举报!</a>',
        SAFE: "安全",
        SAFE_TEXT: "此应用已通过以下安全检测，可放心下载",
        VIRUS_PASS: "扫描通过",
        LOW_RISK: "低风险",
        HIGH_RISK: "高风险",
        VIRUS: "病毒",
        RISK: "有风险",
        RISK_TEXT: "此应用下载有风险，请谨慎下载",
        KING_SOFT: "猎豹安全大师",
        BAIDU: "百度手机士",
        POPULARIZE: "推荐应用",
        DOWNLOAD: "下载",
        REPORT_RETUEN: "返回下载页",
        REPORT_SENDING: "正在发送，请稍后...",
        REPORT_EMAIL: "你的邮箱",
        REPORT_EMAIL_PLACEHOLDER: "Email",
        REPORT_EMAIL_ERROR: "请填写有效的邮箱，可及时了解举报结果",
        REPORT_REASON: "举报原因",
        REPORT_DB: "盗版",
        REPORT_HS: "黄色",
        REPORT_QZ: "欺诈",
        REPORT_OTHER: "其它",
        REPORT_REASON_ERROR: "请选择举报类型",
        REPORT_CONTENT_PLACEHOLDER: "补充举报原因",
        REPORT_CONTENT_ERROR: "请填写举报原因",
        REPORT_BUTTON: "举报！",
        REPORT_THANKS: "感谢你的举报",
        REPORT_MESSAGE: "我们会尽快核实您的举报内容，关于举报的处理结果将于 1-3 个工作日内发送至你邮箱。",
        LEGAL_FORBIDDEN: "因法律的要求<br />而被拒绝",
        LEGAL_FORBIDDEN_LOG: "该 APP 涉及盗版、欺诈、色情或其他不良信息"
    };

    $.extend(Mark.includes, language);

    $(function () {
        window.DAFU = {
            brand : "DAFU.im 3.1 - Rio",
            locale: 'zh',
            params: {},
            platform: {},
            config: {
                server: "//dafuvip.com/jsonFormat"
            },
            data: {},
            APP : {},
            signPackage:{},
            AD  : {},
            init: function(){

            },
            query: function () {
                var self = this;
                $.getJSON(this.config.server+'/'+this.getQuerySetting(), this.getQueryParams(), function (ret) {
                    if (ret.code != '200') {
                        //alert('系统发生错误，请刷新重试');
                        return false;
                    }
                    self.APP         = ret.data.info;
                    self.AD          = ret.data.ad_config;
                    self.signPackage = ret.data.signPackage;
                    self.data        = ret.data;
                    //console.dir(self.APP.template);
                    if (!self.APP.template) {
                        self.success();
                    } else if (['qipai2','buyu','majiang','qipai'].indexOf(self.APP.template) > -1) {
                        self.successVip();
                    }
                });
            },
            getQuerySetting: function() {
                var pathname = window.location.pathname.substring(1);
                pathname =  pathname.split("?")[0];
                return pathname.replace(/show\//, "");
            },
            getQueryParams: function GetRequest() {
                var url = location.search;
                var theRequest = new Object();
                if (url.indexOf("?") != -1) {
                    var str = url.substr(1);
                    var strs = str.split("&");
                    for(var i = 0; i < strs.length; i ++) {
                        theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
                    }
                }
                return theRequest;
            },

            successVip :function() {
                var tmp = Mark.up($('#title').html(), this.APP);
                $('head').append(tmp);
                var tmp = Mark.up($('#meta').html(), this.APP);
                $('head').append(tmp);

                this.APP.show_button = this.data.show_button;
                this.APP.checked = this.data.checked;

                this.APP.support_ios =  (this.APP.support & 1) ? true : false;
                this.APP.support_android =  (this.APP.support & 2) ? true : false;
                $('body').append(Mark.up( $('#content').html(), this.APP));
                var clipboard = new Clipboard('#copy_button');
                clipboard.on('success', function(e) {
                    var msg = e.trigger.getAttribute('aria-label');
                    alert(msg);
                    e.clearSelection();
                });

                this.APP.show_guide = this.data.show_guide;
                $('body').append(Mark.up( $('#copyright').html(), this.APP));

                this.showAd();
                this.showPopup();
                this.weixin();
            },

            success: function () {
                var tmp = Mark.up($('#title').html(), this.APP);
                $('head').append(tmp);
                var tmp = Mark.up($('#meta').html(), this.APP);
                $('head').append(tmp);
                var top_title = Mark.up($('#top_title').html(), this.APP);
                $('body').append(top_title);

                this.APP.show_button = this.data.show_button;
                this.APP.checked = this.data.checked;
                var button = Mark.up($('#button').html(), this.APP);
                $('body').append(button);

                $('body').append(Mark.up( $('#intro').html(), this.APP));
                $('body').append(Mark.up( $('#qrcode').html(), this.APP));
                var clipboard = new Clipboard('#copy_button');
                clipboard.on('success', function(e) {
                    var msg = e.trigger.getAttribute('aria-label');
                    alert(msg);
                    e.clearSelection();
                });

                this.APP.show_guide = this.data.show_guide;
                $('body').append(Mark.up( $('#copyright').html(), this.APP));


                this.showAd();
                this.showPopup();
                this.weixin();
            },

            showAd :function(){
                this.AD.web_url = this.APP.web_url;
                this.AD.show_ad = this.data.show_ad;
                $('body').append(Mark.up( $('#ad').html(), this.AD));

                function FloatAd(selector) {
                    var obj = $(selector);
                    if (obj.find(".item").length == 0) return;//如果没有内容，不执行
                    var windowHeight = $(window).height();//浏览器高度
                    var windowWidth = $(window).width();//浏览器宽度
                    var dirX = -1.5;//每次水平漂浮方向及距离(单位：px)，正数向右，负数向左，如果越大的话就会看起来越不流畅，但在某些需求下你可能会需要这种效果
                    var dirY = -1;//每次垂直漂浮方向及距离(单位：px)，正数向下，负数向上，如果越大的话就会看起来越不流畅，但在某些需求下你可能会需要这种效果

                    var delay = 30;//定期执行的时间间隔，单位毫秒
                    obj.css({ left: windowWidth / 2 - obj.width() / 2 + "px", top: windowHeight / 2 - obj.height() / 2 + "px" });//把元素设置成在页面中间
                    obj.show();//元素默认是隐藏的，避免上一句代码改变位置视觉突兀，改变位置后再显示出来
                    var handler = setInterval(move, delay);//定期执行，返回一个值，这个值可以用来取消定期执行

                    obj.hover(function() {//鼠标经过时暂停，离开时继续
                        clearInterval(handler);//取消定期执行
                    }, function() {
                        handler = setInterval(move, delay);
                    });

                    obj.find(".close").click(function() {//绑定关闭按钮事件
                        close();
                    });
                    $(window).resize(function() {//当改变窗口大小时，重新获取浏览器大小，以保证不会过界（飘出浏览器可视范围）或漂的范围小于新的大小
                        windowHeight = $(window).height();//浏览器高度
                        windowWidth = $(window).width();//浏览器宽度
                    });
                    function move() {//定期执行的函数，使元素移动
                        var currentPos = obj.position();//获取当前位置，这是JQuery的函数，具体见：http://hemin.cn/jq/position.html
                        var nextPosX = currentPos.left + dirX;//下一个水平位置
                        var nextPosY = currentPos.top + dirY;//下一个垂直位置

                        if (nextPosX >= windowWidth - obj.width()) {//这一段是本站特有的需求，当漂浮到右边时关闭漂浮窗口，如不需要可删除
                            //close();
                        }

                        if (nextPosX <= 0 || nextPosX >= windowWidth - obj.width()) {//如果达到左边，或者达到右边，则改变为相反方向
                            dirX = dirX * -1;//改变方向
                            nextPosX = currentPos.left + dirX;//为了不过界，重新获取下一个位置
                        }
                        if (nextPosY <= 0 || nextPosY >= windowHeight - obj.height() - 5) {//如果达到上边，或者达到下边，则改变为相反方向。
                            dirY = dirY * -1;//改变方向
                            nextPosY = currentPos.top + dirY;//为了不过界，重新获取下一个位置
                        }
                        obj.css({ left: nextPosX + "px", top: nextPosY + "px" });//移动到下一个位置
                    }

                    function close() {//停止漂浮，并销毁漂浮窗口
                        clearInterval(handler);
                        obj.remove();
                    }
                }

                FloatAd("#floadAD");
            },
            clickReport : function() {
                    $('.dialog-close .icon-close').click(function(){
                        $('#reportDialog').hide();
                    });
                    $('#reportDialog').show();
                    $('.custom-checkbox').click(function(){
                        $('.custom-checkbox').removeClass('active');
                        $(this).addClass('active');
                    });
                    $("#submit_report").click(function(){
                        var email    = $('#report-email').val();
                        var type     = $('div .active').html();
                        var message  = $('#report-content').val();
                        var app_id   = DAFU.APP.id;
                        var app_name = DAFU.APP.app_name;
                        if (!email) {
                            $('.email-error').show();
                            return false;
                        } else {
                            $('.email-error').hide();
                        }
                        if (!type) {
                            $('.type-error').show();
                            return false;
                        } else {
                            $('.type-error').hide();
                        }
                        if (!message) {
                            $('.message-error').show();
                            return false;
                        } else {
                            $('.message-error').hide();
                        }
                        $('#report-sending').show();
                        $.post('/show/report',{email:email,type:type,message:message,app_id:app_id,app_name:app_name}, function(data){
                            $('#report-sending').hide();
                            if (data.code == 200) {
                                $('#report-form').hide();
                                $('#report-feedback').show();
                            } else {
                                alert(data.msg);
                            }
                        },'json');

                    });

            },
            showPopup: function () {
                var browser = {
                    versions: function () {
                        var u = navigator.userAgent, app = navigator.appVersion;
                        return {
                            trident: u.indexOf('Trident') > -1,
                            presto: u.indexOf('Presto') > -1,
                            webKit: u.indexOf('AppleWebKit') > -1,
                            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,
                            mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/) && u.indexOf('QIHU') && u.indexOf('Chrome') < 0,
                            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
                            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
                            iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1,
                            iPad: u.indexOf('iPad') > -1,
                            webApp: u.indexOf('Safari') == -1,
                            ua: u
                        };
                    }(),
                    language: (navigator.browserLanguage || navigator.language).toLowerCase()
                };
                var weixin, weibo, isQQ, isiOS ,isAndroid = false;
                if (browser.versions.mobile) {//判断是否是移动设备打开。browser代码在下面
                    var ua = navigator.userAgent.toLowerCase();//获取判断用的对象
                    if (ua.match(/MicroMessenger/i) == "micromessenger") {
                        weixin = true;
                    }
                    if (ua.match(/WeiBo/i) == "weibo") {
                        weibo = true;
                    }
                    if (ua.match(/QQ/i) == 'qq' && navigator.userAgent.indexOf("MQQBrowser") < 0) {
                        isQQ = true;
                    }
                    if (browser.versions.ios) {
                        isiOS = true;
                    }
                    if (browser.versions.android) {
                        isAndroid = true;
                    }
                }
                var appType = (this.APP.ext == 'ipa') ? 'ios' : 'android';
                if (weixin == true) {
                    if (isiOS == true) {
                        $("#weixin_ios").show();
                        $("#weixin_android").hide();
                    } else {
                        $("#weixin_ios").hide();
                        $("#weixin_android").show();
                    }
                    return false;
                }

                if (isQQ) {
                    if (isiOS == true) {
                        $("#weixin_ios").show();
                        $("#weixin_android").hide();
                    } else {
                        $("#weixin_ios").hide();
                        $("#weixin_android").show();
                    }
                    return false;
                }

                if (appType == 'android' && isiOS) {
                    $('.down_load').attr('href', '#none').click(function () {
                        alert('该app只适用于android设备');
                        return false;
                    });
                } else if (appType == 'ios' && !isiOS) {
                    $('.down_load').attr('href', '#none').click(function () {
                        alert('该app只适用于IOS设备');
                        return false;
                    });
                } else {
                    $('.down_load').click(function () {
                        if ($(this).attr('name') == 'ios' && !isiOS) {
                            alert('请用IOS设备下载');
                            return false;
                        }
                        if ($(this).attr('name') == 'android' && isiOS) {
                            alert('请用android设备下载');
                            return false;
                        }
                        $(".down_load").hide();
                        $("#showtext").show();
                    });
                }
            }, weixin: function () {
                wx.config({
                    debug: false,
                    appId: this.signPackage["appId"],
                    timestamp: this.signPackage["timestamp"],
                    nonceStr: this.signPackage["nonceStr"],
                    signature: this.signPackage["signature"],
                    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ']
                });

                wx.ready(function () {
                    wx.onMenuShareAppMessage({
                        title: this.APP.app_name,
                        desc: decodeURIComponent(encodeURIComponent(this.APP.app_name + ' - 大福').replace(/\+/g, '%20')),
                        link: this.APP.url,
                        imgUrl: this.APP.icon
                    });
                    wx.onMenuShareTimeline({
                        title: this.APP.app_name,
                        desc: decodeURIComponent(encodeURIComponent(this.APP.app_name + ' - 大福').replace(/\+/g, '%20')),
                        link: this.APP.url,
                        imgUrl: this.APP.icon
                    });
                    wx.onMenuShareQQ({
                        title: this.APP.app_name,
                        desc: decodeURIComponent(encodeURIComponent(this.APP.app_name + ' - 大福').replace(/\+/g, '%20')),
                        link: this.APP.url,
                        imgUrl: this.APP.icon
                    });
                });
            },
            submitPwd:function() {
                window.location.href = '/'+this.getQuerySetting()+'?password='+$('#password').val();
            },
        },
        DAFU.init(), DAFU.query();
    })
}).call(this);

