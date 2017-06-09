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
    <p><span>当前位置:</span><a href="/">首页></a><a href="javascript:;">服务流程</a></p>
</div>
<div class="kjfw_lc">
    <div class="kjfw_lc_jz">
        <h4>方便快捷服务流程</h4>
        <span>综合化管理 实验与学术并行  轻松搞定实验服务</span>
        <div class="dhw_fwlc">
            <img src="/static/qt/img/fwlc_bz.png"/>
        </div>
        <div class="dhw_fwlc_container">
            <div>
                <p><span>1</span>课题思路交流</p>
                <p>有意向的客户可以通过在线咨询，电话咨询等方式提出您的需求，德亨文的客服人员将第一时间响应您的请求，竭诚的为您服务。</p>
            </div>
            <div>
                <p><span>2</span>文献检索查询</p>
                <p>德亨文专业的技术人员，对您的问题进行相关文献检索，同时与客户深度沟通，认真聆听客户的需求，并对客户量身定做相关实验。</p>
            </div>
            <div>
                <p><span>3</span>实验方案设计</p>
                <p>根据客户的思想要求，德亨文技术人员为您提供最专业的实验方案设计，并且与客户确认实验方案后签订实验项目合作协议。</p>
            </div>
            <div>
                <p><span>4</span>订购相关实验试剂</p>
                <p>德亨文实验室人员根据实验项目采购相关实验试剂，保证实验项目正常进行。</p>
            </div>
            <div>
                <p><span>5</span>实验操作进程</p>
                <p>德亨文专业的技术人员随时向客户汇报相关实验项目的操作进程，沟通并且解决实验项目中出现的问题。</p>
            </div>
            <div>
                <p><span>6</span>整理实验结果</p>
                <p>当实验项目完成时，德亨文数据整理研究员整理客户实验项目的数据结果。</p>
            </div>
            <div>
                <p><span>7</span>出具实验结果报告</p>
                <p>德亨文数据整理研究员完成相关实验数据，并且出具相关实验结果报告。</p>
            </div>
            <div>
                <p><span>8</span>实验结果评估及文章建议</p>
                <p>德亨文学术人员会根据实验结果给予客户客户相关文章建议。</p>
            </div>
        </div>
    </div>
</div>
<!--服务详细介绍-->
<div class="fw_item">
    <div>
        <img src="/static/qt/img/fwjs_pic1.jpg"/>
        <span>细胞生物学类实验外包</span>
        <a href="javascript:;">咨询相关实验</a>
    </div>
    <div>
        <img src="/static/qt/img/fwjs_pic2.jpg"/>
        <span>分子生物学类实验外包</span>
        <a href="javascript:;">咨询相关实验</a>
    </div>
    <div>
        <img src="/static/qt/img/fwjs_pic3.jpg"/>
        <span>蛋白质学类实验外包</span>
        <a href="javascript:;">咨询相关实验</a>
    </div>
    <div>
        <img src="/static/qt/img/fwjs_pic4.jpg"/>
        <span>动物建模相关实验外包</span>
        <a href="javascript:;">咨询相关实验</a>
    </div>
</div>
</body>
</html>
