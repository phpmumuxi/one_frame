
 //头部
$(function(){
	 $('.head_r_b ul li a').hover(function(){
	 	  $(this).addClass('active').parent().siblings().find('a').removeClass('active');
	 })
	 //搜索框下拉
	 $('.head_search em span').click(function(){	
	 	 if($('.xgwz').is(":visible")){
	 	    $('.xgwz').hide();
	 	    }
	 	 else{
	 		  $('.xgwz').show();
	 	    }
	     })
	 
	  $('.xgwz').click(function(){
	 	   $(this).hide();
	 	   var init = $('.head_search em span').text();
	 	   $('.head_search em span').text($('.xgwz').text())
	 	   $('.xgwz').text(init);
                   if(init=='实验'){
                       $("#form_search #hidden").val(2);
                   }else{
                       $("#form_search #hidden").val(1);
                   }
	  })
	
	//
	//下拉菜单
	  var oDiv1=document.querySelector(".ban_list_t");
	  var oDiv2=document.querySelector(".yc_list");
	  var oDiv3=document.querySelector(".down_cb");
	  var oDiv4=document.querySelector('.ban_list_a');
	  var timer=null;
	  oDiv1.onmouseover=oDiv2.onmouseover=function(){
	  	   clearTimeout(timer)
	  	   oDiv2.style.display='block';
	   }
	  oDiv2.onmouseout=oDiv1.onmouseout=function(){
	  	 timer=setTimeout(function(){
	  	 	oDiv2.style.display='none';
	  	 	oDiv3.style.display='none';
                        
	  	   },100)
	     }
	  
	  oDiv4.onmouseover=oDiv3.onmouseover=function(){
	  	  clearTimeout(timer)
	  	   oDiv3.style.display='block';
	  }

	
	  
	  oDiv3.onmouseout=function(){
	  	  timer=setTimeout(function(){
	  	 	oDiv2.style.display='none';
	  	 	oDiv3.style.display='none';
	  	   },100)
	  }
	  

	  //锚点
	  $('.m_link ul li a').click(function(){
	  	   $(this).addClass('hover').parent().siblings().find('a').removeClass('hover')

	  })
     })



