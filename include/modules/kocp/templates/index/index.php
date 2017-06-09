<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">
<title>网站管理中心</title>
<link type="text/css" href="<?php echo KO_DOMAIN_URL; ?>/static/ht/css/skin_0.css" rel="stylesheet" id="cssfile"/>
<script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/jquery.js"></script>
<!--[if IE]>
<script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/jquery.cookie.js"></script>
<script type="text/javascript">
$(document).ready(function () {

    $('span.bar-btn').click(function () {
		$('ul.bar-list').toggle('fast');
    });

	pagestyle(); $(window).resize( pagestyle() ); //设置大小
	if ($.cookie('now_location_3') != null) {

		ko_open_Item($.cookie('now_location_1'), $.cookie('now_location_2'), $.cookie('now_location_3'));
	} else { //第一次进入后台时，默认定到欢迎界面
		$('ul>li>a[id*=ko_nav_]').eq(0).addClass('actived');
		var obj1 = $('#mainMenu>ul').first(), obj2 = obj1.find('a[id*=ko_item_]').eq(0);
		obj1.css('display', 'block'); obj2.addClass('selected');
		$('#workspace').attr('src', obj2.attr('url'));
	}

	//皮肤切换
	$('#skin li').click(function(){

		$('#'+this.id).addClass('selected').siblings().removeClass('selected');
		$('#cssfile').attr('href','<?php echo KO_DOMAIN_URL; ?>/static/ht/css/'+ (this.id) +'.css');
        $.cookie( 'KO_Css_Skin' ,  this.id , { path: '/', expires: 10 });
        $('iframe').contents().find('#cssfile2').attr('href','<?php echo KO_DOMAIN_URL; ?>/static/ht/css/'+ (this.id) +'.css'); 
    });

    var cookie_skin = $.cookie('KO_Css_Skin');

    if (cookie_skin) {

		$('#'+cookie_skin).addClass('selected').siblings().removeClass('selected');
		$('#cssfile').attr('href','<?php echo KO_DOMAIN_URL; ?>/static/ht/css/'+ cookie_skin +'.css'); 
		$.cookie('KO_Css_Skin', cookie_skin, {path:'/', expires:10});
    }
});

//获取iframe长宽
function pagestyle() {

	var iframe = $('#workspace');
	var h = $(window).height() - iframe.offset().top;
	var w = $(window).width() - iframe.offset().left;
	if(h < 300) h = 300;
	if(w < 973) w = 973;
	iframe.height(h);
	iframe.width(w);
}

//点击事件

function ko_open_Item(t, d1, d2) { //1顶部，2左侧

	$('.actived').removeClass('actived');
	$('#ko_nav_'+d1).addClass('actived');
	$('.selected').removeClass('selected');
	$('#mainMenu ul').css('display', 'none');
	$('#ko_sort_'+d1).css('display', 'block');
	if (t == 1) {		

		var first_obj = $('#ko_sort_'+d1+'>li>dl>dd>ol>li').first().children('a');first_obj.addClass('selected');
		$('#crumbs').html('<span>'+$('#ko_nav_'+d1+' > span').html()+'</span><span class="arrow">&nbsp;</span><span>'+first_obj.html()+'</span>');
		$('#workspace').attr('src', first_obj.attr('url'));
	} else {
		var now_obj = $('a[id=ko_item_'+d1+d2+']'); now_obj.addClass('selected');
		$('#crumbs').html('<span>'+$('#ko_nav_'+d1+' > span').html()+'</span><span class="arrow">&nbsp;</span><span>'+now_obj.html()+'</span>');
		$('#workspace').attr('src', now_obj.attr('url'));
	}

    $.cookie('now_location_1', t); $.cookie('now_location_2', d1); $.cookie('now_location_3', d2);
}

//显示灰色JS遮罩层 
function showBg(ct, content) {

	var bH = $('body').height(), bW = $('body').width(), objWH = getObjWh(ct);
	$('#pagemask').css({width:bW, height:bH, display:'none'});
	var tbT = objWH.split('|')[0]+'px'; 
	var tbL = objWH.split('|')[1]+'px'; 
	$('#'+ct).css({top:tbT, left:tbL, display:'block'}); 
	$(window).scroll(function(){ resetBg(); }); 
	$(window).resize(function(){ resetBg(); });
} 

