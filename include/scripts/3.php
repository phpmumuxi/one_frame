<?php
$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb();
$a = file(KO_ROOT_PATH.'/3.txt');
foreach($a as $k => $v) {
    $r = explode('	',$v);
    if(isset($r['0']) && !empty($r['0']) && isset($r['1']) &&!empty($r['1'])) {
        $row = $db->fetchRow('select * from {{art_newtype}} where name = "'.trim($r['1']).'"');
        if(empty($row)) {
            $db->insert('art_newtype',array('name'=>trim($r['1'])));
            $newtype_id = $db->getlastInsertId();
        }else{
            $newtype_id = $row['id'];
        }
        
        $row2 = $db->fetchRow(' select a.id from {{art_con}} a left join {{art_type}} b on a.cat_id = b.id where a.title = "'.trim($r['0']).'"');
        if(empty($row2)) {
            $row3 = $db->fetchRow('select * from {{art_type}} where name = "'.trim($r['1']).'"');
            if(empty($row3)) {
                $db->insert('art_type',array('name'=>trim($r['1'])));
                $cat_id = $db->getlastInsertId();
            }else{
                $cat_id = $row3['id'];
            }
            $db->insert('art_con',array('title'=>trim($r['0']),'newtype_id'=>$newtype_id,'cat_id'=>$cat_id));
        }else{
            $db->query('update {{art_con}} set newtype_id = '.$newtype_id.' where id = '.$row2['id']);
        }
    }
}
echo 'jishu';exit;

