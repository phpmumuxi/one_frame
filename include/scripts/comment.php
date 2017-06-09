<?php // http://www.zazhi.com.cn/ - 采集评论
$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb();
$data = $db->fetchAll('select id,title from {{art_con}}');
foreach($data as $v) {
    $content = Public_Http::curl('http://www.zazhi.com.cn/s.html?o=0&q='.urlencode($v['title']));
    preg_match_all('/<div class=\"list-l\">.*?<a href=\"(.*?)\"/si', $content, $matches);
    if(isset($matches['1']['0'])){
        $s = Public_Http::curl($matches['1']['0']);
        preg_match_all('/<div class=\"bbs-item-simple\">(.*?)<span class=\"date\">(.*?)<\/span>/si', $s, $m1);
        if(isset($m1['1'])){
            foreach($m1['1'] as $mk1 => $mv1){
                preg_match_all('/来自<span class=\"author\">(.*?)<\/span>/si', $mv1, $m2);$a['name'] = trim($m2['1']['0']);
                preg_match_all('/<div class="bbs-content">.*?<p>(.*?)<\/p>/si', $mv1, $m3);$a['content'] = trim($m3['1']['0']);
                $a['isshow'] = 1;$a['art_id'] = $v['id'];$a['add_at'] = strtotime($m1['2'][$mk1]);
                $has = $db->fetchCvn('art_comment',array('art_id'=>$a['art_id'],'content'=>$a['content']));
                if($has < 1) {
                    $db->insert('art_comment',$a);
                }
            }
        }
    }
}
