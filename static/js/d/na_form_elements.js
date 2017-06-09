jQuery.fn.extend(
{
	button_style: function(hover_style)
	{
		$(this).each(function()
		{
			var style_name     = $(this).attr('class');
			var style_name_arr = style_name.split(' ');
			style_name         = style_name_arr[0];
			var button_val     = $(this).val();
			insetr_str         = '<div class="'+style_name+'"><span>'+button_val+'</span></div>';
			$(this).after(insetr_str);
			$(this).hide();
			$(this).next().hover(
				function()
				{
					$(this).addClass(hover_style);
					$(this).find('span').addClass(hover_style+'-span');
				}
				,
				function()
				{
					$(this).removeClass(hover_style);
					$(this).find('span').removeClass(hover_style+'-span');
				}
			);
			$(this).next().click(function()
			{
				$(this).prev().trigger('click');
			});
			
		});
	}
});

function checkbox_to_style(parent_id,class_name)
{
	this.parent_id       = "#"+parent_id;
	this.class_name      = class_name;
	
	this.change_it       = function()
	{
		var this_obj = this;
		$(this.parent_id).find(':checkbox').each(function()
		{
			var checked_status = $(this).attr("checked");
			if(checked_status == undefined)
			{
				$(this).parent().addClass(this_obj.class_name);
			}
			else
			{
				$(this).parent().addClass(this_obj.class_name+'_checked');
			}
			
			$(this).css({'display':'block','width':'35px', 'float':'left','margin-left':'-35px', 'margin-right':'15px'});
			
			$(this).change(function()
			{
				$(this).parent().removeClass(this_obj.class_name);
				$(this).parent().removeClass(this_obj.class_name+'_checked');
				if($(this).is(':checked'))
				{
					$(this).parent().addClass(this_obj.class_name+'_checked');
				}
				else
				{
					$(this).parent().addClass(this_obj.class_name);
					
				}
				
			});
		});
	}
}

function select_to_style(select_id ,select_div_class, options_class, width, height, call_back, call_back_args)
{
	this.select_id       =   select_id;
	this.select_div_id   =   select_div_class;
	this.options_id      =   options_class;
	this.str             =   '';
	this.width           =   width;
	this.height          =   height;
	
	this.change_it       =   function()
	{
		var str  = '<div class="'+options_class+'" style="height:'+this.height+'; width:'+this.width+'"><ul>';
		var str_selectd  = '';
		var set_time_id  = null;
		
		$('#'+select_id+' option').each(function()
		{
			str += '<li>'+$(this).html()+'</li>';
			if($(this).attr('selected') == 'selected')
			{
				str_selectd = $(this).html();
			}
		});
		str     += '</ul></div>';
		if(str_selectd == '')
		{
			str_selectd = $('#'+select_id+' option').eq(0).html();
		}
		str  = '<div class="'+select_div_class+'" style="width:'+this.width+';">'+str_selectd+'</div>'+str;
		$('#'+select_id).after(str);
		
		$('#'+select_id).next().click(function()
		{
			var sets = $(this).offset();
			$(this).next().css({'top':sets.top+$(this).outerHeight(true), 'left':sets.left});
			$(this).next().slideDown(200);
			this_obj = $(this);
			set_time_id = setTimeout(function()
			{
				this_obj.next().slideUp(200);
			},2000);
			
			$(this).next().hover
			(
				function()
				{
					clearTimeout(set_time_id);
				}
				,
				function()
				{
					this_obj.next().slideUp(200);
				}
			);
		});
		
		$('#'+select_id).next().next().find('li').click(function()
		{
			var index = $(this).index();
			$('#'+select_id).get(0).selectedIndex  = index;
			$(this).parent().parent().prev().html($('#'+select_id).find('option').eq(index).html());
			$(this).parent().parent().hide();
			if(call_back != undefined)
			{
				if(call_back_args == undefined)
				{
					call_back();
				}
				else
				{
					call_back(call_back_args);
				}
			}
		});
		
		$('#'+select_id).hide();
	}	
}