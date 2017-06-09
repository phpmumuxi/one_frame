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
@ini_set('memory_limit',    '300M');
@ini_set('display_errors',  1); //是否显示出错信息：1显示，0不显示

@define('KO_ROOT_PATH', realpath(dirname(__FILE__).'/../')); //网站根目录
@define('KO_INCLUDE_PATH', KO_ROOT_PATH.'/include'); //程序开发目录
@define('KO_TEMPLATES_PATH', KO_INCLUDE_PATH.'/templates'); //公共模板目录
@define('KO_DATA_PATH', KO_ROOT_PATH.'/data'); //文件目录
@define('KO_UPLOAD_PATH', KO_DATA_PATH.'/upload'); //文件上传目录
@define('KO_CACHE_PATH', KO_DATA_PATH.'/cache'); //文件缓存目录

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

/**
 * @param $msg   提示信息
 * @param $url   跳转地址
 * @param $ko    0错误，1成功
 * @param $tt    几秒后跳转
 */
function showMsg($msg='', $url='', $ko=0, $tt=3) {
	$s = '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>网站提示信息</title></head><body><div style="text-align:center;font-size:12px;">';
	if ($ko != 1) { //操作错误
        $bgc = 'FFE7E7'; $img = 'error'; $ts_ys = 'FF0000;font-size:13px;';
    } else {
        $bgc = 'EDFFCC'; $img = 'success'; $ts_ys = '000000;font-weight:bold;font-size:15px;';
    }    
    $s .= '<div style="width:65%;margin:100px auto;line-height:30px;border:1px solid #EAEAD7;background-color: #'.$bgc.';text-align:left;">';
    $s .= '<p style="vertical-align: middle;margin-left:30px;"><img src="/static/images/'.$img.'.png" style="float:left;vertical-align: middle;"/></p>';
	$s .= '<p style="color:#'.$ts_ys.'margin-left:100px;">'.$msg.'</p>';
    if ($url == '') {
		$w = 'window.history.back();';
	} else {
		$w = 'window.location.href=\''.$url.'\';';
	}
    $s .= '<p style="color:#808080;margin-left:100px;">将在 <em id="show_time">'.$tt.'</em> 秒后跳转到上一个链接或指定链接，<a href="javascript:history.back();">返回上一页</a></p>';
    $s .= '<script type="text/javascript">var set_time = '.$tt.'; function show_time(){ document.getElementById("show_time").innerHTML = --set_time; if (set_time < 1) { '.$w.' } } setInterval("show_time()", 1000);</script>';
	$s .= '</div></div></body></html>';
	exit( $s );
}
function getParam($n='') { //获得参数值
	$a = KO_Base::getParam(); $r = null; $k = @array_search($n, $a);
	if ($k !== false) { if (@count($a) >= $k) { $r = @trim( $a[$k+1] ); } } return $r;
}
function debug($s = '') { //打印错误信息
    $f = @fopen(KO_DATA_PATH.'/debug.txt' , 'a');
    if ($f) {
        if (@is_array($s)) { $s = @var_export($s, 1); }
        @fwrite($f , @date('Y-m-d H:i:s').' Info：' . $s . "\n");
    }
    @fclose($f);
}
function tiao_goto($url='/', $js=false) { //页面跳转
    if ($js) {
		exit('<html><head><script type="text/javascript">window.location="'.$url.'";</script></head><body></body></html>');
    }
    @header('Location: '.$url); exit;
}
function KO_Exception($s='很抱歉，页面或者信息不存在') {
    throw new Exception( $s );
}
function KO_Auto_Loader( $n ) { //自动加载类
	$f = KO_INCLUDE_PATH . '/lib/'. @str_replace('_', '/', $n) .'.php';
	if (@file_exists( $f )) { require_once( $f ); }
}

/**
* 不显示信息直接跳转
*
* @param string $url
*/
function redirect($url = ''){
	if (empty($url)){
		if(!empty($_REQUEST['ref_url'])){
			$url = $_REQUEST['ref_url'];
		}else{
			$url = getReferer();
		}
	}
	header('Location: '.$url);exit();
}

spl_autoload_register( 'KO_Auto_Loader' );

try {
    KO_Base::run(); //运行
} catch (Exception $e) { //报错处理具体方法
       // var_dump($e);exit;  debug模式
	@header('HTTP/1.1 404 Not Found');
	@header('Status: 404 Not Found');
	include_once( KO_TEMPLATES_PATH . '/404.php' ); exit();
}

