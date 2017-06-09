
<div class="xbsw_list">
<img src="/static/qt/img/sy_tx.png"/>
    <p>
        <span><img src="/static/qt/img/sj_btn.png"/>实验技术平台：</span>
        <a href="/lists-1-1.html" <?=$data['id']==1?"class='new_bj'":'' ?>>细胞生物学平台 </a>
        <a href="/lists-2-1.html" <?=$data['id']==2?"class='new_bj'":'' ?>>蛋白质学技术平台 </a>
        <a href="/lists-3-1.html" <?=$data['id']==3?"class='new_bj'":'' ?>>分子生物学技术平台 </a>
        <a href="/lists-4-1.html" <?=$data['id']==4?"class='new_bj'":'' ?>>动物实验技术平台</a>
    </p>
    <p>
        <span><img src="/static/qt/img/sj_btn1.png"/>实验分类:</span>
        <?php
        $arr = Dao_Product::getProductAll($data['id']);
        if (!empty($arr)) {
            foreach ($arr as $v) {
                ?>
                <a href="/detail-<?= $v['id'] ?>.html">【<?= $v['name'] ?>】</a>
    <?php }
}
?>	
    </p>  

    <div class="ban_list">
        <div class="ban_list_t">
            <div class="ban_list_t_bj">
                <img src="/static/qt/img/laboratory_fltb.png">
                <span>实验分类</span>
                <img src="/static/qt/img/laboratory_fljt.png">
            </div>
        </div>
        <div class="yc_list" style='background:#fff;margin-top:1px;display:none;'>
<?php
$product_data = Dao_Product::getCategoryAll();
if (!empty($product_data)) {
    foreach ($product_data as $vv) {
        ?>
                    <div class="ban_list_a">                
                        <h4><a href="lists-<?= $vv['id']; ?>-1.html"><?= $vv['name'] ?><img src="/static/qt/img/laboratory_jt_r.png"/></a></h4>
                        <p>
                            <?php
                            if (!empty($vv['child'])) {
                                foreach ($vv['child'] as $k => $vo) {
                                    if ($k < 3) {
                                        ?>
                                        <a href="detail-<?= $vo['id'] ?>.html"><?= $vo['name'] ?></a> 
                <?php
                }
            }
        }
        ?>
                        </p>
                    </div>
    <?php }
}
?>
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
    <div class="sy_list">
        <p><span>当前位置:</span><a href="/">首页></a><a href="lists-<?= $data['id'] ?>-1.html"><?= $data['name'] ?></a></p>
    </div>
    <div class="experiment_list">
        <div class="experiment_list_l">
            <p><span>实验列表</span><img src="/static/qt/img/fk.jpg"/></p>
            <div class="experiment_list_content">
                <?php if (!empty($page_data)) {
                    foreach ($page_data as $v) {
                        ?>
                        <div class="experiment_list_content_a">
                            <a href="detail-<?= $v['id'] ?>.html"><img src="<?= $v['img'] ?>" width='203' height='138' /></a>
                            <p><span><?= $v['name'] ?></span><span><?= $v['lab_about'] ?></span></p>
                            <div>
                                <a href="javascript:;">价格咨询</a>
                                <a href="detail-<?= $v['id'] ?>.html">查看详情</a>
                            </div>
                        </div>
    <?php }
}
?>	   				
            </div>
             <?php echo $page_arr; ?>
            
        </div>
        <div class="experiment_list_r" style='margin-bottom:20px'>	
            <p><span>推荐项目</span><img src="/static/qt/img/fk.jpg"/></p>
<?php if (!empty($hot_arr)) {
    foreach ($hot_arr as $v) {
        ?>
                    <div class="experiment_list_r_a">
                        <a href="detail-<?= $v['id'] ?>.html"><img src="<?= $v['img'] ?>" width="240" height='158'/></a>
                        <span><?= $v['name'] ?></span>
                        <a href="javascript:;">价格咨询</a>
                    </div>
    <?php }
}
?>	   
        </div>
    </div>
    <div class="cytobiology_ban">
        <a href="javascript:;"><img src="/static/qt/img/laboratory_ban_botm1.jpg"/></a>
    </div>
</div>    

