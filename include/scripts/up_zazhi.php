<?php // http://www.zazhi.com.cn/ - 采集期刊
$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb(); $ko_count = 0;

exit;

$ko_count = 0;
$aa = $db->fetchAll('select id,title from {{art_con}} where lx_id=2 order by id asc');
foreach ($aa as $ka => $va) {
    $last_art_id = intval($va['id']);   $title = trim($va['title']);
    $durl = 'http://'.Str::get_pinyin($va['title']).'.zazhi.com.cn/c1.html';
    //$durl = 'http://shkj.zazhi.com.cn/';
    $s2 = Public_Http::curl( $durl );
    if (preg_match('/<title>404 - Not Found<\/title>/si', $s2)) {
        $durl = 'http://'.Str::get_pinyin($va['title'], 1).'.zazhi.com.cn';
        $s2 = Public_Http::curl($durl);
    }    
    preg_match_all('/<div class="bbs-item-simple">.*?来自<span class="author">(.*?)<\/span>.*?<div class="bbs-content">(.*?)<\/div>.*?<span class="date">(.*?)<\/span>/si', $s2, $r3);
    $namea = isset($r3['1']) ? $r3['1'] : array();
    if (!empty($namea)) {
        foreach ($namea as $k => $v) {
            $qc = array(
                'name' => $v, 'isshow'=>0, 'art_id'=>$last_art_id,
                'content' => isset($r3['2'][$k]) ? $r3['2'][$k] : '',
                'add_at' => isset($r3['3'][$k]) ? strtotime($r3['3'][$k]) : 0,
            );
          //  $db->insert('art_comment', $qc);
        }
        //$db->update('art_qikan', array('old_url'=>$durl), array('art_id'=>$last_art_id));
        $ko_count++;
        echo msg("成功采集期刊：".$title."  共第".$ko_count."条完成\n");  // exit;
    }
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


    


