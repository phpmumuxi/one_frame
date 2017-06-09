<?php // http://c.wanfangdata.com.cn/Periodical.aspx/ - 级别收录
$a = file( dirname(__FILE__).'/level/tjy_qk.txt');
$b = file( dirname(__FILE__).'/level/cscd_qk.txt');
$c = file( dirname(__FILE__).'/level/CSSCI1.txt');
$d = file( dirname(__FILE__).'/level/CSSCI2.txt');

foreach($a as $line => $content){
    $tjy_arr[] = trim(substr((trim($content)),4));   
}
$cscd_hx = array();
$cscd_tz = array();
foreach($b as $line => $content) {
    $pattern = '([0-9a-zA-Z]{4}-[0-9a-zA-Z]{4})';
    $content = preg_replace($pattern, '', $content);
    $t = trim(substr(trim($content),-1,1));
    $u = trim(substr(trim($content),0,-1));
    if($t == 'C')
    {
        $cscd_hx[] = $u;
    }else{
        $cscd_tz[] = $u;
    }
}
foreach($c as $line => $content) {
    $r = explode(' ',trim($content));
    $cssci1[] = trim($r[0]);
}

foreach($d as $line => $content) {
    $r = explode(' ',trim($content));
    $cssci2[] = trim($r[0]);
}
$cssci = array_merge($cssci1,$cssci2);