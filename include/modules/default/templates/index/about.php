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
            <div class="section" id="gsjs0"></div>
            <div class="section" id="gsjs1"></div>
            <div class="section" id="gsjs2"></div>
            <div class="section" id="gsjs3"></div>
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
    <p><span>当前位置:</span><a href="/">首页></a><a href="javascript:;">公司介绍</a></p>
    <h4>德亨文的概况</h4> 
    <div class="dhw_gk_a">
        <div class="dhw_gk_a_l">
            <img src="/static/qt/img/gs_js_gk1.jpg"/>
            <p>南京德亨文生物 科技有限公司坐落在人杰地灵的六朝古都你那就，依托长江三角洲强大的人才资源优势和生物科研底蕴丰富的地域优势，建议了一家以医学实验为基石，进行生命科学研究、产品开发和技术服务的高新技术企业。致力打造集临床、科研、服务于一体的创新型企业，更好的配合医生进行临床实验研究，提升整体医疗服务水平。</p>
            <p>目前公司设有标准化的生物医学实验室，建立了细胞生物学、分子生物学、蛋白质和动物实验等多种技术平台。实验室配备完善的生物医学研究仪器、设备以及国际通行SOP。有经验丰富的实验团队日常运作，专业提供生命科学和临床医学类实验外包服务。</p>
            <img src="/static/qt/img/gs_js_gk3.jpg"/>
            <div class="dhw_gk_a_l_ab">
                <p></p>
                <ul>
                    <li>细胞生物学各类实验</li>
                    <li>分子生物学各类实验</li>
                    <li>蛋白质各类实验</li>
                    <li>动物学各类实验</li>
                    <li>课题基金申请</li>
                    <li>论文翻译、润色服务</li>
                </ul>
            </div>
        </div>
        <div class="dhw_gk_a_r">
            <img src="/static/qt/img/gs_js_gk2.jpg"/>
        </div>
    </div>
</div>
<div class="dhw_wh">

</div>
<div class="qyzz">
    <h4>企业资质</h4>
    <p>服务创作价值，为客户提供专业的实验外包服务</p>
    <ul>
        <li><img src="/static/qt/img/qy_zz1.jpg"/></li>
        <li><img src="/static/qt/img/qy_zz1.jpg"/></li>
        <li><img src="/static/qt/img/qy_zz1.jpg"/></li>
        <li><img src="/static/qt/img/qy_zz1.jpg"/></li>
    </ul>
</div>
<!--联系我们-->
<div class="content_us">
    <div class="content_us_a">
        <img src="/static/qt/img/gsjs_content.png"/>
        <p>地址：南京市中山东路218号长安国际中心</p>
        <p>服务热线：4008-000-627</p>
    </div>
    <div id="map" style='float:right'>
        <div style="width: 692px; height: 387px;" id="allmap"></div>
    </div>

</div>
<div style="clear:both"></div>
<script type="text/javascript" src="/static/qt/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=67jMQ5DmYTe1TLMBKFUTcZAR"></script>
<script type="text/javascript">
        $(function() {
            ShowMap('118.800918,32.046942', '南京德亨文生物科技有限公司', '江苏省南京市秦淮区中山东路218号长安国际中心', '4008-000-627', '2885330393@qq.com', '20');
        })
        function getInfo(id) {
            $.ajax({
                type: "POST",
                url: "WebUserControl/Contact/GetInfo.ashx",
                cache: false,
                async: false,
                data: {ID: id},
                success: function(data) {
                    data = eval(data);
                    var length = data.length;
                    if (length > 0) {
                        ShowMap(data[0]["Image"], data[0]["NewsTitle"], data[0]["Address"], data[0]["Phone"], data[0]["NewsTags"], data[0]["NewsNum"]);
                    }
                }
            });
        }
        function ShowMap(zuobiao, name, addrsee, phone, chuanzhen, zoom) {
            var arrzuobiao = zuobiao.split(',');
            var map = new BMap.Map("allmap");
            map.centerAndZoom(new BMap.Point(arrzuobiao[0], arrzuobiao[1]), zoom);
            map.addControl(new BMap.NavigationControl());
            var marker = new BMap.Marker(new BMap.Point(arrzuobiao[0], arrzuobiao[1]));
            map.addOverlay(marker);
            var infoWindow = new BMap.InfoWindow('<p style="color: #bf0008;font-size:14px;">' + name + '</p><p>地址：' + addrsee + '</p><p>电话：' + phone + '</p><p>传真：' + chuanzhen + '</p>');
            marker.addEventListener("click", function() {
                this.openInfoWindow(infoWindow);
            });
            marker.openInfoWindow(infoWindow);
        }
</script>



