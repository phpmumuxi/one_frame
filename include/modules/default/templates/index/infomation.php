
<div class="xbsw_list wz_lb">
<img src="/static/qt/img/sy_tx.png"/>
    <p>
        <span><img src="/static/qt/img/sj_btn.png"/>实验技术平台：</span>
        <a href="/infomation-9-1.html"  <?php if(count($parent_info)>1){ echo $parent_info[1]['id']==9?"class='new_bj'":''; }else{ echo $parent_info[0]['id']==9?"class='new_bj'":''; } ?>>细胞实验 </a>
        <a href="/infomation-10-1.html" <?php if(count($parent_info)>1){ echo $parent_info[1]['id']==10?"class='new_bj'":''; }else{ echo $parent_info[0]['id']==10?"class='new_bj'":''; } ?>>蛋白质实验  </a>
        <a href="/infomation-11-1.html" <?php if(count($parent_info)>1){ echo $parent_info[1]['id']==11?"class='new_bj'":''; }else{ echo $parent_info[0]['id']==11?"class='new_bj'":''; } ?>>分子生物实验 </a>
        <a href="/infomation-12-1.html" <?php if(count($parent_info)>1){ echo $parent_info[1]['id']==12?"class='new_bj'":''; }else{ echo $parent_info[0]['id']==12?"class='new_bj'":''; } ?>>动物实验</a>
    </p>
    <p>
        <span><img src="/static/qt/img/sj_btn1.png"/>实验分类:</span>
        <?php if (!empty($arr)) {
            foreach ($arr as $v) { ?>
                <a href="/infomation-<?= $v['id'] ?>-1.html" <?php if(count($parent_info)>1){ echo $parent_info[0]['id']==$v['id']?"class='new_bj'":''; } ?>>【<?= $v['name'] ?>】</a>
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
        <p><span>当前位置:</span><a href="/">首页></a>
            <?php if(count($parent_info)>1){ ?>
            <a href="/infomation-<?= $parent_info[1]['id'] ?>-1.html"><?= $parent_info[1]['name'] ?>></a>
            <?php } ?>
            <a href="/infomation-<?= $parent_info[0]['id'] ?>-1.html"><?= $parent_info[0]['name'] ?></a> </p>
    </div>
    <div class="experiment_list" style="margin-bottom: 40px">
        <div class="experiment_list_l">
            <p><span><?= $infomation['name'] ?></span><img src="/static/qt/img/fk.jpg"/></p>
            <div class="experiment_list_content">
                <?php if (!empty($page_data)) {
                    foreach ($page_data as $v) { ?>
                        <div class="experiment_list_content_a">
                            <a href="/single-<?= $v['id'] ?>.html"><img src="<?= $v['img'] ?>" width='203' height='138'/></a>
                            <p><span>【<?php $info = Dao_Product::get_category_parent($v['parent_id']);
                        echo $info['name']; ?>】</span><span><?= $v['title'] ?></span></p>
                            <div>
                                <a href="javascript:;">价格咨询</a>
                                <a href="/single-<?= $v['id'] ?>.html">查看详情</a>
                            </div>
                        </div>
                <?php }
            } ?>	 
            </div>
            <?php echo $page_arr; ?>
        </div>
        <div class="experiment_list_r">	
            <p><span>推荐项目</span><img src="/static/qt/img/fk.jpg"/></p>
<?php if (!empty($hot_news_arr)) {
    foreach ($hot_news_arr as $v) { ?>
                    <div class="experiment_list_r_a">
                        <a href="/detail-<?= $v['id'] ?>.html"><img src="<?= $v['img'] ?>" width='240' height='158'/></a>
                        <span><?= $v['name'] ?></span>
                        <a href="javascript:;">价格咨询</a>
                    </div>
    <?php }
} ?>
        </div>
    </div>
    <div class="cytobiology_ban" >
        <a href="javascript:;"><img src="/static/qt/img/laboratory_ban_botm1.jpg"/></a>
    </div>
</div>    

