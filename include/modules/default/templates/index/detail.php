
<div class="xbsw_list">
<img src="/static/qt/img/sy_tx.png"/>
    <p>
        <span><img src="/static/qt/img/sj_btn.png"/>实验技术平台：</span>
        <a href="lists-1-1.html" <?=$parent_info['id']==1?"class='new_bj'":'' ?>>细胞生物学平台 </a>
        <a href="lists-2-1.html" <?=$parent_info['id']==2?"class='new_bj'":'' ?>>蛋白质学技术平台 </a>
        <a href="lists-3-1.html" <?=$parent_info['id']==3?"class='new_bj'":'' ?>>分子生物学技术平台 </a>
        <a href="lists-4-1.html" <?=$parent_info['id']==4?"class='new_bj'":'' ?>>动物实验技术平台</a>
    </p>
    <p>
        <span><img src="/static/qt/img/sj_btn1.png"/>实验分类:</span>
        <?php $arr = Dao_Product::getProductAll($data_info['parent_id']);
        if (!empty($arr)) {
            foreach ($arr as $v) { ?>
                <a href="detail-<?= $v['id'] ?>.html" <?=$data_info['id']==$v['id']?"class='new_bj'":'' ?>><?= $v['name'] ?> </a>
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
        <p><span>当前位置:</span><a href="/">首页></a><a href="lists-<?= $parent_info['id']; ?>-1.html"><?= $parent_info['name']; ?>></a><a href="javascript:;"><?= $data_info['name'] ?></a></p>
    </div>
    <div class="cytobiology_py">
        <div>
            <img src="<?= $data_info['img'] ?>" width="280px" height='221px'/>
        </div>
        <div class="cytobiology_py_middle">
            <span><?= $data_info['name'] ?></span>
            <p><?= $data_info['lab_about'] ?></p>
            <p><a href="javascript:;">立即咨询</a><a href="javascript:;">立即咨询</a></p>
        </div>
        <div>
            <img src="/static/qt/img/xb_xq_2.jpg"/>
        </div>
    </div>
    <div class="cytobiology_fl">
        <div class="cytobiology_fl_l">
            <span>实验分类</span>
            <div>
                <p><a href="lists-1-1.html">细胞生物学平台</a></p>
                <p><a href="lists-2-1.html">蛋白质技术平台</a></p>
                <p><a href="lists-3-1.html">分子生物学技术平台</a></p>
                <p><a href="lists-4-1.html">动物实验技术平台</a></p>
                <p><a href="lists-5-1.html">科研平台</a></p>
            </div>
            <span>相关文章推荐</span>
            <div>
<?php if (!empty($hot_news)) {
    foreach ($hot_news as $v) { ?>
                        <p>【<a href="/infomation-<?= $v['child']['id'] ?>-1.html"><?= $v['child']['name'] ?></a>】<a href="/single-<?= $v['id'] ?>.html"><?= $v['title'] ?></a></p>
    <?php }
} ?>
            </div>
            <span>热门实验推荐</span>
            <div>
<?php if (!empty($hot_arr)) {
    foreach ($hot_arr as $v) { ?>
                        <p><a href="detail-<?= $v['id'] ?>.html"><img src="<?= $v['img'] ?>" width="199" height='180' /><span><?= $v['name'] ?></span></a></p>
                    <?php }
                } ?>
            </div>
        </div>
        <div class="cytobiology_fl_r">
            <a href="javascript:;"><img src="/static/qt/img/xb_xq_3.jpg"/></a>
            <div class="m_link" id="nav_keleyi_com">
                <ul>
                    <li ><a href="#test1" class="hover">实验内容</a></li>
                    <li><a href="#test2">服务流程</a></li>
                    <li><a href="#test3">成功案例</a></li>
                </ul>
            </div>		
            <div class="route_company_js">
                <p><img src="/static/qt/img/fw_lc_1.png"/><span name="test1" id="test1">实验内容</span><img src="/static/qt/img/fw_lc_4.png"/></p>
                <div class="btn_table">
                   <?= $data_info['content'] ?>
                   <div class="btn_table_a">
                       <a href=""><img src="/static/qt/img/table_btn1.png"/></a>
                       <a href=""><img src="/static/qt/img/table_btn2.png"/></a>
                       <a href=""><img src="/static/qt/img/table_btn3.png"/></a>
                   </div>
                </div>

                <p><img src="/static/qt/img/fw_lc_2.png"/><span name="test2" id="test2">服务流程</span><img src="/static/qt/img/fw_lc_4.png"/></p>
                <div class="fw_lc">
                    <p>
                        <span>文献检索查阅</span>
                        <span>订购相关实验试剂</span>
                        <span>实验进程监控</span>
                        <span>出具实验结构报告</span>
                    </p>
                    <div>
                        <p></p>
                        <span>1</span>
                        <span>2</span>
                        <span>3</span>
                        <span>4</span>
                        <span>5</span>
                        <span>6</span>
                        <span>7</span>
                        <span>8</span>
                        <span>9</span>	
                    </div>
                    <p>
                        <span>前期思路交流</span>
                        <span>实验方案设计</span>
                        <span>实验操作进程</span>
                        <span>整理实验结构</span>
                        <span>实验结果评估及文章建议</span>
                    </p>
                </div>
                <p><img src="/static/qt/img/fw_lc_3.png"/><span name="test3" id="test3">实验结果</span><img src="/static/qt/img/fw_lc_4.png"/></p>
            

            </div>
            <div style='font-family: "微软雅黑";font-size: 14px;color:#7d7d7d '>
                <?=$data_info['lab_demo']; ?>
            </div>
               

        </div>
        <div class="route_company_ban">
            <a href="javascript:;"><img src="/static/qt/img/laboratory_ban_botm.jpg"/></a>
        </div>
    </div>
</div>  

<script type="text/javascript" >
    function menuFixed(id){
    var obj = document.getElementById(id);
    var _getHeight = obj.offsetTop;
    
    window.onscroll = function(){
    changePos(id,_getHeight);
    }
    }
    function changePos(id,height){
    var obj = document.getElementById(id);
    var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    if(scrollTop < height){
    obj.style.position = 'relative';
    }else{
    obj.style.position = 'fixed';
    }
    }
    </script>
    <script type="text/javascript">
    window.onload = function(){
    menuFixed('nav_keleyi_com');
    }
</script>
