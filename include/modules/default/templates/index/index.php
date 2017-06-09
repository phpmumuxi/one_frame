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
            <?php $product_data=Dao_Product::getCategoryAll(); if(!empty($product_data)) { foreach ($product_data as $vv) { ?>
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
            <div class="main">
                <ul class="main_ul">
                    <li>
                        <img src="/static/qt/img/laboratory_sytb1.png"/>
                        <p>
                            <span>各类实验外包服务</span>
                            <span>提供精准的实验数据</span>
                        </p>
                        <a href="javascript:;"><img src="/static/qt/img/laboratory_dj_btn.png"/></a>
                    </li>
                    <li>
                        <img src="/static/qt/img/laboratory_sytb2.png"/>
                        <p>
                            <span>课题基金申请服务</span>
                            <span>协助您完成基金申请</span>
                        </p>
                        <a href="javascript:;"><img src="/static/qt/img/laboratory_dj_btn.png"/></a>
                    </li>
                    <li>
                        <img src="/static/qt/img/laboratory_sytb3.png"/>
                        <p>
                            <span>医学科研、咨询服务</span>
                            <span>提供精准的实验数据</span>
                        </p>
                        <a href="javascript:;"><img src="/static/qt/img/laboratory_dj_btn.png"/></a>
                    </li>
                </ul>

                <div class="main_tj">
                    <div class="main_tj_l">
                        <div class="main_tj_l_t">
                            <p><span>热点实验推荐</span><em></em><a href="javascript:;"><img src="/static/qt/img/laboratory_dj_more.png"/></a></p>
                            <ul>
                                <?php if(!empty($product_hot)) { foreach ($product_hot as  $v) { ?>
                                <li>
                                    <a href="detail-<?=$v['id']?>.html">
                                        <img src="<?=$v['img']?>" width='183' height='105'/>
                                        <span><?=$v['name']?></span>
                                    </a>
                                    <a href="detail-<?=$v['id']?>.html">实验详情咨询>></a>
                                </li>
                                <?php } } ?>
                            </ul>
                        </div>
                        <div class="main_tj_l_t">
                            <p><span>推荐项目</span><em></em></p>
                            <div class="item_recommendation">
                                <div class="item_recommendation_a">
                                    <span>临床研究服务</span>
                                    <p>此项服务包括：治疗效果评价研究、疾病发生的影响因素研究、诊断学研究、其他的研究等，保证您的课题研究顺利进行。</p>
                                    <a href="javascript:;"><img src="/static/qt/img/btn_1.png"/></a>
                                </div>
                                <div class="item_recommendation_a">
                                    <span>科研+实验技术支持</span>
                                    <p>为客户提供医学科研课题整体研究实施服务。德亨文资深专家团队结合相关实验数据全方位保证您的课题顺利开展。</p>
                                    <a href="javascript:;"><img src="/static/qt/img/btn_2.png"/></a>
                                </div>
                                <div class="item_recommendation_a">
                                    <span>整体研究一站式服务</span>
                                    <p>整体实验外包针对临床整体实验实施、数据收集、统计学处理、结果解释到SCI于一体的临床医学学术研究整体式服务。</p>
                                    <a href="javascript:;"><img src="/static/qt/img/btn_3.png"/></a>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="main_tj_r">
                        <div class="main_tj_r_a">
                            <h4>常见问题排行榜</h4>
                            <div class="main_tj_r_b">
                                <?php if(!empty($question_data)) { foreach ($question_data as $v) { ?>
                                <p><?=mb_substr(strip_tags($v['question']),0,18, 'utf-8')?></p>
                                <?php } } ?>
                            </div>
                        </div>
                        <div class="main_tj_r_a">
                            <h4>实验项目排行榜</h4>
                            <div class="main_tj_r_b">
                                <?php if(!empty($data_info)) { foreach ($data_info as $v) { ?>
                                <p><a href="/detail-<?=$v['id']?>.html"><?=$v['name']?></a></p>
                               <?php } } ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!--banner-->
                <div class="bottom_advertisement">
                    <a href="javascript:;"><img src="/static/qt/img/laboratory_ban_botm.jpg"/></a>
                </div>

                <div class="syjs">
                    <div class="syjs_fl">
                        <div class="syjs_fl_t">
                            <p>细胞实验 <span>Cell Experiment</span><a href="/infomation-9-1.html">更多>></a></p>
                        </div>
                        <div class="syjs_fl_b">                            
                            <?php $art_arr1=Dao_News::getAllArts(9); if(!empty($art_arr1)) { foreach ($art_arr1 as $v) { ?>
                            <p>【<a href="/infomation-<?=$v['child']['id']?>-1.html"><?=$v['child']['name']?></a>】<span><a href="/single-<?=$v['id']?>.html"><?=$v['title']?></a></span></p>
                            <?php } } ?>	
                        </div>
                        <a href="javascript:;"><img src="/static/qt/img/btn_4.png"/></a>
                    </div>
                    <div class="syjs_fl">
                        <div class="syjs_fl_t">
                            <p>蛋白质实验 <span>Cell Experiment</span><a href="/infomation-10-1.html">更多>></a></p>
                        </div>
                        <div class="syjs_fl_b">
                            <?php $art_arr2=Dao_News::getAllArts(10); if(!empty($art_arr2)) { foreach ($art_arr2 as $v) { ?>
                            <p>【<a href="/infomation-<?=$v['child']['id']?>-1.html"><?=$v['child']['name']?></a>】<span><a href="/single-<?=$v['id']?>.html"><?=$v['title']?></a></span></p>
                            <?php } } ?>
                        </div>
                        <a href="javascript:;"><img src="/static/qt/img/btn_4.png"/></a>
                    </div>
                    <div class="syjs_fl">
                        <div class="syjs_fl_t">
                            <p>分子生物实验 <span>Cell Experiment</span><a href="/infomation-11-1.html">更多>></a></p>
                        </div>
                        <div class="syjs_fl_b">
                           <?php $art_arr3=Dao_News::getAllArts(11); if(!empty($art_arr3)) { foreach ($art_arr3 as $v) { ?>
                            <p>【<a href="/infomation-<?=$v['child']['id']?>-1.html"><?=$v['child']['name']?></a>】<span><a href="/single-<?=$v['id']?>.html"><?=$v['title']?></a></span></p>
                            <?php } } ?>
                        </div>
                        <a href="javascript:;"><img src="/static/qt/img/btn_4.png"/></a>
                    </div>
                    <div class="syjs_fl">
                        <div class="syjs_fl_t">
                            <p>动物实验 <span>Cell Experiment</span><a href="/infomation-12-1.html">更多>></a></p>
                        </div>
                        <div class="syjs_fl_b">
                           <?php $art_arr4=Dao_News::getAllArts(12); if(!empty($art_arr4)) { foreach ($art_arr4 as $v) { ?>
                            <p>【<a href="/infomation-<?=$v['child']['id']?>-1.html"><?=$v['child']['name']?></a>】<span><a href="/single-<?=$v['id']?>.html"><?=$v['title']?></a></span></p>
                            <?php } } ?>
                        </div>
                        <a href="javascript:;"><img src="/static/qt/img/btn_4.png"/></a>
                    </div>
                </div>
            </div>

           