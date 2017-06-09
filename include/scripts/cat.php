<?php //采集栏目分类
$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb();


$s = file_get_contents( $dir.'/1.txt' );

exit;
    
preg_match_all('/<option.*?>(.*?)<\/option>/si', $s, $r2);
$a2 = isset($r2['1']) ? $r2['1'] : array();
foreach ($a2 as $v2) {
    save_lm($v2, 1, $db);
    echo msg($v2." - 采集完成\n"); 
}
    




function save_lm($title, $fid=0, $db) {    
    $title = trim($title); $a['name'] = $title;
    $a['lx_id'] = 2; $a['parent_id'] = $fid;
    $is_cz = intval($db->fetchOne('select id from {{art_type}} where parent_id='.$fid.' and name like :name', array(':name'=>'%'.$title.'%')));
    if ($is_cz < 1) {
        //$db->insert('art_type', $a);
    }echo ' - '.$is_cz;
//    return $db->getlastInsertId();
}




echo msg("全部完成\n");