function getObjWh(obj) { 

	var st = document.documentElement.scrollTop;//滚动条距顶部的距离 
	var sl = document.documentElement.scrollLeft;//滚动条距左边的距离 
	var ch = document.documentElement.clientHeight;//屏幕的高度 
	var cw = document.documentElement.clientWidth;//屏幕的宽度 
	var objH = $('#'+obj).height();//浮动对象的高度 
	var objW = $('#'+obj).width();//浮动对象的宽度 
	var objT = Number(st)+(Number(ch)-Number(objH))/2; 
	var objL = Number(sl)+(Number(cw)-Number(objW))/2; 
	return objT+'|'+objL; 
} 

function resetBg() { 

	var fullbg = $('#pagemask').css('display'); 
	if (fullbg == 'block') { 

		var bH2 = $('body').height(); 
		var bW2 = $('body').width(); 
		$('#pagemask').css({width:bW2,height:bH2}); 
		var objV = getObjWh('dialog'); 
		var tbT = objV.split('|')[0]+'px'; 
		var tbL = objV.split('|')[1]+'px'; 
		$('#dialog').css({top:tbT, left:tbL}); 
	}
}

//关闭灰色JS遮罩层和操作窗口 
function closeBg(){ 

	$('#pagemask').css('display','none'); 
	$('#dialog').css('display','none'); 
}

</script>
</head>

<body style="margin:0px;" scroll="no">
<div id="pagemask"></div>
<div id="dialog" style="display:none;">
	<div class="title">
		<h3>管理中心导航</h3>
		<span><a href="javaScript:;" onclick="closeBg();">关闭</a></span>
	</div>
	<div class="content"><?php echo $content_1; ?></div>
</div>
<table style="width:100%;" id="frametable" height="100%" width="100%" cellpadding="0" cellspacing="0">
  <tbody>
	<tr>
		<td colspan="2" height="90" class="mainhd">
			<div class="layout-header">
				<div id="title"></div>
				<div id="topnav" class="top-nav">
					<ul>
						<li class="adminid" title="您好:<?php echo $_SESSION['ko_htuser_info']['users']; ?>">您好&nbsp;:&nbsp;<strong><?php echo $_SESSION['ko_htuser_info']['users']; ?></strong></li>
                        <li><a href="<?php echo KO_DOMAIN_URL; ?>/kocp/index/pwd" target="workspace" title="修改密码"><span>修改密码</span></a></li>
						<li><a href="<?php echo KO_DOMAIN_URL; ?>/kocp/index/logout" title="退出"><span>退出</span></a></li>
						<li><a href="<?php echo KO_DOMAIN_URL; ?>" target="_blank" title="网站首页"><span>网站首页</span></a></li>
					</ul>
				</div>

				<nav id="nav" class="main-nav"><?php echo $content_2; ?></nav>
				<div class="loca">
					<strong>您的位置：</strong>
					<div id="crumbs" class="crumbs"><span>控制台</span><span class="arrow">&nbsp;</span><span>欢迎页面</span> </div>
				</div>

				<div class="toolbar">
					<ul id="skin" class="skin">
						<span>换肤</span>
						<li id="skin_0" title="默认风格"></li>
						<li id="skin_1" title="Mac风格"></li>
					</ul>

					<div class="sitemap">
                        <a id="siteMapBtn" href="javascript:;" onclick="showBg('dialog', 'dialog_content');" title="管理地图"><span>管理地图</span></a>
                        <a style="margin-left:8px;" href="<?php echo KO_DOMAIN_URL; ?>/kocp/index/clearcache" title="更新站点缓存"><span>更新站点缓存</span></a>
					</div>
				</div>
			</div>
			<div>
		</div>
		</td>
	</tr>
    <tr>
		<td class="menutd" valign="top" width="161">
            <div id="mainMenu" class="main-menu"><?php echo $content_3; ?></div>
            <!-- <div class="copyright">
                总计登录次数：</br><?php echo $_SESSION['ko_htuser_info']['login_num']; ?>次</br></br>
                最后登录时间：</br><?php echo date('Y-m-d H:i:s', $_SESSION['ko_htuser_info']['last_at']); ?></br></br>
                最后登录IP：</br><?php echo $_SESSION['ko_htuser_info']['last_ip']; ?></br></br>
            </div> -->
        </td>
        <td valign="top" width="100%"><iframe src="" id="workspace" name="workspace" style="overflow:visible;" frameborder="0" width="100%" height="100%" scrolling="yes" onload="window.parent"></iframe></td>
	</tr>
  </tbody>
</table>
</body>
</html>