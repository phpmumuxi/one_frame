$(function()
{
	//提交
	$('#but_order').click(function()
	{
		var exe_check = 1;
		$('.upload_files').each(function()
		{
			var file_name = $(this).val();
			file_name = file_name.toLowerCase();
			if(file_name.indexOf('.exe') != -1)
			{
				exe_check = 2;
			}
		});
		if(exe_check != 1)
		{
			na_alert_box('上传文件类型错误',1);
			return false;
		}
		
		//选择专业
		var cateId  =  $('#cateId').val();
		if(cateId < 1)
		{
			$(window).scrollTop(120);
			na_alert_box('请选择专业',1);
			return false;
		}

		var title  =  $('#title').val();
		var leng      =  na_length(title);
		if(leng < 2)
		{
			$(window).scrollTop(180);
			na_alert_box('请填写您的稿件标题',1);
			$('#title').focus();
			return false;
		}
		//字数检查
		var WordNum         = $('#WordNum').val();
		var reg1            = /^[0-9]{2,}$/;
		if(!reg1.exec(WordNum))
		{
			$(window).scrollTop(160);
			na_alert_box('请填写稿件字数(大于10的整数)',1);
			$('#WordNum').focus();
			return false;
		}
		
		var contact_name  =  $('#contact_name').val();
		var leng_cn       =  na_length(contact_name);
		if(leng_cn < 2)
		{
			na_alert_box('请填写您的称呼',1);
			$('#contact_name').focus();
			return false;
		}
		
		var telephone  =  $('#telephone').val();
		var leng_t     =  na_length(telephone);
		if(telephone < 7)
		{
			na_alert_box('请填写您的联系电话',1);
			$('#telephone').focus();
			return false;
		}
		//遮罩提交
		var c = '<div id="loadin_in_box">数据提交中,请稍候......<br />该过程可能会持续几分钟(上传文件越大时间越长).</div>';
		msg_box_common(c, 488, 'MogoEdit | 订单数据提交', 'disable');
		shade_box();
		setTimeout
		(
			function(){$('#form_order').submit();}
			,
			800
		);
	});
	
	$('.w_198 a:eq(2)').addClass('w_198a_sed');
	//
	$('.order_sub_radius').hover
	(
		function()
		{
			$(this).addClass('order_sub_radius_over');
		}
		,
		function()
		{
			$(this).removeClass('order_sub_radius_over');
		}
	);
	//选择性元素点击事件
	$('.order_sub_radius').click(function()
	{
		var p_obj = $(this).parent();
		if($(this).attr('id') == 'xk_button')
		{
			if($(this).hasClass('order_sub_radius_sed'))
			{
				$(this).removeClass('order_sub_radius_sed');
				$('#is_xk').val('0');
				return false;
			}
		}
		p_obj.find('.order_sub_radius').removeClass('order_sub_radius_sed');
		$(this).addClass('order_sub_radius_sed');
		p_obj.find(':hidden').val($(this).attr('id'));
	});
	//一级专业选择
	select_changer = new select_to_style('cateId','na_select_mian','na_select_options','349px','258px',d_s2);
	select_changer.change_it();
	
	$('#sevice_time').prev().click(function()
	{
		var c = '您选择了加急服务，请您先提交订单。我们将根据该笔订单的具体情况决定此次服务能否正常进行，待我们确认后会开通此笔订单的付款权限并及时与您沟通，协助完成支付，开始润色工作。';
		msg_box_common(c, 488, '加急服务说明');
		shade_box();
	});
	
	$('#but_order').hover
	(
		function()
		{
			$(this).addClass('na_button_over');
		}
		,
		function()
		{
			$(this).removeClass('na_button_over');
		}
	);
	
	$('#skip').click(function()
	{
		location.href = '/polish/confirm';
	});
	
	$('#uper').click(function()
	{
		$('#na_box_confirm_t').css({'background':'url(/images_new/bg/close.png) no-repeat right center #47928B'});
		msg_box_common('您上传的文件过大(最大可以上传8M的文件),请将文件压缩后上传或联系我们的客服人员.<br />请关闭本对话窗,重新上传.', 488, '上传文件过大');
	});
});

//加载二级分类
function d_s2()
{
	var d1 = $('#cateId').val();
	if(d1 == 0)return false;
	$.get
	(
		'/index.php?a=index&m=get_cates&pid='+d1,
		{},
		function(msg)
		{
			$('#cate2_tr').show();
			$('#cate2').html(msg);
			var select_changer2 = new select_to_style('cateId2','na_select_mian','na_select_options','349px','258px');
			select_changer2.change_it();
		}
	);
}