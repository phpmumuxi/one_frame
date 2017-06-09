
<div class="search_ym">

    <div class="ban_list">
        <div class="ban_list_t">
            <div class="ban_list_t_bj">
                <img src="/static/qt/img/laboratory_fltb.png">
                <span>实验分类</span>
                <img src="/static/qt/img/laboratory_fljt.png">
            </div>
        </div>
        <div class="yc_list" style='background:#fff;margin-top:1px;display:none;'>
                    <?php $product_data = Dao_Product::getCategoryAll();
                    if (!empty($product_data)) {
                        foreach ($product_data as $vv) { ?>
                    <div class="ban_list_a">                
                        <h4><a href="lists-<?= $vv['id']; ?>-1.html"><?= $vv['name'] ?><img src="/static/qt/img/laboratory_jt_r.png"/></a></h4>
                        <p>
                    <?php if (!empty($vv['child'])) {
                        foreach ($vv['child'] as $k => $vo) {
                            if ($k < 3) { ?>
                                        <a href="detail-<?= $vo['id'] ?>.html"><?= $vo['name'] ?></a> 
                <?php }
            }
        } ?>
                        </p>
                    </div>
    <?php }
} ?>
        </div>
        <!--下拉侧边栏-->
        <div class="down_cb">

        </div>
    </div>

</div>
<script>
    $('.ban_list').mouseover(function() {
        $('.down_cb').show();
    });
    $('.ban_list .ban_list_a').hover(function() {
        var n = parseInt($(this).index()) + parseInt(1);
        $.get('/index/info', 'id=' + n, function(res) {
            $('.down_cb').html(res);
            $('.down_cb').show();
        });
    }, function() {
        $('.down_cb').hide();
    })
    $('.ban_list').mouseout(function() {
        $('.down_cb').hide();
    });
</script>
<div class="cytobiology">
    <div class="sy_list search_result">
        <p><span>当前位置:</span><a href="/">首页></a><span>搜索</span><span><?= $key_words ?></span>结果</p>
    </div>
    <div class="experiment_list">
        <div class="experiment_list_l">
            <div class="search_result_l">
                <?php if (!empty($page_data)) { foreach ($page_data as $v) {  if($search_type==2){ ?>                
                <a href="/single-<?=$v['id']?>.html"><?=str_replace($key_words, "<font color='red'>".$key_words."</font>", $v['title']) ?></a>
                <?php }else{ ?>
                <a href="/detail-<?=$v['id']?>.html"><?=str_replace($key_words, "<font color='red'>".$key_words."</font>", $v['name']) ?></a>
                <?php } } }else{ ?>
                <h3>没有相关记录</h3>
                <?php } ?>
            </div>
             <!--分页-->
        <div class="fy">
            <?php include(KO_TEMPLATES_PATH . '/cp_page.php'); ?>
        </div>
<!--            <div class="route_company">
                <a href="javascript:;">1</a>
                <a href="javascript:;">2</a>
                <a href="javascript:;">3</a>
            </div>-->
        </div>
        <div class="experiment_list_r" style="margin-bottom: 30px">	
            <p><span>推荐项目</span><img src="/static/qt/img/fk.jpg"/></p>
             <?php if (!empty($hot_arr)) { foreach ($hot_arr as $v) {   ?>   
            <div class="experiment_list_r_a">
                <a href="/detail-<?=$v['id']?>.html"><img src="<?=$v['img']?>" width="240px" height="158px"/></a>
                <span><?=$v['name']?></span>
                <a href="javascript:;">价格咨询</a>
            </div>
            <?php } } ?>
        </div>
    </div>
    <div class="cytobiology_ban" style="margin-bottom: 30px">
        <a href="javascript:;"><img src="/static/qt/img/laboratory_ban_botm1.jpg"/></a>
    </div>
</div>    

<!-- -->
