
<div class="xbsw_list wz_lb">
<img src="/static/qt/img/sy_tx.png"/>
    <p>
        <span><img src="/static/qt/img/sj_btn.png"/>实验技术平台：</span>
        <a href="/infomation-9-1.html"  <?=$parent_info[1]['id']==9?"class='new_bj'":'' ?>>细胞实验 </a>
        <a href="/infomation-10-1.html" <?=$parent_info[1]['id']==10?"class='new_bj'":'' ?>>蛋白质实验  </a>
        <a href="/infomation-11-1.html" <?=$parent_info[1]['id']==11?"class='new_bj'":'' ?>>分子生物实验 </a>
        <a href="/infomation-12-1.html" <?=$parent_info[1]['id']==12?"class='new_bj'":'' ?>>动物实验</a>
    </p>
    <p>
        <span><img src="/static/qt/img/sj_btn1.png"/>实验分类:</span>	    		
        <?php if (!empty($arr)) {
            foreach ($arr as $v) { ?>
                <a href="/infomation-<?= $v['id'] ?>-1.html" <?=$parent_info[0]['id']==$v['id']?"class='new_bj'":'' ?>>【<?= $v['name'] ?>】 </a>
    <?php }
} ?>
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
    <div class="sy_list">
        <p><span>当前位置:</span><a href="/">首页></a><a href="/infomation-<?= $parent_info[1]['id'] ?>-1.html"><?= $parent_info[1]['name'] ?>></a>【<a href="/infomation-<?= $parent_info[0]['id'] ?>-1.html"><?= $parent_info[0]['name'] ?></a> 】<?= $news_info['title'] ?></p>
    </div>
</div>

<div class="aticle_xq" style="margin-bottom: 40px">
    <div>
        <p><?= $news_info['title']; ?></p>
        <a href="javascript:;"><img src="/static/qt/img/aticle_xq_ban.jpg"/></a>
        <div style="margin-top: 20px">
           <?= $news_info['content']; ?>
        </div>
    </div>
    <div>  
        <div class="aticle_r_a">
            <span>点击咨询：</span>
<?php if (!empty($question_arr)) {
    foreach ($question_arr as $v) { ?>
                    <p><?= $v['question'] ?></p>
                <?php }
            } ?>
        </div>
        <div class="aticle_r_a">
            <span>相关实验推荐</span>
<?php if (!empty($hot_arr)) {
    foreach ($hot_arr as $v) { ?>
                    <div class="aticle_r_ab">
                        <img src="<?= $v['img'] ?>"  width='240' height='118'/>
                        <span><?= $v['name'] ?></span>
                        <a href="/detail-<?= $v['id'] ?>.html">查看详情</a>
                    </div>
    <?php }
} ?>

        </div>
    </div>
</div>
