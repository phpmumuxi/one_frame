<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?=$title?></title>
        <link rel="stylesheet" type="text/css" href="/static/qt/css/lab.css"/>
        <link rel="stylesheet" type="text/css" href="/static/qt/css/pageSwitch.min.css"/>
        <script src="/static/qt/js/jquery-1.12.1.min.js" type="text/javascript" charset="utf-8"></script>      
        <script src="/static/qt/js/lab.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <!--head-->
        <div class="head">
            <div class="head_l"><img src="/static/qt/img/laboratory_logo.png"/></div>
            <div class="head_r">
                <div class="head_r_t">
                    <div class="head_r_t_l">
                        <div class="head_search">
                            <em href="javascript:;">
                                <span>实验</span>
                            </em>
                            <form method="get" action="/index/search" id="form_search">
                                <input type="hidden" name="search_type" id="hidden" value="1">
                            <div class="head_input">
                                <input type="text" name="key_words"  value="" />
                            </div> 
                            <a href="javascript:;" id="submitSearch">搜索</a>
                            </form>
                            <script>
                                $('#submitSearch').click(function(){
                                    $('#form_search').submit();
                                })
                            </script>
                        </div>
                        <span class="xgwz">相关文章</span>
                        <ul>
                            <li><a href="/detail-1.html">细胞培养</a></li>
                            <li><a href="/detail-2.html">细胞凋亡检测</a></li>
                            <li><a href="/detail-3.html">蛋白表达检测</a></li>
                        </ul>
                    </div>
                    <div class="head_r_t_r">
                        <a href="#"><img src="/static/qt/img/laboratory_tel.png"/></a>
                    </div>
                </div>
                <div class="head_r_b">
                    <ul>
                        <li><a href="/" class="active">首页</a></li>
                        <li><a href="/index/about">公司介绍</a></li>
                        <li><a href="/index/lineSale">在线报价</a></li>
                        <li><a href="/index/server">服务流程</a></li>
                        <li><a href="/index/question">常见问题</a></li>
                        <li><a href="/index/artInfo">行业资讯</a></li>
                    </ul> 
                </div>
            </div>   
        </div>

        <?php require_once($ko_template_file); ?>


        <!--底部-->
        <div class="footer_bj">
            <div class="footer">
                <div class="footer_l">
                    <div class="footer_l_t">
                        <dl>
                            <dd>
                                <h4>实验分类</h4>
                                <p><a href="/lists-1-1.html">细胞生物学平台</a></p>
                                <p><a href="/lists-2-1.html">蛋白质技术平台</a></p>
                                <p><a href="/lists-3-1.html">分子生物学技术平台</a></p>
                                <p><a href="/lists-4-1.html">动物实验技术平台</a></p>
                                <p><a href="/lists-5-1.html">科研平台</a></p>
                            </dd>
                            <dd>
                                <h4>公司介绍</h4>
                                <p><a href="javascript:;">南京德亨文生物科技有限公司</a></p>
                                <p><a href="javascript:;">We discover life for you</a></p>
                            </dd>
                            <dd>
                                <h4>信誉保障</h4>
                                <p><a href="javascript:;">专业的实验外包平台</a></p>
                            </dd>
                            <dd>
                                <h4>服务流程</h4>
                                <p><a href="/index/server">标准化服务，一对一服务</a></p>
                            </dd>
                        </dl>
                    </div>
                    <div class="footer_l_b">
                        Copyright©2011-2016 All Rights Reserved  苏ICP备17008289号  版权所有：德亨文生物科技所有
                    </div>
                </div>
                <div class="footer_r">
                    <p>德亨文生物科技</p>
                    <p>咨询热线：4008-000-627</p>
                    <p>地址：江苏省南京市秦淮区中山东路218号</p>
                    <img src="/static/qt/img/sm.jpg"/>
                </div>
            </div>
        </div>
    </body>
</html>
