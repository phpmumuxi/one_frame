
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
    <p><a href="/">首页></a><a href="javascript:;">新闻资讯</a></p>
</div>

<div class="rmzx">
    <div>
        <img src="/static/qt/img/new_zx.jpg"/>
    </div>
    <div>
        <div class="rmzx_r_t">
            <h4>热 门 资 讯</h4>
            <span>Popular Information</span>
        </div>
        <div class="rmzx_r_b">
            <div class="rmzx_r_b_l">
                <?php if (!empty($page_data)) {
                    foreach ($page_data as $v) {
                        ?>
                        <a href="/art-<?= $v['id'] ?>.html"><?= $v['title'] ?> </a>
                    <?php }
                }
                ?>  
            </div>
            <div class="rmzx_r_b_r">
<?php if (!empty($page_data)) {
    foreach ($page_data as $v) {
        ?>  
                        <span><?= date('Y-m-d H:i:s', $v['time']); ?></span>
    <?php }
}
?>          
            </div>
        </div>        
    </div>

</div>
 <?php echo $page_arr; ?>
<!-- <div class="fy">
<?php include(KO_TEMPLATES_PATH . '/cp_page.php'); ?>
</div>
 -->
