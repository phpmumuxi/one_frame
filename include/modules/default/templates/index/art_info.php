
<div class="company_redto">
    <img src="/static/qt/img/zxbj_ban.jpg">

    <div class="company_redto_a">
        <div class="ban_list company_js">
            <div class="ban_list_t">
                <div class="ban_list_t_bj">
                    <img src="/static/qt/img/laboratory_fltb.png">
                    <span>实验分类</span>
                    <img src="/static/qt/img/laboratory_fljt.png">
                </div>
            </div>
            <div class="yc_list">
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
    <div class="sy_list">
        <p><span>当前位置:</span><a href="/">首页></a><a href="/index/artInfo">新闻资讯></a><a href="javascript:;"><?= $data['title'] ?></a> </p>
    </div>
</div>

<div class="aticle_xq" style="margin-bottom: 50px">
    <div>
        <p><?= $data['title']; ?></p>
        <div>
            <?= $data['content']; ?>
        </div>
    </div>
    <div>  
        <div class="aticle_r_a">
            <span>实验推荐</span>
            <?php if (!empty($dataArr)) {
                foreach ($dataArr as $v) {
                    ?>
                    <div class="aticle_r_ab">
                        <img src="<?= $v['img'] ?>"  width='240' height='118'/>
                        <span><?= $v['name'] ?></span>
                        <a href="/detail-<?= $v['id'] ?>.html">查看详情</a>
                    </div>
    <?php }
}
?>

        </div>
    </div>
</div>
