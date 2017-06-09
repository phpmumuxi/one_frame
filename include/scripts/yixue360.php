<?php // http://www.yixue360.com/ - 采集期刊
$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb();

$lb_arr = array(
    '61' => '北大核心',
    '63' => '统计源核心',
    '67' => '浙江省核心',
    '62' => 'CSCD期刊',
    '68' => 'CSCD扩展板',
    '64' => '国家级',
    '65' => '省级',
    '69' => '中文核心期刊',
);
$ko_count = 0;
$s = file_get_contents( $dir.'/1.txt' );



preg_match_all('/<option value="(\d+)">(.*?)<\/option>/si', $s, $r2);
$a2 = isset($r2['1']) ? $r2['1'] : array(); 
foreach ($a2 as $k2 => $v2) {
    $cat_id = intval($v2); $cat_name = isset($r2['2'][$k2]) ? trim($r2['2'][$k2]) : '';    
    $url = 'http://www.yixue360.com/periodical/ajaxperiodicalSearch?page=1&pageSize=500&periodicalsearch.ppNameCh=&periodicalsearch.tdIdCh='.$cat_id.'&periodicalsearch.jiIdCh=0&periodicalsearch.ppDomesticCh=&periodicalsearch.ppInternationalCh=&periodicalsearch.jsIdCh=0&periodicalsearch.ppCbzqCh=&periodicalsearch.ppLanguageCh=0&periodicalsearch.ppComprehensiveBeginCh=&periodicalsearch.ppComprehensiveEndCh=&periodicalsearch.ppInitialCh=';    
    $str = Public_Http::curl( $url ); $a = json_decode($str, true);
    if (!empty($a)) {
        //print_r($a);exit;
        foreach ($a as $k => $v) {
            $title = trim($v['ppName']); $img = trim($v['ppImgurl']);
            if ($db == null) { $db = Sys::getdb(); }
            $is_cz = $db->fetchCvn('art_con', array('lx_id'=>2,'title'=>$title));
            if ($is_cz < 1) {        
                if ($v['ppViewType'] == 1) {
                    $v['url'] = 'http://www.yixue360.com/periodical/periodicalChhzSet?peraction='.$v['ppId'].'&flagaction=ChYes';
                    $b = get_url_cc(1, $v['url']);
                    //级别
                    $url2 = 'http://www.yixue360.com/periodical/periodicalChhz?peraction='.$v['ppId'].'&flagaction=ChNo';
                    $str2 = Public_Http::curl( $url2 );
                    preg_match('/级别[：|:](.*?)<\/li>/is', $str2, $row2);
                    $b['level'] = isset($row2['1']) ? strip_tags($row2['1']) : '';
                } else {
                    $v['url'] = 'http://www.yixue360.com/periodical/peridoicalViewFhz?peraction='.$v['ppId'].'&flagaction=ChNo';
                    $b = get_url_cc(0, $v['url']);
                }
                $level_id = 66;
                if (trim($b['level']) != '') {
                    $a = explode(',', str_replace('，', ',', trim($b['level'])));
                    $level_id = array_search(trim($a['0']), $lb_arr);
                    if (!$level_id) {
                        $level_id = 66;
                    }
                }

                //保存期刊文章
                $img = Dao_Art::ko_add_remote($img, -1); $add_mid = 1; $add_at = time();
                $c_arr = array(
                    'title'=>$title, 'thumb'=>$img, 'isshow'=>1,
                    'lx_id'=>2, 'cat_id'=>get_cat_id($cat_name, $db),
                    'istui'=>(mt_rand(1, 10)<=3 ? 1 : 0),
                    'ishot'=>(mt_rand(1, 10)<=3 ? 1 : 0),
                    'click'=>mt_rand(100, 9999),
                    'add_mid'=>$add_mid, 'add_at'=>$add_at,
                    'mod_mid'=>$add_mid, 'mod_at'=>$add_at,
                    'body'=>trim($b['content']),
                );
                if ($db == null) { $db = Sys::getdb(); }
                $db->insert('art_con', $c_arr); $last_art_id = $db->getlastInsertId();            

                //保存期刊信息
                $q_arr = array(
                    'art_id'=>$last_art_id,
                    'zhu_g'=> $b['zhuguan'], 'zhu_b'=> $b['zhuban'], 'you'=> $b['you'],               
                    'issn'=> $b['wai'], 'cn'=> $b['nei'], 'publish'=> $b['chubandi'],

                    'cycle_id'=> get_base_id($b['fabiao'], 1, $db), //发行周期
                    'kaiben'=> '',
                    'fu_yz'=> ($b['fu_yz'] ? $b['fu_yz'] : 0),
                    'zh_yz'=> ($b['zh_yz'] ? $b['zh_yz'] : 0),

                    'speed_id'=> '35', //审稿周期
                    'income_id'=> '13',
                    'level_id'=> $level_id,
                    'honor_id'=> '',
                    'lanset'=> $b['lanset'], 'yaoqiu'=> $b['yaoqiu'],
                );
                $db->insert('art_qikan', $q_arr); $ko_count++;

                echo msg("分类：".$cat_name." - 成功采集期刊：".$title."  共第".$ko_count."条完成\n"); //exit;
            }
        }
    }
}
echo msg("全部完成\n");


