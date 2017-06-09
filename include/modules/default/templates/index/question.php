
<div class="xbsw_list wz_lb">
<img src="/static/qt/img/sy_tx.png"/>
    <p>
        <span><img src="/static/qt/img/sj_btn.png"/>实验技术平台：</span>
        <?php if (!empty($question_type)) {
            foreach ($question_type as $v) { ?>
                <a href="/question-<?= $v['id'] ?>-1.html" <?php if(!empty($type_info))echo $type_info['id']==$v['id']?"class='new_bj'":'' ?>><?= $v['name'] ?></a>
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
                        <h4><a href="/lists-<?= $vv['id']; ?>-1.html"><?= $vv['name'] ?><img src="/static/qt/img/laboratory_jt_r.png"/></a></h4>
                        <p>
                    <?php if (!empty($vv['child'])) {
                        foreach ($vv['child'] as $k => $vo) {
                            if ($k < 3) { ?>
                                        <a href="/detail-<?= $vo['id'] ?>.html"><?= $vo['name'] ?></a> 
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
    $('.ban_list_t').mouseover(function() {        
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
     $('.ban_list').mouseover(function(){
                    $('.down_cb').show();                  
          });
    $('.ban_list').mouseout(function() {        
        $('.down_cb').hide();
    });
   
</script>
<div class="cytobiology">
    <div class="sy_list">
        <p><span>当前位置:</span><a href="/">首页 ></a>
        <?php if (empty($type_info)) { ?>
                <a href="javascript:;">常见问题</a></p>
<?php } else { ?>
            <a href="/index/question">常见问题 ></a><a href="javascript:;"><?= $type_info['name'] ?></a></p>
        <?php } ?>
    </div>
</div>
<div class="cj_wt">
    <div class="cj_wt_container">
<?php if (!empty($question_arr)) {
    foreach ($question_arr as $k => $v) { ?>
                <div>
                    <span><?= ($p - 1) * 10 + $k + 1; ?>.『<?php $type_name = Dao_Que::get_type_name($v['type_id']);
        echo $type_name['name']; ?>』<?= $v['question'] ?></span>
                    <p><?= $v['answer'] ?></p>
                </div>
    <?php }
} ?> 
    </div>

</div>
<?php echo $page_arr; ?>
<!--我的疑问-->
<div class="my_yw" style="margin-bottom: 40px">
    <span>我的疑问:</span>
    <div>
        <form action='/tool/add' method="post" id="ko_sub_form">
            <input type='hidden' name='question' value='subs_question'>
            <textarea name='txt_doubt'></textarea>

            <div class="my_yw_btn">
                <a href="javascript:;">直接咨询我的疑问</a>
                <a href="javascript:void(0);" id="KOsubmitBtn">提交我的疑问</a>
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
</div>
