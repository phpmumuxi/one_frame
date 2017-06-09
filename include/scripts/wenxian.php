<?php // http://xueshu.baidu.com/s?wd=教育与职业 - 采集期刊文献
$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb(); $ko_count = 0;

//exit;



$sql = 'select a.id,a.title from {{art_con}} a where a.lx_id=2';
$sql = 'SELECT a.id,a.title FROM ko_art_con a WHERE a.lx_id=2 AND NOT EXISTS (SELECT 1 FROM ko_art_wenxian b WHERE a.id=b.`art_id`)';
$aa = $db->fetchAll($sql.' order by a.id desc');
foreach ($aa as $va) {
    $last_art_id = intval($va['id']);   $title = trim($va['title']);
    if (Str::str_length($title)>2) {
        $title = preg_replace('/^(.+)(\(|\（)(.*?)$/', '$1', $title);
        $durl = 'http://xueshu.baidu.com/s?wd='.urlencode($title);
        $s2 = Public_Http::curl( $durl );
        get_rr2(2, $last_art_id, get_rr1('annual', $s2), $db);
        get_rr2(1, $last_art_id, get_rr1('cumulative', $s2), $db);

        $ko_count++;
        echo msg("成功采集期刊：".$title."  ID:".$last_art_id."，共第".$ko_count."条完成\n");  // exit;
        sleep( 4 );
    }
}
echo msg("全部完成\n");




function get_rr1($s1='annual',$s2='') {
    preg_match('/\''.$s1.'\' \: \{\"sc_col\"\:\[(.*?)\]\}/si', $s2, $r3);
    return isset($r3['1']) ? trim($r3['1']) : '';
}
function get_rr2($lx_id, $art_id, $s, $db) {
    preg_match_all('/\{\"cita\"\:(\d+)\,\"pub\"\:(\d+)\,\"year\"\:(\d+)\}/si', $s, $r3);
    $namea = isset($r3['1']) ? $r3['1'] : array();
    if (!empty($namea)) {
        foreach ($namea as $k => $v) {
            $qc = array(
                'lx_id'=>$lx_id,'art_id'=>$art_id,'year'=>$r3['3'][$k],
                'cita'=>intval($v), 'pub'=>intval($r3['2'][$k]), 
            );
            $db->insert('art_wenxian', $qc);
        }
    }
}
