function play_editor(url)
{
	var c = '<video src="'+url+'" style="margin: 0 auto 40px auto; width:600px;display: block;" controls="controls"></video>';
	msg_box_common(c, 670 ,'科研视频');
	shade_box();
}

$(document).ready(function(){
	$(window).resize(function(){$('#footer_contact').css({'left':($(window).width() - 980)/2});});
	$('#to_top').click(function(){$(window).scrollTop(0);});
	//下拉菜单
	$('#polish').slide_menu('smenus_polish',120);
	$('#shugao').slide_menu('smenus_shugao',120);
	$('#translate').slide_menu('smenus_translate',120);
	$('#journal_select').slide_menu('smenus_journal_select',120);
	$('#study_abroad').slide_menu('smenus_study_abroad',130);
	$('#examples').slide_menu('smenus_examples',150);
	$('#menu_lx').slide_menu('smenus_lx',185);
	$('#tool').slide_menu('smenus_tool',155);
	$('#quality').slide_menu('smenus_quality',150);
	//底部联系信息
	$('#footer_contact').css({'left':($(window).width() - 980)/2});
	$('#footer_contact').show();
});

function fasted_submit()
{
	var c ='<div class="fast_order_list"><div class="fast_order_list_t">论文润色</div><a href="/polish/sub">下单</a><a href="/polish">详细介绍</a></div><div class="fast_order_list" style="margin-left:22px;"><div class="fast_order_list_t">专业论文翻译</div><a href="/translate/sub">下单</a><a href="/translate">详细介绍</a></div><div class="fast_order_list" style="margin-top:22px;"><div class="fast_order_list_t">留学文书润色</div><a href="/study_abroad/sub">下单</a><a href="/study_abroad">详细介绍</a></div><div class="fast_order_list" style="margin-top:22px; margin-left:22px;"><div class="fast_order_list_t">留学文书翻译</div><a href="/study_abroad_tr/sub">下单</a><a href="/study_abroad_tr">详细介绍</a></div>';
	msg_box_common(c, 758);
	shade_box();
}

function na_box_confirm_delete(title, url, content, func, args)
{
	if($('#na_box_confirm').size() < 1)
	{
		$('<div id="na_box_confirm"><div id="na_box_confirm_t">'+title+'</div><div id="na_box_confirm_c">'+content+'</div><div id="na_box_confirm_b"><div id="na_box_confirm_yes">确认</div><div id="na_box_confirm_cancel">取消</div></div></div>').appendTo('body');
	}
	else
	{
		$('#na_box_confirm_c').html(content);
	}
	
	var sets = get_offsets('na_box_confirm');
	$('#na_box_confirm').css({top:sets.top, left:sets.left});
	$('#na_box_confirm').fadeIn(50);
	
	$('#na_box_confirm_yes').click(function()
	{
		$(this).unbind();
		$('#na_box_confirm').hide(100);
		shade_box_close();
		setTimeout(function()
		{
			func(args);
		},200);
	});
	
	$('#na_box_confirm_cancel').click(function()
	{
		$('#na_box_confirm').fadeOut(100);
		shade_box_close();
	});
	
	$('#na_box_confirm_t').click(function()
	{
		$('#na_box_confirm').fadeOut(100);
		shade_box_close();
	});
	
	//警告框移动效果
	$('#na_box_confirm').mousedown(function(e)
	{
		//获取鼠标位置
		var x = e.clientX;
		var y = e.clientY;
		//获取警告框的偏移值
		var sets = $('#na_box_confirm').offset();
		
		//计算鼠标和警告框的偏移值
		var x1 = x - sets.left;
		var y1 = y - sets.top;
		$(this).css({top:y-y1, left:x-x1});
		
		$(this).bind('mousemove',function(e)
		{
			$(this).css({top:e.clientY-y1, left:e.clientX-x1});
		});
	});
	
	$('#na_box_confirm').mouseup(function()
	{
		$(this).unbind('mousemove');
	});
	
	shade_box();
}

function logoff()
{
	$.get
	(
		'/index.php?a=login&m=logoff',
		{},
		function(msg)
		{
			na_alert_box('您已经退出方维期刊网编辑',2);
			setTimeout(function(){location.href="/";},2000);
		}
	);
}

