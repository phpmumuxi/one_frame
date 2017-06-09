$(document).ready(function(){
	
	//首页轮播动画
	sliderIndex               = new slideBox();
	sliderIndex.main_box_id   = '#indexBanner';
	sliderIndex.point_box_id  = '#indexBannerPoint';
	sliderIndex.point_style   = 'indexBannerSed';
	sliderIndex.start();
	init();
	$(window).resize(function(){init();});
	//客户评价
	$('#customer_scoring_index').scroll_valign();
	$('#index_editor li').last().addClass('no_border');
	
	//去除last li 下划线
	$('.common_left_farea').each(function(){$(this).find('li').last().addClass('no_border');});
	
	//院校展示
	$('#index_schools').scroll_valign(3000);
	
	/* 首页宣传片动画 */
	$('#but_index_play').click(function()
	{
		shade_box();
		index_play();
	});
	$('#index_play_t').click(function()
	{
		$('#index_play').hide();
		shade_box_close();
	});
});

function init(){
	var win_width = $(window).width();
	$('#indexBannerPoint').css({left : (win_width - $('#indexBannerPoint').width())/2 });
	sliderIndex.start();
	var sets = $('#header_menu_in').offset();
	$('#indexBanAd').css({'left':sets.left+660}).show();
}

function index_play()
{
	var win_width  = $(window).width();
	var win_height = $(window).height();
	var left_v     = (win_width - $('#index_play').outerWidth(true))/2;
	var top_v      = (win_height - $('#index_play').outerHeight(true))/2 + $(window).scrollTop();
	$('#index_play').css({left:left_v, top:top_v});
	
	if($('#index_play').is(':hidden'))
	{
		var flashvars={
            f:'http://image.mogostudy.com/mogo.flv',
            c:0,
            p:1,
            e:1,
            m:0,
            i:''
            };
        var params={bgcolor:'#000',allowFullScreen:true,allowScriptAccess:'always'};
        var attributes={id:'ckplayer_indexplay',name:'ckplayer_indexplay'};
        swfobject.embedSWF('/public/player/ckplayer.swf', 'indexplay', '600', '480', '10.0.0','/public/player/expressInstall.swf', flashvars, params, attributes); 
        var video={'http://image.mogostudy.com/mogoedit.f4v':'video/f4v'};
        var support=['iPad','iPhone','ios','android+false','msie10+false'];
        CKobject.embedHTML5('video','ckplayer_indexplay',600,480,video,flashvars,support);
		$('#index_play').fadeIn();
	}
}