final class KO_Base { //框架基类
	static private $KoParam = array(); //参数	
	//初始化
	public static function run() {
		$a = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
		$b = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
		$c = @preg_replace('#^.+/([^/]+)$#', '$1', $a);
		$d = @str_ireplace($c, '', $a);
		$u = @str_ireplace($a, '', $b);
		$u = @str_ireplace($d, '', $u);
		$u = @preg_replace('#^/#', '', $u);
		$u = @preg_replace('#/$#', '', $u);        
        $u = @preg_replace('/(.*?)\?([a-z|A-Z|0-9|_]+)\=.+/si', '$1', $u);
        $u = @preg_replace('#/$#', '', $u);
        
		//获取网站根域名访问地址
		@define('KO_DOMAIN_URL', 'http'.(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'].$d);        
        $is_mobile = 0;
        //if ($_SERVER['HTTP_HOST'] == 'm.bestqikan.cn') { $is_mobile = 1; }
        //Sys::ko_mob_request_url();

		//获取路由配置，框架路由判断
		$ko_is_route = 0; 
              $r_arr = Sys::route_config();             
		if (@is_array($r_arr)) {
			foreach ($r_arr as $rv) {
				$ra = self::_KOROUTE($u, $rv['0'], (isset($rv['2']) ? $rv['2'] : array()));                                 
				if ($ra) {
					$mm = $rv['1']['module'];
					$cc = $rv['1']['controller'];
					$aa = $rv['1']['action'];
					$ko_is_route = 1;
					break;
				}
			}
		}
		if ($ko_is_route == 0) {
			$ko = @explode('/', $u); $mm1 = @array_shift($ko);
			if (@in_array($mm1, self::modules())) { //判断当前模块是否存在
				$mm = $mm1;
				$cc = @array_shift($ko);
				$aa = @array_shift($ko);
			} else {
				$mm = 'default';
				$cc = $mm1;
				$aa = @array_shift($ko);
			}
            if ($is_mobile == 1) { $mm = 'mdefault'; }
			if ($cc == '') { $cc = 'index'; }
			if ($aa == '') { $aa = 'index'; }
            //获得参数
            if (!empty($ko)) {
                $carr = array();
                foreach ($ko as $k => $v) {
                    if ($k % 2 == 0) {
                        $kvk = $k + 1;
                        if (isset($ko[$kvk])) {
                            $carr[$v] = $ko[$kvk]; $_GET[$v] = $ko[$kvk]; $_REQUEST[$v] = $ko[$kvk];
                        }
                    }
                }
                self::$KoParam = $carr;                                
            }
		} else {
            if ($is_mobile == 1) { $mm = 'mdefault'; }
        }
				
		$mm_dir = KO_INCLUDE_PATH . '/modules/' . $mm;
		if (!@file_exists($mm_dir)) { KO_Exception('当前模块：'.$mm.' 不存在'); }
		@define('KO_MODULE_DIR', $mm_dir); @define('KO_MODULE_NAME', $mm);
		
		$cc_file = $mm_dir . '/controllers/' . $cc. '.php';
		if (@file_exists($cc_file)) {
			include_once($cc_file);
		} else {
			KO_Exception('当前模块：'.$mm.' 下的 '.$cc.'.php 控制器文件不存在');
		}

		$cc_name = $cc . 'Controller';
		if (!@class_exists($cc_name)) { KO_Exception('当前模块：'.$mm.' 下的 '.$cc_name.' 控制器类不存在'); }
		@define('KO_CONTROLLER_NAME', $cc);

		$mm_arr = @get_class_methods($cc_name); //获取类中的方法名
		if (!@in_array($aa, $mm_arr, true)) { KO_Exception('当前控制器类：'.$cc_name.' 中的 '.$aa.' 方法不存在'); }
		@define('KO_ACTION_NAME', $aa);
		
		$www = new $cc_name(); $www->$aa();
	}
	//获取参数
	public static function getParam() {
		return self::$KoParam;
	}
	//路由判断，以及设置参数
    private static function _KOROUTE($url, $_regex, $_map=array()) {
        if (!@preg_match('#^'.$_regex.'$#i', @trim(@urldecode( $url )), $val)) { return false; };       
		if (@count($val) == 1) { return true; }
        if (@preg_match('#\(|\)#', $_regex)) { @array_shift($val); } //print_r($val);die;
        if (@count($_map) == 0) { return false; } $arr = array();
        foreach ($val as $k => $v) {            
            if (@isset($_map[$k])) {
                $arr[$_map[$k]] = $v; $_GET[$_map[$k]] = $v; $_REQUEST[$_map[$k]] = $v;
            }
        }
        self::$KoParam = $arr; return true; //获得参数
    }
	//遍历项目模块的一级目录
	private static function modules() {
		$a = array(); $dir = KO_INCLUDE_PATH.'/modules/';
		if (@file_exists($dir)) {
			$dh = @opendir($dir);
			if ($dh) {
				while(false !== ($file = @readdir($dh))) {
					if ($file == '.' || $file == '..') {
						continue;
					} elseif (@is_dir($dir . $file)) {
						$a[] = $file;
					}
				}
			}
			@closedir($dh);
		}
		return $a;
	}

} //end class