// 轮播动画 ------------------------------------
function slideBox(){
	this.slide_speed     = 500;
	this.delay           = 6000;
	this.startIndex      = 0;
	this.li_width        = 0;
	this.main_box_id     = '';
	this.point_box_id    = '';
	this.next_box_id     = '';
	this.point_width     = 20;
	this.total_li        = 0;
	this.set_time_id     = null;
	this.point_style     = '';
	this.next_button_id  = '';
	this.start = function(){
		var winWidth     = $(window).width();
		this.li_width    =  winWidth;
		$(this.main_box_id).find('li').css({width:winWidth});
		if($(this.point_box_id).find('div').size() < 1){
			this.total_li  =  $(this.main_box_id).find('li').size();
			$(this.main_box_id).find('li').eq(0).clone().appendTo(this.main_box_id+' ul');
			var insert_str = '';
			for(i=1; i<=this.total_li; i++){
				insert_str += '<div></div>';
			}
			insert_str += '<input type="hidden" value="0" />';
			$(this.point_box_id).html(insert_str);
			$(this.main_box_id).find('ul').css({'width':500000});
			this.point_width =  $(this.point_box_id).find('div').outerWidth(true);
			$(this.point_box_id).css({'width':this.point_width*this.total_li+2});
		}else{
			this.total_li  =  $(this.main_box_id).find('li').size() - 1;
			$(this.main_box_id).find('ul').css({'width':(this.total_li) * this.li_width + 500000});
			
		}
		var this_obj = this;
		$(this.point_box_id).find('div').click(function(){
			$(this_obj.main_box_id).find('ul').stop();
			clearTimeout(this_obj.set_time_id);
			this_obj.slide_it($(this).index());
		});
		this.slide_it(0);
	}
	
	this.slide_it = function (index){
		if(this.set_time_id != null){
			clearTimeout(this.set_time_id);
		}
		var this_obj = this;
		$(this.main_box_id).find('ul').animate(
			{'margin-left': index * this.li_width * -1},
			this.slide_speed,
			function(){
				if(index < this_obj.total_li){
					this_obj.point_select(index);
					$(this_obj.point_box_id).find(':hidden').val(index);
					this_obj.set_time_id = setTimeout(function(){this_obj.slide_it(index+1)},this_obj.delay);
				}else{
					this_obj.point_select(0);
					$(this_obj.point_box_id).find(':hidden').val(0);
					$(this_obj.main_box_id).find('ul').css({'margin-left':0});
					this_obj.set_time_id = setTimeout(function(){this_obj.slide_it(1)},this_obj.delay);
				}
			}
		);
	}
	this.point_select = function (index){
		$(this.point_box_id).find('div').removeClass(this.point_style);
		$(this.point_box_id).find('div').eq(index).addClass(this.point_style);
	}
}

// 通用遮罩动画--------------------------------
function shade_box()
{
	if($('#shade_box').size() < 1)
	{
		$('<div id="shade_box"></div>').appendTo('body');
	}
	var w_height = $(window).height();
	var b_height = $('body').outerHeight(true)+300;
	if(w_height > b_height)
	{
		var height_use = w_height;
	}
	else
	{
		var height_use = b_height;
	}
	$('#shade_box').css({'height':height_use, 'opacity':0.75});
	$('#shade_box').fadeIn(100);
}

function shade_box_close()
{
	$('#shade_box').hide();
}

// 通用弹出窗口
function msg_box_common(content,width_set,title,without_close)
{
	if($('#na_box_confirm').size() < 1)
	{
		$('<div id="na_box_confirm"><div id="na_box_confirm_t">MogoEdit.com</div><div id="na_box_confirm_c">'+content+'</div></div>').appendTo('body');
	}
	else
	{
		$('#na_box_confirm_c').html(content);
	}
	
	if(width_set != undefined)
	{
		$('#na_box_confirm').css({width:width_set});
	}
	
	var sets = get_offsets('na_box_confirm');
	$('#na_box_confirm').css({top:sets.top - 50, left:sets.left});
	
	
	if(title != undefined)
	{
		$('#na_box_confirm_t').html(title);
	}
	
	$('#na_box_confirm').fadeIn(100);
	
	if(without_close != undefined)
	{
		$('#na_box_confirm_t').unbind();
		$('#na_box_confirm_t').css({'background':'url() no-repeat right center #47928B'});
	}
	else
	{
		$('#na_box_confirm_t').click(function(){$('#na_box_confirm').hide(); shade_box_close(); $('#na_box_confirm_c').html('');});
	}
	
	//通用弹出窗口移动
	$('#na_box_confirm').mousedown(function(e)
	{
		//获取鼠标位置
		var x = e.clientX;
		var y = e.clientY;
		//获取警告框的偏移值
		var sets = $('#na_box_confirm').offset();
		
		//计算鼠标和警告框的偏移值
		var x1 = x - sets.left;
		var y1 = y - sets.top;
		$(this).css({top:y-y1, left:x-x1});
		
		$(this).bind('mousemove',function(e)
		{
			$(this).css({top:e.clientY-y1, left:e.clientX-x1});
		});
	});
	
	$('#na_box_confirm').mouseup(function()
	{
		$(this).unbind('mousemove');
	});
}
var na_alert_box_settime_id = null;
//系统提示框
function na_alert_box(content,type)
{
	if($('#na_box_small').size() < 1)
	{
		$('<div id="na_box_small"></div>').appendTo('body');
	}
	if(na_alert_box_settime_id != null)
	{
		clearTimeout(na_alert_box_settime_id);
	}
	if(type == 1)
	{
		$('#na_box_small').css({'background-image':'url(../../../../../static/images/error.jpg)'});
	}
	else
	{
		$('#na_box_small').css({'background-image':'url(../../../../../static/images/right.jpg)'});
	}
	
	$('#na_box_small').html(content);
	$('#na_box_small').css({width:na_length(content)*8});
	var sets = get_offsets('na_box_small');
	$('#na_box_small').css({top:sets.top, left:sets.left});
	$('#na_box_small').fadeIn(50);
	na_alert_box_settime_id  = setTimeout
	(
		function()
		{
			$('#na_box_small').fadeOut(50);
		},
		2500
	);
}

//计算left 和 top 值
function get_offsets(id)
{
	var win_width    = $(window).width();
	var win_height   = $(window).height();
	var scroll_top   = $(window).scrollTop();
	var top          = (win_height - $('#'+id).outerHeight(true)) / 2 + scroll_top;
	var left         = (win_width - $('#'+id).outerWidth(true)) / 2;
	return {left:left,top:top};
}

//计算字符个数
function na_length(str)
{
    var l = 0;
	var a = str.split("");
	for (var i=0;i<a.length;i++)
	{
		if(a[i].charCodeAt(0)<299) {
			l++;
		}
		else
		{
	  		l+=2;
		}
	}
	return l;
}