<?php
/** 
 * 框架基础文件
 *
 * @Author  Hardy
 */
@header('Content-type: text/html; charset=UTF-8'); //设置网站编码
@date_default_timezone_set( 'PRC' ); //设置时区
if (!@session_id()) { @session_start(); } //开启会话

//初始化设置
@ini_set('memory_limit', '300M');
@ini_set('display_errors', 1); //是否显示出错信息：1显示，0不显示

@define('KO_ROOT_PATH', realpath(dirname(__FILE__).'/../')); //网站根目录
@define('KO_INCLUDE_PATH', KO_ROOT_PATH.'/include'); //程序开发目录
@define('KO_TEMPLATES_PATH', KO_INCLUDE_PATH.'/templates'); //公共模板目录
@define('KO_DATA_PATH', KO_ROOT_PATH.'/data'); //文件目录
@define('KO_UPLOAD_PATH', KO_DATA_PATH.'/upload'); //文件上传目录
@define('KO_CACHE_PATH', KO_DATA_PATH.'/cache'); //文件缓存目录
@define('KO_CARD_PATH', KO_DATA_PATH.'/card'); //任务计划目录
@define('KO_COOKIE_PATH', KO_DATA_PATH.'/cookie'); //COOKIE目录

if (@ini_get('magic_quotes_gpc')) { //删除反斜杠
	function ko_stripslashes_response(array $a) {
		foreach ($a as $k => $v) {
			if (@is_string($v)) {
				$a[$k] = @stripslashes($v);
			} else if (@is_array($v)) {
				$a[$k] = ko_stripslashes_response($v);
			}
		}
		return $a;
	}
    if (isset($_GET)) { $_GET = ko_stripslashes_response($_GET); }
    if (isset($_POST)) { $_POST = ko_stripslashes_response($_POST); }
    if (isset($_REQUEST)) { $_REQUEST = ko_stripslashes_response($_REQUEST); }
}

function msg($s = '') { //命令行显示信息
    if (strtolower(PHP_OS) != 'linux') {
        return utf8_to_gbk( $s );
    }
    return $s;
}

function gbk_to_utf8($s = '') { //GBK转UTF-8
    return mb_convert_encoding($s, 'UTF-8', 'GBK');
}

function utf8_to_gbk($s = '') { //UTF-8转GBK
    return mb_convert_encoding($s, 'GBK', 'UTF-8');
}

function debug($s = '') { //打印错误信息
    $f = @fopen(KO_DATA_PATH.'/debug.txt' , 'a');
    if ($f) {
        if (@is_array($s)) { $s = @var_export($s, 1); }
        @fwrite($f , @date('Y-m-d H:i:s').' Info：' . $s . "\n");
    }
    @fclose($f);
}

function KO_Auto_Loader( $n ) { //自动加载类
	$f = KO_INCLUDE_PATH . '/lib/'. @str_replace('_', '/', $n) .'.php';
	if (@file_exists( $f )) { require_once( $f ); }
}
spl_autoload_register( 'KO_Auto_Loader' );