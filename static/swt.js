//商务通，第一次弹出，13秒后再次显示自动邀请，总共显示2次
var ko_LrinviteTimeout = 2,
ko_LR_next_invite_seconds = 15,
ko_aaa_show_count = 5;
var LR_showminiDiv_no = 1;
//注释后右侧弹窗显示
document.writeln('<script language="javascript" src="http://klf.zoossoft.cn/JS/LsJS.aspx?siteid=KLF51612551&float=0&lng=cn"></script>');
document.writeln('<div id="LRfloater1" style="z-index: 2147483647; position: fixed ! important; left: 50%; margin-left: -173px ! important; top: 50%; margin-top: -210px ! important;  opacity: 1;cursor: pointer;"><img border="0" onclick="openZoosUrl();LR_HideInvite();;return false;" usemap="#Map3LR" src="http://192.168.1.232:8100/sci.png"><map name="Map3LR"><area onclick="LR_RefuseChat();LR_HideInvite();;ko_aaa_close_swt();return false;" href="javascript:void(0)" coords="388,5,272,87" shape="rect"></map></div>');
$(document).ready(function() {
    $('body').append('<div id="ko_rightsead" style="position:fixed;top:50%;margin-top:-154px;right:105px;z-index:999999"><img src="http://192.168.1.232:8100/swt.png" alt="右侧悬浮" usemap="#koxuanfuMap"/><map name="koxuanfuMap">' + '<area shape="rect" coords="5,5,109,661" ' + LiveReceptionCode_BuildChatWin(window.location.hostname + '，右侧悬浮，发表咨询', (LiveReceptionCode_isonline ? '客服人员在线,欢迎点击咨询': '客服人员不在线,请点击留言')) + ' target="_blank"/></map></div>');
});
$('body').append('<div id="hongbao" style="position:fixed;bottom:0;z-index:99999;right:0"><a href="/hongbao" target="_blank" ><img usemap="#planetmap" src="/statics/images/hb.png" /></a><map name="planetmap" id="planetmap"><area shape="circle" coords="250,30,14" alt="Venus" id="sss"/></map></div>');
var ko_current_seconds = 0,
ko_current_count = 0,
ko_lr_mini_closed = 0,
ko_aaa_timer_int = null;
if (typeof(LR_showminiDiv_no) != 'undefined') {
    ko_aaa_caozuo_swt();
} else {
    setInterval(function() {
        if (typeof(lr_mini_closed) != 'undefined' && lr_mini_closed == 1 && ko_lr_mini_closed == 0) {
            ko_aaa_caozuo_swt();
            ko_lr_mini_closed = 1;
        }
    },
    1000);
}
function ko_aaa_caozuo_swt() {
    setTimeout('ko_aaa_show_swt()', (ko_LrinviteTimeout * 1000));
    ko_aaa_timer_int = setInterval(function() {
        if ($('#LRfloater1').is(':hidden') && ko_current_seconds >= ko_LR_next_invite_seconds) {
            ko_aaa_show_swt();
        } else {
            ko_current_seconds++;
        }
    },
    1000);
}
function ko_aaa_show_swt() {
    $('#LRfloater1').fadeIn(1500);
    ko_current_count++;
    ko_current_seconds = 0;
    if (ko_aaa_show_count > 0 && (ko_current_count >= ko_aaa_show_count)) {
        clearInterval(ko_aaa_timer_int);
    }
}
function ko_aaa_close_swt() {
    $('#LRfloater1').fadeOut(1500);
    ko_current_seconds = 0;
}
function ko_click_LRobj(str, id) {
    var obj = null;
    if (id instanceof jQuery) {
        obj = id;
    } else {
        obj = $('#' + id);
    }
    if (obj.length > 0 && typeof(LiveReceptionCode_isonline) != 'undefined') {
        var str = window.location.hostname + '，' + str;
        var url = 'http://klf.zoossoft.cn/LR/Chatpre.aspx?id=KLF51612551&lng=cn&e=';
        if (obj.get(0).tagName == 'A') {
            obj.attr('href', url + str);
            obj.attr('target', '_blank');
            obj.bind('click',
            function() {
                openZoosUrl('chatwin', '&e=' + encodeURI(str));
                return false;
            });
        } else {
            obj.html('<a href="' + url + str + '" target="_blank">' + $.trim(obj.html()) + '</a>');
            obj.html('<a ' + LiveReceptionCode_BuildChatWin(str, (LiveReceptionCode_isonline ? '客服人员在线,欢迎点击咨询': '客服人员不在线,请点击留言')) + '>' + $.trim(obj.html()) + '</a>');
        }
    }
}
$(document).ready(function() { //添加商务通链接
    $(".ljzx").each(function() {
        ko_click_LRobj('首页，立即咨询', $(this), '_self');
    });
    $(".scia,.btn").each(function() {
        ko_click_LRobj('首页，SCI', $(this), '_self');
    });
    $(".carousel-inner .item").each(function() {
        ko_click_LRobj('隐藏，猜你想要', $(this), '_self');
    });
    $(".ab").each(function() {
        ko_click_LRobj('首页，实验技术服务', $(this), '_self');
    });
    $(".tt").each(function() {
        ko_click_LRobj('首页，标题', $(this), '_self');
    });
    $("#sss").each(function() {
        ko_click_LRobj('首页，标题', $(this), '_self');
    });
    $(".line p").each(function() {
        ko_click_LRobj('首页，标题', $(this), '_self');
    });
    $(".zw a").each(function() {
        ko_click_LRobj('基金申请', $(this), '_self');
    });
});
//end document