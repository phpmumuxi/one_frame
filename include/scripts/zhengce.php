<?php // http://www.med126.com - 采集政策
$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb();


exit;
$ko_count = 0;
$dq_arr = Dao_Region::get_area_data( 1 ); //省级地区
foreach ($dq_arr as $v1) {
    $v1['name'] = str_replace('省', '', $v1['name']);
    $pp = Str::get_pinyin($v1['name']);
    if ($v1['name'] == '山西') {
        $pp = 'sx';
    }
    $url = 'http://www.med126.com/lunwen/'.$pp.'/';
    $s2 = Public_Http::gbk_to_utf8(Public_Http::curl($url));
    preg_match_all('/<div class="(listbgb|listbgs)"><img.*?>.*?&nbsp;<a.*?href="(.*?)".*?>(.*?)<\/a><\/div>/si', $s2, $r2);
    $urla = isset($r2['2']) ? $r2['2'] : array();
    if (!empty($urla)) {
        foreach ($urla as $k2 => $v2) {
            $durl = 'http://www.med126.com'.trim($v2);
            $title = isset($r2['3'][$k2]) ? strip_tags(trim($r2['3'][$k2])) : '';            
            if ($durl!='' && $title!='' && preg_match('/2015/si', $title) && !preg_match('/汇总/si', $title)) {
                $s3 = Public_Http::gbk_to_utf8(Public_Http::curl($durl));
                preg_match('/<div class=med126content>(.*?)<\/div>/si', $s3, $r3);
                $body = isset($r3['1']) ? trim($r3['1']) : '';
                $bpa = Dao_Art::handle_body($body, '', 0, 1, 0); $thumb = '';
                $body = $bpa['body']; if ($bpa['pic']!='') { $thumb = $bpa['pic']; }
                if ($db == null) { $db = Sys::getdb(); }
                $is_cz = intval($db->fetchOne('select id from {{art_con}} where lx_id=:lx_id and title=:title', array('lx_id'=>1,'title'=>$title)));
                $add_mid = 1; $add_at = time();
                $c_arr = array(
                    'title'=>$title, 'thumb'=>$thumb, 'isshow'=>0,
                    'lx_id'=>1, 'cat_id'=>167, 'province_id'=>$v1['id'],
                    'istui'=>(mt_rand(1, 10)<=3 ? 1 : 0),
                    'ishot'=>(mt_rand(1, 10)<=3 ? 1 : 0),
                    'click'=>mt_rand(100, 9999),
                    'add_mid'=>$add_mid, 'add_at'=>$add_at,
                    'mod_mid'=>$add_mid, 'mod_at'=>$add_at,
                    'body'=>$body,
                );                
                if ($is_cz < 1) {
                    $db->insert('art_con', $c_arr); $ko_count++;
                    echo msg("城市：".$v1['name']." - 成功采集期刊：".$title."  共第".$ko_count."条完成\n");
                } else {
                    $db->update('art_con', $c_arr, array('id'=>$is_cz)); $ko_count++;
                    echo msg("城市：".$v1['name']." - 成功采集期刊：".$title."  共第".$ko_count."条完成\n");
                }
            }
        }
    }
}
echo msg("全部完成\n");