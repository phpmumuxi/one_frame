<?php

$dir = dirname(__FILE__);
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb();
$ko_count = 0;

for ($num=8;$num<=3187;$num++){
    $durl="http://www.mogoedit.com/information/info/article/{$num}";
    $s2 = Public_Http::curl($durl);
    preg_match_all('/<div class=\"left_write\">.*<\/div>/ism',$s2,$news);
    preg_match_all('/<div class=\"news_title\">.*?<\/div>/ism',$news[0][0],$news_title);
    $d = strip_tags($news_title[0][0]);
    preg_match_all('/<div class=\"news_content\">.*?<\/div>/is',$news[0][0],$news_content);
    $dd = strip_tags($news_content[0][0],'<p>');

    $inidata=array(
        "fingerpost_title" => $d,
        "fingerpost_description" => $d,
        "fingerpost_keyword" => $d,
        "fingerpost_content" => $dd
    );
    $db->insert("fingerpost",$inidata);
}