function get_em($n, $str) {
    preg_match('/'.$n.'：<em.*?>(.*?)<\/em>/si', $str, $r);
    return isset($r['1'])? trim($r['1']) : '';
}
function get_aa($n, $str) {
    preg_match('/<\/span>'.$n.'<a.*?><\/a><\/h2>(.*?)<div class="line10"><\/div>/si', $str, $r5);
    return isset($r5['1'])? trim($r5['1']) : '';
}

function get_url_cc($t=0, $url='') {
    $str = Public_Http::curl( $url ); $a = array();
    if ($t == 1) {
        preg_match('/主管单位：(.*?)<\/li>\s.+?主办单位：(.*?)<\/li>\s.+?国际刊号：(.*?)<\/li>\s.+?国内刊号：(.*?)<\/li>\s.+?发表周期：(.*?)<\/li>\s.+?出版地：(.*?)<\/li>\s.+?<div class="qk_log_list">.*?期刊详情<a name="qq" id="qq"><\/a><\/h2>(.*?)<div class="line10"><\/div>/is', $str, $row);
        $a['fu_yz'] = get_em('复合影响因子', $str);
        $a['zh_yz'] = get_em('综合影响因子', $str);
        $a['lanset'] = get_aa('主要栏目', $str);
        $a['yaoqiu'] = get_aa('投稿须知', $str);
    } else {
        preg_match('/主管单位：(.*?)<\/li>\s.+?主办单位：(.*?)<\/li>\s.+?ISSN：(.*?)<\/li>\s.+?CN：(.*?)<\/li>\s.+?邮发代号：(.*?)<\/li>\s.+?发表周期：(.*?)<\/li>\s.+?出版地：(.*?)<\/li>\s.+?级别：(.*?)<\/li>.+?<div class="qk_log_list">.*?期刊详情<a name="qq" id="qq"><\/a><\/h2>(.*?)<div class="line10"><\/div>/is', $str, $row);
        $a['fu_yz'] = get_em('复合影响因子', $str);
        $a['zh_yz'] = get_em('综合影响因子', $str);
        $a['lanset'] = get_aa('主要栏目', $str);
        $a['yaoqiu'] = get_aa('投稿须知', $str);
    }
    $a['zhuguan'] = isset($row['1']) ? strip_tags($row['1']) : '';
    $a['zhuban'] = isset($row['2']) ? strip_tags($row['2']) : '';
    $a['wai'] = isset($row['3']) ? strip_tags($row['3']) : '';
    $a['nei'] = isset($row['4']) ? strip_tags($row['4']) : '';
    if ($t == 1) {
        $a['you'] = $a['level'] = '';
        $a['fabiao'] = isset($row['5']) ? strip_tags($row['5']) : '';
        $a['chubandi'] = isset($row['6']) ? strip_tags($row['6']) : '';
        $a['content'] = isset($row['7']) ? str_replace('返回顶部↑', '',($row['7'])) : '';        
    } else {
        $a['you'] = isset($row['5']) ? strip_tags($row['5']) : '';
        $a['fabiao'] = isset($row['6']) ? strip_tags($row['6']) : '';
        $a['chubandi'] = isset($row['7']) ? strip_tags($row['7']) : '';        
        $a['level'] = isset($row['8']) ? strip_tags($row['8']) : '';
        $a['content'] = isset($row['9']) ? str_replace('返回顶部↑', '',($row['9'])) : '';
    }
    preg_match('/曾用名：(.*?)<\/li>/is', $str, $row2);
    $a['old_name'] = isset($row2['1']) ? strip_tags($row2['1']) : '';
    return $a;
}





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


    


