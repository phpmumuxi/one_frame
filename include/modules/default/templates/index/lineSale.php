<link rel="stylesheet" type="text/css" href="/static/qt/css/liMarquee.css"/>
<!--banner-->
<div class="ban">
    <div class="ban_list_w">
        <div class="ban_list">
            <div class="ban_list_t">
                <div class="ban_list_t_bj">
                    <img src="/static/qt/img/laboratory_fltb.png"/>
                    <span>实验分类</span>
                    <img src="/static/qt/img/laboratory_fljt.png"/>
                </div>
            </div>
            <?php  $product_data=Dao_Product::getCategoryAll(); if(!empty($product_data)) { foreach ($product_data as $vv) { ?>
            <div class="ban_list_a">                
                <h4><a href="/lists-<?=$vv['id']; ?>-1.html"><?=$vv['name']?><img src="/static/qt/img/laboratory_jt_r.png"/></a></h4>
                <p>
                    <?php if(!empty($vv['child'])) { foreach($vv['child'] as  $k=>$vo) { if($k<3){ ?>
                    <a href="/detail-<?=$vo['id']?>.html"><?=$vo['name']?></a> 
                    <?php } } } ?>
                </p>
            </div>
            <?php } } ?>
            <div class="down_cb" style="display: none;">    

            </div>
        </div>
    </div>
     <!-- Swiper -->
    <div id="container">
        <div class="sections">
            <div class="section" id="section0"></div>
            <div class="section" id="section1"></div>
            <div class="section" id="section2"></div>
            <div class="section" id="section3"></div>
        </div>
    </div>
    <script src="/static/qt/js/pageSwitch.min.js"></script>
    <script>
        $("#container").PageSwitch({
            direction: 'horizontal',
            easing: 'ease-in',
            duration: 1000,
            autoPlay: true,
            loop: 'false'
        });

          $('.ban_list').mouseover(function(){
                    $('.down_cb').show();                  
          });
          $('.ban_list .ban_list_a').hover(function(){              
            var n=$(this).index();
            $.get('/index/info','id='+n,function(res){                 
                $('.down_cb').html(res); 
                $('.down_cb').show();                 
            });
         },function(){
             $('.down_cb').hide();
         })
          $('.ban_list').mouseout(function(){
                    $('.down_cb').hide();
          });
    </script>
</div>


<div class="dhw_gk">
    <p><span>当前位置:</span><a href="/">首页></a><a href="javascript:;">在线报价</a></p>
</div>
<div class="bj_container">
    <div class="bj_container_a">
        <form action='/tool/check' method="post" id="ko_sub_form">
            <input type='hidden' name='subs_user' value='subs_user'>
            <p>
                <label>实验名称:</label>
                <input type="text" name="lab_name" id="" value="" />
            </p>
            <p>
                <label>您的姓名:</label>
                <input type="text" name="name" id="" value="" />
            </p>
            <p>
                <label>电子邮件:</label>
                <input type="text" name="email" id="" value="" />
            </p>
            <p>
                <label>联系电话:</label>
                <input type="text" name="tel" id="" value="" />
            </p>
            <p>
                <label>联系qq:</label>
                <input type="text" name="qq" id="" value="" />
            </p>
            <p>
                <label>备注:</label>
                <textarea name="des" rows="" cols=""></textarea>
            </p>
            <div>
                <!--<input type='submit' name='subs' value='立即咨询'>-->
                <a href="javascript:void(0);" id="KOsubmitBtn">立即咨询</a>
                <a href="javascript:;">在线申请</a>
            </div>
            <script type="text/javascript">
                $(function() {
                    $("#KOsubmitBtn").click(function() {           
                            $("#ko_sub_form").submit();            
                    });
                });        
            </script>
        </form>

    </div>
    <div class="bj_container_b">
        <div class="content_tg_r">
            <h4>期刊发表公告</h4>
            <div class="dowebok">
                <ul>
                    <li>恭喜来自来自广东的徐先生的RNAI干扰腺包装成功。</li>
                    <li>恭喜来自来自山东的王先生MSP实验成功。</li>
                    <li>恭喜来自来自江苏的徐先生的BSP实验成功。</li>
                    <li>恭喜来自来自山东的王先生MSP实验成功。</li>
                    <li>恭喜来自来自广东的徐先生的RNAI干扰腺包装成功。</li>
                    <li>恭喜来自来自山东的王先生MSP实验成功。</li>
                    <li>恭喜来自来自江苏的徐先生的BSP实验成功。</li>
                    <li>恭喜来自来自山东的王先生MSP实验成功。</li>
                    <li>恭喜来自来自广东的徐先生的RNAI干扰腺包装成功。</li>
                    <li>恭喜来自来自山东的王先生MSP实验成功。</li>
                    <li>祝贺深圳市府先生在《世界经济研究杂志》成功发表</li>
                </ul>
            </div>
        </div>
    </div>
    <script src="/static/qt/js/jquery.liMarquee.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $('.dowebok').liMarquee({
            direction: 'up',
            scrollamount: 30
        })
    </script>
</div>

