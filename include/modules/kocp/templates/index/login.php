<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="renderer" content="webkit"/>
    <link type="text/css" rel="stylesheet" href="/static/ht/css/login.css"/>
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    </head>
    <body>
    <div class="bg-dot"></div>
    <div class="login-layout">
    <h1>管理中心</h1>
    <div class="login">
        <div class="qlogin" id="qlogin" >
            <div class="web_login">
                <form method="post" id="ko_formsubmit">
                <input type="hidden" name="<?php echo $_SESSION['ko_login']['ko_n1']; ?>" value="<?php echo $_SESSION['ko_login']['ko_v1']; ?>"/>    
                <ul class="reg_form" id="reg-ul">
                    <div id="koMsg" class="cue">请输入以下必填项进行登录</div>
                    <li>
                        <label for="user" class="input-tips2">用户名：</label>
                        <div class="inputOuter2"><input type="text" id="user" name="<?php echo $_SESSION['ko_login']['ko_n2']; ?>" maxlength="20" class="inputstyle2"/></div>
                    </li>

                    <li>
                        <label for="passwd" class="input-tips2">密&#12288;码：</label>
                        <div class="inputOuter2"><input type="password" id="pwd" name="<?php echo $_SESSION['ko_login']['ko_n3']; ?>" maxlength="30" class="inputstyle2"/></div>
                    </li>

                    <li>
                        <label for="yzm" class="input-tips2">验证码：</label>
                        <div class="inputOuter2">
                            <input type="text" id="yzm" name="<?php echo $_SESSION['ko_login']['ko_n4']; ?>" maxlength="5" style="float:left;width:70px;" class="inputstyle2"/>
                            <a href="javascript:;" title="看不清点击刷新验证码" style="float:left;" onclick="document.getElementById('codeimage').src='/tool/yzm/w/115/h/37/n/5/'+Math.random();">&nbsp;<img src="/tool/yzm/w/115/h/37/n/5" alt="验证码" border="0" id="codeimage"/></a>
                        </div>                              
                    </li>

                    <li>
                        <div class="inputArea"><input type="button" onclick="ko_login()" style="margin-top:10px;margin-left:85px;" class="button_blue" value="立即登录"/></div>
                    </li>
                    <div class="cl"></div>
                </ul>
                </form>    
            </div>
        </div>
    </div>
    </div>
    <script type = "text/javascript" >
      function ko_login() {
      var u = $.trim($('#user').val()),
        p = $.trim($('#pwd').val()),
        c = $.trim($('#yzm').val());
      if (u == '') {
        ko_msg('user', 2, '用户名不能为空');
        return false
      } else {
        ko_msg('user', 1, '')
      }
      if (p == '') {
        ko_msg('pwd', 2, '密码不能为空');
        return false
      } else {
        ko_msg('pwd', 1, '')
      }
      if (c == '') {
        ko_msg('yzm', 2, '验证码不能为空');
        return false
      } else {
        ko_msg('yzm', 1, '')
      }
      $('#ko_formsubmit').submit()
      }

      function ko_msg(a, t, s) {
      if (t == 1) {
        $('#' + a).css({
          border: '1px solid #D7D7D7',
          boxShadow: 'none'
        });
        $('#koMsg').html("<font color='green'><b>信息输入正确</b></font>")
      } else {
        $('#' + a).focus().css({
          border: '1px solid red',
          boxShadow: '0 0 2px red'
        });
        $('#koMsg').html("<font color='red'><b>×" + s + "</b></font>")
      }
      }
      $(function() {
      document.onkeydown = function(e) {
        var a = document.all ? window.event : e;
        if (a.keyCode == 13) {
          ko_login()
        }
      }
      });

      $(document).ready(function(){
        //Random background image
        var random_bg=Math.floor(Math.random()*5+1);
        var bg='url(/static/images/admin/login/bg_'+random_bg+'.jpg)';
        $("body").css("background-image",bg);
      });
    </script>
    </body>
</html>