<?php //采集栏目分类
$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb();



$ko_count = 0;
for($i = 1; $i<=30; $i++) {
    $url = 'http://www.zazhi.com.cn/qikan/s12001l0l0l0l0l0l0l0l0l00'.$i.'.html';
    $s1 = Public_Http::curl($url);
    preg_match_all('/<li class="list-li">(.*?)<\/li>/si', $s1, $r1);
    $a1 = isset($r1['1']) ? $r1['1'] : array();
    if (count($a1) > 0) {
        foreach ($a1 as $v1) {
            preg_match('/<img src="(.*?)".*?>.*?<h4><a target="_blank" href="(.*?)".*?>(.*?)<\/a><\/h4>/si', $v1, $r2);
            $img = isset($r2['1']) ? preg_replace('/(.*)\_{1}([^\_]*)/si', '$1', trim($r2['1'])) : '';
            $durl = isset($r2['2']) ? trim($r2['2']) : '';
            $title = isset($r2['3']) ? trim($r2['3']) : '';
            
            if ($db == null) { $db = Sys::getdb(); }
            $is_cz = $db->fetchCvn('art_con', array('lx_id'=>2,'title'=>$title));
            if ($is_cz < 1) {
                $s2 = Public_Http::curl($durl);            
                preg_match('/<li><span>主管单位：<\/span><a.*?>(.*?)<\/a><\/li>.*?<li><span>主办单位：<\/span><a.*?>(.*?)<\/a><\/li>.*?<li><span>国际刊号：<\/span>(.*?)<\/li>.*?<li><span>国内刊号：<\/span>(.*?)<\/li>.*?<li><span>出版地方：<\/span><a.*?>(.*?)<\/a><\/li>.*?<li><span>邮发代号：<\/span>(.*?)<\/li>.*?<li><span>发行周期：<\/span><a.*?>(.*?)<\/a><\/li>.*?<li><span>期刊开本：<\/span><a.*?>(.*?)<\/a><\/li>.*?<li>复合影响因子：<span>(.*?)<\/span><\/li>.*?<li>综合影响因子：<span>(.*?)<\/span><\/li>.*?<li><span>审稿速度：<\/span>.*?<a.*?>(.*?)<\/a>/si', $s2, $r3);

                //所属分类
                preg_match('/<span>所属分类：<\/span>(.*?)<\/div>/si', $s2, $r4);
                $s4 = isset($r4['1']) ? trim($r4['1']) : '';
                $cat_id = get_a_txt($s4, 0, $db, 1);

                //保存期刊文章
                $img = Dao_Art::ko_add_remote($img, -1); $add_mid = 1; $add_at = time();
                $c_arr = array(
                    'title'=>$title, 'thumb'=>$img, 'isshow'=>1,
                    'lx_id'=>2, 'cat_id'=>$cat_id,
                    'istui'=>(mt_rand(1, 10)<=3 ? 1 : 0),
                    'ishot'=>(mt_rand(1, 10)<=3 ? 1 : 0),
                    'click'=>mt_rand(100, 9999),
                    'add_mid'=>$add_mid, 'add_at'=>$add_at,
                    'mod_mid'=>$add_mid, 'mod_at'=>$add_at,
                    'body'=>get_text('杂志社简介', $s2),
                );
                if ($db == null) { $db = Sys::getdb(); }
                $db->insert('art_con', $c_arr); $last_art_id = $db->getlastInsertId();

                //期刊收录
                preg_match('/<div class="record-r">(.*?)<\/div>/si', $s2, $r4);
                $s4 = isset($r4['1']) ? trim($r4['1']) : '';
                $income_id = get_a_txt($s4, 2, $db);

                //期刊级别
                preg_match('/<li><span>期刊级别(.*?)<\/li>/si', $s2, $r4);
                $s4 = isset($r4['1']) ? trim($r4['1']) : ''; 
                $level_id = get_a_txt($s4, 5, $db);

                //期刊荣誉
                preg_match('/<div class="bar">.*?杂志荣誉.*?<ul>(.*?)<\/ul>/si', $s2, $r4);
                $s4 = isset($r4['1']) ? trim($r4['1']) : ''; 
                $honor_id = get_a_txt($s4, 4, $db);

                //保存期刊信息
                $q_arr = array(
                    'art_id'=>$last_art_id,
                    'zhu_g'=> (isset($r3['1']) ? trim($r3['1']) : ''),
                    'zhu_b'=> (isset($r3['2']) ? trim($r3['2']) : ''),
                    'issn'=> (isset($r3['3']) ? trim($r3['3']) : ''),
                    'cn'=> (isset($r3['4']) ? trim($r3['4']) : ''),
                    'publish'=> (isset($r3['5']) ? trim($r3['5']) : ''),                

                    'you'=> (isset($r3['6']) ? trim($r3['6']) : ''),
                    'cycle_id'=> get_base_id((isset($r3['7']) ? trim($r3['7']) : ''), 1, $db), //发行周期
                    'kaiben'=> (isset($r3['8']) ? trim($r3['8']) : ''),
                    'fu_yz'=> (isset($r3['9']) ? trim($r3['9']) : ''),
                    'zh_yz'=> (isset($r3['10']) ? trim($r3['10']) : ''),

                    'speed_id'=> get_base_id((isset($r3['11']) ? trim($r3['11']) : ''), 3, $db), //审稿周期
                    'income_id'=> $income_id,
                    'level_id'=> $level_id,
                    'honor_id'=> $honor_id,
                    'lanset'=> get_text('杂志栏目设置', $s2),
                    'yaoqiu'=> get_text('杂志社征稿要求', $s2),
                );
                $db->insert('art_qikan', $q_arr); $ko_count++;

                echo msg("第".$i."页 - 成功采集期刊：".$title."  共第".$ko_count."条完成\n");
            }
        }
    }
    echo msg("第 ".$i." 页采集完成\n");
}
echo msg("全部完成\n");


//返回分类ID
function get_cat_id($name='', $db=null) {
    if ($db == null) { $db = Sys::getdb(); } $name = trim($name);
    $a = intval($db->fetchOne('select id from {{art_type}} where lx_id=2 and name=:name', array(':name'=>$name)));
    return $a;
}

//返回基础数据ID
function get_base_id($name='', $type=0, $db=null) {
    if ($db == null) { $db = Sys::getdb(); } $name = trim($name);
    $a = intval($db->fetchOne('select id from {{base_info}} where lx_id='.intval($type).' and name=:name', array(':name'=>$name)));
    return $a;
}

//获取基本信息
function get_text($k='杂志社简介', $s2) {
    preg_match('/<div class="bar">.*?'.$k.'<\/span>.*?<div class="con"><p>(.*?)<\/p><\/div>/si', $s2, $r4);
    return isset($r4['1']) ? trim($r4['1']) : '';
}

//获取A里面值
function get_a_txt($s4, $type, $db, $ttt=0) {
    $level_id = array();
    preg_match_all('/<a.*?>(.*?)<\/a>/si', $s4, $t5);
    $a6 = isset($t5['1']) ? ($t5['1']) : array();
    foreach ($a6 as $v6) {
        if ($ttt == 0) {
            $id = get_base_id(trim($v6), $type, $db);
        } else {
            $id = get_cat_id(trim($v6), $db);
        }
        if ($id > 0) {
            $level_id[] = $id;
        }
    }
    return $level_id ? implode(',', $level_id) : '';
}


    


