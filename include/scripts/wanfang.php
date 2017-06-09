<?php // http://c.wanfangdata.com.cn/Periodical.aspx/ - 采集期刊
$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
include($dir.'/wanfang1.php');
$db = Sys::getdb();

@define('KO_DOMAIN_URL', 'http://www.qkw360.com');

$type = array('文史哲期刊','社科期刊','经管期刊','文史哲期刊','基础科学','医药期刊','农业科技','工程科技I');
$cate = array('教育','少儿教育','中学生教育','大学学报(教科文艺)');
$s1 = Public_Http::curl('http://c.wanfangdata.com.cn/Periodical.aspx');
preg_match_all('/<ul class="Content_ul">(.*?)<\/ul>/si', $s1, $r1);

foreach($r1[1] as $k => $v)
{
    preg_match_all('/<a.*?href=[\"|\'](.*?)[\"|\'].*?>.*?<t>(.*?)<\/t>/si', $v, $r2);
    $aaa[$k][] = isset($r2[1]) ? $r2[1] : array();
    $aaa[$k][] = isset($r2[2]) ? $r2[2] : array();
}

$ko_count = 0;
foreach ($aaa as $kaa => $vaa) {
    $parent_id = get_cat_id($type[$kaa]);
    foreach($vaa[0] as $kaa0 => $vaa0) {
        $cate_id = get_cat_id($vaa[1][$kaa0]);
        if(!$cate_id)
        {
            if ($db == null) { $db = Sys::getdb(); }
            if(in_array(trim($vaa[1][$kaa0]),$cate)) {
                $parent_id = get_cat_id('教育期刊');
            }
            $db->insert('art_type',array('lx_id'=>2,'name'=>trim($vaa[1][$kaa0]),'parent_id'=>$parent_id,'sort'=>0));
            $cate_id = $db->getlastInsertId();
            $db->update('art_type', array('child_ids'=>$cate_id), array('id'=>$cate_id));
            
            $child_ids = $db->fetchOne("select child_ids from {{art_type}} where id = ".$parent_id);
            $child_ids .= ','.$cate_id;
            $db->update('art_type', array('child_ids'=>$child_ids), array('id'=>$parent_id));
        }
        
        for($i = 1; $i<=12; $i++) {
            $s1 = Public_Http::curl( 'http://c.wanfangdata.com.cn/'.$vaa0.'&PageNo='.$i);
            preg_match_all('/<ul class="record_items record_items11" style="border-top:0;">(.*?)<\/ul>/si', $s1, $r1);
            preg_match_all('/<a href=\'(.*?)\'>/si', $r1[1][0], $r2);
            
            $a1 = isset($r2['1']) ? str_replace('Periodical','PeriodicalProfile',$r2['1']) : array();
            if (count($a1) > 0) {
                foreach ($a1 as $v1) {
                    $s2 = Public_Http::curl('http://c.wanfangdata.com.cn/'.$v1);

                    //标题，图片
                    preg_match_all('/<div class="qkhead_pic_new">.*?<img id="periodicalImage" src="(.*?)" \/>.*?<h1>(.*?)<img.*?<\/h1>/si', $s2, $r3);
                    $img = isset($r3[1][0]) ? trim($r3[1][0]) : '';
                    $title = isset($r3[2][0]) ? trim($r3[2][0]) : '';
                    //期刊简介
                    preg_match_all('/<p class="qikan_info">(.*?)<\/p>/si', $s2, $r4);
                    $body = isset($r4[1][0]) ? trim($r4[1][0]) : '';
                    //期刊信息
                    preg_match_all('/<p><t>主管单位<\/t>：(.*?)<\/p>.*?<p><t>主办单位<\/t>：(.*?)<\/p>.*?<p>ISSN：(.*?)<\/p>.*?<p>CN：(.*?)<\/p>/si', $s2, $r5);
                    
                    if ($db == null) { $db = Sys::getdb(); }
                    $is_cz = $db->fetchCvn('art_con', array('lx_id'=>2,'title'=>$title));
                    if ($is_cz < 1) {
                        //保存期刊文章
                        $img = ko_add_remote($img, -1); $add_mid = 1; $add_at = time();
                        
                        $c_arr = array(
                            'title'=>$title, 'thumb'=>$img, 'isshow'=>0,
                            'lx_id'=>2, 'cat_id'=>$cate_id,
                            'istui'=>(mt_rand(1, 10)<=3 ? 1 : 0),
                            'ishot'=>(mt_rand(1, 10)<=3 ? 1 : 0),
                            'click'=>mt_rand(100, 9999),
                            'add_mid'=>$add_mid, 'add_at'=>$add_at,
                            'mod_mid'=>$add_mid, 'mod_at'=>$add_at,
                            'body'=>$body,
                        );

                        if ($db == null) { $db = Sys::getdb(); }
                        $db->insert('art_con', $c_arr); $last_art_id = $db->getlastInsertId();
                            
                        //保存期刊信息
                        $level_id = '';
                        if(in_array(trim($title),$tjy_arr)) {
                            $r = get_base_id('统计源期刊',5);
                            $level_id .= $r.',';
                        }
                        if(in_array(trim($title),$cscd_hx)) {
                            $r = get_base_id('CSCD核心期刊',5);
                            $level_id .= $r.',';
                        }
                        if(in_array(trim($title),$cscd_tz)) {
                            $r = get_base_id('CSCD扩展板',5);
                            $level_id .= $r.',';
                        }
                        if(in_array(trim($title),$cssci)) {
                            $r = get_base_id('CSSCI南大核心期刊',5);
                            $level_id .= $r.',';
                        }
                        $q_arr = array(
                            'art_id'=>$last_art_id,
                            'level_id'=>trim($level_id,','),
                            'zhu_g'=> (isset($r5['1']['0']) ? trim($r5['1']['0']) : ''),
                            'zhu_b'=> (isset($r5['2']['0']) ? trim($r5['2']['0']) : ''),
                            'issn'=> (isset($r5['3']['0']) ? trim($r5['3']['0']) : ''),
                            'cn'=> (isset($r5['4']['0']) ? trim($r5['4']['0']) : ''),
                        );
                        $db->insert('art_qikan', $q_arr); $ko_count++;
                        echo msg("第".$i."页 - 成功采集期刊：".trim($vaa[1][$kaa0])."  共第".$ko_count."条完成"."</br>\r\n");
                    }
                }
            }
        }
    }
    echo msg(trim($type[$kaa])."采集完成"."</br>\r\n");
}
echo msg("全部完成\r\n");

//保存图片
function ko_add_remote($pic='', $maxW=650, $maxH=0) {
    $path = KO_UPLOAD_PATH.'/art/'.date('Ymd').'/';
    if (!preg_match('/http\:\/\//is', $pic)) {
        $pic = KO_DOMAIN_URL . $pic;
    }
    Sys::create_dir( $path );
    $path .= time().mt_rand(10000, 99999999).'.jpg';
    if (copy($pic, $path)) { 
        if ($maxW >= 0) {
            Public_Img::resize($path, $maxW, $maxH); //调整图片大小
        }
    } else {
        $path = '';
    }
    return str_replace(KO_ROOT_PATH, '', $path);
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